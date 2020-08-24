<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Student;
use App\Models\Batch;

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
        return view('modules/components/groups/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/components/groups/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/components/groups/inactive')->with(compact('menus'));
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

        return view('modules/components/groups/add')->with(compact('menus', 'group', 'segment', 'flashMessage'));
    }

    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        $group = (new Group)->find($id);
        $groupusers = (new GroupUser)->get_this_groupsusers($id);
        return view('modules/components/groups/edit')->with(compact('menus', 'groupusers', 'group', 'segment', 'flashMessage'));
    }

    public function store(Request $request)
    {   

        $timestamp = date('Y-m-d H:i:s');
        $batch_id = Batch::where('is_active','1')->where('status','Current')->pluck('id');
        //die(var_dump($batch_id));
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

        $users = $request->group_member;
        if($users)
        {
            foreach ($users as $key => $user) {
                $groupuser = GroupUser::create([
                    'group_id' => $group->id,
                    'users_id' => $user,
                    'batch_id' =>  $batch_id[0],
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            }
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
        $batch_id = Batch::where('is_active','1')->where('status','Current')->pluck('id');

        if(!$batch_id->isEmpty())
        {
            $group = Group::find($id);

            if(!$group) {
                throw new NotFoundHttpException();
            }

            $group->code = $request->code;
            $group->name = $request->name;
            $group->description = $request->description;
            $group->updated_at = $timestamp;
            $group->updated_by = Auth::user()->id;

            //UPDATE groupuser
            $groupuser = GroupUser::where('group_id', $id)->where('is_active', 1);
            $groupuser->delete();
            $users = $request->group_member;

            if($users){
                foreach ($users as $key => $user) {
                    $user = intval($user);
                    $groupuser = GroupUser::create([
                        'group_id' => $id,
                        'users_id' => $user,
                        'batch_id' =>  $batch_id[0],
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);
                }
            }

            if ($group->update()) {

                $data = array(
                    'title' => 'Well done!',
                    'text' => 'The group has been successfully updated.',
                    'type' => 'success',
                    'class' => 'btn-brand'
                );
            }
        }
        else 
        {
            $data = array(
                'title' => 'Warning',
                'text' => 'No current batch is active.',
                'type' => 'warning',
                'class' => 'btn-brand'
            );
        }

        echo json_encode( $data ); exit();
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

    public function all_member()
    {
        /*if($group_id){
            $res = Student::where('is_active', 1)->whereNotIn('id',function($query) {
                $query->select('users_id')->from('groups_users')->where('group_id', $group_id);
            })->orderBy('students.id', 'ASC')->get();
        } else {*/
        $res = Student::where('is_active', 1)->orderBy('id', 'ASC')->get();
        //}
        
        return $res->map(function($student) {
            return [
                'studentID' => $student->id,
                'studentIdentification' => $student->identification_no,
                'studentName' => $student->firstname.' '.$student->lastname,
                'studentModified' => ($student->updated_at !== NULL) ? date('d-M-Y', strtotime($student->updated_at)).'<br/>'. date('h:i A', strtotime($student->updated_at)) : date('d-M-Y', strtotime($student->created_at)).'<br/>'. date('h:i A', strtotime($student->created_at)),          
            ];
        });
    }

    public function get_student($id)
    {
        $student = (new Student)->get_this_student( $id );
        echo json_encode( $student ); exit();
    }

}
