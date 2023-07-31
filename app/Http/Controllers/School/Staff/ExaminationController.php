<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\AffectiveTrait;
use App\Models\AffectiveTraitResult;
use App\Models\CommentResult;
use App\Models\CommentResultGrade;
use App\Models\CommentResultGroup;
use App\Models\CommentResultItem;
use App\Models\CommentResultRemark;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\GeneralSetting;
use App\Models\Grade;
use App\Models\MarkStore;
use App\Models\Pin;
use App\Models\Psychomotor;
use App\Models\PsychomotorSubject;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\PsychomotorResult;
use App\Models\ResultRemark;
use App\Models\Staff;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use QrCode;

class ExaminationController extends Controller
{

    const STANDARD = 'standard';
    const CUMMULATIVE = 'cummulative';
    const COMMENT = 'comment';

    public function index(Request $request)
    {


        $user = user();
        if ($user instanceof Staff)
            $classes = $user->school_classes->unique();
        else
            $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();


        if ($request->getMethod() == 'POST' || $request->class) {
            $exams = Exam::where('school_id', getSchool()->id)->with('exam_types')->get();
            $exam_id = $request->exam;
            $class_id = $request->class;
            $section_id = $request->section;
            $session_id = $request->session;

            $subject = Subject::find($request->subject);
            $currentClass = SchoolClass::find($class_id);
            $currentSection = Section::find($section_id);
            $currentSession = AcademicSession::find($session_id);
            $sessions = AcademicSession::all();
            if (!(auth()->user() || (user()->subjects != null and user()->subjects->contains($subject)))) {
                return back()->with('error', 'Unauthorized access');
            }
            $sections =  $currentClass->sections;
            $subjects = $currentSection
                ->subjects()
                ->wherePivot('school_class_id', $class_id)->get();

            $students = Student::where('school_id', getSchool()->id)
                ->where('school_class_id', $class_id)
                ->where('section_id', $section_id)
                ->get();
            $exam = Exam::find($exam_id);
            return view('staff.examinations.marks_register', compact(
                'exams',
                'exam',
                'students',
                'classes',
                'sections',
                'subjects',
                'currentClass',
                'currentSection',
                'subject',
                'sessions',
                'currentSession'
            ));
        }
        $sessions = AcademicSession::all();
        $exams = Exam::where('school_id', getSchool()->id)->get();
        return view('staff.examinations.marks_register', compact('classes', 'exams', 'sessions'));
    }

    public function postMarks(Request $request)
    {
        $studentsMarks = $request->students;
        $exam_id = $request->exam;
        $academic_session_id = $request->session;
        $class_id = $request->class;
        $subject_id = $request->subject;
        $section_id = $request->section;

        foreach ($studentsMarks as $skey => $student) {
            foreach ($student['mark'] as $key => $mark) {
                $markStore = MarkStore::where('exam_id', $exam_id)
                    ->where('exam_type_id', $key)
                    ->where('subject_id', $subject_id)
                    ->where('academic_session_id', $academic_session_id)
                    ->where('student_id', $skey)
                    ->where('school_class_id', $class_id)
                    ->where('section_id', $section_id)
                    ->first();
                if ($markStore) {
                    $markStore->update([
                        'score' => $mark,
                        'absent' => isset($student['absent']) ? 1 : 0,
                        'not_offered' => isset($student['not_offered']) ? 1 : 0

                    ]);
                    continue;
                }
                $markStore = new MarkStore(
                    [
                        'exam_type_id' => $key,
                        'exam_id' => $exam_id,
                        'subject_id' => $subject_id,
                        'academic_session_id' => $academic_session_id,
                        'student_id' => $skey,
                        'school_class_id' => $class_id,
                        'section_id' => $section_id,
                        'score' => $mark,
                        'absent' => isset($student['absent']) ? 1 : 0,
                        'not_offered' => isset($student['not_offered']) ? 1 : 0
                    ]
                );
                $markStore->save();
            }
        }
        return  redirect()->action(
            'School\Staff\ExaminationController@index',
            [
                'exam' => $exam_id,
                'class' => $class_id,
                'section' => $section_id,
                'subject' => $subject_id,
                'session' => $academic_session_id
            ]
        )->with('message', 'Result Saved');
    }

    public function clearMarks(Request $request)
    {

        $exam_id = $request->exam;
        $academic_session_id = $request->session;
        $class_id = $request->class;
        $subject_id = $request->subject;
        $section_id = $request->section;

        $mark_scores = MarkStore::where('exam_id', $exam_id)
            ->where('subject_id', $subject_id)
            ->where('academic_session_id', $academic_session_id)
            ->where('school_class_id', $class_id)
            ->where('section_id', $section_id);

        if (!$mark_scores->count())
            return  redirect()->action(
                'School\Staff\ExaminationController@index',
                [
                    'exam' => $exam_id,
                    'class' => $class_id,
                    'section' => $section_id,
                    'subject' => $subject_id,
                    'session' => $academic_session_id
                ]
            )->with('error', 'No result Cleared');
        $mark_scores->delete();


        return  redirect()->action(
            'School\Staff\ExaminationController@index',
            [
                'exam' => $exam_id,
                'class' => $class_id,
                'section' => $section_id,
                'subject' => $subject_id,
                'session' => $academic_session_id
            ]
        )->with('message', 'Marks Cleared');
    }

