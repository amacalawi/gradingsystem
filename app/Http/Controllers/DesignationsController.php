<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\EducationType;
use App\Models\DesignationEducationType;
use App\Models\AuditLog;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class DesignationsController extends Controller
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
        return view('modules/components/schools/designations/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {       
        $this->is_permitted(1);
        $menus = $this->load_menus();
        $types = (new EducationType)->manage_education_types();
        return view('modules/components/schools/designations/manage')->with(compact('menus', 'types'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        $types = (new EducationType)->manage_education_types();
        return view('modules/components/schools/designations/inactive')->with(compact('menus', 'types'));
    }

    public function all_active(Request $request)
    {   
        $res = Designation::with([
            'edtypes' =>  function($q) { 
                $q->select(['designations_education_types.id', 'designations_education_types.designation_id', 'designations_education_types.education_type_id', 'education_types.name'])->join('education_types', function($join)
                {
                    $join->on('education_types.id', '=', 'designations_education_types.education_type_id');
                });
            }
        ])
        ->where('is_active', 1)
        ->orderBy('id', 'DESC')
        ->get();

        return $res->map(function($designation) {
            return [
                'designationID' => $designation->id,
                'designationCode' => $designation->code,
                'designationName' => $designation->name,
                'designationDescription' => $designation->description,
                'designationTypeID' => $designation->edtypes->map(function($a) { return $a->education_type_id; }),
                'designationTypeName' => $designation->edtypes->map(function($a) { return $a->name; }),
                'designationModified' => ($designation->updated_at !== NULL) ? date('d-M-Y', strtotime($designation->updated_at)).'<br/>'. date('h:i A', strtotime($designation->updated_at)) : date('d-M-Y', strtotime($designation->created_at)).'<br/>'. date('h:i A', strtotime($designation->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Designation::with([
            'edtypes' =>  function($q) { 
                $q->select(['designations_education_types.id', 'designations_education_types.designation_id', 'designations_education_types.education_type_id', 'education_types.name'])->join('education_types', function($join)
                {
                    $join->on('education_types.id', '=', 'designations_education_types.education_type_id');
                });
            }
        ])
        ->where('is_active', 0)
        ->orderBy('id', 'DESC')
        ->get();

        return $res->map(function($designation) {
            return [
                'designationID' => $designation->id,
                'designationCode' => $designation->code,
                'designationName' => $designation->name,
                'designationDescription' => $designation->description,
                'designationTypeID' => $designation->edtypes->map(function($a) { return $a->education_type_id; }),
                'designationTypeName' => $designation->edtypes->map(function($a) { return $a->name; }),
                'designationModified' => ($designation->updated_at !== NULL) ? date('d-M-Y', strtotime($designation->updated_at)).'<br/>'. date('h:i A', strtotime($designation->updated_at)) : date('d-M-Y', strtotime($designation->created_at)).'<br/>'. date('h:i A', strtotime($designation->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $designation = (new Designation)->fetch($id);
        $types = (new EducationType)->all_education_types_selectpicker();
        return view('modules/components/schools/designations/add')->with(compact('menus', 'designation', 'types', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $designation = (new Designation)->fetch($id);
        $types = (new EducationType)->all_education_types_selectpicker();
        return view('modules/components/schools/designations/edit')->with(compact('menus', 'designation', 'types', 'segment'));
    }
    
    public function store(Request $request)
    {    
        $this->is_permitted(0); 
        $timestamp = date('Y-m-d H:i:s');

        $rows = Designation::where([
            'code' => $request->code
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a designation with an existing code.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $designation = Designation::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$designation) {
            throw new NotFoundHttpException();
        }

        foreach ($request->education_type_id as $education_type) {
            $designation_education_type = DesignationEducationType::create([
                'designation_id' => $designation->id,
                'education_type_id' => $education_type,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            $this->audit_logs('designations_education_types', $designation_education_type->id, 'has inserted a new designation education type.', DesignationEducationType::find($designation_education_type->id), $timestamp, Auth::user()->id);
        }

        $this->audit_logs('designations', $designation->id, 'has inserted a new designation.', Designation::find($designation->id), $timestamp, Auth::user()->id);

        $data = array(
            'title' => 'Well done!',
            'text' => 'The designation has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {   
        $this->is_permitted(2);  
        $timestamp = date('Y-m-d H:i:s');
        $designation = Designation::find($id);

        if(!$designation) {
            throw new NotFoundHttpException();
        }

        $designation->code = $request->code;
        $designation->name = $request->name;
        $designation->description = $request->description;
        $designation->updated_at = $timestamp;
        $designation->updated_by = Auth::user()->id;

        if ($designation->update()) {

            DesignationEducationType::where('designation_id', $id)->update(['updated_at' => $timestamp, 'updated_by' => Auth::user()->id,'is_active' => 0]);
            foreach ($request->education_type_id as $education_type) {
                $designation_education_type = DesignationEducationType::where(['designation_id' => $id, 'education_type_id' => $education_type])
                ->update([
                    'education_type_id' => $education_type,
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id,
                    'is_active' => 1
                ]);
                $designation_education_type = DesignationEducationType::where(['designation_id' => $id, 'education_type_id' => $education_type, 'is_active' => 1])->get();
                if ($designation_education_type->count() > 0) {
                    $this->audit_logs('designations_education_types', $designation_education_type->first()->id, 'has modified a designation education type.', DesignationEducationType::find($designation_education_type->first()->id), $timestamp, Auth::user()->id);
                } else {
                    $designation_education_type = DesignationEducationType::create([
                        'designation_id' => $id,
                        'education_type_id' => $education_type,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('designations_education_types', $designation_education_type->id, 'has inserted a new designation education type.', DesignationEducationType::find($designation_education_type->id), $timestamp, Auth::user()->id);
                }
            }

            $this->audit_logs('designations', $id, 'has modified a designation.', Designation::find($id), $timestamp, Auth::user()->id);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The designation has been successfully updated.',
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
            $designations = Designation::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            $this->audit_logs('designations', $id, 'has removed a designation.', Designation::find($id), $timestamp, Auth::user()->id);
          
            $data = array(
                'title' => 'Well done!',
                'text' => 'The designation has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else {
            $batches = Designation::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            $this->audit_logs('designations', $id, 'has retrieved a designation.', Designation::find($id), $timestamp, Auth::user()->id);
        
            $data = array(
                'title' => 'Well done!',
                'text' => 'The designation has been successfully activated.',
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
                        $exist = Designation::where('code', $data[0])->get();
                        if ($exist->count() > 0) {
                            $designation = Designation::find($exist->first()->id);
                            $designation->code = $data[0];
                            $designation->name = $data[1];
                            $designation->description = $data[2];
                            $designation->updated_at = $timestamp;
                            $designation->updated_by = Auth::user()->id;

                            if ($designation->update()) {
                                DesignationEducationType::where('designation_id', $exist->first()->id)->update(['updated_at' => $timestamp, 'updated_by' => Auth::user()->id,'is_active' => 0]);
                                $education_types = explode(',',$data[3]);
                                foreach ($education_types as $education_type) {
                                    $education_type_id = EducationType::where('code', $education_type)->first()->id;
                                    $designation_education_type = DesignationEducationType::where(['designation_id' => $exist->first()->id, 'education_type_id' => $education_type_id])
                                    ->update([
                                        'education_type_id' => $education_type_id,
                                        'updated_at' => $timestamp,
                                        'updated_by' => Auth::user()->id,
                                        'is_active' => 1
                                    ]);
                                    $designation_education_type = DesignationEducationType::where(['designation_id' => $exist->first()->id, 'education_type_id' => $education_type_id, 'is_active' => 1])->get();
                                    if ($designation_education_type->count() > 0) {
                                        $this->audit_logs('designations_education_types', $designation_education_type->first()->id, 'has modified a designation education type.', DesignationEducationType::find($designation_education_type->first()->id), $timestamp, Auth::user()->id);
                                    } else {
                                        $designation_education_type = DesignationEducationType::create([
                                            'designation_id' => $exist->first()->id,
                                            'education_type_id' => $education_type_id,
                                            'created_at' => $timestamp,
                                            'created_by' => Auth::user()->id
                                        ]);
                                        $this->audit_logs('designations_education_types', $designation_education_type->id, 'has inserted a new designation education type.', DesignationEducationType::find($designation_education_type->id), $timestamp, Auth::user()->id);
                                    }
                                }

                                $this->audit_logs('designations', $exist->first()->id, 'has modified a designation.', Designation::find($exist->first()->id), $timestamp, Auth::user()->id);
                            }
                        } else {
                            $designation = Designation::create([
                                'code' => $data[0],
                                'name' => $data[1],
                                'description' => $data[2],
                                'created_at' => $timestamp,
                                'created_by' => Auth::user()->id
                            ]);
                    
                            if (!$designation) {
                                throw new NotFoundHttpException();
                            }
                            
                            $education_types = explode(',',$data[3]);
                            foreach ($education_types as $education_type) {
                                $education_type_id = EducationType::where('code', $education_type)->first()->id;
                                $designation_education_type = DesignationEducationType::create([
                                    'designation_id' => $designation->id,
                                    'education_type_id' => $education_type_id,
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                                $this->audit_logs('designations_education_types', $designation_education_type->id, 'has inserted a new designation education type.', DesignationEducationType::find($designation_education_type->id), $timestamp, Auth::user()->id);
                            }
                    
                            $this->audit_logs('designations', $designation->id, 'has inserted a new designation.', Designation::find($designation->id), $timestamp, Auth::user()->id);
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
