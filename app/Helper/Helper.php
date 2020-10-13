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
        $route = (request()->segment(3) == null || request()->segment(3) == 'add' || request()->segment(3) == 'edit' || request()->segment(3) == 'store' || request()->segment(3) == 'update' || request()->segment(3) == 'import' || request()->segment(3) == 'update-status')  ? '' : request()->segment(3);
        $modSlug = (request()->segment(2) == null)  ? '' : request()->segment(2);

        if ($role->count() > 0) {
            $sub_module = SubModule::select('sub_modules.id')
            ->join('modules', function($join2)
            {
                $join2->on('modules.id', '=', 'sub_modules.module_id');
            })
            ->where(['modules.slug' => $modSlug, 'sub_modules.slug' => $route, 'sub_modules.is_active' => 1])
            ->get();

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