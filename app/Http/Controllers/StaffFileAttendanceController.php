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
use App\Models\Staff;
use App\Models\Dtr;
use App\Models\Dtrlog;

class StaffFileAttendanceController extends Controller
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
        return view('modules/attendancesheets/staffs/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/attendancesheets/staffs/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/attendancesheets/staffs/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {   
        $res = AttendanceSheets::with([
            'staff' =>  function($q) { 
                $q->select(['id', 'user_id', 'firstname', 'middlename', 'lastname']); 
            }
        ])
        ->where('role_id', 3)
        ->where([
            'is_active' => 1
        ])->orderBy('id', 'ASC')->get();

        return $res->map(function($attendancesheet) {
            return [
                'attendancesheetID' => $attendancesheet->id,
                'attendancesheetUserName' => $attendancesheet->staff->lastname.', '.$attendancesheet->staff->firstname.' '.$attendancesheet->staff->middlename,
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
            'staff' =>  function($q) { 
                $q->select(['id', 'user_id', 'firstname', 'middlename', 'lastname']); 
            }
        ])
        ->where([
            'is_active' => 0
        ])->orderBy('id', 'ASC')->get();

        return $res->map(function($attendancesheet) {
            return [
                'attendancesheetID' => $attendancesheet->id,
                'attendancesheetUserName' => $attendancesheet->staff->lastname.', '.$attendancesheet->staff->firstname.' '.$attendancesheet->staff->middlename,
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
        $student = (new Staff)->fetch($id);
        if (count($flashMessage) && $flashMessage[0]['module'] == 'Attendancesheets') {
            $attendancesheets = (new AttendanceSheets)->fetch($flashMessage[0]['id']);
        } else {
            $attendancesheets = (new AttendanceSheets)->fetch($id);
        }
        return view('modules/attendancesheets/staffs/add')->with(compact('menus', 'attendancesheets', 'student', 'types', 'segment', 'flashMessage'));
    }

    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(5);
        $types = (new EducationType)->all_education_types();
        $staff_id = AttendanceSheets::where('id', $id )->first()->user_id;
        $staff = (new Staff)->fetch($staff_id);
        //die(var_dump($student));
        if (count($flashMessage) && $flashMessage[0]['module'] == 'Attendancesheets') {
            $attendancesheets = (new AttendanceSheets)->fetch($flashMessage[0]['id']);
        } else {
            $attendancesheets = (new AttendanceSheets)->fetch($id);
        }

        return view('modules/attendancesheets/staffs/edit')->with(compact('menus', 'attendancesheets', 'staff', 'types', 'segment', 'flashMessage'));
    }

    public function store(Request $request)
    {   
        $timestamp = date('Y-m-d H:i:s');
        $staff_arr = explode(' - ', $request->member);
        $staff_dtl = Staff::where('identification_no', $staff_arr[0] )->first(['id', 'user_id', 'role_id']);

        $status = $this->get_status_via_auth_user_type(Auth::user()->id, $staff_dtl->role_id);

        $attendancesheets = AttendanceSheets::create([
            'user_id' => $staff_dtl->user_id,
            'role_id' => $staff_dtl->role_id,
            'timed_in' => $request->timed_in,
            'timed_out' => $request->timed_out,
            'attendance_category_id' => $request->attendance_category_id,
            'reason' => $request->reason,
            'status' => $status,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if($status == 'approved')
        {
            //IN
            if($request->timed_in){
                $datetimein = explode(' ', $request->timed_in);
                $date_in = $datetimein[0];
                $time_in = $datetimein[1];
            }else{
                $date_in = '-';
                $time_in = '-';
            }

            //OUT
            if($request->timed_out){
                $datetimeout = explode(' ', $request->timed_out);
                $date_out = $datetimeout[0];
                $time_out = $datetimeout[1];
            }else{
                $date_out = '-';
                $time_out = '-';
            }

            //DTR
            $attendancesheets_dtr = Dtr::create([
                'user_id' => $staff_dtl->user_id,
                'datein' => $date_in,
                'timein' => $time_in,
                'dateout' => $date_out,
                'timeout' => $time_out,
                'total_late' => '-',
                'attendance_sheet_id' => $attendancesheets->id,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            
            //DTRLOG
            $modes = ['1','0']; //in or out
            foreach( $modes as $mode ){
                
                $in = 0; $out = 0;

                if($request->timed_in && $mode == '1'){
                    $timelog = $request->timed_in;
                    $mode = $mode;
                    $status = '_IN';
                    $in = 1;
                }
                if($request->timed_out && $mode == '0'){
                    $timelog = $request->timed_out;
                    $mode = $mode;
                    $status = '_OUT';
                    $out = 1;
                }

                if( $in || $out ){
                    $attendancesheets_dtrlog = Dtrlog::create([
                        'user_id' => $staff_dtl->user_id,
                        'timelog' => $timelog,
                        'device_id' => '1', //no device yet
                        'mode' => $mode,
                        'status' => $status,
                        'attendance_sheet_id' => $attendancesheets->id,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                }
            }

        }

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
        $staff_dtl = Staff::where('identification_no', $staff_arr[0] )->first(['id', 'user_id', 'role_id']);

        $status = $this->get_status_via_auth_user_type(Auth::user()->id, $staff_dtl->role_id);

        $attendancesheets->user_id = $staff_dtl->user_id;
        $attendancesheets->role_id = $staff_dtl->role_id;
        $attendancesheets->timed_in = $request->timed_in;
        $attendancesheets->timed_out = $request->timed_out;
        $attendancesheets->attendance_category_id = $request->attendance_category_id;
        $attendancesheets->reason = $request->reason;
        $attendancesheets->status = $status;
        $attendancesheets->updated_at = $timestamp;
        $attendancesheets->updated_by = Auth::user()->id;
        $status = 'approved';
        if($status == 'approved')
        {
            //IN
            if($request->timed_in){
                $datetimein = explode(' ', $request->timed_in);
                $date_in = $datetimein[0];
                $time_in = $datetimein[1];
            }else{
                $date_in = '-';
                $time_in = '-';
            }

            //OUT
            if($request->timed_out){
                $datetimeout = explode(' ', $request->timed_out);
                $date_out = $datetimeout[0];
                $time_out = $datetimeout[1];
            }else{
                $date_out = '-';
                $time_out = '-';
            }            

            $attendancesheets_dtr = Dtr::where('attendance_sheet_id', $id)
            ->update([
                'user_id' => $staff_dtl->user_id,
                'datein' => $date_in,
                'timein' => $time_in,
                'dateout' => $date_out,
                'timeout' => $time_out,
                'total_late' => '-',
                'attendance_sheet_id' => $id,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
            ]);

            
            //DTRLOG
            $modes = ['1','0']; //in or out
            foreach( $modes as $mode ){
                
                $in = 0; $out = 0;

                if($request->timed_in && $mode == '1'){
                    $timelog = $request->timed_in;
                    $mode = $mode;
                    $status = '_IN';
                    $in = 1;
                }
                if($request->timed_out && $mode == '0'){
                    $timelog = $request->timed_out;
                    $mode = $mode;
                    $status = '_OUT';
                    $out = 1;
                }

                if( $in || $out ){

                    $exist_in = 0;
                    $exist_out = 0;

                    if($in){
                        $exist_in = Dtrlog::where('attendance_sheet_id', $id)->where('mode', 1)->first(['status']);
                    }
                    if($out){
                        $exist_out = Dtrlog::where('attendance_sheet_id', $id)->where('mode', 0)->first(['status']);
                    }

                    if($exist_in || $exist_out){
                        $attendancesheets_dtrlog = Dtrlog::where('attendance_sheet_id', $id)->where('mode', $mode)
                        ->update([
                            'user_id' => $staff_dtl->user_id,
                            'timelog' => $timelog,
                            'device_id' => '1',
                            'mode' => $mode,
                            'status' => $status,
                            'attendance_sheet_id' => $id,
                            'updated_at' => $timestamp,
                            'updated_by' => Auth::user()->id,
                        ]);
                    } else {
                        $attendancesheets_dtrlog = Dtrlog::create([
                            'user_id' => $staff_dtl->user_id,
                            'timelog' => $timelog,
                            'device_id' => '1', //no device yet
                            'mode' => $mode,
                            'status' => $status,
                            'attendance_sheet_id' => $attendancesheets->id,
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                        ]);
                    }
                }
            }
        }

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
    
    public function get_status_via_auth_user_type($auth_id, $role_id){
        
        $status = 'pending';
        $user_role_id = Student::where('user_id', $auth_id)->first(['role_id']);
        
        if( ($role_id > 3) && ($user_role_id->role_id <= 3) ){
            $status = 'approved';
        }
        
        return $status;
    }

}