    public function viewResults(Request $request)
    {

        $exams = Exam::where('school_id', getSchool()->id)->get();

        $sessions = AcademicSession::all();
        if (request()->query->count()) {
            $exam =  Exam::findOrFail($request->exam);
            $currentSession =  AcademicSession::findOrFail($request->session);
            $currentClass =  SchoolClass::findOrFail($request->class);
            $currentSection =  Section::findOrFail($request->section);
            $sections = $currentClass->sections;
            $mark_stores = MarkStore::where('exam_id', $exam->id)
                ->where('academic_session_id', $currentSession->id)
                ->where('school_class_id', $currentClass->id)->get();
            if ($currentSession->id == getSettings()->current_session_id) {
                $students = Student::where('section_id', $currentSection->id)
                    ->where('school_class_id', $currentClass->id)
                    ->where('school_id', getSchool()->id)->paginate(15);
            } else {
                $student_ids = $mark_stores->pluck('student_id')->unique();
                $students = Student::whereIn('id', $student_ids)->paginate(15);
            }
            $classes = SchoolClass::where('school_id', getSchool()->id)->get();

            return view('staff.examinations.students', compact('sessions', 'exams', 'classes', 'sections', 'students', 'currentClass', 'currentSection', 'exam', 'currentSession', 'mark_stores'));
        }
        $classes = SchoolClass::where('school_id', getSchool()->id)->get();
        return view('staff.examinations.students', compact('classes', 'exams', 'sessions'));
    }

    public function getResult(Request $request)
    {
        $sessions = AcademicSession::all();
        $generalSettings = GeneralSetting::where('school_id', getSchool()->id)->first();

        $exams = Exam::where('school_id', request()->route()->school_id)->with('exam_types')->get();
        $exam_id = $request->exam;
        $class_id = $request->class;
        $student_id = $request->student;
        $session_id = $request->session;
        $section_id = $request->section;
        $type = $request->type;
        $rs = getSchool()->id . "/$session_id/$exam_id/$class_id/$student_id/" . $type;
        $encryptRs = Crypt::encryptString($rs);
        $verifyUrl = 'https://' . strtolower(request()->getHost()) . '/result/verify/' . $encryptRs;

        $verifyUrlQrCode = QrCode::format('svg')->size(80)->generate($verifyUrl);
        $classes = SchoolClass::where('school_id', getSchool()->id)
            ->get();
        $currentClass = SchoolClass::find($class_id);
        $exam = Exam::find($exam_id);
        $session = AcademicSession::findOrFail($session_id);

        //student
        $student = Student::find($student_id);
        $pin = Pin::where([
            'academic_session_id' => $session_id,
            'exam_id' => $exam_id,
            'student_id' =>  $student_id,
            'school_class_id' => $class_id,
            'result_type' => $type,
        ])->first();

        $psychomotor = Psychomotor::where('school_id', request()->route()->school_id)->with('subjects', 'grades')->first();
        $affectiveTrait = AffectiveTrait::where('school_id', request()->route()->school_id)->with('subjects', 'grades')->first();

        $psychomotorResult = PsychomotorResult::where([
            ['school_id', getSchool()->id],
            ['school_class_id', $class_id],
            ['exam_id', $exam_id],
            ['section_id', $section_id],
        ])->get();
        $affectiveTraitResult = AffectiveTraitResult::where([
            ['school_id', getSchool()->id],
            ['school_class_id', $class_id],
            ['exam_id', $exam_id],
            ['section_id', $section_id],
        ])->get();
        $pdf = App::make('dompdf.wrapper'); //prepare dompdf

        if ($type == self::COMMENT) {
            $results = CommentResult::where([
                ['exam_id', $exam_id],
                ['school_class_id', $class_id],
                ['student_id', $student_id],
                ['section_id', $request->section],
                ['academic_session_id', $session_id],
            ]);
            if (!$results->count()) {
                return redirect()->back()->with('error', 'No results found');
            }
            $result = $results->get()->groupBy('comment_result_group_id');
            $grades = CommentResultGrade::where('school_id', request()->route()->school_id)->get();

            $section = Section::find($request->section);
            $remark = CommentResultRemark::where('student_id', $student_id)
                ->where('exam_id', $exam_id)
                ->where('school_class_id', $class_id)
                ->where('academic_session_id', $session_id)
                ->where('school_id', getSchool()->id)->first();

            $html = view('staff.examinations.templates.comment_result', compact(
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
                'affectiveTrait',
                'psychomotorResult',
                'affectiveTraitResult',
                'type',
                'pin',
            ));
        } else {

            //students scores from store
            $allMarkStoreFromStudents = MarkStore::where([
                ['exam_id', $exam_id],
                ['school_class_id', $class_id],
                ['not_offered', 0],
                ['absent', 0],
                ['academic_session_id', $session_id],
                ['section_id', $request->section],
            ])->get();
            // dd($allMarkStoreFromStudents->take(5));
            if (!$allMarkStoreFromStudents->count()) {
                return redirect()->back()->with('error', 'No Result Available at the moment');
            }

            //get class section subjects
            // $subjects = Subject::find($allMarkStoreFromStudents->where('student_id', $student->id)->pluck('subject_id'))->sortBy('name');
            $subjects = Subject::find($allMarkStoreFromStudents->pluck('subject_id')->unique())->sortBy('name');

            $total_mark = $allMarkStoreFromStudents->where('student_id', $student->id)->sum('score');

            //get all mark for all student in this session
            // $allMarkStoreFromStudents =  MarkStore::where([
            //     ['exam_id', $exam_id],
            //     ['section_id', $student->section_id],
            //     [
            //         'academic_session_id',
            //         $session_id
            //     ],
            //     ['school_class_id', $class_id],
            //     ['not_offered', 0],
            //     ['absent', 0],
            // ])->get();

            //pluck out unique id for all the students in class
            $allStudentsId = $allMarkStoreFromStudents->pluck('student_id')->unique();

            //Get all the students total scores
            $scores = $allStudentsId->map(function ($e) use ($allMarkStoreFromStudents, $subjects) {
                $subject_count =  $subjects->count();
                $score = $allMarkStoreFromStudents->where('student_id', $e)->sum('score');
                return [
                    'student_id' => $e, 'score' => $score,
                    'subject_count' => $subject_count,
                    'student_average' => '' . $score / $subject_count
                ];
            })->sortByDesc('student_average');
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
            // $classAverage = number_format($scores->sum(function ($s) {
            //     return $s['student_average']; //$s['score'] / $s['subject_count'];

            // }) / $allStudentsId->count(), 2);
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

            $section = $student->section;
            $html = view('staff.examinations.templates.standard_result', compact(
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
                'verifyUrlQrCode',
                'generalSettings',
                'affectiveTrait',
                'psychomotorResult',
                'type',
                'affectiveTraitResult',
                'pin'
            ));
            // return $html;
        }
        return $html;
    }

