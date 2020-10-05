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
        if($id){
            $subjects = self::select('subjects.id', 'subjects.code', 'subjects.name', 'subjects.description', 'subjects.coordinator_id', 'subjects.is_mapeh', 'subjects.is_tle', 'subjects.material_id','subjects_education_types.education_type_id', 'subjects.is_active')
                ->join('subjects_education_types', 'subjects.id', 'subjects_education_types.subject_id')
                ->where('subjects.id', $id)
                ->where('subjects.is_active', 1)
                ->get();
        }else{
            $subjects = self::find($id);
        }

        if ($subjects) {

            $subject_ids = array();

            foreach($subjects as $subject){

                array_push( $subject_ids , $subject->education_type_id);

                $results = array(
                    'id' => ($subject->id) ? $subject->id : '',
                    'code' => ($subject->code) ? $subject->code : '',
                    'name' => ($subject->name) ? $subject->name : '',
                    'description' => ($subject->description) ? $subject->description : '',
                    'coordinator_id' => ($subject->coordinator_id) ? $subject->coordinator_id : '',
                    'education_type_id' => ($subject_ids) ? $subject_ids : '',
                    'is_mapeh' => ($subject->is_mapeh) ? $subject->is_mapeh : '',
                    'is_tle' => ($subject->is_tle) ? $subject->is_tle : '',
                    'material_id' => ($subject->material_id) ? $subject->material_id : '',
                );
            }
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'schoolyear_id' => '',
                'coordinator_id' => '',
                'education_type_id' => '',
                'is_mapeh' => '0',
                'is_tle' => '0',
                'material_id' => '1',
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

    public function get_all_subjects_with_type( $sectioninfo_id )
    {
        $sectioninfos = (new SectionInfo)->fetch($sectioninfo_id);
        $subjects = self::where('education_type_id', $sectioninfos->education_type_id)->where('is_active', 1)->orderBy('id', 'asc')->get();

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
        $subjects = self::where('is_active', 1)->where('education_type_id', $type)->orderBy('id', 'asc')->get();

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

    //Added here to avoid conflict //this function will be move if system is ready
    public function get_all_teachers_bytype()
    {
        $teachers = Staff::where('is_active', 1)->orWhere('type', 'Adviser')->orWhere('type', 'Teacher')->orderBy('id', 'asc')->get();

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

    public function edtype()
    {
        return $this->belongsTo('App\Models\EducationType', 'education_type_id', 'id');
    }

    public function subject_education_id()
    {
        return $this->belongsTo('App\Models\SubjectEducationTypes');
    }

    public function siblings()
    {
        return $this->hasMany('App\Models\Sibling', 'student_id', 'id');    
    }

}
