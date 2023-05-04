<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\Psychomotor;
use App\Models\PsychomotorGrade;
use App\Models\PsychomotorSubject;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = Term::where('school_id', getSchool()->id)->get();
        $exams = Exam::where('school_id', getSchool()->id)->get();
        return view('staff.exams_setup', compact('terms', 'exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->terms as $term) {
                $term = Term::findOrFail($term);
                $exam = new Exam();
                $exam->name = $term->name;
                $exam->total_mark = $request->total_mark;
                $exam->school_id = request()->route()->school_id;
                $exam->term_id = $term->id;
                $exam->save();

                foreach ($request->exam_types as $type) {
                    $examtype = new ExamType();
                    $examtype->name = $type['name'];
                    $examtype->mark = $type['mark'];
                    $examtype->exam_id = $exam->id;
                    $examtype->school_id = request()->route()->school_id;
                    $examtype->save();
                }
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Fail creating Exam');
        }

        return redirect()->back()->with('message', 'Exam Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam = Exam::where('school_id', getSchool()->id)->where('id', $id)->first();
        if (!$exam)
            return redirect()->back()->with('error', 'Exams not found');


        $terms = Term::where('school_id', getSchool()->id)->get();
        $exams = Exam::where('school_id', getSchool()->id)->get();
        return view('staff.exams_setup', compact('terms', 'exams', 'exam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $exam = Exam::where('school_id', getSchool()->id)->where('id', $id)->first();
        try {
            DB::beginTransaction();
            foreach ($request->terms as $term) {
                $term = Term::findOrFail($term);
                $exam->name = $term->name;
                $exam->total_mark = $request->total_mark;
                $exam->save();
                // $exam_types = $exam->exam_types;
                foreach ($request->exam_types as $key => $type) {
                    $examtype = ExamType::where('id', $key)->where('school_id', getSchool()->id)->first();
                    if (!$examtype)
                        $examtype = new ExamType();
                    $examtype->name = $type['name'];
                    $examtype->mark = $type['mark'];
                    $examtype->exam_id = $exam->id;
                    $examtype->school_id = request()->route()->school_id;
                    $examtype->save();
                }
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Fail creating Exam');
        }

        return redirect()->back()->with('message', 'Exam updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exams = Exam::findOrFail($id);

        if ($exams->delete()) {
            return redirect()->route('exams-setup.index')->with('message', 'Exam setup Deleted');
        }
        return redirect()->route('exams-setup.index')->with('error', 'Deletion failed');
    }

    public function psychomotors(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            try {
                DB::beginTransaction();
                $psychomotor = Psychomotor::create([
                    'title' => $request->title,
                    'school_id' => request()->route()->school_id
                ]);
                if ($psychomotor) {
                    //save subjects
                    foreach ($request->subjects as $subject) {
                        PsychomotorSubject::create([
                            'title' => $subject,
                            'school_id' => request()->route()->school_id,
                            'psychomotor_id' => $psychomotor->id
                        ]);
                    }

                    foreach ($request->grades as $grade) {
                        PsychomotorGrade::create([
                            'name' => $grade['name'],
                            'remark' => $grade['remark'],
                            'school_id' => request()->route()->school_id,
                            'psychomotor_id' => $psychomotor->id
                        ]);
                    }
                }
                DB::commit();
                return redirect()->back()->with('message', 'Saved');
            } catch (Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Psychomotor Setup failed');
            }
        }

        $psychomotor = Psychomotor::where('school_id', getSchool()->id)->with('subjects')->first();

        return view('staff.examinations.psychomotors', compact('psychomotor'));
    }

    public function psychomotorUpdate(Request $request, $id)
    {
        $psychomotor = Psychomotor::findOrFail($id);
        $psychomotor->update([
            'title' => $request->title
        ]);

        foreach ($request->subjects as $key => $subject) {
            $psychomotorSubject = PsychomotorSubject::find($key);
            $psychomotorSubject->update([
                'title' => $subject
            ]);
        }

        foreach ($request->grades as $key => $grade) {
            $psychomotorGrade = PsychomotorGrade::find($key);
            $psychomotorGrade->update([
                'name' => $grade['name'],
                'remark' => $grade['remark'],
            ]);
        }

        return redirect()->back()->with('message', 'Saved');
    }
}
