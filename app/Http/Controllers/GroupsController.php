<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;

class GroupsController extends Controller
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
        return view('modules/groups/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/groups/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/groups/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Group::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($group) {
            return [
                'groupID' => $group->id,
                'groupCode' => $group->code,
                'groupName' => $group->name,
                'groupDescription' => $group->description,
                'groupModified' => ($group->updated_at !== NULL) ? date('d-M-Y', strtotime($group->updated_at)).'<br/>'. date('h:i A', strtotime($group->updated_at)) : date('d-M-Y', strtotime($group->created_at)).'<br/>'. date('h:i A', strtotime($group->created_at)),
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Group::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($group) {
            return [
                'groupID' => $group->id,
                'groupCode' => $group->code,
                'groupName' => $group->name,
                'groupDescription' => $group->description,
                'groupModified' => ($group->updated_at !== NULL) ? date('d-M-Y', strtotime($group->updated_at)).'<br/>'. date('h:i A', strtotime($group->updated_at)) : date('d-M-Y', strtotime($group->created_at)).'<br/>'. date('h:i A', strtotime($group->created_at)),          
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);

        if (count($flashMessage) && $flashMessage[0]['module'] == 'group') {
            $group = (new Group)->fetch($flashMessage[0]['id']);
        } else {
            $group = (new Group)->fetch($id);
        }

        return view('modules/groups/add')->with(compact('menus', 'types', 'group', 'segment', 'flashMessage'));
    }

    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        $group = (new Group)->find($id);
        return view('modules/groups/edit')->with(compact('menus', 'group', 'segment', 'flashMessage'));
    }

    public function store(Request $request)
    {   
        
        $timestamp = date('Y-m-d H:i:s');

        $group = Group::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$group) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The group has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();

    }

    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');
        $group = Group::find($id);

        if(!$group) {
            throw new NotFoundHttpException();
        }

        $group->code = $request->code;
        $group->name = $request->name;
        $group->description = $request->description;
        $group->updated_at = $timestamp;
        $group->updated_by = Auth::user()->id;

        if ($group->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The group has been successfully updated.',
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
            $groups = Group::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The group status has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }

        else if ($action == 'Active') {
            $groups = Group::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The group status has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }

    }

}
