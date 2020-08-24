<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use App\Models\DtrTimeSetting;
use App\Models\DtrTimeDay;
use App\Models\PresetMessage;

class SchedulesController extends Controller
{
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }

    public function index()
    {   
        $menus = $this->load_menus();
        return view('modules/components/schedules/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/components/schedules/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/components/schedules/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Schedule::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($schedule) {
            return [
                'scheduleID' => $schedule->id,
                'scheduleCode' => $schedule->code,
                'scheduleName' => $schedule->name,
                'scheduleDescription' => $schedule->description,
                'scheduleModified' => ($schedule->updated_at !== NULL) ? date('d-M-Y', strtotime($schedule->updated_at)).'<br/>'. date('h:i A', strtotime($schedule->updated_at)) : date('d-M-Y', strtotime($schedule->created_at)).'<br/>'. date('h:i A', strtotime($schedule->created_at)),
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Schedule::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($schedule) {
            return [
                'scheduleID' => $schedule->id,
                'scheduleCode' => $schedule->code,
                'scheduleName' => $schedule->name,
                'scheduleDescription' => $schedule->description,
                'scheduleModified' => ($schedule->updated_at !== NULL) ? date('d-M-Y', strtotime($schedule->updated_at)).'<br/>'. date('h:i A', strtotime($schedule->updated_at)) : date('d-M-Y', strtotime($schedule->created_at)).'<br/>'. date('h:i A', strtotime($schedule->created_at)),
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $dtr_time_setting = (new DtrTimeSetting)->fetch($id);
        $preset_message = (new PresetMessage)->all_preset_message();

        if (count($flashMessage) && $flashMessage[0]['module'] == 'schedule') {
            $schedule = (new Schedule)->fetch($flashMessage[0]['id']);
        } else {
            $schedule = (new Schedule)->fetch($id);
        }

        return view('modules/components/schedules/add')->with(compact('menus', 'schedule', 'preset_message', 'dtr_time_setting', 'segment', 'flashMessage'));
    }

    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        $schedule = (new Schedule)->find($id);

        $preset_times = ['normal_in','normal_out','late_in','late_out','early_in','early_out'];
        foreach($preset_times as $preset_time ){
            $dtr_time_setting_pm[$preset_time] = (new DtrTimeSetting)->get_preset_message_id($preset_time, $id);
        }
        
        //die( var_dump($dtr_time_setting_pm) );
        $preset_message = (new PresetMessage)->all_preset_message();

        return view('modules/components/schedules/edit')->with(compact('menus', 'schedule', 'dtr_time_setting_pm', 'preset_message', 'dtr_time_setting', 'segment', 'flashMessage'));
    }

    public function store(Request $request)
    {   
        $timestamp = date('Y-m-d H:i:s');        
       
        //Schedule
        $schedule = Schedule::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$schedule) {
            throw new NotFoundHttpException();
        }

        //Dtr time settings
        $days = $request->days;
        $code_in_outs = $request->code_in_out;
        $check_days = $request->check_day;
 
        foreach ($code_in_outs as $code_in_out)
        {
            if($code_in_out == 'normal_in' || $code_in_out == 'late_in' || $code_in_out == 'early_in' ){// 
                
                if($code_in_out == 'normal_in'){
                    $presetmsg_id = $request->normal_in_preset_message;
                } elseif($code_in_out == 'late_in'){
                    $presetmsg_id = $request->late_in_preset_message;
                } elseif($code_in_out == 'early_in'){
                    $presetmsg_id = $request->early_in_preset_message;
                }
                $mode = 1;

            }elseif($code_in_out == 'normal_out' || $code_in_out == 'late_out' || $code_in_out == 'early_out' ){ //
                
                if($code_in_out == 'normal_out'){
                    $presetmsg_id = $request->normal_out_preset_message;
                } elseif($code_in_out == 'late_out'){
                    $presetmsg_id = $request->late_out_preset_message;
                } elseif($code_in_out == 'early_out'){
                    $presetmsg_id = $request->early_out_preset_message;
                }
                $mode = 0;

            }else{
                $mode = -1;
            }
            
            $dtrtimesettings = DtrTimeSetting::create([
                'name' => $code_in_out,
                'mode' => $mode,
                'presetmsg_id' => $presetmsg_id,
                'schedule_id' => $schedule->id,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);

            foreach($days as $day){

                $thisday = array_search($day, $check_days); //find day to save
                
                if($thisday > -1){
                    $time_from_name = $day."_".$code_in_out."_from";
                    $time_to_name = $day."_".$code_in_out."_to";    
                    $time_from = $_POST[$time_from_name];
                    $time_to = $_POST[$time_to_name];
                }else{    
                    $time_from = '00:00:00';
                    $time_to = '00:00:00';
                }

                $dtrtimedays = DtrTimeDay::create([
                    'day' => $day,
                    'time_from' => $time_from,
                    'time_to' => $time_to,
                    'dtr_time_settings_id' => $dtrtimesettings->id,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
                
            }
        } 

        $data = array(
            'title' => 'Well done!',
            'text' => 'The schedule has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $schedule = Schedule::find($id);

        if(!$schedule) {
            throw new NotFoundHttpException();
        }

        $schedule->code = $request->code;
        $schedule->name = $request->name;
        $schedule->description = $request->description;
        $schedule->updated_at = $timestamp;
        $schedule->updated_by = Auth::user()->id;


        $days = $request->days;
        $code_in_outs = $request->code_in_out;
        $check_days = $request->check_day;

        //die(var_dump($code_in_outs));
        //*
        foreach ($code_in_outs as $code_in_out)
        {
            if($code_in_out == 'normal_in' || $code_in_out == 'late_in' || $code_in_out == 'early_in' ){// 
                
                if($code_in_out == 'normal_in'){
                    $presetmsg_id = $request->normal_in_preset_message;
                } elseif($code_in_out == 'late_in'){
                    $presetmsg_id = $request->late_in_preset_message;
                } elseif($code_in_out == 'early_in'){
                    $presetmsg_id = $request->early_in_preset_message;
                }
                $mode = 1;

            }elseif($code_in_out == 'normal_out' || $code_in_out == 'late_out' || $code_in_out == 'early_out' ){ //
            
                if($code_in_out == 'normal_out'){
                    $presetmsg_id = $request->normal_out_preset_message;
                } elseif($code_in_out == 'late_out'){
                    $presetmsg_id = $request->late_out_preset_message;
                } elseif($code_in_out == 'early_out'){
                    $presetmsg_id = $request->early_out_preset_message;
                }
                $mode = 0;
            
            }else{
                $mode = -1;
            }
            
            $dtrtimesettings = DtrTimeSetting::where([
                'schedule_id' => $id,
                'name' => $code_in_out
            ])
            ->update([
                'name' => $code_in_out,
                'mode' => $mode,
                'presetmsg_id' => $presetmsg_id,
                'schedule_id' => $id,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
            ]);

            foreach($days as $day){
                
                $thisday = array_search($day, $check_days); //find day to save
                
                if($thisday > -1){
                    $time_from_name = $day."_".$code_in_out."_from";
                    $time_to_name = $day."_".$code_in_out."_to";    
                    $time_from = $_POST[$time_from_name];
                    $time_to = $_POST[$time_to_name];
                }else{    
                    $time_from = '00:00:00';
                    $time_to = '00:00:00';
                }

                $dtrtimesettings_id = DtrTimeSetting::select('id')->where('schedule_id', $id)->where('name', $code_in_out)->pluck('id');
                
                $dtrtimedays = DtrTimeDay::where([
                    'dtr_time_settings_id' => $dtrtimesettings_id[0],
                    'day' => $day
                ])
                ->update([
                    'day' => $day,
                    'time_from' => $time_from,
                    'time_to' => $time_to,
                    'dtr_time_settings_id' => $dtrtimesettings_id[0],
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id,
                ]);
                
            }
        } 
        //*/

        if ($schedule->update()) {
            $data = array(
                'title' => 'Well done!',
                'text' => 'The schedule has been successfully updated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
            echo json_encode( $data ); exit();
        }
    }   

    public function update_status(Request $request, $id)
    {   
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Remove') {
            $schedules = Schedule::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The schedule status has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }

        else if ($action == 'Active') {
            $schedules = Schedule::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The schedule status has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }

    }
 
    public function get_this_schedule(Request $request, $id)
    {
        $schedule = (new Schedule)->get_this_schedule( $id );
        echo json_encode( $schedule ); exit();
    }
}
