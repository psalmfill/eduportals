<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use App\Http\Repositories\PaymentRepository;
use App\Models\Payment;
use App\Models\Pin;
use App\Models\PinCollection;
use App\Models\School;
use Barryvdh\DomPDF\PDF;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PinsController extends Controller
{
    protected $paymentRepository;

    public function __construct()
    {
        $this->paymentRepository = app(PaymentRepository::class);
    }

    public function index()
    {
        $schools = School::where('vendor_id', user()->vendor->id)->get();
        $pins = Pin::whereHas('school', function ($q) {
            return $q->whereHas('vendor', function ($qr) {
                return $qr->where('vendor_id', user()->vendor->id);
            });
        })->paginate();
        return view('vendors.pins', compact('schools', 'pins'));
    }

    public function collections()
    {
        $schools = School::where('vendor_id', user()->vendor->id)->get();
        $pinCollections = PinCollection::whereHas('school', function ($q) {
            return $q->where('vendor_id', user()->vendor->id);
        })->orderBy('created_at', 'desc')->paginate();
        return view('vendors.pin_collections', compact('pinCollections', 'schools'));
    }


    public function viewCollection($id)
    {
        $pinCollection = PinCollection::find($id);
        return view('vendors.pin_collection', compact('pinCollection'));
    }

    public function buy(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:5',
            'school' => 'required|exists:schools,id'
        ]);

        try {
            DB::beginTransaction();
            $pinCollection = PinCollection::create([
                'school_id' => $request->school,
                'reference' => Str::random(),
                'quantity' => $request->quantity,
                'delivered' => false,
            ]);

            $data['paymentable_type'] = get_class($pinCollection);
            $data['paymentable_id'] = $pinCollection->id;
            $data['reference'] = Str::random(10);
            $data['user_id'] = user()->id;
            $data['school_id'] = $request->school;
            $data['amount'] = $request->quantity * 50;


            $payment = Payment::create($data);
            DB::commit();
            $response = $this->paymentRepository->createWithModel($payment);
            if ($response->status == 'success') {
                return redirect($response->data->link);
            } else {
                // fail the payment
                $this->paymentRepository->update([
                    'status' => 'failed',
                    $payment->id
                ]);
                return redirect()->back()->with('error', 'Could not process payment');
            }
            // go to paystack payment
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Could not process payment');
        }
        // create a collection
    }

    public function payments()
    {
        $payments = Payment::whereHas('school', function ($q) {
            return $q->where('vendor_id', user()->vendor->id);
        })
            ->where('paymentable_type', PinCollection::class)->orderBy('created_at', 'desc')
            ->paginate();
        return view('vendors.pin_payments', compact('payments'));
    }
    public function download($id)
    {
        try {

            $collection = PinCollection::findOrFail($id)->pins()->with('school')->get();

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML(view('templates.pins', compact('collection')));
            return $pdf->download('pins.pdf');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred');
        }
    }
}
