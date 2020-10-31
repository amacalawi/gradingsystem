<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Staff;
use App\Models\Component;

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

    public function all_subjects_selectpicker($id = '')
    {	
        if ($id == '') {
            $subjects = self::where('is_active', 1)
            ->orderBy('id', 'ASC')
            ->get();
        } else {
            $subjects = self::
            whereIn('id',
                SectionsSubjects::select('subject_id')
                ->whereIn('section_info_id', 
                    SectionInfo::select('id')->where([
                        'batch_id' => (new Batch)->get_current_batch(), 
                        'is_active' => 1,
                        'section_info_id' => (new Component)->where('id', $id)->pluck('section_info_id')
                    ])
                )->where([
                    'batch_id' => (new Batch)->get_current_batch(),
                    'is_active' => 1
                ])
            )
            ->where(['is_active' => 1])
            ->orderBy('id', 'ASC')
            ->get();
        }

        $subjectx = array();
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
        $subjects = self::select('subjects.id', 'subjects.name')->join('subjects_education_types', 'subjects_education_types.subject_id', 'subjects.id')->where('subjects_education_types.education_type_id', $sectioninfos->education_type_id)->where('subjects.is_active', 1)->orderBy('subjects.id', 'asc')->get();

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
        $subjects = self::select('subjects.id as sub_id', 'subjects.name')->join('subjects_education_types','subjects.id','subjects_education_types.subject_id')->where('subjects.is_active', 1)->where('subjects_education_types.education_type_id', $type)->orderBy('subjects.id', 'asc')->get();

        $subs = array();
        $subs[] = array('0' => 'select a subject');

        foreach ($subjects as $subject) {
            $subs[] = array(
                $subject->sub_id  => $subject->name,
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