    public function viewBroadsheetResult(Request $request)
    {
        $user = user();
        if ($user instanceof Staff)
            $classes = $user->school_classes->unique();
        else
            $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();

        if ($request->getMethod() == 'POST') {
            $exam_id = $request->exam;
            $class_id = $request->class;
            $section_id = $request->section;
            $session_id = $request->session;

            $exams = Exam::where('school_id', getSchool()->id)->with('exam_types')->get();
            $currentClass = SchoolClass::find($class_id);
            $currentSection = Section::find($section_id);
            $currentSession = AcademicSession::find($session_id);
            $sessions = AcademicSession::all();

            $sections =  $currentClass->sections;
            $markstore = MarkStore::where('school_class_id', $class_id)
                ->where('academic_session_id', $session_id)
                ->when($currentSection, function ($q, $currentSection) {
                    return $q->where('section_id', $currentSection->id);
                })
                ->where('exam_id', $exam_id)->get();
            $student_ids = $markstore->pluck('student_id')->unique();
            $subject_ids = $markstore->pluck('subject_id')->unique();
            $subjects = Subject::find($subject_ids);
            $students = Student::whereIn('id', $student_ids)->get();
            $exam = Exam::find($exam_id);

            $classAverage = $this->calculateClassAverage($exam_id, $class_id, $section_id, $currentSession->id);


            return view('staff.examinations.broadsheet', compact(
                'exams',
                'exam',
                'students',
                'classes',
                'sections',
                'subjects',
                'sessions',
                'currentClass',
                'currentSection',
                'currentSession',
                'classAverage',
                'markstore'
            ));
        }
        $exams = Exam::where('school_id', getSchool()->id)->get();
        $sessions = AcademicSession::all();
        return view('staff.examinations.broadsheet', compact('classes', 'exams', 'sessions'));
    }

    public function broadsheetDownload(
        $session_id,
        $exam_id,
        $class_id,
        $section_id
    ) {
        $currentClass = SchoolClass::find($class_id);
        $currentSection = Section::find($section_id);
        $currentSession = AcademicSession::find($session_id);
        $sessions = AcademicSession::all();


        $classes = SchoolClass::where('school_id', getSchool()->id)
            ->get();

        $sections =  $currentClass->sections;
        $markstore = MarkStore::where('school_class_id', $class_id)
            ->where('academic_session_id', $session_id)
            ->where('exam_id', $exam_id)
            ->when($section_id, function ($q, $section_id) {
                return $q->where('section_id', $section_id);
            })->get();
        $student_ids = $markstore->pluck('student_id')->unique();
        $subject_ids = $markstore->pluck('subject_id')->unique();
        $subjects = Subject::find($subject_ids);
        // $students = Student::find($student_ids);
        $students = Student::whereIn('id', $student_ids)->get();
        $exam = Exam::find($exam_id);
        // $avgs = collect();
        // foreach ($students as $student) {
        //     $results = $markstore->where('student_id', $student->id);
        //     $totalScore = $results->sum('score');
        //     $subjectsOffered = $subjects->whereIn('id', $results->pluck('subject_id')->unique())->sortBy('name');
        //     $avgs->push([
        //         'student_id' => $student->id,
        //         'avg' => $totalScore / $subjectsOffered->count()
        //     ]);
        // }
        $students = $students->map(function ($student) use ($markstore, $subjects) {
            $results = $markstore->where('student_id', $student->id);
            $totalScore = $results->sum('score');
            $subjectsOffered = $subjects->whereIn('id', $results->pluck('subject_id')->unique())->sortBy('name');
            $student['avg'] = $totalScore / $subjectsOffered->count();
            return $student;
        })->sort(function ($a, $b) {
            return ($a['avg'] > $b['avg']) ? -1 : 1;
        });

        $classAverage = $this->calculateClassAverage($exam_id, $class_id, $section_id, $currentSession->id);

        $html = view('templates.broadsheet', compact(
            // 'exams',
            'exam',
            'students',
            'classes',
            'sections',
            'subjects',
            'sessions',
            'currentClass',
            'currentSection',
            'currentSession',
            'classAverage',
            'markstore'

        ));
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a1', 'landscape')->getOptions()->setDpi(350);
        return $pdf->stream();
    }

