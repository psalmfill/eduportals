<?php

namespace App\Http\Controllers\School\Student;

use QrCode;
use App\Models\Pin;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\MarkStore;
use App\Models\Attendance;
use App\Models\Psychomotor;
use App\Models\SchoolClass;
use App\Models\ResultRemark;
use Illuminate\Http\Request;
use App\Models\CommentResult;
use App\Models\AffectiveTrait;
use App\Models\GeneralSetting;
use App\Models\AcademicSession;
use App\Models\PsychomotorResult;
use App\Models\CommentResultGrade;
use App\Models\CommentResultRemark;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Models\AffectiveTraitResult;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\PersonalizedResultRemark;

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

    public function verifyResult(Request $request, $code)
    {
        $decryptRs = Crypt::decryptString($code);
        $rs = explode('/', $decryptRs);
        if (count($rs) != 6) {
            abort(404);
        }
        $sessions = AcademicSession::all();
        $generalSettings = GeneralSetting::where('school_id', getSchool()->id)->first();

        $exams = Exam::where('school_id', request()->route()->school_id)->with('exam_types')->get();
        $exam_id = $rs[2];
        $class_id = $rs[3];
        $student_id =  $rs[4];
        $session_id = $rs[1];
        $type = $rs[5];

        $pin = Pin::where([
            'academic_session_id' => $session_id,
            'exam_id' => $exam_id,
            'student_id' =>  $student_id,
            'school_class_id' => $class_id,
            'result_type' => $type,
        ])->first();
        if (!$pin) {
            abort(401);
        }
        $rs = getSchool()->id . "/$session_id/$exam_id/$class_id/$student_id/" . $type;
        $encryptRs = Crypt::encryptString($rs);

        $verifyUrl = 'https://' . strtolower(request()->getHost()) . '/result/verify/' . $encryptRs;

        $verifyUrlQrCode = QrCode::format('svg')->size(80)->generate($verifyUrl);
        $classes = SchoolClass::where('school_id', getSchool()->id)
            ->get();
        $currentClass = SchoolClass::find($class_id);
        $exam = Exam::find($exam_id);
        $session = AcademicSession::findOrFail($session_id);
        $section = Section::find($request->section);
        //student
        $student = Student::find($student_id);

        $psychomotor = Psychomotor::where('school_id', request()->route()->school_id)->with('subjects', 'grades')->first();
        $affectiveTrait = AffectiveTrait::where('school_id', request()->route()->school_id)->with('subjects', 'grades')->first();
        $psychomotorResult = PsychomotorResult::where([
            ['school_id', getSchool()->id],
            ['school_class_id', $class_id],
            ['exam_id', $exam_id],
        ])->get();
        $affectiveTraitResult = AffectiveTraitResult::where([
            ['school_id', getSchool()->id],
            ['school_class_id', $class_id],
            ['exam_id', $exam_id],
        ])->get();

        $pdf = App::make('dompdf.wrapper'); //prepare dompdf

        if ($type == self::COMMENT) {
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
                'generalSettings',
                'pin',
                'type'

            ));
        } else {
            $res  = MarkStore::where([
                ['exam_id', $exam_id],
                ['school_class_id', $class_id],
                ['student_id', $student_id],
                ['not_offered', 0],
                // ['absent', 0],
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
                // ['absent', 0],
                ['academic_session_id', $session_id],
                ['section_id', $section->id],
            ])->get();

            $result = $allMarkStoreFromStudents->where('student_id', '=', $student_id);
            if (!$result->count()) {
                return redirect()->back()->with('message', 'No Result Available at the moment');
            }

            // get class section subjects
            $student_subjects
                = Subject::find($allMarkStoreFromStudents->where('student_id', $student_id)->pluck('subject_id'))->sortBy('name');
            $subjects = Subject::find($allMarkStoreFromStudents->pluck('subject_id'))->sortBy('name');
            $total_mark = $allMarkStoreFromStudents->where('student_id', $student->id)->sum('score');

            //pluck out unique id for all the students in class
            $allStudentsId = $allMarkStoreFromStudents->pluck('student_id')->unique();
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
            $attendances = Attendance::getReport(
                $session_id,
                $exam->term_id,
                $class_id,
                $student_id
            );
            $personalizedRemark = PersonalizedResultRemark::where('exam_id', $exam->id)
            ->where('academic_session_id', $session_id)
            ->where('student_id', $student_id)
            ->where('school_class_id', $class_id)
            ->first();
            $html = view('staff.examinations.templates.standard_result', compact(
                'classes',
                'currentClass',
                'personalizedRemark',
                'grades',
                'exam',
                'student',
                'subjects',
                'student_subjects',
                'psychomotor',
                'total_mark',
                'total_students',
                'position',
                'studentAverage',
                'classAverage',
                'remark',
                'session',
                'section',
                'generalSettings',
                'verifyUrlQrCode',
                'affectiveTrait',
                'psychomotorResult',
                'affectiveTraitResult',
                'pin',
                'type',
                'attendances'
            ));
        }
        return $html;
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
        $student_id = auth()->id();
        $session_id = $request->session;
        $type = $request->type;
        $rs = getSchool()->id . "/$session_id/$exam_id/$class_id/$student_id/$type";
        $encryptRs = Crypt::encryptString($rs);

        $verifyUrl = 'https://' . strtolower(request()->getHost()) . '/result/verify/' .
            $encryptRs;

        $verifyUrlQrCode = base64_encode(QrCode::format('svg')->size(80)->generate($verifyUrl));
        $classes = SchoolClass::where('school_id', getSchool()->id)
            ->get();
        $currentClass = SchoolClass::find($class_id);
        $exam = Exam::find($exam_id);
        $session = AcademicSession::findOrFail($session_id);
        $section = Section::find($request->section);
        //student
        $student = Student::find($student_id);

        $psychomotor = Psychomotor::where('school_id', request()->route()->school_id)->with('subjects', 'grades')->first();
        $affectiveTrait = AffectiveTrait::where('school_id', request()->route()->school_id)->with('subjects', 'grades')->first();
        $psychomotorResult = PsychomotorResult::where([
            ['school_id', getSchool()->id],
            ['school_class_id', $class_id],
            ['exam_id', $exam_id],
        ])->get();
        $affectiveTraitResult = AffectiveTraitResult::where([
            ['school_id', getSchool()->id],
            ['school_class_id', $class_id],
            ['exam_id', $exam_id],
        ])->get();

        $pdf = App::make('dompdf.wrapper'); //prepare dompdf

        if ($type == self::COMMENT) {
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
                'generalSettings',
                'verifyUrlQrCode',

            ));
        } else {
            $res  = MarkStore::where([
                ['exam_id', $exam_id],
                ['school_class_id', $class_id],
                ['student_id', $student_id],
                ['not_offered', 0],
                // ['absent', 0],
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
                // ['absent', 0],
                ['academic_session_id', $session_id],
                ['section_id', $section->id],
            ])->get();

            $result = $allMarkStoreFromStudents->where('student_id', '=', $student_id);
            if (!$result->count()) {
                return redirect()->back()->with('message', 'No Result Available at the moment');
            }

            // get class section subjects
             $student_subjects
                = Subject::find($allMarkStoreFromStudents->where('student_id', $student_id)->pluck('subject_id'))->sortBy('name');
            $subjects = Subject::find($allMarkStoreFromStudents->pluck('subject_id'))->sortBy('name');
            $total_mark = $allMarkStoreFromStudents->where('student_id', $student->id)->sum('score');

            //pluck out unique id for all the students in class
            $allStudentsId = $allMarkStoreFromStudents->pluck('student_id')->unique();
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
            $personalizedRemark = PersonalizedResultRemark::where('exam_id', $exam->id)
            ->where('academic_session_id', $session_id)
            ->where('student_id', $student_id)
            ->where('school_class_id', $class_id)
            ->first();
            $grades = Grade::where('school_id', getSchool()->id)->get();
            $attendances = Attendance::getReport(
                $session_id,
                $exam->term_id,
                $class_id,
                $student_id
            );
            $html = view('templates.standard_result', compact(
                'classes',
                'currentClass',
                'personalizedRemark',
                'grades',
                'exam',
                'student',
                'subjects',
                'student_subjects',
                'psychomotor',
                'total_mark',
                'total_students',
                'position',
                'studentAverage',
                'classAverage',
                'remark',
                'session',
                'section',
                'generalSettings',
                'verifyUrlQrCode',
                'affectiveTrait',
                'psychomotorResult',
                'affectiveTraitResult',
                'attendances'
            ));
        }
        // increase pin usage
        $pin->update([
            'academic_session_id' => $session->id,
            'exam_id' => $exam->id,
            'trial' => $pin->trial + 1,
            'student_id' => auth()->id(),
            'school_class_id' => $class_id,
            'section_id' => $section->id,
            'result_type' => $type,
        ]);
        // return $html;

        $pdf->loadHTML($html)->setPaper('a4');
        // Instantiate canvas instance 
        $canvas = $pdf->getCanvas();
        // Get height and width of page 
        $w = $canvas->get_width();
        $h = $canvas->get_height();

        // Specify watermark image 
        $imageURL = public_path(Storage::url(getSchool()->logo));
        $imgWidth = 300;
        $imgHeight = 200;

        // Set image opacity 
        $canvas->set_opacity(.3);

        // Specify horizontal and vertical position 
        $x = (($w / 2) - ($imgWidth / 2));
        $y = (($h / 2) - ($imgHeight / 2));

        // Add an image to the pdf 
        $canvas->image($imageURL, $x, $y, $imgWidth, $imgHeight);
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
            // ['absent', 0],
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
