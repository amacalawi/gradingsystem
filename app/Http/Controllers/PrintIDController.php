<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\html;

use App\Models\Module;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Admission;
use App\User;

class PrintIDController extends Controller
{
    public function view(Request $request, $id = '')
    { 
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $batch = (new Batch)->get_current_batch();
        $module = (new Module)->fetch($id);
        $users = (new Student)->all_student($batch);
        
        return view('modules/notifications/print/view')->with(compact( 'menus','segment','module','users' ));
    }

    public function search(Request $request, $id)
    {   
        $user = (new Student)->fetch($id);
        //check if profile picture exist
        if (!file_exists( storage_path('app/public/uploads/students').'/'.str_replace("-", "", $user->identification_no).'/'.$user->avatar )) {
            $user->avatar = 'default.png';
        }

        // level and section;
        $batch = (new Batch)->get_current_batch();
        $level_sections = (new Admission)->get_student_level_section( $user->id, $batch);
        if($level_sections){
            foreach($level_sections as $level_section){
                $user->section = $level_section->section_name;
                $user->level = $level_section->level_name;
            }
        }
        echo json_encode( $user ); exit();
    }
}
