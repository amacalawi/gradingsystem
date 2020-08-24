<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Batch;
use App\Models\Group;
use App\Models\Section;
use App\User;

class InfoblastController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $menus = $this->load_menus();
        return view('modules/notifications/messaging/infoblast/new')->with(compact('menus'));
    }

    public function new()
    {   
        $menus = $this->load_menus();
        $groups = Group::where('is_active', 1)->get();
        $sections = Section::where('is_active', 1)->get();
        $users = User::where('id', '!=', 1)->where('is_active', 1)->get();
        return view('modules/notifications/messaging/infoblast/new')->with(compact('menus', 'groups', 'sections', 'users'));
    }
}
