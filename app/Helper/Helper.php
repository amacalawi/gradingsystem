<?php

namespace App\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;
use App\Models\RoleSubModule;
use App\Models\SubModule;

class Helper
{
    public static function get_privileges()
    {   
        $role = (new UserRole)->where('user_id', Auth::user()->id)->get();
        $route = request()->segment(3);

        if ($role->count() > 0) {
            $sub_module = SubModule::where(['slug' => $route, 'is_active' => 1])->get();
            if ($sub_module->count() > 0) {
                $privileges = RoleSubModule::where(['role_id' => $role->first()->id, 'sub_module_id' => $sub_module->first()->id, 'is_active' => 1])->get();
                if ($privileges->count() > 0) {
                    return $privileges->first()->permissions;
                }
            } 
        } 

        return '0,0,0,0';
    }
}