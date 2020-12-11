<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Batch;

class Calendar extends Model
{
    protected $guarded = ['id'];

    protected $table = 'calendars';
    
    public $timestamps = false;

    public function get_all_calendar()
    {
        $calendars = self::where('is_active', 1)->where('batch_id', (New Batch)->get_current_batch() )->get();
        
        $arr[] = array (
            'id' => 0,
            'title' => 'sample',
            'start' => '1994-02-03 08:00:00',
            'end' => '1994-02-03 17:00:00',
            'allDay'    => true,
            'className' => 'm-fc-event--solid-light'
        );

        foreach ($calendars as $calendar)
        {
            $arr[] = array (
                'id' => $calendar->id,
                'title' => $calendar->name,
                'start' => $calendar->start_date,
                'end' => $calendar->end_date,
                'allDay'    => true,
                'className' => $calendar->color
            );
        }

        return json_encode( $arr );
    }
    
}
