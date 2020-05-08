<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Staff;
use App\Models\Level;

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
        return view('modules/academics/sections/manage');
    }

    public function manage(Request $request)
    {   
        return view('modules/academics/sections/manage');
    }

    public function inactive(Request $request)
    {   
        return view('modules/academics/sections/inactive');
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
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        $levels = (new Level)->all_levels();
        $subjects = (new Subject)->all_subjects();
        
        $staffs = Staff::select('id', 'lastname', 'firstname', 'middlename', 'identification_no')->where('type','Teacher')->orderBy('lastname', 'asc')->get();
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
        return view('modules/academics/sections/add')->with(compact('section', 'levels', 'staffs', 'subjects', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        $levels = (new Level)->all_levels();
        $subjects = (new Subject)->all_subjects();
        
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
        return view('modules/academics/sections/edit')->with(compact('section', 'staffs', 'subjects', 'levels', 'segment', 'flashMessage'));
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
        $section->updated_by = Auth::user()->id;

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
