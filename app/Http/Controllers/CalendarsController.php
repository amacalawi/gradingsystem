<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\Helper;
use App\Models\Calendar;

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
        return view('modules/components/calendars/manage')->with(compact('menus'));
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

}
