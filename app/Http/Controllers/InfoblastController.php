<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Batch;

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
        return view('modules/notifications/messaging/infoblast/new')->with(compact('menus'));
    }
}
