<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('student.result');
        return view('student.index');
    }

    public function subjects()
    {
        $section = user()->section;
        $subjects = $section->subjects()->wherePivot('school_class_id', user()->school_class_id)
            ->wherePivot('school_id', getSchool()->id)->get();
        return view('student.subjects', compact('subjects'));
    }

    public function profile()
    {
        return view('student.view', ['student' => user()]);
    }

    public function changePassword(Request $request)
    {
        $data = $request->all();
        if (!Hash::check($data['current_password'], user()->password)) {
            return redirect()->back()->with('error', 'Current Password is incorrect');
        }

        $user  = user();
        $user->password = bcrypt($data['password']);
        if ($user->save()) {
            return redirect()->back()->with('message', ' Password updated');
        }
        return redirect()->back()->with('error', 'Fail to change password');
    }

    public function viewAttendance(Request $request)
    {

        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        if ($request->query->count()) {
            $currentClass = SchoolClass::findOrFail($request->class);
            $currentSession = AcademicSession::findOrFail($request->session);
            $sessions = AcademicSession::all();
            $terms = Term::where('school_id', getSchool()->id)->get();
            $month = $request->month;
            $currentTerm = Term::findOrFail($request->term);
            $student = user();

            // check if result exist

            $attendances = Attendance::where([
                ['school_id', '=', getSchool()->id],
                ['academic_session_id', '=', $currentSession->id],
                ['term_id', '=', $currentTerm->id],
                ['student_id', '=', $student->id]
            ])->whereMonth('date', date_parse($month)['month'])->get();

            return view('student.view_attendance', compact(
                'currentClass',
                'currentSession',
                'sessions',
                'classes',
                'student',
                'month',
                'months',
                'terms',
                'currentTerm',
                'attendances'
            ));
        }
        $sessions = AcademicSession::all();
        $terms = Term::where('school_id', getSchool()->id)->get();
        return view('student.view_attendance', compact('sessions', 'classes', 'terms', 'months'));
    }
}
