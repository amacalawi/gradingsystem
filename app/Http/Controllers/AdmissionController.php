<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Admission;

class AdmissionController extends Controller
{

    private $models;
    
    public function all_admitted(Request $request)
    {
        
        $res = Admission::select('admissions.id as admin_id','admissions.*','students.id as stud_id', 'students.*')
            ->join('students', 'students.id', '=', 'admissions.user_id')
            ->where('admissions.is_active', 1)
            ->where('admissions.status', '')
            ->orderBy('admin_id', 'desc')->get();
   
        return $res->map(function($admit) {
            return [
                'admitID' => $admit->id,
                'admitUserId' => $admit->user_id,
                'admitName' => $admit->lastname . ', ' .$admit->firstname.' '.$admit->middlename,
                'admitBatchId' => $admit->batch_id,
                'admitStatus' => $admit->status,
                'admitSectionStudentId' => $admit->section_student_id,
                'admitModified' => ($admit->updated_at !== NULL) ? date('d-M-Y', strtotime($admit->updated_at)).'<br/>'. date('h:i A', strtotime($admit->updated_at)) : date('d-M-Y', strtotime($admit->created_at)).'<br/>'. date('h:i A', strtotime($admit->created_at))
            ];
        });
        
    }

    public function get_this_admitted(Request $request, $id)
    {
        $student = (new Admission)->get_this_admitted( $id );
        echo json_encode( $student ); exit();
        
    }

}