    private function calculateClassAverage($exam_id, $class_id, $section_id, $session_id)
    {

        # calculate Class average

        $allMarkStoreFromStudents =  MarkStore::where([
            ['exam_id', $exam_id],
            ['school_class_id', $class_id],
            ['not_offered', 0],
            ['absent', 0],
            ['academic_session_id', $session_id],
        ])->when($section_id, function ($q, $section_id) {
            return $q->where('section_id', $section_id);
        })->get();


        //pluck out unique id for all the students in class
        $allStudentsId = $allMarkStoreFromStudents->pluck('student_id')->unique();

        //Get all the students total scores
        $scores = $allStudentsId->map(function ($e) use ($allMarkStoreFromStudents) {
            return [
                'student_id' => $e,
                'score' => $allMarkStoreFromStudents->where('student_id', $e)->sum('score'),
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


    public function psychomotorResults(Request $request)
    {
        $user = user();
        if ($user instanceof Staff)
            $classes = $user->school_classes->unique();
        else
            $classes = SchoolClass::where('school_id', getSchool()->id)->get();

        if ($request->getMethod() == 'POST' || $request->query->count()) {
            $exams = Exam::where('school_id', getSchool()->id)->with('exam_types')->get();
            $exam_id = $request->exam;
            $class_id = $request->class;
            $section_id = $request->section;
            $session_id = $request->session;
            $currentClass = SchoolClass::find($class_id);
            $currentSection = Section::find($section_id);
            $currentSession = AcademicSession::find(getSettings()->current_session_id);

            $sessions = AcademicSession::all();

            $sections =  $currentClass->sections;

            $students = Student::where('school_id', getSchool()->id)
                ->where('school_class_id', $class_id)
                ->where('section_id', $section_id)
                ->get();
            $exam = Exam::find($exam_id);
            $psychomotor = Psychomotor::where('school_id', getSchool()->id)->with('subjects')->first();

            if (!$psychomotor) {
                return redirect()->route('staff.examinations.psychomotors')->with('error', 'You are yet to setup Psychomotor! Do that to upload result.');
            };

            $psychomotorResult = PsychomotorResult::where([
                ['school_id', getSchool()->id],
                ['school_class_id', $class_id],
                ['section_id', $section_id],
                ['exam_id', $exam_id],
                ['section_id', $section_id],
            ])->get();

            return view('staff.examinations.psychomotor_results', compact(
                'exams',
                'exam',
                'students',
                'classes',
                'sections',
                'currentClass',
                'currentSection',
                'currentSession',
                'psychomotor',
                'sessions',
                'psychomotorResult'
            ));
        }
        $sessions = AcademicSession::all();
        $exams = Exam::where('school_id', getSchool()->id)->get();
        return view('staff.examinations.psychomotor_results', compact('classes', 'exams', 'sessions'));
    }

    public function psychomotorResultsStore(Request $request)
    {
        $class_id = $request->class;
        $section_id = $request->section;
        $exam_id = $request->exam;
        $students = $request->students;
        $session_id = $request->session;

        foreach ($students as $student_id => $subjects) {
            foreach ($subjects['subjects'] as $subject_name => $grade) {

                $data = [
                    'school_id' => request()->route()->school_id,
                    'school_class_id' => $class_id,
                    'section_id' => $section_id,
                    'exam_id' => $exam_id,
                    'section_id' => $section_id,
                    'student_id' => $student_id,
                    'academic_session_id' => $session_id,
                    'subject' => $subject_name,
                    'grade' => $grade,
                    'subject' => $subject_name

                ];
                //check if result exist already
                $psychomotorResult = PsychomotorResult::where([
                    ['school_id', getSchool()->id],
                    ['school_class_id', $class_id],
                    ['section_id', $section_id],
                    ['exam_id', $exam_id],
                    ['section_id', $section_id],
                    ['subject', $subject_name],
                    ['student_id', $student_id]
                ])->first();

                if ($psychomotorResult) {
                    $psychomotorResult->update([
                        'grade' => $grade,
                        'subject' => $subject_name
                    ]);
                    continue;
                } else {


                    $psychomotorResult = new PsychomotorResult($data);
                    $psychomotorResult->save();
                }
            }
        }

        return redirect()->action(
            'School\Staff\ExaminationController@psychomotorResults',
            [
                'exam' => $exam_id,
                'class' => $class_id,
                'section' => $section_id,
                'session' => $session_id
            ]
        );
    }


    public function affectiveTraitResults(Request $request)
    {
        $user = user();
        if ($user instanceof Staff)
            $classes = $user->school_classes->unique();
        else
            $classes = SchoolClass::where('school_id', getSchool()->id)->get();

        if ($request->getMethod() == 'POST' || $request->query->count()) {
            $exams = Exam::where('school_id', getSchool()->id)->with('exam_types')->get();
            $exam_id = $request->exam;
            $class_id = $request->class;
            $section_id = $request->section;
            $session_id = $request->session;
            $currentClass = SchoolClass::find($class_id);
            $currentSection = Section::find($section_id);
            $currentSession = AcademicSession::find(getSettings()->current_session_id);

            $sessions = AcademicSession::all();

            $sections =  $currentClass->sections;

            $students = Student::where('school_id', getSchool()->id)
                ->where('school_class_id', $class_id)
                ->where('section_id', $section_id)
                ->get();
            $exam = Exam::find($exam_id);
            $affectiveTrait = AffectiveTrait::where('school_id', getSchool()->id)->with('subjects')->first();

            if (!$affectiveTrait) {
                return redirect()->route('staff.examinations.affective_traits')->with('error', 'You are yet to setup Affective Trait! Do that to upload result.');
            };

            $affectiveTraitResult = AffectiveTraitResult::where([
                ['school_id', getSchool()->id],
                ['school_class_id', $class_id],
                ['section_id', $section_id],
                ['exam_id', $exam_id],
                ['section_id', $section_id],
            ])->get();

            return view('staff.examinations.affective_trait_results', compact(
                'exams',
                'exam',
                'students',
                'classes',
                'sections',
                'currentClass',
                'currentSection',
                'currentSession',
                'affectiveTrait',
                'sessions',
                'affectiveTraitResult'
            ));
        }
        $sessions = AcademicSession::all();
        $exams = Exam::where('school_id', getSchool()->id)->get();
        return view('staff.examinations.affective_trait_results', compact('classes', 'exams', 'sessions'));
    }

    public function affectiveTraitResultsStore(Request $request)
    {
        $class_id = $request->class;
        $section_id = $request->section;
        $exam_id = $request->exam;
        $students = $request->students;
        $session_id = $request->session;

        foreach ($students as $student_id => $subjects) {
            foreach ($subjects['subjects'] as $subject_name => $grade) {

                $data = [
                    'school_id' => request()->route()->school_id,
                    'school_class_id' => $class_id,
                    'section_id' => $section_id,
                    'exam_id' => $exam_id,
                    'section_id' => $section_id,
                    'student_id' => $student_id,
                    'academic_session_id' => $session_id,
                    'subject' => $subject_name,
                    'grade' => $grade,
                    'subject' => $subject_name

                ];
                //check if result exist already
                $affectiveTraitResult = AffectiveTraitResult::where([
                    ['school_id', getSchool()->id],
                    ['school_class_id', $class_id],
                    ['section_id', $section_id],
                    ['exam_id', $exam_id],
                    ['section_id', $section_id],
                    ['subject', $subject_name],
                    ['student_id', $student_id]
                ])->first();

                if ($affectiveTraitResult) {
                    $affectiveTraitResult->update([
                        'grade' => $grade,
                        'subject' => $subject_name
                    ]);
                    continue;
                } else {


                    $affectiveTraitResult = new AffectiveTraitResult($data);
                    $affectiveTraitResult->save();
                }
            }
        }

        return redirect()->action(
            'School\Staff\ExaminationController@affectiveTraitResults',
            [
                'exam' => $exam_id,
                'class' => $class_id,
                'section' => $section_id,
                'session' => $session_id
            ]
        );
    }


    public function commentResultSetup()
    {
        $groups = CommentResultGroup::where('school_id', getSchool()->id)->get();
        return view('staff.examinations.comment_result_setup', compact('groups'));
    }

    public function commentResultSetupPost(Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                Rule::unique('comment_result_groups')->where('school_id', getSchool()->id)
            ],
        ]);
        if (count($request->topics) > 6) {
            return redirect()->back()->with('error', 'Maximum of 6 topics is required');
        }
        $count = CommentResultGroup::where('school_id', getSchool()->id)->count();
        if ($count >= 12) {
            return redirect()->back()->with('error', 'Maximum comment result group reached');
        }

        try {
            DB::beginTransaction();
            $group = new CommentResultGroup();
            $group->title = $request->title;
            $group->school_id = request()->route()->school_id;
            $group->save();

            foreach ($request->topics as $topic) {
                $t = new CommentResultItem();
                $t->title = $topic;
                $t->comment_result_group_id = $group->id;
                $t->school_id = request()->route()->school_id;
                $t->save();
            }
            DB::commit();
            return redirect()->back()->with('message', 'Successfully created new Comment result group');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'failed creating new Comment result group');
        }


        // return view('staff.examinations.comment_result_setup');
    }

