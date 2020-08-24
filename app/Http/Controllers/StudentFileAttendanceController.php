<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\AttendanceSheets;
use App\Models\EducationType;
use App\Models\Student;

class StudentFileAttendanceController extends Controller
{
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menus = $this->load_menus();
        return view('modules/attendancesheets/students/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/attendancesheets/students/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/attendancesheets/students/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {   
        $res = AttendanceSheets::with([
            'student' =>  function($q) { 
                $q->select(['id', 'firstname', 'middlename', 'lastname']); 
            }
        ])
        ->where('role_id', 4)
        ->where([
            'is_active' => 1
        ])->orderBy('id', 'ASC')->get();

        return $res->map(function($attendancesheet) {
            return [
                'attendancesheetID' => $attendancesheet->id,
                'attendancesheetUserName' => $attendancesheet->student->lastname.', '.$attendancesheet->student->firstname.' '.$attendancesheet->student->middlename,
                'attendancesheetTimedIn' => $attendancesheet->timed_in,
                'attendancesheetTimedOut' => $attendancesheet->timed_out,
                'attendancesheetCategoryID' => $attendancesheet->attendance_category_id,
                'attendancesheetReason' => $attendancesheet->reason,
                'attendancesheetStatus' => $attendancesheet->status,
                'attendancesheetModified' => ($attendancesheet->updated_at !== NULL) ? date('d-M-Y', strtotime($attendancesheet->updated_at)).'<br/>'. date('h:i A', strtotime($attendancesheet->updated_at)) : date('d-M-Y', strtotime($attendancesheet->created_at)).'<br/>'. date('h:i A', strtotime($attendancesheet->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = AttendanceSheets::with([
            'student' =>  function($q) { 
                $q->select(['id', 'firstname', 'middlename', 'lastname']); 
            }
        ])
        ->where([
            'is_active' => 0
        ])->orderBy('id', 'ASC')->get();

        return $res->map(function($attendancesheet) {
            return [
                'attendancesheetID' => $attendancesheet->id,
                'attendancesheetUserName' => $attendancesheet->student->lastname.', '.$attendancesheet->student->firstname.' '.$attendancesheet->student->middlename,
                'attendancesheetTimedIn' => $attendancesheet->timed_in,
                'attendancesheetTimedOut' => $attendancesheet->timed_out,
                'attendancesheetCategoryID' => $attendancesheet->attendance_category_id,
                'attendancesheetReason' => $attendancesheet->reason,
                'attendancesheetStatus' => $attendancesheet->status,
                'attendancesheetModified' => ($attendancesheet->updated_at !== NULL) ? date('d-M-Y', strtotime($attendancesheet->updated_at)).'<br/>'. date('h:i A', strtotime($attendancesheet->updated_at)) : date('d-M-Y', strtotime($attendancesheet->created_at)).'<br/>'. date('h:i A', strtotime($attendancesheet->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(5);
        $types = (new EducationType)->all_education_types();
        $student = (new Student)->fetch($id);
        if (count($flashMessage) && $flashMessage[0]['module'] == 'Attendancesheets') {
            $attendancesheets = (new AttendanceSheets)->fetch($flashMessage[0]['id']);
        } else {
            $attendancesheets = (new AttendanceSheets)->fetch($id);
        }
        return view('modules/attendancesheets/students/add')->with(compact('menus', 'attendancesheets', 'student', 'types', 'segment', 'flashMessage'));
    }

    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(5);
        $types = (new EducationType)->all_education_types();
        $student_id = AttendanceSheets::where('id', $id )->first()->user_id;
        $student = (new Student)->fetch($student_id);
        if (count($flashMessage) && $flashMessage[0]['module'] == 'Attendancesheets') {
            $attendancesheets = (new AttendanceSheets)->fetch($flashMessage[0]['id']);
        } else {
            $attendancesheets = (new AttendanceSheets)->fetch($id);
        }

        return view('modules/attendancesheets/students/edit')->with(compact('menus', 'attendancesheets', 'student', 'types', 'segment', 'flashMessage'));
    }

    public function store(Request $request)
    {   
        $timestamp = date('Y-m-d H:i:s');

        $student_arr = explode(' - ', $request->member);
        $student_dtl = Student::where('identification_no', $student_arr[0] )->first(['id', 'role_id']);

        $attendancesheets = AttendanceSheets::create([
            'user_id' => $student_dtl->id,
            'role_id' => $student_dtl->role_id,
            'timed_in' => $request->timed_in,
            'timed_out' => $request->timed_out,
            'attendance_category_id' => $request->attendance_category_id,
            'reason' => $request->reason,
            'status' => 'apr',
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);
        $data = array(
            'title' => 'Well done!',
            'text' => 'The File Attendance has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );
        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {   
        $timestamp = date('Y-m-d H:i:s');
        $attendancesheets = AttendanceSheets::find($id);
        if(!$attendancesheets) {
            throw new NotFoundHttpException();
        }
        
        $staff_arr = explode(' - ', $request->member);
        $staff_dtl = Student::where('identification_no', $staff_arr[0] )->first(['id', 'role_id']);

        $attendancesheets->user_id = $staff_dtl->id;
        $attendancesheets->role_id = $staff_dtl->role_id;
        $attendancesheets->timed_in = $request->timed_in;
        $attendancesheets->timed_out = $request->timed_out;
        $attendancesheets->attendance_category_id = $request->attendance_category_id;
        $attendancesheets->reason = $request->reason;
        $attendancesheets->status = 'approved';
        $attendancesheets->updated_at = $timestamp;
        $attendancesheets->updated_by = Auth::user()->id;

        if ($attendancesheets->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The Staff Attendance Sheets has been successfully updated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
            echo json_encode( $data ); exit();
        }
    }

    public function get_column_via_id($id, $column)
    {
        return (new Student)->where('id', $id)->first()->$column;
    }
}
