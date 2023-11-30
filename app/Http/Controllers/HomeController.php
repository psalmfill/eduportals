<?php

namespace App\Http\Controllers;

use App\Http\Controllers\School\Staff\PinsController;
use App\Http\Repositories\PaymentRepository;
use App\Models\Payment;
use App\Models\Pin;
use App\Models\PinCollection;
use App\Models\School;
use App\Models\SchoolCategory;
use App\Models\Staff;
use App\Models\VendorCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $schools = School::all();
        return view('index', compact('schools'));
    }

    public function getStarted()
    {
        $vendorCategories = VendorCategory::all();
        return view('get_started', compact('vendorCategories'));
    }

    public function handlePaymentCallback(Request $request)
    {
        $paymentRepo = app(PaymentRepository::class);
        $response = $paymentRepo->handleCallback($request->all());
        // dd($response, $response->paymentable, $response->paymentable instanceof PinCollection);
        // get the payment object
        if ($response instanceof Payment) {
            if ($response->status == 'completed') {
                if ($response->paymentable instanceof PinCollection) {
                    // check if user has already pin given the pin 
                    if ($response->paymentable->delivered) {
                        if (user()->vendor) {
                            return redirect("/staff/pins/collections/{$response->paymentable->id}");
                        }
                        return redirect("/vendor/pins/collections/{$response->paymentable->id}");
                    }
                    // generate pin
                    return $this->generate($response->paymentable);
                }
            }
        }
    }
    public function generate(PinCollection $pinCollection)
    {
        try {
            DB::beginTransaction();
            $count = $pinCollection->quantity;
            $days = 90;
            while ($count > 0) {
                $latestPin = Pin::latest('serial_number')->first();
                $pin = new Pin();
                $pin->code = $this->generateCode();
                $pin->ref_code = $this->generateRefCode($pinCollection->school);
                $pin->serial_number = $this->generateSerialCode($latestPin ? (int)$latestPin->serial_number : Pin::count());
                $pin->duration = $days;
                $pin->school_id =  $pinCollection->school_id;
                $pin->pin_collection_id = $pinCollection->id;
                $pin->save();
                $count--;
            }
            $collection = $pinCollection->pins()->with('school')->get();

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML(view('templates.pins', compact('collection')));
            $pinCollection->update(['delivered' => true]);
            DB::commit();
            return $pdf->download('pins.pdf');
        } catch (Exception $e) {

            DB::rollBack();
            return redirect()->back()->with('error', 'Pins Generation failed');
        }
    }

    private function generateCode()
    {
        while (true) {
            $code = random_int(1000, 9999) . '-' . random_int(1000, 9999) . '-' . random_int(1000, 9999) . '-' . random_int(1000, 9999);
            if (!Pin::where('code', $code)->exists()) {
                return $code;
            }
        }
    }

    private function generateRefCode(School $school)
    {
        return strtoupper($school->code) . '-' . random_int(1000, 9999) . '-' . Str::random(5);
    }

    private function generateSerialCode($int)
    {
        $int += 1;
        $count = 20;
        $sn = '';
        while ($count > strlen($int)) {
            $sn .= '0';
            $count--;
        }
        return $sn . $int;
    }
}
