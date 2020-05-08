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
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;

class UserRoleController extends Controller
{   
    use FlashMessages;
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('modules/memberships/users/roles/manage');
    }

    public function manage(Request $request)
    {   
        return view('modules/memberships/users/roles/manage');
    }

    public function inactive(Request $request)
    {   
        return view('modules/memberships/users/roles/inactive');
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
        $segment = request()->segment(4);
        $role = (new Role)->fetch($id);
        $headers = (new Header)->all_modules();
        return view('modules/memberships/users/roles/add')->with(compact('role', 'headers', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $segment = request()->segment(4);
        $role = (new Role)->fetch($id);
        $headers = (new Header)->all_modules();
        return view('modules/memberships/users/roles/edit')->with(compact('role', 'headers', 'segment'));
    }
    
    public function store(Request $request)
    {    
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
            }
        }

        if (!$role) {
            throw new NotFoundHttpException();
        }

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
                } else {
                    $role_header = RoleHeader::create([
                        'role_id' => $role->id,
                        'header_id' => $headerID,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
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
                } else {
                    $role_module = RoleModule::create([
                        'role_id' => $role->id,
                        'module_id' => $moduleID,
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
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
                } else {
                    $role_sub_module = RoleSubModule::create([
                        'role_id' => $role->id,
                        'sub_module_id' => $sub_moduleID,
                        'permissions' => implode(",", $permissions),
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                }
            }
        }

        if ($role->update()) {
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
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The header has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Up') {
            $headers = Role::find($id);

            $headers2 = Role::where([
                'order' => ($headers->order - 1),
            ])
            ->update([
                'order' => $headers->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $headers->order = ($headers->order - 1);
            $headers->updated_at = $timestamp;
            $headers->updated_by = Auth::user()->id;
            $headers->update();
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The header has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Down') {
            $headers = Role::find($id);

            $headers2 = Role::where([
                'order' => ($headers->order + 1),
            ])
            ->update([
                'order' => $headers->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $headers->order = ($headers->order + 1);
            $headers->updated_at = $timestamp;
            $headers->updated_by = Auth::user()->id;
            $headers->update();
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The header has been successfully removed.',
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
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The header has been successfully activated.',
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
}