    public function commentResultSetupEdit($id)
    {
        $group = CommentResultGroup::findOrFail($id);
        $groups = CommentResultGroup::where('school_id', getSchool()->id)->get();
        return view('staff.examinations.comment_result_setup', compact('groups', 'group'));
    }

    public function commentResultSetupUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => [
                'required',
                Rule::unique('comment_result_groups')->where('school_id', getSchool()->id)->ignore($id)
            ],
        ]);

        try {
            DB::beginTransaction();
            $group = CommentResultGroup::findOrFail($id);
            $group->title = $request->title;
            $group->save();
            foreach ($request->topics as $t_id => $topic) {
                if ($group->topics()->where('id', $t_id)->first()) {
                    $t = CommentResultItem::find($t_id);
                    $t->title = $topic;
                    $t->save();
                } else {
                    $t = new CommentResultItem();
                    $t->title = $topic;
                    $t->comment_result_group_id = $group->id;
                    $t->school_id = request()->route()->school_id;
                    $t->save();
                }
            }

            DB::commit();
            return redirect()->route('staff.comment_result.setup')->with('message', 'Successfully updated Comment result group');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'failed updating Comment result group');
        }
    }

    public function commentResultSetupDestroy($id)
    {
        try {
            DB::beginTransaction();
            $commentGroup = CommentResultGroup::findOrFail($id);
            $commentGroup->topics()->delete();
            $commentGroup->delete();

            DB::commit();
            return redirect()->route('staff.comment_result.setup')->with('message', 'Successfully deleting Comment result group');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'failed deleting Comment result group');
        }
    }

    public function commentResultGrades()
    {
        $grades = CommentResultGrade::where('school_id', getSchool()->id)->get();
        return view('staff.examinations.comment_result_grades', compact('grades'));
    }

    public function commentResultGradesPost(Request $request)
    {

        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('comment_result_grades')->where('school_id', getSchool()->id)
            ],
            'remark' => 'required|string'
        ]);
        $data['school_id'] = request()->route()->school_id;

        CommentResultGrade::create($data);
        return redirect()->back()->with('message', 'Grade created successfully');

        // $grades = CommentResultGrade::where('school_id',1)->get();
        // return view('staff.examinations.comment_result_grades', compact('grades'));
    }

    public function commentResultGradesEdit($id)
    {
        $grade = CommentResultGrade::findOrFail($id);
        $grades = CommentResultGrade::where('school_id', getSchool()->id)->get();
        return view('staff.examinations.comment_result_grades', compact('grades', 'grade'));
    }

    public function commentResultGradesUpdate(Request $request, $id)
    {

        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('comment_result_grades')->where('school_id', getSchool()->id)->ignore($id)
            ],
            'remark' => 'required|string'
        ]);

        CommentResultGrade::findOrFail($id)->update($data);
        return redirect()->back()->with('message', 'Grade updated successfully');

        // $grades = CommentResultGrade::where('school_id',1)->get();
        // return view('staff.examinations.comment_result_grades', compact('grades'));
    }

    public function commentResultGradesDestroy($id)
    {
        try {
            $grade = CommentResultGrade::findOrFail($id);
            $grade->delete();
            return redirect()->back()->with('message', 'Grade deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error deleting grade');
        }
    }

    public function commentResults()
    {
        $sessions = AcademicSession::all();
        $exams = Exam::where('school_id', getSchool()->id)->get();
        $user = user();
        if ($user instanceof Staff)
            $classes = $user->school_classes->unique();
        else
            $classes = SchoolClass::where('school_id', getSchool()->id)->get();
        return view('staff.examinations.comment_results', compact('sessions', 'exams', 'classes'));
    }
    public function commentResultsFilter(Request $request)
    {

        $exam = Exam::findOrFail($request->exam);
        $currentClass = SchoolClass::findOrFail($request->class);
        $session = AcademicSession::findOrFail($request->session);
        $currentSection = Section::findOrFail($request->section);
        $sections = $currentClass->sections;

        $students = Student::where('school_id', getSchool()->id)
            ->where('school_class_id', $currentClass->id)
            ->where('section_id', $currentSection->id)->get();
        $sessions = AcademicSession::all();
        $exams = Exam::where('school_id', getSchool()->id)->get();
        $user = user();
        if ($user instanceof Staff)
            $classes = $user->school_classes->unique();
        else
            $classes = SchoolClass::where('school_id', getSchool()->id)->get();
        return view('staff.examinations.comment_results', compact('sessions', 'exams', 'classes', 'session', 'exam', 'currentClass', 'currentSection', 'students', 'sections'));
    }

    public function commentResultsUpload($student_id, $session_id, $exam_id, $class_id, $section_id)
    {

        $exam = Exam::findOrFail($exam_id);
        $currentClass = SchoolClass::findOrFail($class_id);
        $session = AcademicSession::findOrFail($session_id);
        $currentSection = Section::findOrFail($section_id);
        $sections = $currentClass->sections;

        $student = Student::findOrFail($student_id);
        $commentGroups = CommentResultGroup::where('school_id', getSchool()->id)->with('topics')->get();
        $commentGrades = CommentResultGrade::where('school_id', getSchool()->id)->get();
        // $exams = Exam::where('school_id',getSchool()->id)->get();
        // $classes = SchoolClass::where('school_id',getSchool()->id)->get();
        return view('staff.examinations.comment_result_upload', compact(
            'exam',
            'currentClass',
            'session',
            'currentSection',
            'student',
            'commentGroups',
            'commentGrades'
        ));
    }

    public function commentResultsStore(Request $request)
    {
        $student_id = $request->student_id;
        $exam_id = $request->exam_id;
        $school_class_id = $request->school_class_id;
        $section_id = $request->section_id;
        $session_id = $request->session_id;

        try {
            DB::beginTransaction();
            foreach ($request->groups as $group_id => $topics) {
                foreach ($topics['topics'] as $topic_id => $grade_id) {
                    $grade = CommentResultGrade::find($grade_id);
                    $result = CommentResult::where('comment_result_group_id', $group_id)
                        ->where('comment_result_item_id', $topic_id)
                        ->where('student_id', $student_id)
                        ->where('exam_id', $exam_id)
                        ->where('school_class_id', $school_class_id)
                        ->where('section_id', $section_id)
                        ->where('academic_session_id', $session_id)
                        ->where('school_id', getSchool()->id)->first();
                    if (!$result) {

                        $result = new CommentResult();
                        $result->comment_result_group_id = $group_id;
                        $result->student_id = $student_id;
                        $result->section_id = $section_id;
                        $result->exam_id = $exam_id;
                        $result->academic_session_id = $session_id;
                        $result->school_id = request()->route()->school_id;
                        $result->school_class_id = $school_class_id;
                        $result->comment_result_item_id = $topic_id;
                    }
                    $result->grade = $grade->name;
                    $result->remark = $grade->remark;
                    $result->comment_result_grade_id = $grade_id;
                    $result->save();
                }
            }

            // finally store the remark
            $remark = CommentResultRemark::getRemark(
                getSchool()->id,
                $session_id,
                $exam_id,
                $school_class_id,
                $section_id,
                $student_id
            );
            if ($remark) {
                $remark->update($request->merge(['academic_session_id' => $request->session_id, 'school_id' => getSchool()->id])->only(
                    ['teacher', 'headmaster', 'next_term_begins', 'next_term_fee', 'student_id', 'exam_id', 'school_id', 'school_class_id', 'section_id', 'academic_session_id']

                ));
            } else {
                CommentResultRemark::create($request->merge(['academic_session_id' => $request->session_id, 'school_id' => getSchool()->id])->only(
                    ['teacher', 'headmaster', 'next_term_begins', 'next_term_fee', 'student_id', 'exam_id', 'school_id', 'school_class_id', 'section_id', 'academic_session_id']
                ));
            }

            DB::commit();
            return redirect()->back()->with('message', 'Result uploaded successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Result upload failed');
        }
    }

    public function downloadResult(Request $request)
    {

        $html = '<!DOCTYPE html>
<html lang="en">';
        $sessions = AcademicSession::all();
        $generalSettings = GeneralSetting::where('school_id', getSchool()->id)->first();

        $exams = Exam::where('school_id', request()->route()->school_id)->with('exam_types')->get();
        $exam_id = $request->exam;
        $class_id = $request->class;
        $session_id = $request->session;
        $section_id = $request->section;
        $type = $request->type;
        $classes = SchoolClass::where('school_id', getSchool()->id)
            ->get();
        $currentClass = SchoolClass::find($class_id);
        $exam = Exam::find($exam_id);
        $session = AcademicSession::findOrFail($session_id);
        $currentSection = Section::find($section_id);

        $section = $currentSection;
        //students
        $students = Student::where('section_id', $section_id)
            ->where('school_class_id', $class_id)
            ->where('school_id', getSchool()->id)->paginate(15, ['*'], 'page', $request->page);


        $psychomotor = Psychomotor::where('school_id', request()->route()->school_id)->with('subjects', 'grades')->first();


        $pdf = App::make('dompdf.wrapper'); //prepare dompdf

        if ($type == self::COMMENT) {
            $results = CommentResult::where([
                ['exam_id', $exam_id],
                ['school_class_id', $class_id],
                ['academic_session_id', $session_id],

            ]);


            $grades = CommentResultGrade::where('school_id', request()->route()->school_id)->get();

            $section = Section::find($results->first()->section_id);
            $remarks = CommentResultRemark::where('exam_id', $exam_id)
                ->where('school_class_id', $class_id)
                ->where('academic_session_id', $session_id)
                ->where('school_id', getSchool()->id)->get();

            foreach ($students as $student) {
                $rs = getSchool()->id . "/$session_id/$exam_id/$class_id/$student->id/" . $type;
                $encryptRs = Crypt::encryptString($rs);

                $verifyUrl = 'https://' . strtolower(request()->getHost()) . '/result/verify/' . $encryptRs;

                $verifyUrlQrCode =
                    base64_encode(QrCode::format('svg')->size(80)->generate($verifyUrl));

                $result = $results->where('student_id', $student->id)->get()->groupBy('comment_result_group_id');
                $remark = $remarks->where('student_id', $student->id)->first();
                $html .= view('staff.examinations.templates.comment_result_m', compact('student', 'exam', 'session', 'classes', 'currentClass', 'exams', 'sessions', 'grades', 'result', 'remark', 'psychomotor', 'section', 'generalSettings', 'verifyUrlQrCode'))->render();
            }
        } else {

            //students scores from store
            $allMarkStoreFromStudents = MarkStore::where([
                ['exam_id', $exam_id],
                ['school_class_id', $class_id],
                ['not_offered', 0],
                ['absent', 0],
                ['academic_session_id', $session_id],
                ['section_id', $section_id],
            ])->get();
            if (!$allMarkStoreFromStudents->count()) {
                return redirect()->back()->with('message', 'No Result Available at the moment');
            }

            //get class section subjects
            $subject_ids = $allMarkStoreFromStudents->pluck('subject_id')->unique();
            $subjects = Subject::find($subject_ids);

            //pluck out unique id for all the students in class
            $allStudentsId = $allMarkStoreFromStudents->pluck('student_id')->unique();
            $total_students = $allStudentsId->count();
            $student_ids = $allMarkStoreFromStudents->pluck('student_id')->unique();
            // $students = Student::whereIn('id', $student_ids)->get();

            //Get all the students total scores
            $scores = $allStudentsId->map(function ($e) use ($allMarkStoreFromStudents) {
                $subject_count =  $allMarkStoreFromStudents->where('student_id', $e)->unique('subject_id')->count();
                $score = $allMarkStoreFromStudents->where('student_id', $e)->sum('score');
                return [
                    'student_id' => $e,
                    'score' => $score,
                    'subject_count' => $subject_count,
                    'student_average' => '' . $score / $subject_count
                ];
            })->sortByDesc('student_average');

            //get Student position in class
            // $position = $scores->pluck('student_id')->search($student_id) + 1;
            $scoresGroup = $scores->groupBy('student_average');
            $position = $scoresGroup->count();
            $newGroup = [];
            // remove the grouping score
            foreach ($scoresGroup as $group) {
                $newGroup[] = $group;
            }
            //calculate class average
            $classAverage = $this->calculateClassAverage($exam_id, $class_id, $section_id, $session_id);

            //get school remarks
            $remarks = ResultRemark::where(
                [
                    ['exam_id', $exam_id],
                    ['school_class_id', $class_id],
                ]
            )->orderBy('min_average', 'desc')->get();

            $grades = Grade::where('school_id', getSchool()->id)->get();

            foreach ($students as $student) {
                $rs = getSchool()->id . "/$session_id/$exam_id/$class_id/$student->id/" . $type;
                $encryptRs = Crypt::encryptString($rs);

                $verifyUrl = 'https://' . strtolower(request()->getHost()) . '/result/verify/' . $encryptRs;

                $verifyUrlQrCode = base64_encode(QrCode::format('svg')->size(80)->generate($verifyUrl));

                $total_mark = $allMarkStoreFromStudents->where('student_id', $student->id)->sum('score');
                $subject_ids = $allMarkStoreFromStudents->pluck('subject_id')->unique();
                $subjects = Subject::find($subject_ids);

                foreach ($newGroup as $key => $value) {
                    if (strval(collect($value)->pluck('student_id')->search($student->id)) != '') {
                        $position = $key + 1;
                    }
                }


                //calculate student average
                $studentAverage = number_format($total_mark / $subjects->count(), 2);



                // ->where('max_average', '<=', floor($studentAverage))
                $remark = $remarks->where('min_average', '<=', $studentAverage)
                    ->first();

                $html .= view('staff.examinations.templates.standard_result_m', compact(
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
                    'generalSettings',
                    'verifyUrlQrCode'
                ))->render();
            }
            // return $html;
        }
        $html .= '</html>';
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

    public function downloadSingleResult(Request $request)
    {

        $pin = Pin::where('code', $request->pin_code)->where('school_id', getSchool()->id)->first();
        if (!$pin) {
            return redirect()->back()->with('error', 'Invalid result checking pin');
        }


        if ($pin->student_id != null && $pin->student_id != $request->student) {
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
                ['section_id', $section->id],
            ])->get();

            $result = $allMarkStoreFromStudents->where('student_id', '=', $student_id);
            if (!$result->count()) {
                return redirect()->back()->with('message', 'No Result Available at the moment');
            }

            // get class section subjects
            $subjects = Subject::find($allMarkStoreFromStudents->where('student_id', $student_id)->pluck('subject_id'))->sortBy('name');
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
                'generalSettings',
                'verifyUrlQrCode',
                'affectiveTrait',
                'psychomotorResult',
                'affectiveTraitResult'
            ));
        }
        // increase pin usage
        $pin->update([
            'academic_session_id' => $session->id,
            'exam_id' => $exam->id,
            'trial' => $pin->trial + 1,
            'student_id' => $student_id,
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
}
