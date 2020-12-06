<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $guarded = ['id'];

    protected $table = 'calendars';
    
    public $timestamps = false;

    public function get_all_calendar()
    {
        $arr[] = array (
            'id' => 0,
            'code' => 'code',
            'name' => 'sample',
            'description' => 'sample',
            'type' => 'type',
            'color' => 'bgm-pink',
            'specification' => 'specification',
            'start_date' => '1901-07-01T12:30:00',
            'end_date' => '1901-07-01T14:15:00',
        );
        
        $calendars = self::where('is_active', 1)->where('type', 0);

        foreach ($calendars as $calendar)
        {
            $arr[] = array (
                'id' => $calendar->id,
                'code' => $calendar->code,
                'name' => $calendar->name,
                'description' => $calendar->description,
                'type' => $calendar->type,
                'color' => $calendar->color,
                'specification' => $calendar->specification,
                'start_date' => $calendar->start_date,
                'end_date' => $calendar->end_date,
            );
        }
        return json_encode( $arr );
    }
    
}
