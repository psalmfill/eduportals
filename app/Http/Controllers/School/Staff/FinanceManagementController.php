<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\Expenditure;
use App\Models\Fee;
use App\Models\FeeItem;
use App\Models\FeePaymentItem;
use App\Models\GeneralSetting;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\Term;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FinanceManagementController extends Controller
{
    public function transactions(Request $request)
    {
        $currentSession = AcademicSession::find($request->session);
        $currentTerm = Term::find($request->term);

        $transactions = Transaction::where('school_id', getSchool()->id)
            ->when($currentSession, function ($q, $session) {
                return $q->where('academic_session_id', $session->id);
            })->when($currentTerm, function ($q, $term) {
                return $q->where('term_id', $term->id);
            })->paginate();
        $sessions = AcademicSession::all();
        $terms = Term::where('school_id', getSchool()->id)->get();
        return view('staff.finances.transactions', compact('transactions',  'terms', 'sessions', 'currentSession', 'currentTerm'));
    }

    public function showTransactions(Transaction $transaction)
    {
        return view('staff.finances.transaction', compact('transaction'));
    }

    public function fees()
    {
        $fees = Fee::where('school_id', getSchool()->id)->paginate();
        return view('staff.finances.fees', compact('fees'));
    }

    public function recordFee()
    {
        $sessions = AcademicSession::all();
        $terms  = Term::where('school_id', getSchool()->id)->get();
        $classes = SchoolClass::where('school_id', getSchool()->id)->get();
        $feeItems = FeeItem::orderBy('name')->get();
        return view('staff.finances.record_fee', compact('sessions', 'terms', 'classes', 'feeItems'));
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
        $data = $request->validate(
            [
                'session' => 'required|exists:academic_sessions,id',
                'term' => 'required|exists:terms,id',
                'student' => 'required|exists:students,id',
                'class' => 'required|exists:school_classes,id',
                'total_fee' => 'required|numeric',
                'amount_paid' => 'required|numeric',
                'feeItems'=> 'required|array'

            ]
        );

        $feeItems = FeeItem::find( $data['feeItems'] );

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

                foreach ($feeItems as $item) {
                    FeePaymentItem::updateOrCreate([
                        'fee_id'=> $fee->id,
                        'fee_item_id'=>$item->id,
                        'amount' => $item->amount
                    ]);
                }
            }

            //  create transaction
            $transaction = $fee->transactions()->create([
                'school_id' => getSchool()->id,
                'academic_session_id' => $data['session'],
                'term_id' => $data['term'],
                'student_id' => $data['student'],
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
            return redirect()->back()->with('error', 'Record was not saved');
        }
    }

    public function expenditures()
    {
        $expenditures = Expenditure::where('school_id', getSchool()->id)->paginate();
        return view('staff.finances.expenditures', compact('expenditures'));
    }

    public function showExpenditures(Expenditure $expenditure)
    {
        return view('staff.finances.expenditure', compact('expenditure'));
    }

    public function recordExpenditure()
    {
        $sessions = AcademicSession::all();
        $terms  = Term::where('school_id', getSchool()->id)->get();
        $classes = SchoolClass::where('school_id', getSchool()->id)->get();

        //
        return view('staff.finances.record_expenditure', compact('sessions', 'terms', 'classes'));
    }

    public function saveExpenditure(Request $request)
    {
        $data = $request->validate(
            [
                'session' => 'required|exists:academic_sessions,id',
                'term' => 'required|exists:terms,id',
                'amount' => 'required|numeric',
                'description' => 'required|string',
                'title' => 'required|string',
                'date' => 'required|date',
            ]
        );

        try {
            DB::beginTransaction();

            $expenditure = new Expenditure();
            $expenditure->school_id = getSchool()->id;
            $expenditure->academic_session_id = $data['session'];
            $expenditure->term_id = $data['term'];
            $expenditure->staffable_type = get_class(user());
            $expenditure->staffable_id = user()->id;
            $expenditure->amount = $data['amount'];
            $expenditure->title = $data['title'];
            $expenditure->date = $data['date'];
            $expenditure->description = $data['description'];
            $expenditure->reference = Str::uuid();
            $expenditure->save();
            //  create transaction
            $transaction = $expenditure->transaction()->create([
                'school_id' => getSchool()->id,
                'academic_session_id' => $data['session'],
                'term_id' => $data['term'],
                'staffable_type' => get_class(user()),
                'staffable_id' => user()->id,
                'amount' => $data['amount'],
                'status' => 'confirmed',
                'reference' => Str::uuid(),
                'channel' => 'expenditure'
            ]);

            DB::commit();

            return redirect()->route('staff.finances.expenditures')->with('message', 'Expenditure has been recorded successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Record was not saved');
        }
    }

    public function feesSetup(){
        $schoolClass = request()->school_class ? SchoolClass::where('id', request()->school_class)->with('sections')->first() : null;
        $section = request()->school_class ? Section::where('id', request()->section)->first() : null;

        $school_classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->with('sections', 'sections.subjects')->orderBy('name', 'asc')->get();
        $feeItems = FeeItem::orderBy('name')->get();
        return view('staff.finances.setup_fees', compact('school_classes', 'feeItems', 'section', 'schoolClass'));
    }

    public function saveFeesSetup(Request $request)
    {
        $class = SchoolClass::findOrFail($request->class);
        if (!$request->sections)
            return redirect()->back()->with('error', 'Please select at least one section');

        foreach ($request->sections as $section) {

            $class->fee_items()->wherePivot(
                'school_id',
                getSchool()->id
            )->wherePivot('section_id', $section)->detach();


            $feeItems = $request->feeItems ?? [];
            foreach ($feeItems as $subject) {

                $class->fee_items()->attach($subject, [
                    'section_id' => $section,
                    'school_id' => getSchool()->id
                ]);
            }
        }

        return redirect()->back();
    }
}
