<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\Fee;
use App\Models\GeneralSetting;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Term;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FinanceManagementController extends Controller
{
    public function transactions()
    {
        $transactions = Transaction::where('school_id', getSchool()->id)->paginate();
        return view('staff.finances.transactions', compact('transactions'));
    }

    public function fees()
    {
        $fees = Fee::where('school_id', getSchool()->id)->paginate(1);
        return view('staff.finances.fees', compact('fees'));
    }

    public function recordFee()
    {
        $sessions = AcademicSession::all();
        $terms  = Term::where('school_id', getSchool()->id)->get();
        $classes = SchoolClass::where('school_id', getSchool()->id)->get();

        //
        return view('staff.finances.record_fee', compact('sessions', 'terms', 'classes'));
    }
    public function completeFee($id)
    {
        $sessions = AcademicSession::all();
        $terms  = Term::where('school_id', getSchool()->id)->get();
        $classes = SchoolClass::where('school_id', getSchool()->id)->get();

        $fee = Fee::findOrFail($id);
        return view('staff.finances.record_fee', compact('sessions', 'terms', 'classes', 'fee'));
    }

    public function  showFee($id)
    {
        $fee = Fee::findOrFail($id);
        $generalSettings = GeneralSetting::where('school_id', getSchool()->id)->first();
        return view('staff.finances.templates.fee_reciept', compact('generalSettings', 'fee'));
    }

    public function saveFee(Request $request)
    {
        // dd($request->all());
        $data = $request->validate(
            [
                'session' => 'required|exists:academic_sessions,id',
                'term' => 'required|exists:terms,id',
                'student' => 'required|exists:students,id',
                'class' => 'required|exists:school_classes,id',
                'total_fee' => 'required|numeric',
                'amount_paid' => 'required|numeric'

            ]
        );

        try {
            DB::beginTransaction();
            // check for fees
            $fee = Fee::where(
                [
                    ['school_id', getSchool()->id],
                    ['academic_session_id', $data['session']],
                    ['term_id', $data['term']],
                    ['student_id', $data['student']],
                    ['school_class_id', $data['class']]
                ]
            )->first();

            if (!$fee) {
                $fee = new Fee();
                $fee->school_id = getSchool()->id;
                $fee->academic_session_id = $data['session'];
                $fee->term_id = $data['term'];
                $fee->student_id = $data['student'];
                $fee->school_class_id = $data['class'];
                $fee->staffable_type = get_class(user());
                $fee->staffable_id = user()->id;
                $fee->amount = $data['total_fee'];
                $fee->full_payment = false;
                $fee->reference = Str::uuid();
                $fee->save();
            }

            //  create transaction
            $transaction = $fee->transactions()->create([
                'school_id' => getSchool()->id,
                'academic_session_id' => $data['session'],
                'term_id' => $data['term'],
                'staffable_type' => get_class(user()),
                'staffable_id' => user()->id,
                'amount' => $data['amount_paid'],
                'status' => 'confirmed',
                'reference' => Str::uuid()
            ]);
            if ($fee->amount == $fee->transactions()->sum('amount')) {
                $fee->update([
                    'full_payment' => true,
                ]);
            }
            DB::commit();

            return redirect()->route('staff.finances.fees')->with('message', 'Fee has been recorded successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Record was not saved');
        }
    }
}
