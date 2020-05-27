<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Staff;

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
                'type' => ($subject->type) ? $subject->type : '',
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'schoolyear_id' => '',
                'type' => ''
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

    public function get_column_via_identifier($column, $id)
    {
        return self::where('id', $id)->first()->$column;
    }
    
    public function get_all_subjects_bytype($type)
    {
        $subjects = self::where('is_active', 1)->where('type', $type)->orderBy('id', 'asc')->get();

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

    //Added here to avoid conflict
    public function get_all_teachers_bytype()
    {
        $teachers = Staff::where('is_active', 1)->where('type', 'Teacher')->orderBy('id', 'asc')->get();

        $teac = array();
        $teac[] = array('0' => 'select a teacher');

        foreach ($teachers as $teacher) {
            $teac[] = array(
                $teacher->id => $teacher->lastname.', '.$teacher->firstname.' '.$teacher->middlename.'( '.$teacher->identification_no.' )',
            );
        }

        $teachers = array();
        foreach($teac as $tea) {
            foreach($tea as $key => $val) {
                $teachers[$key] = $val;
            }
        }

        return $teachers;  
    }

    //Added here to avoid conflict
    public function get_all_advisers_bytype()
    {

        $advisers = Staff::where('is_active', 1)->where('type', 'Adviser')->orderBy('id', 'asc')->get();

        $advs = array();
        $advs[] = array('0' => 'select a adviser');

        foreach ($advisers as $adviser) {
            $advs[] = array(
                $adviser->id  => $adviser->lastname.', '.$adviser->firstname.' '.$adviser->middlename.'( '.$adviser->identification_no.' )',
            );
        }

        $advisers = array();
        foreach($advs as $adv) {
            foreach($adv as $key => $val) {
                $advisers[$key] = $val;
            }
        }

        return $advisers;  
    }

}
