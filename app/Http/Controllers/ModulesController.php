<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Header;
use App\Models\Module;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class ModulesController extends Controller
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
        return view('modules/components/menus/modules/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/menus/modules/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/menus/modules/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Module::with(['header'])->where('is_active', 1)->orderBy('order', 'ASC')->get();

        return $res->map(function($module) {
            return [
                'moduleID' => $module->id,
                'moduleHeader' => $module->header_id,
                'moduleHeaderName' => $module->header->name,
                'moduleCode' => $module->code,
                'moduleName' => $module->name,
                'moduleDescription' => $module->description,
                'moduleIcon' => $module->icon,
                'moduleSlug' => $module->slug,
                'moduleOrder' => $module->order,
                'moduleModified' => ($module->updated_at !== NULL) ? date('d-M-Y', strtotime($module->updated_at)).'<br/>'. date('h:i A', strtotime($module->updated_at)) : date('d-M-Y', strtotime($module->created_at)).'<br/>'. date('h:i A', strtotime($module->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Module::with(['header'])->where('is_active', 0)->orderBy('order', 'ASC')->get();

        return $res->map(function($module) {
            return [
                'moduleID' => $module->id,
                'moduleHeader' => $module->header_id,
                'moduleHeaderName' => $module->header->name,
                'moduleCode' => $module->code,
                'moduleName' => $module->name,
                'moduleDescription' => $module->description,
                'moduleIcon' => $module->icon,
                'moduleSlug' => $module->slug,
                'moduleOrder' => $module->order,
                'moduleModified' => ($module->updated_at !== NULL) ? date('d-M-Y', strtotime($module->updated_at)).'<br/>'. date('h:i A', strtotime($module->updated_at)) : date('d-M-Y', strtotime($module->created_at)).'<br/>'. date('h:i A', strtotime($module->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $module = (new Module)->fetch($id);
        $headers = (new Header)->all_headers();
        return view('modules/components/menus/modules/add')->with(compact('menus', 'module', 'headers', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $module = (new Module)->fetch($id);
        $headers = (new Header)->all_headers();
        return view('modules/components/menus/modules/edit')->with(compact('menus', 'module', 'headers', 'segment'));
    }
    
    public function store(Request $request)
    {    
        $this->is_permitted(0);
        $timestamp = date('Y-m-d H:i:s');

        $rows = Module::where([
            'code' => $request->code
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a module with an existing code.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $count = Module::all()->count() + 1;

        $module = Module::create([
            'header_id' => $request->header_id,
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'slug' => str_replace(' ', '-', strtolower($request->name)),
            'order' => $count,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$module) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The module has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $module = Module::find($id);

        if(!$module) {
            throw new NotFoundHttpException();
        }

        $module->header_id = $request->header_id;
        $module->code = $request->code;
        $module->name = $request->name;
        $module->description = $request->description;
        $module->icon = $request->icon;
        $module->slug = str_replace(' ', '-', strtolower($request->name));
        $module->updated_at = $timestamp;
        $module->updated_by = Auth::user()->id;

        if ($module->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The module has been successfully updated.',
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
            $modules = Module::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The module has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Up') {
            $modules = Module::find($id);

            $modules2 = Module::where([
                'order' => ($modules->order - 1),
            ])
            ->update([
                'order' => $modules->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $modules->order = ($modules->order - 1);
            $modules->updated_at = $timestamp;
            $modules->updated_by = Auth::user()->id;
            $modules->update();
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The module has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Down') {
            $modules = Module::find($id);

            $modules2 = Module::where([
                'order' => ($modules->order + 1),
            ])
            ->update([
                'order' => $modules->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $modules->order = ($modules->order + 1);
            $modules->updated_at = $timestamp;
            $modules->updated_by = Auth::user()->id;
            $modules->update();
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The module has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();
        }         
        else {
            $batches = Module::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The module has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

}
