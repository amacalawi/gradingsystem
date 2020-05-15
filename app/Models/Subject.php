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
                'description' => ($subject->description) ? $subject->description : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => ''
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
}
