<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\CommentResult;
use App\Models\CommentResultGrade;
use App\Models\CommentResultRemark;
use App\Models\Exam;
use App\Models\GeneralSetting;
use App\Models\Grade;
use App\Models\MarkStore;
use App\Models\Pin;
use App\Models\Psychomotor;
use App\Models\ResultRemark;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ExaminationsController extends Controller
{
    const STANDARD = 'standard';
    const CUMMULATIVE = 'cummulative';
    const COMMENT = 'comments';

    public function index()
    {
        $sessions = AcademicSession::all();
        $exams = Exam::where('school_id', getSchool()->id)->get();
        $resultTypes = [self::STANDARD, self::CUMMULATIVE, self::COMMENT];
        $classes = SchoolClass::where('school_id', getSchool()->id)->get();
        $pins = Pin::where('school_id', getSchool()->id)->where('student_id', auth()->id())->get();
        return view('student.result', compact('exams', 'classes', 'sessions', 'resultTypes', 'pins'));
    }

    public function getResult(Request $request)
    {
        $pin = Pin::where('code', $request->pin_code)->where('school_id', getSchool()->id)->first();
        if (!$pin) {
            return redirect()->back()->with('error', 'Invalid result checking pin');
        }

        if ($pin->student_id != null && $pin->student_id != user()->id) {
            return redirect()->back()->with('error', 'Pin already in use by another student');
        }

        // if ($pin->trial == $pin->duration) {
        //     return redirect()->back()->with('error', 'You have exceeded number of usage');
        // }
        if ($pin->academic_session_id and $pin->academic_session_id != $request->session) {
            return redirect()->back()->with('error', 'Pin cannot be use for selected session');
        }

        if ($pin->exam_id and $pin->exam_id != $request->exam) {
            return redirect()->back()->with('error', 'Pin cannot be use for selected exam');
        }


        $sessions = AcademicSession::all();
        $generalSettings = GeneralSetting::where('school_id', getSchool()->id)->first();

        $exams = Exam::where('school_id', request()->route()->school_id)->with('exam_types')->get();
        $exam_id = $request->exam;
        $class_id = $request->class;
        $student_id = $request->student;
        $session_id = $request->session;

        $classes = SchoolClass::where('school_id', getSchool()->id)
            ->get();
        $currentClass = SchoolClass::find($class_id);
        $exam = Exam::find($exam_id);
        $session = AcademicSession::findOrFail($session_id);
        $section = Section::find($request->section);
        //student
        $student = Student::find($student_id);

        $psychomotor = Psychomotor::where('school_id', request()->route()->school_id)->with('subjects', 'grades')->first();


        $pdf = App::make('dompdf.wrapper'); //prepare dompdf

        if ($request->type == self::COMMENT) {
            $results = CommentResult::where([
                ['exam_id', $exam_id],
                ['school_class_id', $class_id],
                ['student_id', $student_id],
                ['section_id', $student->section_id],
                ['academic_session_id', $session_id],
            ]);
            $result = $results->get()->groupBy('comment_result_group_id');
            $grades = CommentResultGrade::where('school_id', request()->route()->school_id)->get();

            $section = Section::find($results->first()->section_id);
            $remark = CommentResultRemark::where('student_id', $student_id)
                ->where('exam_id', $exam_id)
                ->where('school_class_id', $class_id)
                ->where('academic_session_id', $session_id)
                ->where('school_id', getSchool()->id)->first();

            $html = view('templates.comment_result', compact(
                'classes',
                'currentClass',
                'grades',
                'exam',
                'student',
                'result',
                'psychomotor',
                'remark',
                'session',
                'section',
                'generalSettings'

            ));
        } else {
            $res  = MarkStore::where([
                ['exam_id', $exam_id],
                ['school_class_id', $class_id],
                ['student_id', $student_id],
                ['not_offered', 0],
                ['absent', 0],
                ['academic_session_id', $session_id],
            ])->first();
            if (!$res) {
                return redirect()->back()->with('message', 'No Result Available at the moment');
            }
            // get the user section
            $section = Section::find($res->section_id);


            //students scores from store
            $allMarkStoreFromStudents = MarkStore::where([
                ['exam_id', $exam_id],
                ['school_class_id', $class_id],
                ['not_offered', 0],
                ['absent', 0],
                ['academic_session_id', $session_id],
                ['section_id', $section->id . ''],
            ])->get();

            $result = $allMarkStoreFromStudents->where('student_id', '=', $student_id);
            if (!$result->count()) {
                return redirect()->back()->with('message', 'No Result Available at the moment');
            }

            // get class section subjects
            $subjects = Subject::find($allMarkStoreFromStudents->where('student_id', $student_id)->pluck('subject_id'))->sortBy('name');
            $total_mark = $allMarkStoreFromStudents->where('student_id', $student->id)->sum('score');

            //pluck out unique id for all the students in class
            $allStudentsId = $allMarkStoreFromStudents->pluck('student_id')->merge([$student->id])->unique();
            //Get all the students total scores
            $scores = $allStudentsId->map(function ($e) use ($allMarkStoreFromStudents) {
                $subject_count =  $allMarkStoreFromStudents->where('student_id', $e)->unique('subject_id')->count();
                $score = $allMarkStoreFromStudents->where('student_id', $e)->sum('score');
                return [
                    'student_id' => $e, 'score' => $score,
                    'subject_count' => $subject_count,
                    'student_average' => '' . $score / $subject_count
                ];
            })->sortByDesc('student_average');

            //get Student position in class
            $scoresGroup = $scores->groupBy('student_average');
            $position = $scoresGroup->count();
            $newGroup = [];
            // remove the grouping score
            foreach ($scoresGroup as $group) {
                $newGroup[] = $group;
            }
            foreach ($newGroup as $key => $value) {
                if (strval(collect($value)->pluck('student_id')->search($student_id)) != '') {
                    $position = $key + 1;
                }
            }

            $total_students = $allStudentsId->count();

            //calculate student average
            $studentAverage = number_format($total_mark / $subjects->count(), 2);

            //calculate class average
            $classAverage = $this->calculateClassAverage($exam_id, $class_id, $student->section_id, $session_id);

            //get school remarks
            $remark = ResultRemark::where(
                [
                    ['exam_id', $exam_id],
                    ['school_class_id', $class_id],
                ]
            )->orderBy('min_average', 'desc')
                // ->where('max_average', '<=', floor($studentAverage))
                ->where('min_average', '<=', $studentAverage)
                ->first();
            $grades = Grade::where('school_id', getSchool()->id)->get();

            $html = view('templates.standard_result', compact(
                'classes',
                'currentClass',
                'grades',
                'exam',
                'student',
                'subjects',
                'psychomotor',
                'total_mark',
                'total_students',
                'position',
                'studentAverage',
                'classAverage',
                'remark',
                'session',
                'section',
                'generalSettings'
            ));
        }
        // increase pin usage
        $pin->update([
            'academic_session_id' => $session->id,
            'exam_id' => $exam->id,
            'trial' => $pin->trial + 1,
            'student_id' => auth()->id()
        ]);

        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
    }

    private function calculateClassAverage($exam_id, $class_id, $section_id, $session_id)
    {

        # calculate Class average


        $allMarkStoreFromStudents =  MarkStore::where([
            ['exam_id', $exam_id],
            ['section_id', $section_id],
            ['school_class_id', $class_id],
            ['not_offered', 0],
            ['absent', 0],
            ['academic_session_id', $session_id],
        ])->get();

        //pluck out unique id for all the students in class
        $allStudentsId = $allMarkStoreFromStudents->pluck('student_id')->unique();

        //Get all the students total scores
        $scores = $allStudentsId->map(function ($e) use ($allMarkStoreFromStudents) {
            return [
                'student_id' => $e, 'score' => $allMarkStoreFromStudents->where('student_id', $e)->sum('score'),
                'subject_count' => $allMarkStoreFromStudents->where('student_id', $e)->unique('subject_id')->count()
            ];
        })->sortByDesc('score');

        if (!$scores->sum('score')) return 0;

        //calculate class average
        $classAverage = number_format($scores->sum(function ($s) {
            return $s['score'] / $s['subject_count'];
        }) / $allStudentsId->count(), 2);

        return $classAverage;
    }
}
