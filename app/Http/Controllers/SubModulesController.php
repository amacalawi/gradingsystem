<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\SubModule;
use App\Models\AuditLog;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class SubModulesController extends Controller
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
        return view('modules/components/menus/sub-modules/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/menus/sub-modules/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/menus/sub-modules/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = SubModule::with(['module'])->where('is_active', 1)->orderBy('order', 'ASC')->get();

        return $res->map(function($submodule) {
            return [
                'submoduleID' => $submodule->id,
                'submoduleModule' => $submodule->module_id,
                'submoduleModuleName' => $submodule->module->name,
                'submoduleCode' => $submodule->code,
                'submoduleName' => $submodule->name,
                'submoduleDescription' => $submodule->description,
                'submoduleIcon' => $submodule->icon,
                'submoduleSlug' => $submodule->slug,
                'submoduleOrder' => $submodule->order,
                'submoduleModified' => ($submodule->updated_at !== NULL) ? date('d-M-Y', strtotime($submodule->updated_at)).'<br/>'. date('h:i A', strtotime($submodule->updated_at)) : date('d-M-Y', strtotime($submodule->created_at)).'<br/>'. date('h:i A', strtotime($submodule->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = SubModule::with(['module'])->where('is_active', 0)->orderBy('order', 'ASC')->get();

        return $res->map(function($submodule) {
            return [
                'submoduleID' => $submodule->id,
                'submoduleModule' => $submodule->module_id,
                'submoduleModuleName' => $submodule->module->name,
                'submoduleCode' => $submodule->code,
                'submoduleName' => $submodule->name,
                'submoduleDescription' => $submodule->description,
                'submoduleIcon' => $submodule->icon,
                'submoduleSlug' => $submodule->slug,
                'submoduleOrder' => $submodule->order,
                'submoduleModified' => ($submodule->updated_at !== NULL) ? date('d-M-Y', strtotime($submodule->updated_at)).'<br/>'. date('h:i A', strtotime($submodule->updated_at)) : date('d-M-Y', strtotime($submodule->created_at)).'<br/>'. date('h:i A', strtotime($submodule->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $sub_module = (new SubModule)->fetch($id);
        $modules = (new Module)->all_modules();
        return view('modules/components/menus/sub-modules/add')->with(compact('menus', 'sub_module', 'modules', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $sub_module = (new SubModule)->fetch($id);
        $modules = (new Module)->all_modules();
        return view('modules/components/menus/sub-modules/edit')->with(compact('menus', 'sub_module', 'modules', 'segment'));
    }
    
    public function store(Request $request)
    {    
        $this->is_permitted(0);
        $timestamp = date('Y-m-d H:i:s');

        $rows = SubModule::where([
            'code' => $request->code
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a sub module with an existing code.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $count = SubModule::all()->count() + 1;

        $submodule = SubModule::create([
            'module_id' => $request->module_id,
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'slug' => str_replace(' ', '-', strtolower($request->name)),
            'order' => $count,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$submodule) {
            throw new NotFoundHttpException();
        }

        $auditLogs = AuditLog::create([
            'entity' => 'sub_modules',
            'entity_id' => $submodule->id,
            'description' => 'has inserted a new sub module.',
            'data' => json_encode(SubModule::find($submodule->id)),
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        $data = array(
            'title' => 'Well done!',
            'text' => 'The sub sub module has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $submodule = SubModule::find($id);

        if(!$submodule) {
            throw new NotFoundHttpException();
        }

        $submodule->module_id = $request->module_id;
        $submodule->code = $request->code;
        $submodule->name = $request->name;
        $submodule->description = $request->description;
        $submodule->icon = $request->icon;
        $submodule->slug = str_replace(' ', '-', strtolower($request->name));
        $submodule->updated_at = $timestamp;
        $submodule->updated_by = Auth::user()->id;

        if ($submodule->update()) {

            $auditLogs = AuditLog::create([
                'entity' => 'sub_modules',
                'entity_id' => $id,
                'description' => 'has modified a sub module.',
                'data' => json_encode(SubModule::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The sub sub module has been successfully updated.',
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
            $submodules = SubModule::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);

            $auditLogs = AuditLog::create([
                'entity' => 'sub_modules',
                'entity_id' => $id,
                'description' => 'has removed a sub module.',
                'data' => json_encode(SubModule::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The sub sub module has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Up') {
            $submodules = SubModule::find($id);

            $submodules2 = SubModule::where([
                'order' => ($submodules->order - 1),
            ])
            ->update([
                'order' => $submodules->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $submodules->order = ($submodules->order - 1);
            $submodules->updated_at = $timestamp;
            $submodules->updated_by = Auth::user()->id;
            $submodules->update();

            $auditLogs = AuditLog::create([
                'entity' => 'sub_modules',
                'entity_id' => $id,
                'description' => 'has modified the sub module order up.',
                'data' => json_encode(SubModule::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The sub sub module has been successfully moved.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Down') {
            $submodules = SubModule::find($id);

            $submodules2 = SubModule::where([
                'order' => ($submodules->order + 1),
            ])
            ->update([
                'order' => $submodules->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $submodules->order = ($submodules->order + 1);
            $submodules->updated_at = $timestamp;
            $submodules->updated_by = Auth::user()->id;
            $submodules->update();

            $auditLogs = AuditLog::create([
                'entity' => 'sub_modules',
                'entity_id' => $id,
                'description' => 'has modified the sub module order down.',
                'data' => json_encode(SubModule::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The sub sub module has been successfully moved.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();
        }         
        else {
            $batches = SubModule::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);

            $auditLogs = AuditLog::create([
                'entity' => 'sub_modules',
                'entity_id' => $id,
                'description' => 'has retrieved a sub module.',
                'data' => json_encode(SubModule::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The sub sub module has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

}
