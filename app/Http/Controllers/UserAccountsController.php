<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\SecretQuestion;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class UserAccountsController extends Controller
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
        return view('modules/memberships/users/accounts/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/memberships/users/accounts/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/memberships/users/accounts/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = User::with([
            'role' =>  function($q) { 
                $q->select(['user_id', 'role_id']); 
            }
        ])->where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($user) {
            return [
                'userID' => $user->id,
                'userEmail' => $user->email,
                'userFullname' => $user->name,
                'userName' => $user->username,
                'userRole' => (new Role)->where('id', $user->role->role_id)->pluck('name'),
                'userModified' => ($user->updated_at !== NULL) ? date('d-M-Y', strtotime($user->updated_at)).'<br/>'. date('h:i A', strtotime($user->updated_at)) : date('d-M-Y', strtotime($user->created_at)).'<br/>'. date('h:i A', strtotime($user->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = User::with([
            'role' =>  function($q) { 
                $q->select(['user_id', 'role_id']); 
            }
        ])->where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($user) {
            return [
                'userID' => $user->id,
                'userEmail' => $user->email,
                'userFullname' => $user->name,
                'userName' => $user->username,
                'userRole' => (new Role)->where('id', $user->role->role_id)->pluck('name'),
                'userModified' => ($user->updated_at !== NULL) ? date('d-M-Y', strtotime($user->updated_at)).'<br/>'. date('h:i A', strtotime($user->updated_at)) : date('d-M-Y', strtotime($user->created_at)).'<br/>'. date('h:i A', strtotime($user->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $user = (new User)->fetch($id);
        $secrets = (new SecretQuestion)->all_secrets();
        $roles = (new Role)->all_roles();
        return view('modules/memberships/users/accounts/add')->with(compact('menus', 'user', 'secrets', 'roles', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $user = (new User)->fetch($id);
        $secrets = (new SecretQuestion)->all_secrets();
        $roles = (new Role)->all_roles();
        return view('modules/memberships/users/accounts/edit')->with(compact('menus', 'user', 'secrets', 'roles', 'segment'));
    }
    
    public function store(Request $request)
    {   
        $this->is_permitted(0);  
        $timestamp = date('Y-m-d H:i:s');

        $rows = User::with([
            'role' =>  function($q) { 
                $q->select(['user_id', 'role_id']); 
            }
        ])->where([
            'email' => $request->email
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a user with an existing email.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'type' => (new Role)->where('id', $user->role->role_id)->pluck('name'),
            'secret_question_id' => $request->secret_question_id,
            'secret_password' => $request->secret_password,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        $userRole = UserRole::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The user has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $user = User::find($id);
        
        if(!$user) {
            throw new NotFoundHttpException();
        }

        $rows = User::where('id', '!=', $id)->where('email', $request->email)->count();    

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'rows' => $rows,
                'text' => 'The email is already in use.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $password = User::where('id', '=', $id)->pluck('password');
        if ($password != $request->password) {
            $secret_password = User::where('id', '=', $id)->pluck('secret_password');
            if ($secret_password != $request->secret_password) {
                User::where('id', '=', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'type' => (new Role)->where('id', $user->role->role_id)->pluck('name'),
                    'secret_question_id' => $request->secret_question_id,
                    'secret_password' => Hash::make($request->secret_password),
                    'updated_at' => $timestamp
                ]);
            } else {
                User::where('id', '=', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'type' => (new Role)->where('id', $user->role->role_id)->pluck('name'),
                    'secret_question_id' => $request->secret_question_id,
                    'updated_at' => $timestamp
                ]);
            }
        } else {
            $secret_password = User::where('id', '=', $id)->pluck('secret_password');
            if ($secret_password != $request->secret_password) {
                User::where('id', '=', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => (new Role)->where('id', $user->role->role_id)->pluck('name'),
                    'secret_question_id' => $request->secret_question_id,
                    'secret_password' => Hash::make($request->secret_password),
                    'updated_at' => $timestamp
                ]);
            } else {
                User::where('id', '=', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => (new Role)->where('id', $user->role->role_id)->pluck('name'),
                    'secret_question_id' => $request->secret_question_id,
                    'updated_at' => $timestamp
                ]);
            }
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The user has been successfully updated.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update_status(Request $request, $id)
    {   
        $this->is_permitted(3);
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Remove') {
            $users = User::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The user has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else {
            $batches = User::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The user has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

}
