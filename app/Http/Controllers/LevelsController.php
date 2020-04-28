<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Level;

class LevelsController extends Controller
{

    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }

    public function index()
    {
        return view('modules/academics/levels/manage');
    }

    public function manage(Request $request)
    {   
        return view('modules/academics/levels/manage');
    }

    public function inactive(Request $request)
    {   
        return view('modules/academics/levels/inactive');
    }

    public function all_active(Request $request)
    {
        $res = Level::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($level) {
            return [
                'levelID' => $level->id,
                'levelCode' => $level->code,
                'levelName' => $level->name,
                'levelDescription' => $level->description,
                'levelModified' => ($level->updated_at !== NULL) ? date('d-M-Y', strtotime($level->updated_at)).'<br/>'. date('h:i A', strtotime($level->updated_at)) : date('d-M-Y', strtotime($level->created_at)).'<br/>'. date('h:i A', strtotime($level->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Level::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($level) {
            return [
                'levelID' => $level->id,
                'levelCode' => $level->code,
                'levelName' => $level->name,
                'levelDescription' => $level->description,
                'levelModified' => ($level->updated_at !== NULL) ? date('d-M-Y', strtotime($level->updated_at)).'<br/>'. date('h:i A', strtotime($level->updated_at)) : date('d-M-Y', strtotime($level->created_at)).'<br/>'. date('h:i A', strtotime($level->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        if (count($flashMessage) && $flashMessage[0]['module'] == 'level') {
            $level = (new Level)->fetch($flashMessage[0]['id']);
        } else {
            $level = (new Level)->fetch($id);
        }
        return view('modules/academics/levels/add')->with(compact('level', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        $level = (new Level)->find($id);
        return view('modules/academics/levels/edit')->with(compact('level', 'segment', 'flashMessage'));
    }
    
    public function store(Request $request)
    {   
        
        $timestamp = date('Y-m-d H:i:s');

        $level = Level::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);
        /* 
        if (!$level) {
            throw new NotFoundHttpException();
        }
        */
        $data = array(
            'title' => 'Well done!',
            'text' => 'The level has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();

    }

    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');
        $level = Level::find($id);

        if(!$level) {
            throw new NotFoundHttpException();
        }

        $level->code = $request->code;
        $level->name = $request->name;
        $level->description = $request->description;
        $level->updated_at = $timestamp;
        $level->updated_by = Auth::user()->id;

        if ($level->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The level has been successfully updated.',
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
            $levels = Level::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The level status has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else if ($action == 'Active') {
            $levels = Level::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The level status has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else if ($action == 'Current') {
            $levels = Level::where('id', '!=', $id)->where('status', '!=', 'Closed')
            ->update([
                'status' => 'Open',
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);

            $levels = Level::where([
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
                'text' => 'The level status has been successfully changed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else if ($action == 'Open') {
            $rows = Level::where('id', '!=', $id)->where([
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
                $levels = Level::where([
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
                    'text' => 'The level status has been successfully changed.',
                    'type' => 'success',
                    'class' => 'btn-brand'
                );

                echo json_encode( $data ); exit();
            }
        }
        else {
            $rows = Level::where('id', '!=', $id)->where([
                'status' => 'Open',
                'is_active' => 1
            ])->count();

            if ($rows == 1) {
                $levels = Level::where('id', '!=', $id)->where([
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

            $levels = Level::where([
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
                'text' => 'The level status has been successfully changed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();
        }
    }

}
