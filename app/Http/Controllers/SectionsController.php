<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Staff;
use App\Models\Level;
use App\Models\SectionsSubjects;
use App\Models\SectionsStudents;
use App\Models\Admission;

class SectionsController extends Controller
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
        return view('modules/academics/sections/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/sections/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/sections/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Section::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($section) {
            return [
                'sectionID' => $section->id,
                'sectionCode' => $section->code,
                'sectionName' => $section->name,
                'sectionDescription' => $section->description,
                'sectionModified' => ($section->updated_at !== NULL) ? date('d-M-Y', strtotime($section->updated_at)).'<br/>'. date('h:i A', strtotime($section->updated_at)) : date('d-M-Y', strtotime($section->created_at)).'<br/>'. date('h:i A', strtotime($section->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Section::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($section) {
            return [
                'sectionID' => $section->id,
                'sectionCode' => $section->code,
                'sectionName' => $section->name,
                'sectionDescription' => $section->description,
                'sectionModified' => ($section->updated_at !== NULL) ? date('d-M-Y', strtotime($section->updated_at)).'<br/>'. date('h:i A', strtotime($section->updated_at)) : date('d-M-Y', strtotime($section->created_at)).'<br/>'. date('h:i A', strtotime($section->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $levels = (new Level)->all_levels();
        $subjects = (new Subject)->all_subjects();
        $admitted = (new Admission)->all_admitted_student();
        $staffs = Staff::select('id', 'lastname', 'firstname', 'middlename', 'identification_no')->where('type','Teacher')->orderBy('lastname', 'asc')->get();
        $sections_subjects = 0;

        
        $stfs = array();
        $stfs[] = array('' => 'select a teacher');
        foreach ($staffs as $staff) {
            $stfs[] = array(
                $staff->id => $staff->lastname.', '.$staff->firstname.' '.$staff->firstname.' ('.$staff->identification_no.')'
            );
        }

        $staffs = array();
        foreach($stfs as $stf) {
            foreach($stf as $key => $val) {
                $staffs[$key] = $val;
            }
        }

        $section = (new Section)->fetch($id); 
        //die( var_dump($staffs) );
        return view('modules/academics/sections/add')->with(compact('menus', 'section', 'sections_subjects', 'admitted', 'levels', 'staffs', 'subjects', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $allSubjects = Subject::all();
        $allTeachers = Staff::where('is_active', 1)->where('type','Teacher')->orderBy('lastname', 'asc')->get();

        $levels = (new Level)->all_levels();
        $subjects = (new Subject)->all_subjects();

        $sections_students = (new SectionsStudents)->getSection_Student($id);
        $sections_subjects = (new SectionsSubjects)->getSection_Subject($id);

        $staffs = Staff::select('id', 'lastname', 'firstname', 'middlename', 'identification_no')->where('is_active', 1)->where('type','Teacher')->orderBy('lastname', 'asc')->get();
        $stfs = array();
        $stfs[] = array('' => 'select a teacher');
        foreach ($staffs as $staff) {
            $stfs[] = array(
                $staff->id => $staff->lastname.', '.$staff->firstname.' '.$staff->firstname.' ('.$staff->identification_no.')'
            );
        }
        
        $staffs = array();
        foreach($stfs as $stf) {
            foreach($stf as $key => $val) {
                $staffs[$key] = $val;
            }
        }

        $section = (new Section)->find($id);

        return view('modules/academics/sections/edit')->with(compact('menus', 'section', 'sections_students', 'allTeachers', 'allSubjects', 'staffs', 'sections_subjects', 'sections_teachers', 'subjects', 'levels', 'segment', 'flashMessage'));

    }
    
    public function store(Request $request)
    {   
        
        $timestamp = date('Y-m-d H:i:s');

        $section = Section::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'level_id' => $request->level_id,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);
        
        //section subject
        $subjects = $request->subjects;
        $teachers = $request->teachers;
        foreach ($subjects as $key => $subject) {
            
            $sections_subjects = SectionsSubjects::create([
                'section_id' => $section->id,
                'subject_id' => $subject,
                'staff_id' => $teachers[$key],
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            
        }
        
        //section members
        $members = $request->list_admitted_student;
        foreach ($members as $key => $member) {
            
            $sections_students = SectionsStudents::create([
                'section_id' => $section->id,
                'user_id' => $member,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
        }
        
        $data = array(
            'title' => 'Well done!',
            'text' => 'The section has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();

    }

    public function update(Request $request, $id)
    {   
        
        $timestamp = date('Y-m-d H:i:s');
        $section = Section::find($id);

        if(!$section) {
            throw new NotFoundHttpException();
        }

        $section->code = $request->code;
        $section->name = $request->name;
        $section->description = $request->description;
        $section->level_id = $request->level_id;
        $section->updated_at = $timestamp;
        $section->updated_at = Auth::user()->id;

        //UPDATE section_subject
        $all_subjects = $request->subjects;
        $all_teachers = $request->teachers;
        $ids_sections_subjects = $request->sections_subjects;
        $counter = 1;
        foreach ($all_subjects as $key => $subject) {
            
            if( count($ids_sections_subjects) >= $counter )
            {
                $counter+=1;
                if( ( $all_teachers[$key] != 'NULL' ) && ( $subject != 'NULL' ) )
                {
                    $ss = SectionsSubjects::find($ids_sections_subjects[$key]);
                    $ss->section_id = $id;
                    $ss->subject_id = $subject;
                    $ss->staff_id = $all_teachers[$key];
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
                        'section_id' => $id,
                        'subject_id' => $subject,
                        'staff_id' => $all_teachers[$key],
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                ]);
            }
            
        }
        
        //UPDATE section_subject
        $section_student = SectionsStudents::where('section_id', $id)->where('is_active', 1);
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


        if ($section->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The section has been successfully updated.',
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
            $sections = Section::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The section status has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else if ($action == 'Active') {
            $sections = Section::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The section status has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else if ($action == 'Current') {
            $sections = Section::where('id', '!=', $id)->where('status', '!=', 'Closed')
            ->update([
                'status' => 'Open',
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);

            $sections = Section::where([
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
                'text' => 'The section status has been successfully changed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else if ($action == 'Open') {
            $rows = Section::where('id', '!=', $id)->where([
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
                $sections = Section::where([
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
                    'text' => 'The section status has been successfully changed.',
                    'type' => 'success',
                    'class' => 'btn-brand'
                );

                echo json_encode( $data ); exit();
            }
        }
        else {
            $rows = Section::where('id', '!=', $id)->where([
                'status' => 'Open',
                'is_active' => 1
            ])->count();

            if ($rows == 1) {
                $sections = Section::where('id', '!=', $id)->where([
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

            $sections = Section::where([
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
                'text' => 'The section status has been successfully changed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();
        }
    }  

}
