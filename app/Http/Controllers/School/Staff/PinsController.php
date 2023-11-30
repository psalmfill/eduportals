<?php

namespace App\Http\Controllers\School\Staff;

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
use Illuminate\Http\Response;
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

        $pins = Pin::where('school_id', getSchool()->id)->paginate();
        return view('staff.pins.index', compact('pins'));
    }

    public function collections()
    {
        $pinCollections = PinCollection::where('school_id', getSchool()->id)->paginate();
        return view('staff.pins.pin_collections', compact('pinCollections'));
    }


    public function viewCollection($id)
    {
        $pinCollection = PinCollection::findOrFail($id);
        return view('staff.pins.pin_collection', compact('pinCollection'));
    }

    public function buy(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:5',
        ]);

        try {
            DB::beginTransaction();
            $pinCollection = PinCollection::create([
                'school_id' => getSchool()->id,
                'reference' => Str::random(),
                'quantity' => $request->quantity,
                'delivered' => false,
            ]);

            $data['paymentable_type'] = get_class($pinCollection);
            $data['paymentable_id'] = $pinCollection->id;
            $data['reference'] = Str::random(10);
            $data['user_id'] = user()->id;
            $data['school_id'] = getSchool()->id;
            $data['amount'] = $request->quantity * 350;


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
        $payments = Payment::where('school_id', getSchool()->id)
            ->where('paymentable_type', PinCollection::class)->orderBy('created_at', 'desc')
            ->paginate();
        return view('staff.pins.payments', compact('payments'));
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
