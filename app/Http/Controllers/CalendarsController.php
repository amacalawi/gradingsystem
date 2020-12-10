<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\Helper;
use App\Models\Calendar;
use App\Models\CalendarSection;
use App\Models\CalendarSetting;
use App\Models\Section;
use App\Models\EducationType;
use App\Models\PresetMessage;
use App\Models\Batch;

class CalendarsController extends Controller
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

    public function index()
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/calendars/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        $sections = (New Section)->get_all_sections();
        $preset_message = (new PresetMessage)->all_preset_message();

        $types = array( '' => 'please select a type', 'full-day' => 'Full day', 'half-day' => 'Half day', 'custom-day' => 'Custom day' );

        return view('modules/components/calendars/manage')->with(compact('menus', 'sections', 'types', 'preset_message'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/calendars/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Calendar::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($calendar) {
            return [
                'calendarID' => $calendar->id,
                'calendarCode' => $calendar->code,
                'calendarName' => $calendar->name,
                'calendarDescription' => $calendar->description,
                'calendarModified' => ($calendar->updated_at !== NULL) ? date('d-M-Y', strtotime($calendar->updated_at)).'<br/>'. date('h:i A', strtotime($calendar->updated_at)) : date('d-M-Y', strtotime($calendar->created_at)).'<br/>'. date('h:i A', strtotime($calendar->created_at)),
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Calendar::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($schedule) {
            return [
                'calendarID' => $calendar->id,
                'calendarCode' => $calendar->code,
                'calendarName' => $calendar->name,
                'calendarDescription' => $calendar->description,
                'calendarModified' => ($calendar->updated_at !== NULL) ? date('d-M-Y', strtotime($calendar->updated_at)).'<br/>'. date('h:i A', strtotime($calendar->updated_at)) : date('d-M-Y', strtotime($calendar->created_at)).'<br/>'. date('h:i A', strtotime($calendar->created_at)),
            ];
        });
    }

    public function get_calendar()
    {
        $calendar = (New Calendar)->get_all_calendar();
        return $calendar;
    }

    public function store(Request $request)
    {   
        $this->is_permitted(1);
        $timestamp = date('Y-m-d H:i:s');
        
        //Calendar
        $calendar = Calendar::create([
            'batch_id' => (New Batch)->get_current_batch(),
            'code' => strtolower(str_replace(" ","-", $request->title )),
            'name' => $request->title,
            'description' => $request->description,
            'type' => $request->holidayType,
            'color' => $request->palette,
            'specification' => '',
            'start_date' => $request->eventStart,
            'end_date' => $request->eventEnd,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);
    
        //Calendar Sections
        $calendar_sections = $request->sections;
        
        foreach ($calendar_sections as $key => $calendar_section) {
            $calendarsection = CalendarSection::create([
                'calendar_id' => $calendar->id,
                'section_info_id' => $calendar_section,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
        }

        //Calendar Time Settings
        $calendar_time_settings = ['LATE_IN','LATE_OUT','EARLY_IN','EARLY_OUT','NORMAL_IN','NORMAL_OUT'];
        
        foreach ($calendar_time_settings as $key => $calendar_time_setting) {
            if($calendar_time_setting == 'LATE_IN'){
                $calendarsetting = CalendarSetting::create([
                    'calendar_id' => $calendar->id,
                    'presetmsg_id' => $request->late_in_preset_message,
                    'mode' => 1,
                    'name' => $calendar_time_setting,
                    'time_from' => $request->latein_from,
                    'time_to' => $request->latein_to,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            }
            if($calendar_time_setting == 'LATE_OUT'){
                $calendarsetting = CalendarSetting::create([
                    'calendar_id' => $calendar->id,
                    'presetmsg_id' => $request->late_out_preset_message,
                    'mode' => 0,
                    'name' => $calendar_time_setting,
                    'time_from' => $request->lateout_from,
                    'time_to' => $request->lateout_to,
                    'calendar_id' => $calendar->id,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            }
            if($calendar_time_setting == 'EARLY_IN'){
                $calendarsetting = CalendarSetting::create([
                    'calendar_id' => $calendar->id,
                    'presetmsg_id' => $request->early_in_preset_message,
                    'mode' => 1,
                    'name' => $calendar_time_setting,
                    'time_from' => $request->earlyin_from,
                    'time_to' => $request->earlyin_to,
                    'calendar_id' => $calendar->id,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            }
            if($calendar_time_setting == 'EARLY_OUT'){
                $calendarsetting = CalendarSetting::create([
                    'calendar_id' => $calendar->id,
                    'presetmsg_id' => $request->early_out_preset_message,
                    'mode' => 0,
                    'name' => $calendar_time_setting,
                    'time_from' => $request->earlyout_from,
                    'time_to' => $request->earlyout_to,
                    'calendar_id' => $calendar->id,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            }
            if($calendar_time_setting == 'NORMAL_IN'){
                $calendarsetting = CalendarSetting::create([
                    'calendar_id' => $calendar->id,
                    'presetmsg_id' => $request->normal_in_preset_message,
                    'mode' => 1,
                    'name' => $calendar_time_setting,
                    'time_from' => $request->normalin_from,
                    'time_to' => $request->normalin_to,
                    'calendar_id' => $calendar->id,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            }
            if($calendar_time_setting == 'NORMAL_OUT'){
                $calendarsetting = CalendarSetting::create([
                    'calendar_id' => $calendar->id,
                    'presetmsg_id' => $request->normal_out_preset_message,
                    'mode' => 0,
                    'name' => $calendar_time_setting,
                    'time_from' => $request->normalout_from,
                    'time_to' => $request->normalout_to,
                    'calendar_id' => $calendar->id,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            }
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The section has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
        
    }

    public function remove(Request $request, $id)
    {
        $timestamp = date('Y-m-d H:i:s');

        $calendar = Calendar::where([
            'id' => $id,
        ])
        ->update([
            'updated_at' => $timestamp,
            'updated_by' => Auth::user()->id,
            'is_active' => 0
        ]);

        $data = array(
            'title'   => 'Success',
            'message' => 'Calendar was successfully removed.',
            'type'    => 'success',
        );

        echo json_encode( $data );
    }
}
