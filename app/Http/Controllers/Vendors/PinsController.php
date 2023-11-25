<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
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
        })->paginate();
        return view('vendors.pin_collections', compact('pinCollections', 'schools'));
    }


    public function viewCollection($id)
    {
        $pinCollection = PinCollection::find($id);
        return view('vendors.pin_collection', compact('pinCollection'));
    }

    public function buy(Request $request)
    {
        abort(401);
    }


    public function generate(Request $request)
    {
        $request->validate([
            'school' => 'required|exists:schools,id',
            'quantity' => 'required|integer|min:1',
            'days' => 'required|integer|min:1',

        ]);
        try {
            DB::beginTransaction();
            $school = School::findOrFail($request->school);

            $pinCollection = PinCollection::create([
                'school_id' => $school->id,
                'reference' => Str::random(),
            ]);

            $count = $request->quantity;
            $days = $request->days;
            while ($count > 0) {
                $latestPin = Pin::latest('serial_number')->first();
                $pin = new Pin();
                $pin->code = $this->generateCode();
                $pin->ref_code = $this->generateRefCode($school);
                $pin->serial_number = $this->generateSerialCode($latestPin ? (int)$latestPin->serial_number : Pin::count());
                $pin->duration = $days;
                $pin->school_id = $school->id;
                $pin->pin_collection_id = $pinCollection->id;
                $pin->save();
                $count--;
            }
            $collection = $pinCollection->pins()->with('school')->get();

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML(view('templates.pins', compact('collection')));
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
