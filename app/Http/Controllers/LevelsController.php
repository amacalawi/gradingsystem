<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Imports\LevelImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Level;
use App\Models\Quarter;
use App\Models\EducationType;

use Illuminate\Http\File;

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
        $menus = $this->load_menus();
        return view('modules/academics/levels/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/levels/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/levels/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Level::
        with([
            'edtype' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($level) {
            return [
                'levelID' => $level->id,
                'levelCode' => $level->code,
                'levelName' => $level->name,
                'levelDescription' => $level->description,
                'levelModified' => ($level->updated_at !== NULL) ? date('d-M-Y', strtotime($level->updated_at)).'<br/>'. date('h:i A', strtotime($level->updated_at)) : date('d-M-Y', strtotime($level->created_at)).'<br/>'. date('h:i A', strtotime($level->created_at)),
                'levelTypeID' => $level->edtype->id,
                'levelType' => $level->edtype->name,
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Level::
        with([
            'edtype' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($level) {
            return [
                'levelID' => $level->id,
                'levelCode' => $level->code,
                'levelName' => $level->name,
                'levelDescription' => $level->description,
                'levelModified' => ($level->updated_at !== NULL) ? date('d-M-Y', strtotime($level->updated_at)).'<br/>'. date('h:i A', strtotime($level->updated_at)) : date('d-M-Y', strtotime($level->created_at)).'<br/>'. date('h:i A', strtotime($level->created_at)),
                'levelTypeID' => $level->edtype->id,
                'levelType' => $level->edtype->name,       
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $types = (new EducationType)->all_education_types();
        if (count($flashMessage) && $flashMessage[0]['module'] == 'level') {
            $level = (new Level)->fetch($flashMessage[0]['id']);
        } else {
            $level = (new Level)->fetch($id);
        }
        return view('modules/academics/levels/add')->with(compact('menus', 'types', 'level', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $types = (new EducationType)->all_education_types();
        $level = (new Level)->find($id);
        return view('modules/academics/levels/edit')->with(compact('menus', 'types', 'level', 'segment', 'flashMessage'));
    }
    
    public function store(Request $request)
    {   
        
        $timestamp = date('Y-m-d H:i:s');

        $level = Level::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'education_type_id' => $request->type,
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
        $level->education_type_id = $request->type;
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

    public function get_all_levels_bytype(Request $request, $type)
    {
        $levels = (new Level)->get_all_levels_bytype($type);
        echo json_encode( $levels ); exit();
    }

    public function import_level(Request $request)
    {   
        $this->validate( $request, [
            'import_file' => 'required|mimes:xls,xlsx'
        ]);
        
        $path = $request->file('import_file')->store('Imports');

        Excel::import(new LevelImport, $path);
        return redirect('/academics/academics/levels');
    }

}
