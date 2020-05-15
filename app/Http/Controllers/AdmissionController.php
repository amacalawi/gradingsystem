<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Admission;

class AdmissionController extends Controller
{
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }

    public function all_admitted(Request $request)
    {
        
        $res = Admission::where('is_active', 1)->where('status', 'admit')->where('schoolyear_id', '1')->orderBy('id', 'DESC')->get();
        //die( var_dump($res) );
        return $res->map(function($admmit) {
            return [
                'admmitID' => $admmit->id,
                'admmitUserId' => $admmit->user_id,
                'admmitFirstname' => $admmit->firstname,
                'admmitMiddlename' => $admmit->middlename,
                'admmitLastname' => $admmit->lastname,
                'admmitSchoolyear' => $admmit->schoolyear_id,
                'admmitStatus' => $admmit->status,
                'admmitModified' => ($admmit->updated_at !== NULL) ? date('d-M-Y', strtotime($admmit->updated_at)).'<br/>'. date('h:i A', strtotime($admmit->updated_at)) : date('d-M-Y', strtotime($admmit->created_at)).'<br/>'. date('h:i A', strtotime($admmit->created_at))
            ];
        });
        
    }

    public function get_this_admitted(Request $request, $id)
    {
        $student = (new Admission)->get_this_admitted( $id );
        echo json_encode( $student ); exit();
        
    }

}
