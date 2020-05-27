<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SectionsStudents;
use App\Models\SectionsSubjects;
use App\Models\SectionsStudentsEnlist;
use App\Models\Quarter;
use App\Models\Staff;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Batch;
use App\Models\Admission;

class SectionsStudentsController extends Controller
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
        return view('modules/academics/admissions/sectionsstudents/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/admissions/sectionsstudents/manage')->with(compact('menus'));
    }    

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/admissions/sectionsstudents/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        
        $res = SectionsStudents::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($sectionsstudents) {
            return [
                'sectionsstudentsID' => $sectionsstudents->id,
                'sectionsstudentsCode' => $sectionsstudents->code,
                'sectionsstudentsName' => $sectionsstudents->name,
                'sectionsstudentsDescription' => $sectionsstudents->description,
                'sectionsstudentsSection_id' => $sectionsstudents->section_id,
                'sectionsstudentsStaff_id' => $sectionsstudents->staff_id,
                'sectionsstudentsModified' => ($sectionsstudents->updated_at !== NULL) ? date('d-M-Y', strtotime($sectionsstudents->updated_at)).'<br/>'. date('h:i A', strtotime($sectionsstudents->updated_at)) : date('d-M-Y', strtotime($sectionsstudents->created_at)).'<br/>'. date('h:i A', strtotime($sectionsstudents->created_at))
            ];
        });
        
    }

    public function all_inactive(Request $request)
    {
        $res = SectionsStudents::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($sectionsstudents) {
            return [
                'sectionsstudentsID' => $sectionsstudents->id,
                'sectionsstudentsCode' => $sectionsstudents->code,
                'sectionsstudentsName' => $sectionsstudents->name,
                'sectionsstudentsDescription' => $sectionsstudents->description,
                'sectionsstudentsSection_id' => $sectionsstudents->section_id,
                'sectionsstudentsStaff_id' => $sectionsstudents->staff_id,
                'sectionsstudentsModified' => ($sectionsstudents->updated_at !== NULL) ? date('d-M-Y', strtotime($sectionsstudents->updated_at)).'<br/>'. date('h:i A', strtotime($sectionsstudents->updated_at)) : date('d-M-Y', strtotime($sectionsstudents->created_at)).'<br/>'. date('h:i A', strtotime($sectionsstudents->created_at))
            ];
        });
        
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $types = (new Quarter)->types();

        $sections_subjects = 0;
        $allTeachers = Staff::where('is_active', 1)->where('type','Teacher')->orderBy('lastname', 'asc')->get();
        $allSubjects = Subject::all();
        $allSections = Section::all();

        if (count($flashMessage) && $flashMessage[0]['module'] == 'sectionstudent') {
            $sectionsstudents = (new SectionsStudents)->fetch($flashMessage[0]['id']);
        } else {
            $sectionsstudents = (new SectionsStudents)->fetch($id);
        }
        return view('modules/academics/admissions/sectionsstudents/add')->with(compact('menus', 'types', 'sections_students','sections_subjects','allTeachers','allSubjects','allSections', 'sectionsstudents', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $types = (new Quarter)->types();
        $sectionstudent = (new SectionsStudents)->find($id);

        $allSubjects = Subject::all();
        $allSections = Section::all();

        $sections_students = (new Admission)->getAdmitted_SectionsStudents($id); 
        $sections_subjects = (new SectionsSubjects)->getSection_Subject($id);
        $allTeachers = Staff::where('is_active', 1)->where('type','Teacher')->orderBy('lastname', 'asc')->get();
        
        if (count($flashMessage) && $flashMessage[0]['module'] == 'sectionstudent') {
            $sectionsstudents = (new SectionsStudents)->fetch($flashMessage[0]['id']);
        } else {
            $sectionsstudents = (new SectionsStudents)->fetch($id);
        }

        return view('modules/academics/admissions/sectionsstudents/edit')->with(compact('menus', 'sections_students','sections_subjects','allTeachers','allSubjects','allSections', 'sections_students','sections_subjects','allTeachers','allSubjects', 'sectionsstudents', 'types', 'sectionstudent', 'segment', 'flashMessage'));
    }
    
    public function store(Request $request)
    {           
        $timestamp = date('Y-m-d H:i:s');
        $batch_id = Batch::where('is_active','1')->where('status','Current')->pluck('id');

        $sectionstudent = SectionsStudents::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'section_id' => $request->section,
            'batch_id' => $batch_id[0],
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);
        
        //Admission teachers and subject
        
        $subjects = $request->subjects;
        $teachers = $request->teachers;

        if($subjects[0] != "0" && $teachers[0] != "0")
        {
            foreach ($subjects as $key => $subject) {
                $sections_subjects = SectionsSubjects::create([
                    'subject_id' => $subject,
                    'staff_id' => $teachers[$key],
                    'section_student_id' => $sectionstudent->id,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            } 
        }
        //section members
        $members = $request->list_admitted_student;
        if($members)
        {
            foreach ($members as $key => $member) {

                $enliststudent = Admission::find($member);
                $enliststudent->status = 'admit';
                $enliststudent->section_student_id = $sectionstudent->id;
                $enliststudent->updated_at = $timestamp;
                $enliststudent->updated_by = Auth::user()->id;
                $enliststudent->update();
                
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

    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');
        $sectionstudent = SectionsStudents::find($id);
        $batch_id = Batch::where('is_active','1')->where('status','Current')->pluck('id');

        if(!$sectionstudent) {
            throw new NotFoundHttpException();
        }
        
        //UPDATE section student
        $sectionstudent->code = $request->code;
        $sectionstudent->name = $request->name;
        $sectionstudent->description = $request->description;
        $sectionstudent->type = $request->type;
        $sectionstudent->section_id = $request->section;
        $sectionstudent->batch_id = $batch_id[0];
        $sectionstudent->updated_at = $timestamp;
        $sectionstudent->updated_by = Auth::user()->id;
        
        //UPDATE section subject and teacher
        $all_subjects = $request->subjects;
        $all_teachers = $request->teachers;
        $ids_sections_subjects = $request->sections_subjects;
        $counter = 1;

        if( ($all_teachers[0] != "NULL") && ($all_subjects[0] != "NULL") )
        {
            foreach ($all_subjects as $key => $subject) {

                if( count($ids_sections_subjects) >= $counter )
                {   

                    $counter+=1;
                    if( ( $all_teachers[$key] != 'NULL' ) && ( $subject != 'NULL' ) )
                    {
                        $ss = SectionsSubjects::find($ids_sections_subjects[$key]);
                        $ss->subject_id = $subject;
                        $ss->staff_id = $all_teachers[$key];
                        $ss->section_student_id = $id;
                        $ss->updated_at = $timestamp;
                        $ss->updated_by = Auth::user()->id;
                        $ss->update();
                    }
                    else 
                    {
                        $ss = SectionsSubjects::find($ids_sections_subjects[$key]);
                        $ss->delete();
                    }
                }
                
                elseif( ( $all_teachers[$key] != 'NULL' ) && ( $subject != 'NULL' ) )
                {   
                    $counter+=1;
                    $sections_subjects = SectionsSubjects::create([
                            'subject_id' => $subject,
                            'staff_id' => $all_teachers[$key],
                            'section_student_id' => $id,
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                    ]);
                }
                
            }  
        }
        
        //UPDATE admission
        $section_student = Admission::where('section_id', $id)->where('is_active', 1);
        $section_student->delete();
        $members = $request->list_admitted_student;
        foreach ($members as $key => $member) {
            
            $sections_students = SectionsStudents::create([
                'section_id' => $id,
                'user_id' => $member,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
        }

        //section members
        $members = $request->list_admitted_student;
        if($members)
        {
            foreach ($members as $key => $member) {

                $enliststudent = Admission::find($member);
                $enliststudent->status = 'admit';
                $enliststudent->section_student_id = $sectionstudent->id;
                $enliststudent->updated_at = $timestamp;
                $enliststudent->updated_by = Auth::user()->id;
                $enliststudent->update();
                
            }
        }

        
        if ($sectionstudent->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The section-student has been successfully updated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();

        }
    }

    public function update_status(Request $request, $id)
    {   
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Remove') {
            $sectionsstudents = SectionsStudents::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The section-student status has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else if ($action == 'Active') {
            $sectionsstudents = SectionsStudents::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The section-student status has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else if ($action == 'Current') {
            $sectionsstudents = SectionsStudents::where('id', '!=', $id)->where('status', '!=', 'Closed')
            ->update([
                'status' => 'Open',
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);

            $sectionsstudents = SectionsStudents::where([
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
                'text' => 'The section-student status has been successfully changed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else if ($action == 'Open') {
            $rows = SectionsStudents::where('id', '!=', $id)->where([
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
                $sectionsstudents = SectionsStudents::where([
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
                    'text' => 'The section-student status has been successfully changed.',
                    'type' => 'success',
                    'class' => 'btn-brand'
                );

                echo json_encode( $data ); exit();
            }
        }
        else {
            $rows = SectionsStudents::where('id', '!=', $id)->where([
                'status' => 'Open',
                'is_active' => 1
            ])->count();

            if ($rows == 1) {
                $sectionsstudents = SectionsStudents::where('id', '!=', $id)->where([
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

            $sectionsstudents = SectionsStudents::where([
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
                'text' => 'The section-student status has been successfully changed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();
        }
    }
}
