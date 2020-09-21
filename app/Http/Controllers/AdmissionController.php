<?php

namespace App\Http\Controllers;

use App\Imports\ClassImport;
use Maatwebsite\Excel\Facades\Excel;

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
use App\Models\EducationType;
use App\Helper\Helper;

class AdmissionController extends Controller
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
        $admission = $this->admission_check();
        return view('modules/academics/admissions/sectionsstudents/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        $admission = $this->admission_check();
        return view('modules/academics/admissions/sectionsstudents/manage')->with(compact('menus'));
    }    

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/academics/admissions/sectionsstudents/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $batch_id = Batch::where('is_active', 1)->where('status','Current')->pluck('id'); //current batch
        
        if(!$batch_id->isEmpty()){
            $res = SectionInfo::select('sections_info.classcode','sections_info.updated_at','sections_info.created_at','sections_info.id','sections_info.batch_id','sections_info.section_id','sections_info.adviser_id','sections_info.level_id','sections.name as secname','staffs.user_id','levels.name as lvlname')
            ->join('sections','sections.id','=','sections_info.section_id')
            ->join('staffs','staffs.id','=','sections_info.adviser_id')
            ->join('levels','levels.id','=','sections_info.level_id')
            ->where('sections_info.is_active', 1)
            ->where('sections_info.batch_id', $batch_id[0])
            ->orderBy('sections_info.id', 'DESC')
            ->get();

            return $res->map(function($admission) {
                return [
                    'admissionId' => $admission->id,
                    'admissionSecCode' => $admission->classcode,
                    'admissionBatchId' => $admission->batch_id,
                    'admissionSectionId' => $admission->section_id,
                    'admissionSecName' => $admission->secname,
                    'admissionAdviserId' => ucwords((new Staff)->where('id', $admission->adviser_id)->first()->firstname).' '.ucwords((new Staff)->where('id', $admission->adviser_id)->first()->lastname),
                    'admissionLevel' => $admission->level_id, 
                    'admissionLvlName' => $admission->lvlname,
                    'admissionNoStudent' => (new Admission)->where(['section_id' => $admission->section_id, 'batch_id' => $admission->batch_id, 'is_active' => 1])->count(),
                    'admissionNoSubject' => (new SectionsSubjects)->where(['section_info_id' => $admission->id, 'is_active' => 1])->count(),
                    'admissionModified' => ($admission->updated_at !== NULL) ? date('d-M-Y', strtotime($admission->updated_at)).'<br/>'. date('h:i A', strtotime($admission->updated_at)) : date('d-M-Y', strtotime($admission->created_at)).'<br/>'. date('h:i A', strtotime($admission->created_at))
                ];
            });
        }
    }

    public function all_inactive(Request $request)
    {
        $batch_id = Batch::where('is_active', 1)->where('status', 'Current')->pluck('id'); //current batch
        $res = SectionInfo::select('sections_info.classcode','sections_info.updated_at','sections_info.created_at','sections_info.id','sections_info.batch_id','sections_info.section_id','sections_info.adviser_id','sections_info.level_id','sections.name as secname','staffs.user_id','levels.name as lvlname')
            ->join('sections','sections.id','=','sections_info.section_id')
            ->join('staffs','staffs.id','=','sections_info.adviser_id')
            ->join('levels','levels.id','=','sections_info.level_id')
            ->where('sections_info.is_active', 1)
            ->where('sections_info.batch_id', '!=', $batch_id[0])
            ->orderBy('sections_info.id', 'DESC')
            ->get();
        
        return $res->map(function($admission) {
            return [
                'admissionId' => $admission->id,
                'admissionSecCode' => $admission->classcode,
                'admissionBatchId' => $admission->batch_id,
                'admissionSectionId' => $admission->section_id,
                'admissionSecName' => $admission->secname,
                'admissionAdviserId' => ucwords((new Staff)->where('id', $admission->adviser_id)->first()->firstname).' '.ucwords((new Staff)->where('id', $admission->adviser_id)->first()->lastname),
                'admissionLevel' => $admission->level_id, 
                'admissionLvlName' => $admission->lvlname,
                'admissionNoStudent' => (new Admission)->where(['section_id' => $admission->section_id, 'batch_id' => $admission->batch_id, 'is_active' => 1])->count(),
                'admissionNoSubject' => (new SectionsSubjects)->where(['section_info_id' => $admission->id, 'is_active' => 1])->count(),
                'admissionModified' => ($admission->updated_at !== NULL) ? date('d-M-Y', strtotime($admission->updated_at)).'<br/>'. date('h:i A', strtotime($admission->updated_at)) : date('d-M-Y', strtotime($admission->created_at)).'<br/>'. date('h:i A', strtotime($admission->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {     
        $this->is_permitted(0); 
        $menus = $this->load_menus();
        $admission = $this->admission_check();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $types = (new EducationType)->all_education_types();
        
        if (count($flashMessage) && $flashMessage[0]['module'] == 'sectionstudent') {
            $sectioninfos = (new SectionInfo)->fetch($flashMessage[0]['id']);
        } else {
            $sectioninfos = (new SectionInfo)->fetch($id);
        }

        return view('modules/academics/admissions/sectionsstudents/add')->with(compact('menus', 'types', 'sectioninfos', 'segment', 'flashMessage'));
    }
    
    public function store(Request $request)
    {    
        $this->is_permitted(0);       
        $timestamp = date('Y-m-d H:i:s');
        $batch_id = Batch::where('is_active','1')->where('status','Current')->pluck('id');

        if(!$batch_id->isEmpty())
        {
            $classcode = $this->generate_classcode($request->type, $request->section, $batch_id[0]);
            if(!$batch_id){
                $batch_id[0] = '0';
            } 

            $exist_classcode = SectionInfo::where('classcode', $classcode)->get();  //die(var_dump($classcode));                    
            if (($exist_classcode->count() <= 0) )
            {
                //sections_info
                $sectioninfo = SectionInfo::create([
                    'batch_id' => $batch_id[0],
                    'section_id' => $request->section,
                    'adviser_id' => $request->adviser,
                    'level_id' => $request->level,
                    'education_type_id' => $request->type,
                    'classcode' => $classcode,
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
                        $enliststudent = Admission::create([
                            'batch_id' => $batch_id[0],
                            'section_id' => $request->section,
                            'student_id' =>  $member,
                            'status' => 'admit',
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                        ]);
                    }
                }

                $data = array(
                    'title' => 'Well done!',
                    'text' => 'The classes has been successfully saved.',
                    'type' => 'success',
                    'class' => 'btn-brand'
                );
            
            } else {
                $data = array(
                    'title' => 'Warning',
                    'text' => 'Class already exist.',
                    'type' => 'warning',
                    'class' => 'btn-brand'
                );
            }
        }
        else 
        {
            $data = array(
                'title' => 'Warning',
                'text' => 'No current batch is active.',
                'type' => 'warning',
                'class' => 'btn-brand'
            );
        }

        echo json_encode( $data ); exit();

    }

    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $types = (new EducationType)->all_education_types();
        $sections = (new Section)->get_all_sections_with_type($id);
        $levels = (new Level)->get_all_levels_with_type($id);
        $subjects = (new Subject)->get_all_subjects_with_type($id);
        $advisers = $this->get_all_advisers();
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
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $batch_id = Batch::where('is_active','1')->where('status','Current')->pluck('id');
        
        if(!$batch_id->isEmpty())
        {
            $classcode = $this->generate_classcode($request->type, $request->section, $batch_id[0]);
            if(!$batch_id){
                $batch_id[0] = '0';
            } 

            $exist_classcode = SectionInfo::where('classcode', $classcode)->get();
            if (($exist_classcode->count() > 0) )
            {

                $sectioninfo = SectionInfo::find($id);
                if(!$sectioninfo) {
                    throw new NotFoundHttpException();
                }
                
                //sections_info
                $sectioninfo->section_id = $request->section;
                $sectioninfo->adviser_id = $request->adviser;
                $sectioninfo->level_id = $request->level;
                $sectioninfo->education_type_id = $request->type;
                $sectioninfo->classcode = $classcode;
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

                //admissions
                $members = $request->list_admitted_student;
                if($members)
                {
                    foreach ($members as $key => $member) {
                        
                        $checkstudent = Admission::where('batch_id', $batch_id[0])->where('student_id', $member)->count();

                        if($checkstudent) //UPDATE
                        {   
                            $enliststudent = Admission::where('student_id', $member)
                            ->update([
                                'section_id' => $request->section,
                                'status' => 'admit',
                                'updated_at' => $timestamp,
                                'updated_by' => Auth::user()->id,
                            ]);
                        } 
                        else  //ADD
                        {   
                            $sections_subjects = Admission::create([
                                'batch_id' => $batch_id[0],
                                'section_id' =>  $request->section,
                                'status' => 'admit',
                                'student_id' => $member,
                                'created_at' => $timestamp,
                                'created_by' => Auth::user()->id
                            ]);
                        }
                    }

                    //DELETE
                    $students = Admission::select('student_id')->where('section_id', $request->section)->whereNotIn('student_id', $request->list_admitted_student )->get();
                    foreach($students as $student)
                    {
                        $ss = Admission::where('student_id', $student['student_id']);
                        $ss->delete();
                    }

                } 
                else //No student selected 
                {
                    $ss = Admission::where('section_id', $request->section);
                    $ss->delete();
                }
                //end admissions

                if ($sectioninfo->update()) {
                    $data = array(
                        'title' => 'Well done!',
                        'text' => 'The classes has been successfully updated.',
                        'type' => 'success',
                        'class' => 'btn-brand'
                    );
                }
            
            }else {
                $data = array(
                    'title' => 'Warning',
                    'text' => 'Class already exist.',
                    'type' => 'warning',
                    'class' => 'btn-brand'
                );
            }
        }
        else 
        {
            $data = array(
                'title' => 'Warning',
                'text' => 'No current batch is active.',
                'type' => 'warning',
                'class' => 'btn-brand'
            );
        }

        echo json_encode( $data ); exit();
    }

    public function update_status(Request $request, $id)
    {   
        $this->is_permitted(3);
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Remove') {
            $sectioninfos = SectionInfo::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The admission status has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else if ($action == 'Active') {
            $sectioninfos = SectionInfo::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The admission status has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else if ($action == 'Current') {
            $sectioninfos = SectionInfo::where('id', '!=', $id)->where('status', '!=', 'Closed')
            ->update([
                'status' => 'Open',
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);

            $sectioninfos = SectionInfo::where([
                'id' => $id,
            ])
            ->update([
                'status' => $request->input('items')[0]['action'],
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The admission status has been successfully changed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else if ($action == 'Open') {
            $rows = SectionInfo::where('id', '!=', $id)->where([
                'status' => 'Open',
                'is_active' => 1
            ])->count();
                
            if ($rows > 0) {
                $data = array(
                    'title' => 'Oh snap!',
                    'text' => 'Only one (Open Status) can be changed at a time.',
                    'type' => 'warning',
                    'class' => 'btn-danger'
                );
        
                echo json_encode( $data ); exit();
            } else {
                $sectioninfos = SectionInfo::where([
                    'id' => $id,
                ])
                ->update([
                    'status' => $request->input('items')[0]['action'],
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id,
                    'is_active' => 1
                ]);

                $data = array(
                    'title' => 'Well done!',
                    'text' => 'The admission status has been successfully changed.',
                    'type' => 'success',
                    'class' => 'btn-brand'
                );

                echo json_encode( $data ); exit();
            }
        }
        else {
            $rows = SectionInfo::where('id', '!=', $id)->where([
                'status' => 'Open',
                'is_active' => 1
            ])->count();

            if ($rows == 1) {
                $sectioninfos = SectionInfo::where('id', '!=', $id)->where([
                    'status' => 'Open',
                    'is_active' => 1
                ])
                ->update([
                    'status' => 'Current',
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id,
                    'is_active' => 1
                ]);
            }

            $sectioninfos = SectionInfo::where([
                'id' => $id,
            ])
            ->update([
                'status' => $request->input('items')[0]['action'],
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The admission status has been successfully changed.',
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

    public function get_this_admitted_section(Request $request, $section_id)
    {
        $student = (new Admission)->get_this_admitted_section( $section_id );
        echo json_encode( $student ); exit();
    }

    public function save_this_admitted(Request $request, $id, $section_id)
    {
        $timestamp = date('Y-m-d H:i:s');
        $batch_id = Batch::where('is_active','1')->where('status','Current')->pluck('id');
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

    public function generate_classcode($type, $section_id, $batch_id)
    {
        //Type
        $type = $this->check_type($type);
        $tc = '';
        $type_code = explode('-', $type);
        foreach ($type_code as $ty_code) {
            $tc .= strtoupper($ty_code[0]);
        }

        //section
        $section_code = Section::where('id', $section_id)->pluck('name');
        $sc = strtoupper(substr($section_code[0], 0, 2));

        //batch
        $batch_code = Batch::where('id', $batch_id)->where('status', 'Current')->pluck('date_start');
        $bt_code = explode('-', $batch_code[0]);
        foreach ($bt_code as $btcode)
        {
            if( strlen($btcode) == 4){ //Year
                $bc = substr($btcode, 2, 2);
            }
        }

        //section id
        $sidc = sprintf("%02d", $section_id);

        //combine
        $classcode = $tc.$sc.'-'.$bc.$sidc;

        return $classcode;
    }

    public function check_type($type_id)
    {
        $educationtypes = EducationType::select('id', 'code')->where('id', $type_id)->where('is_active', 1)->get();
        $education_code = 0;
        foreach($educationtypes as $educationtype){
            if($educationtype->id){
                $education_code = $educationtype->code;
            }
        }
        return $education_code;
    }

    public function import(Request $request)
    {
        foreach($_FILES as $file)
        {  
            $row = 0; $timestamp = date('Y-m-d H:i:s');
            if (($files = fopen($file['tmp_name'], "r")) !== FALSE) 
            {
                while (($data = fgetcsv($files, 3000, ",")) !== FALSE) 
                {
                    $row++;
                    if ($row > 1) { 
                        if ($data[0] !== '') {

                            $batch_id = Batch::where('is_active', 1)->where('status','Current')->pluck('id');
                            
                            if(!$batch_id->isEmpty())
                            {   
                                $exist_type = EducationType::where('code', $data[2])->pluck('id');
                                $exist_section = Section::where('code', $data[0])->where('education_type_id', $exist_type[0])->first();
                                $exist_level = Level::where('code', $data[1])->where('education_type_id', $exist_type[0])->first();
                                $exist_adviser = Staff::where('identification_no', $data[3])->first();

                                if(($exist_section) && ($exist_level) && ($exist_adviser) && ($data[4] != ''))
                                {
                                    $classcode = $this->generate_classcode($exist_type[0], $exist_section->id, $batch_id[0]);
                                    $exist_classcode = SectionInfo::where('classcode', $classcode)->get();
                                   
                                    if (($exist_classcode->count() > 0) ) { //UPDATE
                                        
                                        //Section info
                                        $sectioninfo = SectionInfo::find($exist_classcode->first()->id);
                                        $sectioninfo->batch_id = $batch_id[0];
                                        $sectioninfo->section_id = Section::where('code', $data[0])->first()->id;
                                        $sectioninfo->adviser_id = Staff::where('identification_no', $data[3])->first()->id;
                                        $sectioninfo->level_id = Level::where('code', $data[1])->first()->id;
                                        $sectioninfo->education_type_id = EducationType::where('code', $data[2])->first()->id;
                                        $sectioninfo->classcode = $classcode;
                                        $sectioninfo->updated_at = $timestamp;
                                        $sectioninfo->updated_by = Auth::user()->id;
                                        $sectioninfo->update();

                                        //Section subject
                                        $sections_subjects_str = $data[4];
                                        $sections_subjects_arr = explode(", ", $sections_subjects_str);

                                        $ss = SectionsSubjects::where('section_info_id', $exist_classcode->first()->id);
                                        $ss->delete();
                                       
                                        foreach($sections_subjects_arr as $sections_subjects)
                                        {
                                            $sec_subs = explode("&", $sections_subjects);
                                            $exist_subject = Subject::where('code', $sec_subs[0])->first();
                                            $exist_teacher = Staff::where('identification_no', $sec_subs[1])->where('type', 'Teacher')->first();

                                            if($exist_subject && $exist_teacher)
                                            {  
                                                $sections_subjects = SectionsSubjects::create([
                                                    'batch_id' => $batch_id[0],
                                                    'subject_id' => Subject::where('code', $sec_subs[0])->first()->id,
                                                    'teacher_id' => Staff::where('identification_no', $sec_subs[1])->where('type', 'Teacher')->first()->id,
                                                    'section_info_id' => $exist_classcode->first()->id,
                                                    'created_at' => $timestamp,
                                                    'created_by' => Auth::user()->id
                                                ]); 
                                            }
                                        }

                                        //Student
                                        if($data[5] != ''){

                                            $admit = Admission::where('batch_id', $batch_id[0])->where('section_id', $exist_section->id);
                                            $admit->delete();

                                            $students_arr = explode(", ", $data[5]);
                                            foreach($students_arr as $student){
                                                
                                                $exist_student = Student::where('identification_no', $student)->first();
                                                
                                                if( $exist_student ){

                                                    $check_student = Admission::where('batch_id', $batch_id[0])->where('student_id', $exist_student->id)->first();
                                                    if( !$check_student ){
                                                        $admission = Admission::create([
                                                            'batch_id' => $batch_id[0],
                                                            'section_id' => $exist_section->id,
                                                            'student_id' => $exist_student->id,
                                                            'status' => 'admit',
                                                            'created_at' => $timestamp,
                                                            'created_by' => Auth::user()->id
                                                        ]);
                                                    }
                                                }
                                            }
                                        }

                                    }else { //ADD

                                        $check_sec_sub = $this->validate_sec_sub($data[4]);

                                        if($check_sec_sub > 0)
                                        {
                                            $sectioninfo = SectionInfo::create([
                                                'batch_id' => $batch_id[0],
                                                'section_id' => $exist_section->id,
                                                'adviser_id' => $exist_adviser->id,
                                                'level_id' => $exist_level->id,
                                                'education_type_id' => $exist_type[0],
                                                'classcode' => $classcode,
                                                'created_at' => $timestamp,
                                                'created_by' => Auth::user()->id
                                            ]);
                                            
                                            //Section subject
                                            $sections_subjects_str = $data[4];
                                            $sections_subjects_arr = explode(", ", $sections_subjects_str);
                                            foreach($sections_subjects_arr as $sections_subjects)
                                            {
                                                $sec_subs = explode("&", $sections_subjects);
                                                $exist_subject = Subject::where('code', $sec_subs[0])->first();
                                                $exist_teacher = Staff::where('identification_no', $sec_subs[1])->where('type', 'Teacher')->first();

                                                if($exist_subject && $exist_teacher)
                                                {   
                                                    $sections_subjects = SectionsSubjects::create([
                                                        'batch_id' => $batch_id[0],
                                                        'subject_id' => Subject::where('code', $sec_subs[0])->first()->id,
                                                        'teacher_id' => Staff::where('identification_no', $sec_subs[1])->where('type', 'Teacher')->first()->id,
                                                        'section_info_id' => $sectioninfo->id,
                                                        'created_at' => $timestamp,
                                                        'created_by' => Auth::user()->id
                                                    ]);
                                                }
                                            }
                                        }

                                        //Student
                                        if($data[5] != ''){
                                            $students_arr = explode(", ", $data[5]);
                                            foreach($students_arr as $student){
                                                $exist_student = Student::where('identification_no', $student)->first();
                                                if( $exist_student ){
                                                    $check_student = Admission::where('batch_id', $batch_id[0])->where('student_id', $exist_student->id)->first();
                                                    if( !$check_student ){
                                                        $admission = Admission::create([
                                                            'batch_id' => $batch_id[0],
                                                            'section_id' => $exist_section->id,
                                                            'student_id' =>  $exist_student->id,
                                                            'status' => 'admit',
                                                            'created_at' => $timestamp,
                                                            'created_by' => Auth::user()->id
                                                        ]);
                                                    }
                                                }
                                            }
                                        }

                                    }
                                }
                            }
                        }
                    }
                }
                fclose($files);
            }
        }

        $data = array(
            'message' => 'success'
        );

        echo json_encode( $data );
        exit();
    }

    public function validate_sec_sub($sec_sub)
    {
        $check_sec_sub = 0;
        if($sec_sub){
            $sections_subjects_str = $sec_sub;
            $sections_subjects_arr = explode(",", $sections_subjects_str);
            foreach($sections_subjects_arr as $sections_subjects)
            {
                $sec_subs = explode("&", $sections_subjects);
                $exist_subject = Subject::where('code', $sec_subs[0])->first();
                $exist_teacher = Staff::where('identification_no', $sec_subs[1])->where('type', 'Teacher')->first();
                if($exist_subject && $exist_teacher)
                {   
                    $check_sec_sub++;
                }
            }
        }

        return $check_sec_sub;
    }

}
