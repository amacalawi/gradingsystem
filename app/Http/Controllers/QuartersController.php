<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Quarter;
use App\Models\EducationType;
use App\Models\QuarterEducationType;
use App\Models\AuditLog;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class QuartersController extends Controller
{   
    use FlashMessages;
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
        return view('modules/components/schools/quarters/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/schools/quarters/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/schools/quarters/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Quarter::with([
            'edtypes' =>  function($q) { 
                $q->select(['quarters_education_types.id', 'quarters_education_types.quarter_id', 'quarters_education_types.education_type_id', 'education_types.name'])->join('education_types', function($join)
                {
                    $join->on('education_types.id', '=', 'quarters_education_types.education_type_id');
                });
            }
        ])
        ->where([
            'batch_id' => (new Batch)->get_current_batch(),
            'is_active' => 1
        ])
        ->orderBy('id', 'DESC')
        ->get();

        return $res->map(function($quarter) {
            return [
                'quarterID' => $quarter->id,
                'quarterCode' => $quarter->code,
                'quarterName' => $quarter->name,
                'quarterDescription' => $quarter->description,
                'quarterStart' => date('d-M-Y', strtotime($quarter->date_start)),
                'quarterEnd' => date('d-M-Y', strtotime($quarter->date_end)),
                'quarterTypeID' => $quarter->edtypes->map(function($a) { return $a->education_type_id; }),
                'quarterTypeName' => $quarter->edtypes->map(function($a) { return $a->name; }),
                'quarterModified' => ($quarter->updated_at !== NULL) ? date('d-M-Y', strtotime($quarter->updated_at)).'<br/>'. date('h:i A', strtotime($quarter->updated_at)) : date('d-M-Y', strtotime($quarter->created_at)).'<br/>'. date('h:i A', strtotime($quarter->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Quarter::with([
            'edtypes' =>  function($q) { 
                $q->select(['quarters_education_types.id', 'quarters_education_types.quarter_id', 'quarters_education_types.education_type_id', 'education_types.name'])->join('education_types', function($join)
                {
                    $join->on('education_types.id', '=', 'quarters_education_types.education_type_id');
                });
            }
        ])
        ->where([
            'batch_id' => (new Batch)->get_current_batch(),
            'is_active' => 0
        ])
        ->orderBy('id', 'DESC')
        ->get();

        return $res->map(function($quarter) {
            return [
                'quarterID' => $quarter->id,
                'quarterCode' => $quarter->code,
                'quarterName' => $quarter->name,
                'quarterDescription' => $quarter->description,
                'quarterStart' => date('d-M-Y', strtotime($quarter->date_start)),
                'quarterEnd' => date('d-M-Y', strtotime($quarter->date_end)),
                'quarterTypeID' => $quarter->edtypes->map(function($a) { return $a->education_type_id; }),
                'quarterTypeName' => $quarter->edtypes->map(function($a) { return $a->name; }),
                'quarterModified' => ($quarter->updated_at !== NULL) ? date('d-M-Y', strtotime($quarter->updated_at)).'<br/>'. date('h:i A', strtotime($quarter->updated_at)) : date('d-M-Y', strtotime($quarter->created_at)).'<br/>'. date('h:i A', strtotime($quarter->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $quarter = (new Quarter)->fetch($id);
        $types = (new EducationType)->all_education_types_selectpicker();
        return view('modules/components/schools/quarters/add')->with(compact('menus', 'quarter', 'types', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $quarter = (new Quarter)->fetch($id);
        $types = (new EducationType)->all_education_types_selectpicker();
        return view('modules/components/schools/quarters/edit')->with(compact('menus', 'quarter', 'types', 'segment'));
    }
    
    public function store(Request $request)
    {   
        $this->is_permitted(0); 
        $timestamp = date('Y-m-d H:i:s');

        $rows = Quarter::where([
            'code' => $request->code
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a quarter with an existing code.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $quarter = Quarter::create([
            'batch_id' => (new Batch)->get_current_batch(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'date_start' => date('Y-m-d', strtotime($request->date_start)),
            'date_end' => date('Y-m-d', strtotime($request->date_end)),
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$quarter) {
            throw new NotFoundHttpException();
        }

        foreach ($request->education_type_id as $education_type) {
            $quarter_education_type = QuarterEducationType::create([
                'quarter_id' => $quarter->id,
                'education_type_id' => $education_type,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            $this->audit_logs('quarters_education_types', $quarter_education_type->id, 'has inserted a new quarter education type.', QuarterEducationType::find($quarter_education_type->id), $timestamp, Auth::user()->id);
        }

        $this->audit_logs('quarters', $quarter->id, 'has inserted a new quarter.', Quarter::find($quarter->id), $timestamp, Auth::user()->id);

        $data = array(
            'title' => 'Well done!',
            'text' => 'The quarter has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {   
        $this->is_permitted(2); 
        $timestamp = date('Y-m-d H:i:s');
        $quarter = Quarter::find($id);

        if(!$quarter) {
            throw new NotFoundHttpException();
        }
        
        $quarter->code = $request->code;
        $quarter->name = $request->name;
        $quarter->description = $request->description;
        $quarter->date_start = date('Y-m-d', strtotime($request->date_start));
        $quarter->date_end = date('Y-m-d', strtotime($request->date_end));
        $quarter->updated_at = $timestamp;
        $quarter->updated_by = Auth::user()->id;

        if ($quarter->update()) {

            QuarterEducationType::where('quarter_id', $id)->update(['updated_at' => $timestamp, 'updated_by' => Auth::user()->id,'is_active' => 0]);
            foreach ($request->education_type_id as $education_type) {
                $quarter_education_type = QuarterEducationType::where(['quarter_id' => $id, 'education_type_id' => $education_type])
                ->update([
                    'education_type_id' => $education_type,
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id,
                    'is_active' => 1
                ]);
                $quarter_education_type = QuarterEducationType::where(['quarter_id' => $id, 'education_type_id' => $education_type, 'is_active' => 1])->get();
                if ($quarter_education_type->count() > 0) {
                    $this->audit_logs('quarters_education_types', $quarter_education_type->first()->id, 'has modified a quarter education type.', QuarterEducationType::find($quarter_education_type->first()->id), $timestamp, Auth::user()->id);
                } else {
                    $quarter_education_type = QuarterEducationType::create([
                        'quarter_id' => $id,
                        'education_type_id' => $education_type,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('quarters_education_types', $quarter_education_type->id, 'has inserted a new quarter education type.', QuarterEducationType::find($quarter_education_type->id), $timestamp, Auth::user()->id);
                }
            }

            $this->audit_logs('quarters', $id, 'has modified a quarter.', Quarter::find($id), $timestamp, Auth::user()->id);

            $data = array(
                'data' => $request->education_type_id,
                'title' => 'Well done!',
                'text' => 'The quarter has been successfully updated.',
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
            $quarters = Quarter::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            $this->audit_logs('quarters', $id, 'has removed a quarter.', Quarter::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The quarter has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else {
            $batches = Quarter::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            $this->audit_logs('quarters', $id, 'has retrieved a quarter.', Quarter::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The quarter has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
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
                    if ($row > 1) 
                    {  
                        $exist = Quarter::where('code', $data[0])->get();
                        if ($exist->count() > 0) {
                            $quarter = Quarter::find($exist->first()->id);
                            $quarter->code = $data[0];
                            $quarter->name = $data[1];
                            $quarter->description = $data[2];
                            $quarter->date_start = date('Y-m-d', strtotime($data[3]));
                            $quarter->date_end = date('Y-m-d', strtotime($data[4]));
                            $quarter->updated_at = $timestamp;
                            $quarter->updated_by = Auth::user()->id;

                            if ($quarter->update()) {
                                QuarterEducationType::where('quarter_id', $exist->first()->id)->update(['updated_at' => $timestamp, 'updated_by' => Auth::user()->id,'is_active' => 0]);
                                $education_types = explode(',',$data[5]);
                                foreach ($education_types as $education_type) {
                                    $education_type_id = EducationType::where('code', $education_type)->first()->id;
                                    $quarter_education_type = QuarterEducationType::where(['quarter_id' => $exist->first()->id, 'education_type_id' => $education_type_id])
                                    ->update([
                                        'education_type_id' => $education_type_id,
                                        'updated_at' => $timestamp,
                                        'updated_by' => Auth::user()->id,
                                        'is_active' => 1
                                    ]);
                                    $quarter_education_type = QuarterEducationType::where(['quarter_id' => $exist->first()->id, 'education_type_id' => $education_type_id, 'is_active' => 1])->get();
                                    if ($quarter_education_type->count() > 0) {
                                        $this->audit_logs('quarters_education_types', $quarter_education_type->first()->id, 'has modified a quarter education type.', QuarterEducationType::find($quarter_education_type->first()->id), $timestamp, Auth::user()->id);
                                    } else {
                                        $quarter_education_type = QuarterEducationType::create([
                                            'quarter_id' => $exist->first()->id,
                                            'education_type_id' => $education_type_id,
                                            'created_at' => $timestamp,
                                            'created_by' => Auth::user()->id
                                        ]);
                                        $this->audit_logs('quarters_education_types', $quarter_education_type->id, 'has inserted a new quarter education type.', QuarterEducationType::find($quarter_education_type->id), $timestamp, Auth::user()->id);
                                    }
                                }

                                $this->audit_logs('quarters', $exist->first()->id, 'has modified a quarter.', Quarter::find($exist->first()->id), $timestamp, Auth::user()->id);
                            }
                        } else {
                            $quarter = Quarter::create([
                                'batch_id' => (new Batch)->get_current_batch(),
                                'code' => $data[0],
                                'name' => $data[1],
                                'description' => $data[2],
                                'date_start' => date('Y-m-d', strtotime($data[3])),
                                'date_end' => date('Y-m-d', strtotime($data[4])),
                                'created_at' => $timestamp,
                                'created_by' => Auth::user()->id
                            ]);
                    
                            if (!$quarter) {
                                throw new NotFoundHttpException();
                            }
                            
                            $education_types = explode(',',$data[5]);
                            foreach ($education_types as $education_type) {
                                $education_type_id = EducationType::where('code', $education_type)->first()->id;
                                $quarter_education_type = QuarterEducationType::create([
                                    'quarter_id' => $quarter->id,
                                    'education_type_id' => $education_type_id,
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                                $this->audit_logs('quarters_education_types', $quarter_education_type->id, 'has inserted a new quarter education type.', QuarterEducationType::find($quarter_education_type->id), $timestamp, Auth::user()->id);
                            }
                    
                            $this->audit_logs('quarters', $quarter->id, 'has inserted a new quarter.', Quarter::find($quarter->id), $timestamp, Auth::user()->id);
                        }
                    } // close for if $row > 1 condition   
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
