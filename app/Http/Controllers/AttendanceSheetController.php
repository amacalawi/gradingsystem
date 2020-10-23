<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\AttendanceSheets;
use App\User;
use App\Helper\Helper;

class AttendanceSheetController extends Controller
{
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }
    
    public function is_permitted($permission)
    {
        $privileges = explode(',', strtolower(Helper::get_privileges()));
        if (!$privileges[$permission] == 1) {
            return abort(404);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menus = $this->load_menus();
        return view('modules/academics/attendancesheets/forapproval/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/attendancesheets/forapproval/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/attendancesheets/forapproval/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {   
        $res = AttendanceSheets::with([
            'student' =>  function($q) { 
                $q->select(['id', 'user_id', 'firstname', 'middlename', 'lastname']); 
            }
        ])
        ->where('role_id', 4)
        ->where('status', 'pending')
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
                $q->select(['id', 'user_id', 'firstname', 'middlename', 'lastname']); 
            }
        ])
        ->where('role_id', 4)
        ->where('status', 'pending')
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

    public function update_status(Request $request, $id)
    {   
        $this->is_permitted(3);
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Approved') {
            $attendancesheet = AttendanceSheets::where('id', $id)
            ->update([
                'status' => 'approved',
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The attendance status has been successfully changed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
    }

}
