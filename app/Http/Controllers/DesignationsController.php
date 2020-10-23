<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\EducationType;
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
        $res = Designation::
        with([
            'edtype' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($designation) {
            return [
                'designationID' => $designation->id,
                'designationCode' => $designation->code,
                'designationName' => $designation->name,
                'designationDescription' => $designation->description,
                'designationTypeID' => $designation->edtype->id,
                'designationType' => $designation->edtype->name,
                'designationModified' => ($designation->updated_at !== NULL) ? date('d-M-Y', strtotime($designation->updated_at)).'<br/>'. date('h:i A', strtotime($designation->updated_at)) : date('d-M-Y', strtotime($designation->created_at)).'<br/>'. date('h:i A', strtotime($designation->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Designation::
        with([
            'edtype' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($designation) {
            return [
                'designationID' => $designation->id,
                'designationCode' => $designation->code,
                'designationName' => $designation->name,
                'designationDescription' => $designation->description,
                'designationTypeID' => $designation->edtype->id,
                'designationType' => $designation->edtype->name,
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
        $types = (new EducationType)->all_education_types();
        return view('modules/components/schools/designations/add')->with(compact('menus', 'designation', 'types', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $designation = (new Designation)->fetch($id);
        $types = (new EducationType)->all_education_types();
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
            'education_type_id' => $request->education_type_id,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$designation) {
            throw new NotFoundHttpException();
        }

        $auditLogs = AuditLog::create([
            'entity' => 'designations',
            'entity_id' => $designation->id,
            'description' => 'has inserted a new designation.',
            'data' => json_encode(Designation::find($designation->id)),
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

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
        $designation->education_type_id = $request->education_type_id;
        $designation->updated_at = $timestamp;
        $designation->updated_by = Auth::user()->id;

        if ($designation->update()) {

            $auditLogs = AuditLog::create([
                'entity' => 'designations',
                'entity_id' => $id,
                'description' => 'has modified a designation.',
                'data' => json_encode(Designation::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);

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
                
            $auditLogs = AuditLog::create([
                'entity' => 'designations',
                'entity_id' => $id,
                'description' => 'has removed a designation.',
                'data' => json_encode(Designation::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);

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
            
            $auditLogs = AuditLog::create([
                'entity' => 'designations',
                'entity_id' => $id,
                'description' => 'has retrieved a designation.',
                'data' => json_encode(Designation::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The designation has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

}
