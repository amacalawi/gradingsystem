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
