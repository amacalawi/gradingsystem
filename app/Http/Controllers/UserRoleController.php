<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Header;
use App\Models\Role;
use App\Models\RoleHeader;
use App\Models\RoleModule;
use App\Models\RoleSubModule;
use App\Models\AuditLog;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class UserRoleController extends Controller
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
        return view('modules/memberships/users/roles/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/memberships/users/roles/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/memberships/users/roles/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Role::where('is_active', 1)->orderBy('id', 'ASC')->get();

        return $res->map(function($role) {
            return [
                'roleID' => $role->id,
                'roleCode' => $role->code,
                'roleName' => $role->name,
                'roleDescription' => $role->description,
                'roleModified' => ($role->updated_at !== NULL) ? date('d-M-Y', strtotime($role->updated_at)).'<br/>'. date('h:i A', strtotime($role->updated_at)) : date('d-M-Y', strtotime($role->created_at)).'<br/>'. date('h:i A', strtotime($role->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Role::where('is_active', 0)->orderBy('id', 'ASC')->get();

        return $res->map(function($role) {
            return [
                'roleID' => $role->id,
                'roleCode' => $role->code,
                'roleName' => $role->name,
                'roleDescription' => $role->description,
                'roleModified' => ($role->updated_at !== NULL) ? date('d-M-Y', strtotime($role->updated_at)).'<br/>'. date('h:i A', strtotime($role->updated_at)) : date('d-M-Y', strtotime($role->created_at)).'<br/>'. date('h:i A', strtotime($role->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $role = (new Role)->fetch($id);
        $headers = (new Header)->all_modules();
        return view('modules/memberships/users/roles/add')->with(compact('menus', 'role', 'headers', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $role = (new Role)->fetch($id);
        $headers = (new Header)->all_modules();
        return view('modules/memberships/users/roles/edit')->with(compact('menus', 'role', 'headers', 'segment'));
    }
    
    public function store(Request $request)
    {    
        $this->is_permitted(0);  
        $timestamp = date('Y-m-d H:i:s');

        $rows = Role::where([
            'code' => $request->code
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a header with an existing code.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $role = Role::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        $headers = $request->input('headers');
        foreach($headers as $headerID){
            if ($headerID !== NULL) {
                $role_header = RoleHeader::create([
                    'role_id' => $role->id,
                    'header_id' => $headerID,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
                $this->audit_logs('roles_headers', $role_header->id, 'has inserted a new role header.', RoleHeader::find($role_header->id), $timestamp, Auth::user()->id);
            }
        }

        $modules = $request->input('modules');
        foreach ($modules as $moduleID) {
            if ($moduleID !== NULL) {
                $role_module = RoleModule::create([
                    'role_id' => $role->id,
                    'module_id' => $moduleID,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
                $this->audit_logs('roles_modules', $role_module->id, 'has inserted a new role module.', RoleModule::find($role_module->id), $timestamp, Auth::user()->id);
            }
        }

        $sub_modules = $request->input('sub_modules');
        foreach ($sub_modules as $sub_moduleID) {
            if ($sub_moduleID !== NULL) {
                $permissions   = [];
                $permissions[] = !empty($request->input('crud')[$sub_moduleID][1]) ? 1 : 0;
                $permissions[] = !empty($request->input('crud')[$sub_moduleID][2]) ? 1 : 0;
                $permissions[] = !empty($request->input('crud')[$sub_moduleID][3]) ? 1 : 0;
                $permissions[] = !empty($request->input('crud')[$sub_moduleID][4]) ? 1 : 0;

                $role_sub_module = RoleSubModule::create([
                    'role_id' => $role->id,
                    'sub_module_id' => $sub_moduleID,
                    'permissions' => implode(",", $permissions),
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
                $this->audit_logs('roles_sub_modules', $role_sub_module->id, 'has inserted a new role sub module.', RoleSubModule::find($role_sub_module->id), $timestamp, Auth::user()->id);
            }
        }

        if (!$role) {
            throw new NotFoundHttpException();
        }

        $this->audit_logs('roles', $role->id, 'has inserted a new role.', Role::find($role->id), $timestamp, Auth::user()->id);

        $data = array(
            'title' => 'Well done!',
            'dataness' => $request->headers,
            'text' => 'The header has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $role = Role::find($id);

        if(!$role) {
            throw new NotFoundHttpException();
        }

        $role->code = $request->code;
        $role->name = $request->name;
        $role->description = $request->description;
        $role->updated_at = $timestamp;
        $role->updated_by = Auth::user()->id;

        RoleHeader::where('role_id', $role->id)->update(['is_active' => 0, 'updated_at' => $timestamp, 'updated_by' => Auth::user()->id]);
        $headers = $request->input('headers');
        foreach($headers as $headerID){
            if ($headerID !== NULL) {
                $headerCount = RoleHeader::where([
                    'role_id' => $role->id,
                    'header_id' => $headerID,
                ])->get();

                if ($headerCount->count() > 0) {
                    $role_header = RoleHeader::where([
                        'id' => $headerCount->first()->id
                    ])->update([
                        'role_id' => $role->id,
                        'header_id' => $headerID,
                        'updated_at' => $timestamp,
                        'updated_by' => Auth::user()->id,
                        'is_active' => 1
                    ]);
                    $this->audit_logs('roles_headers', $headerCount->first()->id, 'has modified a role header.', RoleHeader::find($headerCount->first()->id), $timestamp, Auth::user()->id);
                } else {
                    $role_header = RoleHeader::create([
                        'role_id' => $role->id,
                        'header_id' => $headerID,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('roles_headers', $role_header->id, 'has inserted a new role header.', RoleHeader::find($role_header->id), $timestamp, Auth::user()->id);
                }
            }
        }

        RoleModule::where('role_id', $role->id)->update(['is_active' => 0, 'updated_at' => $timestamp, 'updated_by' => Auth::user()->id]);
        $modules = $request->input('modules');
        foreach ($modules as $moduleID) {
            if ($moduleID !== NULL) {
                $moduleCount = RoleModule::where([
                    'role_id' => $role->id,
                    'module_id' => $moduleID,
                ])->get();
                
                if ($moduleCount->count() > 0) {
                    $role_module = RoleModule::where([
                        'id' => $moduleCount->first()->id
                    ])->update([
                        'role_id' => $role->id,
                        'module_id' => $moduleID,
                        'updated_at' => $timestamp,
                        'updated_by' => Auth::user()->id,
                        'is_active' => 1
                    ]);
                    $this->audit_logs('roles_modules', $moduleCount->first()->id, 'has modified a role module.', RoleModule::find($moduleCount->first()->id), $timestamp, Auth::user()->id);
                } else {
                    $role_module = RoleModule::create([
                        'role_id' => $role->id,
                        'module_id' => $moduleID,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('roles_modules', $role_module->id, 'has inserted a new role module.', RoleModule::find($role_module->id), $timestamp, Auth::user()->id);
                }
            }
        }

        RoleSubModule::where('role_id', $role->id)->update(['is_active' => 0, 'updated_at' => $timestamp, 'updated_by' => Auth::user()->id]);
        $sub_modules = $request->input('sub_modules');
        foreach ($sub_modules as $sub_moduleID) {
            if ($sub_moduleID !== NULL) {
                $permissions   = [];
                $permissions[] = !empty($request->input('crud')[$sub_moduleID][1]) ? 1 : 0;
                $permissions[] = !empty($request->input('crud')[$sub_moduleID][2]) ? 1 : 0;
                $permissions[] = !empty($request->input('crud')[$sub_moduleID][3]) ? 1 : 0;
                $permissions[] = !empty($request->input('crud')[$sub_moduleID][4]) ? 1 : 0;

                $subModuleCount = RoleSubModule::where([
                    'role_id' => $role->id,
                    'sub_module_id' => $sub_moduleID,
                ])->get();
                
                if ($subModuleCount->count() > 0) {
                    $role_sub_module = RoleSubModule::where([
                        'id' => $subModuleCount->first()->id
                    ])->update([
                        'role_id' => $role->id,
                        'sub_module_id' => $sub_moduleID,
                        'permissions' => implode(",", $permissions),
                        'updated_at' => $timestamp,
                        'updated_by' => Auth::user()->id,
                        'is_active' => 1
                    ]);
                    $this->audit_logs('roles_sub_modules', $subModuleCount->first()->id, 'has modified a role sub module.', RoleSubModule::find($subModuleCount->first()->id), $timestamp, Auth::user()->id);
                } else {
                    $role_sub_module = RoleSubModule::create([
                        'role_id' => $role->id,
                        'sub_module_id' => $sub_moduleID,
                        'permissions' => implode(",", $permissions),
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                    $this->audit_logs('roles_sub_modules', $role_sub_module->id, 'has inserted a new role sub module.', RoleSubModule::find($role_sub_module->id), $timestamp, Auth::user()->id);
                }
            }
        }

        if ($role->update()) {

            $this->audit_logs('roles', $id, 'has modified a role.', Role::find($id), $timestamp, Auth::user()->id);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The header has been successfully updated.',
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
            $headers = Role::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            $this->audit_logs('roles', $id, 'has removed a role.', Role::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The role has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }         
        else {
            $batches = Role::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            $this->audit_logs('roles', $id, 'has retrieved a role.', Role::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The role has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

    public function check_header_if_checked($headerID, $roleID)
    {
        $result = (new RoleHeader)->check_header_if_checked($headerID, $roleID);
        return $result;
    }

    public function check_module_if_checked($moduleID, $roleID)
    {
        $result = (new RoleModule)->check_module_if_checked($moduleID, $roleID);
        return $result;
    }

    public function check_sub_module_if_checked($subModuleID, $roleID)
    {
        $result = (new RoleSubModule)->check_sub_module_if_checked($subModuleID, $roleID);
        return $result;
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
