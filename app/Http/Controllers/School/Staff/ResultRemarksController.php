<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\Exam;
use App\Models\ResultRemark;
use App\Models\SchoolClass;
use Exception;
use Illuminate\Http\Request;

class ResultRemarksController extends Controller
{
    public function index()
    {
        $academicSessions = AcademicSession::all();
        $resultRemarks = ResultRemark::where('school_id', getSchool()->id)->where('academic_session_id', getSettings()->current_session_id)->orderBy('created_at', 'desc')->paginate(25);
        $exams = Exam::where('school_id', getSchool()->id)->get();
        $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        return view('staff.result_remarks', compact('resultRemarks', 'classes', 'exams', 'academicSessions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'school_class_ids.*' => 'required|exists:school_classes,id',
            'exam_id' => 'required|exists:exams,id',
            'min_average' => 'required|numeric|lt:max_average',
            'max_average' => 'required|numeric|gt:min_average',
            'headmaster' => 'required|string',
            'teacher' => 'required|string',
            'next_term_begins' => 'required|date',
            'next_term_fee' => 'required|string',
            'decision' => 'required'
        ]);

        $data['school_id'] = request()->route()->school_id;
        $school_class_ids = $data['school_class_ids'];
        unset($data['school_class_ids']);
        try {
            foreach ($school_class_ids as $id) {
                $data['school_class_id'] = $id;
                $resultRemark = new ResultRemark($data);
                $resultRemark->save();
            }

            return redirect()->back()->with('message', 'Successfully created new remark');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'failed creating new remark');
        }
        return redirect()->back()->with('error', 'failed creating new remark');
    }

    public function edit($id)
    {
        $academicSessions = AcademicSession::all();
        $resultRemark = ResultRemark::findOrFail($id);
        $resultRemarks = ResultRemark::where('school_id', getSchool()->id)->orderBy('created_at', 'desc')->paginate(25);
        $exams = Exam::where('school_id', getSchool()->id)->get();
        $classes = SchoolClass::where('school_id', getSchool()->id)->get();
        return view('staff.result_remarks', compact('resultRemarks', 'classes', 'exams', 'resultRemark', 'academicSessions'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'academic_session_id' => 'required',
            'school_class_id' => 'required|exists:school_classes,id',
            'exam_id' => 'required|exists:exams,id',
            'min_average' => 'required|numeric|lt:max_average',
            'max_average' => 'required|numeric|gt:min_average',
            'headmaster' => 'required|string',
            'teacher' => 'required|string',
            'next_term_begins' => 'required|date',
            'next_term_fee' => 'required|string',
            'decision' => 'required'
        ]);

        try {
            $resultRemark = ResultRemark::findOrFail($id);
            $resultRemark->update($data);
            return redirect()->back()->with('message', 'Successfully updated remark');
        } catch (Exception $e) {
        }
        return redirect()->back()->with('error', 'failed creating updating remark');
    }

    public function destroy($id)
    {
        $resultRemark = ResultRemark::findOrFail($id);
        if ($resultRemark->delete())
            return redirect()->route('staff.result_remarks')->with('message', 'Successfully deleted remark');
        return redirect()->back()->with('error', 'failed deleting remark');
    }

    public function storeExisting(Request $request)
    {
        $data = $request->validate([
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'current_academic_session_id' => 'required|exists:academic_sessions,id',
            'current_exam_id' => 'required|exists:exams,id',
            'exam_id' => 'required|exists:exams,id',
            'next_term_begins' => 'required|date',
            'next_term_fee' => 'required|numeric',
        ]);
        $resultRemarks = ResultRemark::select([
            'headmaster', 'teacher', 'max_average', 'min_average', 'decision', 'school_id', 'school_class_id'
        ])->where([
            ['academic_session_id', $request->academic_session_id],
            ['exam_id', $request->exam_id],
        ])->get();
        if ($resultRemarks->count() == 0) {
            return redirect()->back()->with('error', 'No existing data for selected session and term');
        }
        try {
            foreach ($resultRemarks as $resultRemark) {
                $data = $resultRemark->toArray();
                $data['academic_session_id'] = $request->current_academic_session_id;
                $data['exam_id'] = $request->current_exam_id;
                $data['next_term_begins'] = $request->next_term_begins;
                $data['next_term_fee'] = $request->next_term_fee;

                $resultRemark = new ResultRemark($data);
                $resultRemark->save();
            }

            return redirect()->back()->with('message', 'Successfully created new remarks');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'failed creating new remark');
        }
        return redirect()->back()->with('error', 'failed creating new remark');
    }
}
