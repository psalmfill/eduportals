<?php

namespace App\Http\Controllers\Admin;

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
        $schools = School::all();
        return view('admin.pins', compact('schools'));
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
                $pin = new Pin();
                $pin->code = $this->generateCode();
                $pin->ref_code = $this->generateRefCode($school);
                $pin->serial_number = $this->generateSerialCode(Pin::count());
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
            dd($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'Pins Generation failed');
        }
    }

    private function generateCode()
    {
        return random_int(1000, 9999) . '-' . random_int(1000, 9999) . '-' . random_int(1000, 9999) . '-' . random_int(1000, 9999);
    }

    private function generateRefCode(School $school)
    {
        return strtoupper($school->code) . '-' . random_int(1000, 9999) . '-' . Str::random(5);
    }

    private function generateSerialCode($int)
    {
        $count = 20;
        $sn = '';
        while ($count > strlen($int)) {
            $sn .= '0';
            $count--;
        }
        return $sn . $int;
    }
}
