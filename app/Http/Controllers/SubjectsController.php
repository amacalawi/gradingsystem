<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\Staff;
use App\Models\Quarter;

class SubjectsController extends Controller
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
        return view('modules/academics/subjects/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/subjects/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/subjects/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Subject::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($subject) {
            return [
                'subjectID' => $subject->id,
                'subjectCode' => $subject->code,
                'subjectName' => $subject->name,
                'subjectDescription' => $subject->description,
                'subjectModified' => ($subject->updated_at !== NULL) ? date('d-M-Y', strtotime($subject->updated_at)).'<br/>'. date('h:i A', strtotime($subject->updated_at)) : date('d-M-Y', strtotime($subject->created_at)).'<br/>'. date('h:i A', strtotime($subject->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Subject::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($subject) {
            return [
                'subjectID' => $subject->id,
                'subjectCode' => $subject->code,
                'subjectName' => $subject->name,
                'subjectDescription' => $subject->description,
                'subjectModified' => ($subject->updated_at !== NULL) ? date('d-M-Y', strtotime($subject->updated_at)).'<br/>'. date('h:i A', strtotime($subject->updated_at)) : date('d-M-Y', strtotime($subject->created_at)).'<br/>'. date('h:i A', strtotime($subject->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $types = (new Quarter)->types();
        if (count($flashMessage) && $flashMessage[0]['module'] == 'subject') {
            $subject = (new Subject)->fetch($flashMessage[0]['id']);
        } else {
            $subject = (new Subject)->fetch($id);
        }
        return view('modules/academics/subjects/add')->with(compact('menus', 'types', 'subject', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $types = (new Quarter)->types();
        $subject = (new Subject)->find($id);
        return view('modules/academics/subjects/edit')->with(compact('menus', 'types', 'subject', 'segment', 'flashMessage'));
    }
    
    public function store(Request $request)
    {   
        
        $timestamp = date('Y-m-d H:i:s');

        $subject = Subject::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);
        /* 
        if (!$subject) {
            throw new NotFoundHttpException();
        }
        */
        $data = array(
            'title' => 'Well done!',
            'text' => 'The subject has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();

    }

    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');
        $subject = Subject::find($id);

        if(!$subject) {
            throw new NotFoundHttpException();
        }

        $subject->code = $request->code;
        $subject->name = $request->name;
        $subject->description = $request->description;
        $subject->type = $request->type;
        $subject->updated_at = $timestamp;
        $subject->updated_by = Auth::user()->id;

        if ($subject->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The subject has been successfully updated.',
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
            $subjects = Subject::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The subject status has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else if ($action == 'Active') {
            $subjects = Subject::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The subject status has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else if ($action == 'Current') {
            $subjects = Subject::where('id', '!=', $id)->where('status', '!=', 'Closed')
            ->update([
                'status' => 'Open',
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);

            $subjects = Subject::where([
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
                'text' => 'The subject status has been successfully changed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else if ($action == 'Open') {
            $rows = Subject::where('id', '!=', $id)->where([
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
                $subjects = Subject::where([
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
                    'text' => 'The subject status has been successfully changed.',
                    'type' => 'success',
                    'class' => 'btn-brand'
                );

                echo json_encode( $data ); exit();
            }
        }
        else {
            $rows = Subject::where('id', '!=', $id)->where([
                'status' => 'Open',
                'is_active' => 1
            ])->count();

            if ($rows == 1) {
                $subjects = Subject::where('id', '!=', $id)->where([
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

            $subjects = Subject::where([
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
                'text' => 'The subject status has been successfully changed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();
        }
    } 

        
    public function get_all_subjects()
    {
        $subjects = (new Subject)->get_all_subjects();
        echo json_encode( $subjects ); exit();
    }

    public function get_all_teachers()
    {
        $teachers = Staff::where('is_active', 1)->where('type','Teacher')->orderBy('id', 'asc')->get();
        //die( var_dump($teachers) );
        $staffs = array();
        $staffs[] = array('0' => 'select a teacher');

        foreach ($teachers as $teacher) {
            $staffs[] = array(
                $teacher->id  => $teacher->lastname.', '.$teacher->firstname.' '.$teacher->middlename.' ('.$teacher->identification_no.')' ,
            );
        }

        $teachers = array();
        foreach($staffs as $staff) {
            foreach($staff as $key => $val) {
                $teachers[$key] = $val;
            }
        }

        echo json_encode( $teachers ); exit();
    }

}
