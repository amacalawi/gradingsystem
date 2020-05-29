<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\SectionInfo;
use App\Models\Quarter;
use App\Models\Student;
use App\Models\Batch;
use App\Models\SectionsSubjects; 
use App\Models\Section;
use App\Models\Level;
use App\Models\Staff; 
use App\Models\Subject; 

class AdmissionController extends Controller
{

    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }

    public function index()
    {   
        $menus = $this->load_menus();
        $admission = $this->admission_check();
        return view('modules/academics/admissions/sectionsstudents/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        $admission = $this->admission_check();
        return view('modules/academics/admissions/sectionsstudents/manage')->with(compact('menus'));
    }    

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/admissions/sectionsstudents/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $batch_id = Batch::where('is_active', 1)->where('status','Current')->pluck('id'); //current batch
        $res = SectionInfo::select('sections_info.id','sections_info.batch_id','sections_info.section_id','sections_info.adviser_id','sections_info.level_id','sections.name as secname','staffs.user_id','levels.name as lvlname')->join('sections','sections.id','=','sections_info.section_id')->join('staffs','staffs.id','=','sections_info.adviser_id')->join('levels','levels.id','=','sections_info.level_id')->where('sections_info.is_active', 1)->where('sections_info.batch_id', $batch_id[0])->orderBy('sections_info.id', 'DESC')->get();
        
        return $res->map(function($admission) {
            return [
                'admissionId' => $admission->id,
                'admissionBatchId' => $admission->batch_id,
                'admissionSectionId' => $admission->section_id,
                'admissionSecName' => $admission->secname,
                'admissionAdviserId' => $admission->adviser_id,
                'admissionLevel' => $admission->level_id, 
                'admissionLvlName' => $admission->lvlname,
                'admissionNoStudent' => $admission->lvlname,
                'admissionNoSubject' => $admission->lvlname,
                'admissionModified' => ($admission->updated_at !== NULL) ? date('d-M-Y', strtotime($admission->updated_at)).'<br/>'. date('h:i A', strtotime($admission->updated_at)) : date('d-M-Y', strtotime($admission->created_at)).'<br/>'. date('h:i A', strtotime($admission->created_at))
            ];
        });
        
    }

    public function all_inactive(Request $request)
    {
        $res = Admission::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($admission) {
            return [
                'admissionId' => $admission->id,
                'admissionBatchId' => $admission->batch_id,
                'admissionSectionId' => $admission->section_id,
                'admissionStudentId' => $admission->student_id,
                'admissionStatus' => $admission->status,
                'admissionModified' => ($admission->updated_at !== NULL) ? date('d-M-Y', strtotime($admission->updated_at)).'<br/>'. date('h:i A', strtotime($admission->updated_at)) : date('d-M-Y', strtotime($admission->created_at)).'<br/>'. date('h:i A', strtotime($admission->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {      
        $menus = $this->load_menus();
        $admission = $this->admission_check();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $types = (new Quarter)->types();
        
        if (count($flashMessage) && $flashMessage[0]['module'] == 'sectionstudent') {
            $sectioninfos = (new SectionInfo)->fetch($flashMessage[0]['id']);
        } else {
            $sectioninfos = (new SectionInfo)->fetch($id);
        }

        return view('modules/academics/admissions/sectionsstudents/add')->with(compact('menus', 'types', 'sectioninfos', 'segment', 'flashMessage'));
    }
    
    public function store(Request $request)
    {           
        $timestamp = date('Y-m-d H:i:s');
        $batch_id = Batch::where('is_active','1')->where('status','Current')->pluck('id');
        
        if(!$batch_id){
            $batch_id[0] = '0';
        } 

        //sections_info
        $sectioninfo = SectionInfo::create([
            'batch_id' => $batch_id[0],
            'section_id' => $request->section,
            'adviser_id' => $request->adviser,
            'level_id' => $request->level,
            'type' => $request->type,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);
        
        
        //sections_subjects
        $subjects = $request->subjects;
        $teachers = $request->teachers;

        if($subjects[0] != "0" && $teachers[0] != "0")
        {
            foreach ($subjects as $key => $subject) {
                $sections_subjects = SectionsSubjects::create([
                    'batch_id' => $batch_id[0],
                    'subject_id' => $subject,
                    'teacher_id' => $teachers[$key],
                    'section_info_id' => $sectioninfo->id,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            } 
        }

        $members = $request->list_admitted_student;
        if($members)
        {
            foreach ($members as $key => $member) {
                //admission
                $enliststudent = Admission::where('student_id', $member)
                ->update([
                    'section_id' => $request->section,
                    'status' => 'admit',
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id,
                ]);
            }
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The section-student has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();

    }

    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $types = (new Quarter)->types();
        $sections = (new Section)->get_all_sections();
        $levels = (new Level)->get_all_levels();
        $advisers = $this->get_all_advisers();
        $subjects = (new Subject)->get_all_subjects();
        $teachers = (new Subject)->get_all_teachers_bytype();
        $sections_subjects = (new SectionsSubjects)->get_sections_subjects($id);
        
        $section_id = SectionInfo::where('id', $id)->pluck('section_id');
        $sections_students = (new Admission)->getthisAdmitted($section_id[0]); //section_id

        if (count($flashMessage) && $flashMessage[0]['module'] == 'sectionstudent') {
            $sectioninfos = (new SectionInfo)->fetch($flashMessage[0]['id']);
        } else {
            $sectioninfos = (new SectionInfo)->fetch($id);
        }

        return view('modules/academics/admissions/sectionsstudents/edit')->with(compact('sections_students','menus', 'sections_subjects', 'teachers', 'subjects', 'advisers', 'levels', 'sections', 'types', 'sectioninfos', 'segment', 'flashMessage'));
    }
    
    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');
        $sectioninfo = SectionInfo::find($id);
        $batch_id = Batch::where('is_active','1')->where('status','Current')->pluck('id');

        if(!$sectioninfo) {
            throw new NotFoundHttpException();
        }
        
        //sections_info
        $sectioninfo->section_id = $request->section;
        $sectioninfo->adviser_id = $request->adviser;
        $sectioninfo->level_id = $request->level;
        $sectioninfo->type = $request->type;
        $sectioninfo->updated_at = $timestamp;
        $sectioninfo->updated_by = Auth::user()->id;
        //end sections_info


        //section_subject
        $all_subjects = $request->subjects;
        $all_teachers = $request->teachers;
        $ids_sections_subjects = $request->sections_subjects;
        $counter = 1;

        foreach($ids_sections_subjects as $id_section_subject)
        {
            $ss = SectionsSubjects::find($id_section_subject);
            $ss->delete();
        }

        foreach ($all_subjects as $key => $subject) 
        {
            $sections_subjects = SectionsSubjects::create([
                'batch_id' => $batch_id[0],
                'subject_id' => $subject,
                'teacher_id' => $all_teachers[$key],
                'section_info_id' => $id,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
        }
        //end section_subject

        //admission
        $members = $request->list_admitted_student;
        if($members)
        {
            foreach ($members as $key => $member) {
                $enliststudent = Admission::where('student_id', $member)
                ->update([
                    'section_id' => $request->section,
                    'status' => 'admit',
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id,
                ]);
            }
        }
        //end admission

        if ($sectioninfo->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The section-student has been successfully updated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();

        }
    }

    public function all_admitted(Request $request)
    {

        $res = Student::select('students.*')->where('is_active', 1)->whereNotIn('id',function($query) {
            $query->select('student_id')->from('admissions');
        })->get();

        return $res->map(function($student) {
            $middlename = !empty($student->middlename) ? $student->middlename : '';
            $designation = ($student->designation_id > 0) ? '('.$student->designation->name.')' : '';
            return [
                'studentID' => $student->id,
                'studentNumber' => $student->identification_no,
                'studentName' => $student->firstname.' '.$middlename.' '.$student->lastname,
                'studentGender' => $student->gender,
                'studentContactNo' => $student->mobile_no,
                'studentModified' => ($student->updated_at !== NULL) ? date('d-M-Y', strtotime($student->updated_at)).'<br/>'. date('h:i A', strtotime($student->updated_at)) : date('d-M-Y', strtotime($student->created_at)).'<br/>'. date('h:i A', strtotime($student->created_at))
            ];
        });
      
    }

    public function get_this_admitted(Request $request, $id)
    {
        $student = (new Admission)->get_this_admitted( $id );
        echo json_encode( $student ); exit();
        
    }

    public function save_this_admitted(Request $request, $id, $section_id)
    {
        $timestamp = date('Y-m-d H:i:s');
        $batch_id = Batch::where('is_active','1')->where('status','Current')->pluck('id');
        
        $enliststudent = Admission::create([
            'batch_id' => $batch_id[0],
            'section_id' => $section_id,
            'student_id' => $id,
            'status' => 'semi-admit',
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        $student = (new Admission)->get_this_admitted( $id );
        echo json_encode( $student ); exit();
    }

    public function delete_this_admitted(Request $request, $id)
    {
        $enliststudent = Admission::where('student_id', $id);
        $enliststudent->delete();

        $data = array(
            'title' => 'Well done!',
            'text' => 'The student has been successfully deleted.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function get_all_advisers()
    {
        $advisers = Staff::where('is_active', 1)->where('type', 'Adviser')->orderBy('id', 'asc')->get();

        $advs = array();
        $advs[] = array('0' => 'select a adviser');
        
        foreach ($advisers as $adviser) {
            $advs[] = array(
                $adviser->id => $adviser->lastname.', '.$adviser->firstname.' '.$adviser->middlename,
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

    public function admission_check()
    {
        $enliststudent = Admission::where('status', 'semi-admit');
        $enliststudent->delete();
    }
}
