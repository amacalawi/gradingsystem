<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = ['id'];

    protected $table = 'subjects';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $subject = self::find($id);
        if ($subject) {
            $results = array(
                'id' => ($subject->id) ? $subject->id : '',
                'code' => ($subject->code) ? $subject->code : '',
                'name' => ($subject->name) ? $subject->name : '',
                'description' => ($subject->description) ? $subject->description : '',
                'schoolyear_id' => ($subject->schoolyear_id) ? $subject->schoolyear_id : '',
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'schoolyear_id' => '',
            );
        }
        return (object) $results;
    }

    public function all_subjects()
    {	
    	$subjects = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $subjectx = array();
        $subjectx[] = array('' => 'select a subject');
        foreach ($subjects as $subject) {
            $subjectx[] = array(
                $subject->id => $subject->name
            );
        }

        $subjects = array();
        foreach($subjectx as $subject) {
            foreach($subject as $key => $val) {
                $subjects[$key] = $val;
            }
        }

        return $subjects;
    }

    public function get_all_subjects()
    {
        $subjects = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $subs = array();
        $subs[] = array('0' => 'select a subject');

        foreach ($subjects as $subject) {
            $subs[] = array(
                $subject->id  => $subject->name,
            );
        }

        $subjects = array();
        foreach($subs as $sub) {
            foreach($sub as $key => $val) {
                $subjects[$key] = $val;
            }
        }

        return $subjects;  
    }
}
