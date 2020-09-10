<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Components\FlashMessages;
use App\Models\AttendanceSheetsSettings;
use App\Models\Batch;
use App\Models\Schedule;
use App\Models\Staff;

class StaffSettingsController extends Controller
{
    use FlashMessages;
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
        return view('modules/academics/attendancesheets/staffs/settings/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/attendancesheets/staffs/settings/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/attendancesheets/staffs/settings/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = AttendanceSheetsSettings::with([
            'staff' => function($q) { 
                $q->select(['id', 'user_id', 'identification_no', 'firstname', 'lastname', 'middlename']);
            },
            'schedule' => function($q) { 
                $q->select(['id', 'code', 'name']);
            }
        ])
        ->where([
            'batch_id' => (new Batch)->get_current_batch(),
            'is_active' => 1,
            'role_id' => 3,
        ])->orderBy('id', 'ASC')->get();

        return $res->map(function($staffsettings) {
            return [
                'staffsettingsID' => $staffsettings->id,
                //'staffsettingsStaffNo' => (new Staff)->where(['id' => $staffsettings->user_id, 'is_active' => 1])->count(),
                'staffsettingsStaffNo' => $staffsettings->staff->lastname.', '.$staffsettings->staff->firstname.' '.$staffsettings->staff->middlename,
                'staffsettingsSchedule' => $staffsettings->schedule->name,
                'staffsettingsModified' => ($staffsettings->updated_at !== NULL) ? date('d-M-Y', strtotime($staffsettings->updated_at)).'<br/>'. date('h:i A', strtotime($staffsettings->updated_at)) : date('d-M-Y', strtotime($staffsettings->created_at)).'<br/>'. date('h:i A', strtotime($staffsettings->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = AttendanceSheetsSettings::with([
            'staff' => function($q) { 
                $q->select(['id', 'identification_no', 'firstname', 'lastname', 'middlename']);
            },
            'schedule' => function($q) { 
                $q->select(['id', 'code', 'name']);
            }
        ])
        ->where([
            'batch_id' => (new Batch)->get_current_batch(),
            'is_active' => 0
        ])->orderBy('id', 'ASC')->get();

        return $res->map(function($staffsettings) {
            return [
                'staffsettingsID' => $staffsettings->id,
                'staffsettingsStaffNo' => (new Staff)->where(['id' => $staffsettings->user_id, 'is_active' => 1])->count(),
                'staffsettingsSchedule' => $staffsettings->schedule->name,
                'staffsettingsModified' => ($staffsettings->updated_at !== NULL) ? date('d-M-Y', strtotime($staffsettings->updated_at)).'<br/>'. date('h:i A', strtotime($staffsettings->updated_at)) : date('d-M-Y', strtotime($staffsettings->created_at)).'<br/>'. date('h:i A', strtotime($staffsettings->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(5);
        $staff = (new Staff)->fetch($id);
        $schedule = (new Schedule)->all_schedule($id);
        if (count($flashMessage) && $flashMessage[0]['module'] == 'Attendancesheets') {
            $attendancesheetssettings = (new AttendanceSheetsSettings)->fetch_staff($flashMessage[0]['id']);
        } else {
            $attendancesheetssettings = (new AttendanceSheetsSettings)->fetch_staff($id);
        }
        return view('modules/academics/attendancesheets/staffs/settings/add')->with(compact('menus', 'schedule', 'staff', 'attendancesheetssettings', 'segment', 'flashMessage'));
    }

    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(5);
        $attendancesheetssettings = (new AttendanceSheetsSettings)->find($id);
        $schedule = (new Schedule)->all_schedule($attendancesheetssettings->schedule_id);
        $staff = (new Staff)->fetch($attendancesheetssettings->user_id);
        return view('modules/academics/attendancesheets/staffs/settings/edit')->with(compact('menus', 'staff', 'schedule', 'attendancesheetssettings', 'segment', 'flashMessage'));
    }
    

    public function store(Request $request)
    {   
        $batch_id = Batch::where('is_active', 1)->where('status','Current')->pluck('id'); //current batch
        
        if(!$batch_id->isEmpty()){
        
            $members = $request->member;
            
            foreach($members as $member)
            {   
                $timestamp = date('Y-m-d H:i:s');
                $staff_arr = explode(' - ', $member);
                $staff_dtl = Staff::where('identification_no', $staff_arr[0] )->first(['user_id', 'role_id']);

                $already_exist = AttendanceSheetsSettings::where('user_id', $staff_dtl->user_id )->where('schedule_id', $request->schedule_id )->where('role_id', $staff_dtl->role_id )->first(['id']);
                if(!$already_exist){
                    $attendancesheetssettings = AttendanceSheetsSettings::create([
                        'batch_id' => $batch_id[0],
                        'user_id' => $staff_dtl->user_id,
                        'role_id' => $staff_dtl->role_id,
                        'schedule_id' => $request->schedule_id,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                }
            }
            /* if (!$attendancesheetssettings) {
                throw new NotFoundHttpException();
            } */

            $data = array(
                'title' => 'Well done!',
                'text' => 'The Staff Settings has been successfully saved.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

        } else {
            $data = array(
                'title' => 'Warning!',
                'text' => 'No current batch selected.',
                'type' => 'warning',
                'class' => 'btn-brand'
            );
        }

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {   
        $batch_id = Batch::where('is_active', 1)->where('status','Current')->pluck('id'); //current batch
        
        if(!$batch_id->isEmpty()){
        
            $members = $request->member;
            
            foreach($members as $member)
            {   
                $timestamp = date('Y-m-d H:i:s');
                $staff_arr = explode(' - ', $member);
                $staff_dtl = Staff::where('identification_no', $staff_arr[0] )->first(['user_id', 'role_id']);

                $already_exist = AttendanceSheetsSettings::where('id', '!=', $id)->where('user_id', $staff_dtl->user_id )->where('schedule_id', $request->schedule_id )->where('role_id', $staff_dtl->role_id )->first(['id']);
                if(!$already_exist){

                    $attendancesheetssettings = AttendanceSheetsSettings::find($id);
                    if(!$attendancesheetssettings) {
                        throw new NotFoundHttpException();
                    }

                    $attendancesheetssettings->batch_id = $batch_id[0];
                    $attendancesheetssettings->user_id = $staff_dtl->user_id;
                    $attendancesheetssettings->role_id = $staff_dtl->role_id;
                    $attendancesheetssettings->schedule_id = $request->schedule_id;
                    $attendancesheetssettings->updated_at = $timestamp;
                    $attendancesheetssettings->updated_by = Auth::user()->id;

                    if ($attendancesheetssettings->update()) {

                        $data = array(
                            'title' => 'Well done!',
                            'text' => 'The Staff Settings has been successfully saved.',
                            'type' => 'success',
                            'class' => 'btn-brand'
                        );
                    }

                }
            }
            
        } else {
            $data = array(
                'title' => 'Warning!',
                'text' => 'No current batch selected.',
                'type' => 'warning',
                'class' => 'btn-brand'
            );
        }

        echo json_encode( $data ); exit();
    }
}
