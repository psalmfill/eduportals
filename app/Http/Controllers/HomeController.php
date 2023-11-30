<?php

namespace App\Http\Controllers;

use App\Http\Controllers\School\Staff\PinsController;
use App\Http\Repositories\PaymentRepository;
use App\Http\Requests\NewVendorRequest;
use App\Models\Payment;
use App\Models\Pin;
use App\Models\PinCollection;
use App\Models\School;
use App\Models\SchoolCategory;
use App\Models\Staff;
use App\Models\User;
use App\Models\Vendor;
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
                        if (!user()->vendor) {
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


            // $collection = $pinCollection->pins()->with('school')->get();

            // $pdf = App::make('dompdf.wrapper');
            // $pdf->loadHTML(view('templates.pins', compact('collection')));
            $pinCollection->update(['delivered' => true]);
            DB::commit();
            if (!user()->vendor) {
                return redirect("/staff/pins/collections/{$pinCollection->id}");
            }
            return redirect("/vendor/pins/collections/{$pinCollection->id}");
            // return $pdf->download('pins.pdf');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewVendorRequest $request)
    {
        try {
            DB::beginTransaction();
            //created vendor admin
            $admin = new User();
            $admin->first_name = $request->admin_first_name;
            $admin->last_name = $request->admin_last_name;
            $admin->other_name = $request->admin_other_name;
            $admin->email = $request->admin_email;
            $admin->phone_number = $request->admin_phone_number;
            $admin->address = $request->admin_address;
            $admin->password = bcrypt($request->password);
            $admin->role_id = 2;
            $admin->save();

            //create vendor
            $vendor = new Vendor();
            $vendor->name = $request->name;
            $vendor->code = $request->code;
            $vendor->email = $request->email;
            $vendor->address = $request->address;
            $vendor->country = $request->country;
            $vendor->state = $request->state;
            $vendor->phone_number = $request->admin_phone_number;
            $vendor->city = $request->city;
            $vendor->user_id = $admin->id;
            $vendor->vendor_category_id = $request->category;
            $vendor->save();

            DB::commit();
            return redirect()->route('vendor.login.form')->with('message', 'vendor created successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'vendor creation fail');
        }
    }
}
