<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\LevelImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Level;
use App\Models\Quarter;
use App\Models\EducationType;
use App\Models\AuditLog;
use Illuminate\Http\File;
use App\Helper\Helper;

class LevelsController extends Controller
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
        return view('modules/academics/levels/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/academics/levels/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
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
        $this->is_permitted(0);
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
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $types = (new EducationType)->all_education_types();
        $level = (new Level)->find($id);
        return view('modules/academics/levels/edit')->with(compact('menus', 'types', 'level', 'segment', 'flashMessage'));
    }
    
    public function store(Request $request)
    {   
        $this->is_permitted(0);
        $timestamp = date('Y-m-d H:i:s');

        $level = Level::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'education_type_id' => $request->type,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);
        
        if (!$level) {
            throw new NotFoundHttpException();
        }

        $this->audit_logs('levels', $level->id, 'has inserted a new level.', Level::find($level->id), $timestamp, Auth::user()->id);

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
        $this->is_permitted(2);
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

            $this->audit_logs('levels', $id, 'has modified a level.', Level::find($id), $timestamp, Auth::user()->id);

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
        $this->is_permitted(3);
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
            $this->audit_logs('levels', $id, 'has removed a level.', Level::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The level status has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else {
            $levels = Level::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            $this->audit_logs('levels', $id, 'has retrieved a level.', Level::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The level status has been successfully activated.',
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

    public function import(Request $request)
    {   
        $this->is_permitted(0);

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
                            $exist = Level::where('code', $data[0])->get();
                            $exist_type = EducationType::where('code', $data[3])->get();
                            if($exist_type->count() > 0) {
                                if ($exist->count() > 0) {
                                    $level = Level::find($exist->first()->id);
                                    $level->code = $data[0];
                                    $level->name = $data[1];
                                    $level->description = $data[2];
                                    $level->education_type_id = EducationType::where('code', $data[3])->first()->id;
                                    $level->updated_at = $timestamp;
                                    $level->updated_by = Auth::user()->id;
                                    $level->update();
                                    $this->audit_logs('levels', $exist->first()->id, 'has imported and updated a level.', Level::find($exist->first()->id), $timestamp, Auth::user()->id);
                                } else {
                                    $level = Level::create([
                                        'code' => $data[0],
                                        'name' => $data[1],
                                        'description' => $data[2],
                                        'education_type_id' => EducationType::where('code', $data[3])->first()->id,
                                        'created_at' => $timestamp,
                                        'created_by' => Auth::user()->id
                                    ]);
                                    $this->audit_logs('levels', $level->id, 'has imported a new level.', Level::find($level->id), $timestamp, Auth::user()->id);
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

    public function audit_logs($entity, $entity_id, $description, $data, $timestamp, $user)
    {
        $auditLogs = AuditLog::create([
            'entity' => $entity,
            'entity_id' => $entity_id,
            'description' => $description,
            'data' => json_encode($data),
            'created_at' => $timestamp,
            'created_by' => $user
        ]);

        return true;
    }
}
