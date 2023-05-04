<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\HostelRoom;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HostelManagementController extends Controller
{
    public function index()
    {

        $hostels = Hostel::where('school_id', getSchool()->id)->get();
        return view('staff.hostels.index', compact(
            'hostels'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('hostels')->where('school_id', request()->route()->school_id)
            ],
            'description' => 'required|string',
        ]);

        $hostel = Hostel::create([
            'name' => $request->name,
            'description' => $request->description,
            'school_id' => getSchool()->id,
            'active' => 1
        ]);
        if ($hostel) {
            return redirect()->back()->with('message', 'hostel created');
        }
        return redirect()->back()->with('error', 'failed to create hostel');
    }

    public function show($id)
    {

        $rooms = HostelRoom::where('hostel_id', $id)->get();
        $hostel = Hostel::findOrFail($id);
        return view('staff.hostels.rooms', compact(
            'rooms',
            'hostel',
        ));
    }

    public function edit($id)
    {

        $hostels = Hostel::where('school_id', getSchool()->id)->get();
        $hostel = Hostel::findOrFail($id);
        return view('staff.hostels.index', compact(
            'hostels',
            'hostel',
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('hostels')->where('school_id', request()->route()->school_id)->ignore($id)
            ],
            'description' => 'required|string',
        ]);

        $hostel = Hostel::where('school_id', getSchool()->id)->where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        if ($hostel) {
            return redirect()->back()->with('message', 'hostel updated');
        }
        return redirect()->back()->with('error', 'failed to update hostel');
    }

    public function destroy($id)
    {

        $hostel = Hostel::where('school_id', getSchool()->id)->where('id', $id)->first();
        if ($hostel and $hostel->delete()) {
            return redirect()->route('staff.hostels.index')->with('message', 'hostel deleted');
        }
        return redirect()->back()->with('error', 'failed to delete hostel');
    }


    public function storeRoom(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('hostels')->where('school_id', request()->route()->school_id)
            ],
            'description' => 'required|string',
        ]);

        $hostel = HostelRoom::create([
            'name' => $request->name,
            'description' => $request->description,
            'space' => $request->space,
            'school_id' => getSchool()->id,
            'hostel_id' => $id,
            'active' => 1
        ]);
        if ($hostel) {
            return redirect()->back()->with('message', 'Room created');
        }
        return redirect()->back()->with('error', 'failed to create room');
    }


    public function showRoom($id, $room_id)
    {

        $room = HostelRoom::findOrFail($room_id);
        $hostel = $room->hostel;
        $students = Student::where('hostel_room_id', $room_id)->get();
        return view('staff.hostels.students', compact(
            'room',
            'hostel',
            'students',
        ));
    }

    public function showHostelStudents($id)
    {

        $hostel = Hostel::findOrFail($id);
        $students = Student::whereHas('hostel_room', function ($q) use ($id) {
            return $q->where('hostel_id', $id);
        })->get();
        return view('staff.hostels.students', compact(
            'hostel',
            'students',
        ));
    }

    public function roomAssignStudent(Request $request, $id, $room_id)
    {

        $room = HostelRoom::findOrFail($room_id);
        if ($room->students()->count() == $room->space) {
            return redirect()->back()->with('error', 'No extra space available in room');
        }

        $student =  Student::where('reg_no', $request->reg_no)->where('school_id', getSchool()->id)->first();
        if (!$student) {
            return redirect()->back()->with('error', 'Invalid Student Admission Number');
        }
        if ($student->update([
            'hostel_room_id' => $room_id
        ])) {
            return redirect()->back()->with('message', 'Student Assigned to Room');
        } else {
            return redirect()->back()->with('error', 'Failed to Assign Student to room');
        }
    }

    public function roomEvictStudent(Request $request, $id, $room_id)
    {

        $room = HostelRoom::findOrFail($room_id);
        if ($room->students()->count() == $room->space) {
            return redirect()->back()->with('error', 'No extra space available in room');
        }

        $student =  Student::where('reg_no', $request->reg_no)->where('school_id', getSchool()->id)->first();
        if (!$student) {
            return redirect()->back()->with('error', 'Invalid Student Admission Number');
        }
        if ($student->update([
            'hostel_room_id' => null
        ])) {
            return redirect()->back()->with('message', 'Student Evicted to Room');
        } else {
            return redirect()->back()->with('error', 'Failed to Evict Student to room');
        }
    }

    public function editRoom($id, $room_id)
    {

        $rooms = HostelRoom::where('school_id', getSchool()->id)->where('hostel_id', $id)->get();
        $hostel = Hostel::findOrFail($id);
        $room = HostelRoom::findOrFail($room_id);
        return view('staff.hostels.rooms', compact(
            'rooms',
            'hostel',
            'room'
        ));
    }

    public function updateRoom(Request $request, $id, $room_id)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('hostel_rooms')->where('hostel_id', $id)->ignore($room_id)
            ],
            'description' => 'required|string',
        ]);

        $hostelRoom = HostelRoom::where('school_id', getSchool()->id)->where('id', $room_id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'space' => $request->space,
        ]);
        if ($hostelRoom) {
            return redirect()->back()->with('message', 'Room updated');
        }
        return redirect()->back()->with('error', 'failed to update room');
    }

    public function destroyRoom($id, $room_id)
    {

        $hostel = HostelRoom::where('school_id', getSchool()->id)->where('id', $room_id)->first();
        if ($hostel and $hostel->delete()) {
            return redirect()->route('staff.hostels.show', $id)->with('message', 'Room deleted');
        }
        return redirect()->back()->with('error', 'failed to delete hostel');
    }
}
