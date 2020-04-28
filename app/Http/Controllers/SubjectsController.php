<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;

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
        return view('modules/academics/subjects/manage');
    }

    public function manage(Request $request)
    {   
        return view('modules/academics/subjects/manage');
    }

    public function inactive(Request $request)
    {   
        return view('modules/academics/subjects/inactive');
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
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        if (count($flashMessage) && $flashMessage[0]['module'] == 'subject') {
            $subject = (new Subject)->fetch($flashMessage[0]['id']);
        } else {
            $subject = (new Subject)->fetch($id);
        }
        return view('modules/academics/subjects/add')->with(compact('subject', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        $subject = (new Subject)->find($id);
        return view('modules/academics/subjects/edit')->with(compact('subject', 'segment', 'flashMessage'));
    }
    
    public function store(Request $request)
    {   
        
        $timestamp = date('Y-m-d H:i:s');

        $subject = Subject::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
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
}
