<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
use App\Models\RoleHeader;
use App\Models\RoleModule;
use App\Models\RoleSubModule;

class UserRole extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'users_roles';
    
    public $timestamps = false;

    public function load_menus($user)
    {   
        $menus = array(); $increment = 0;
        $userRole = self::where('user_id', $user)->first();

        $userHeaders = RoleHeader::with([
            'header' => function($q) {
                $q->select(['id', 'name', 'slug'])->where('is_active', 1)->orderBy('order', 'asc'); 
            },
        ])->where('role_id', $userRole->role_id)->get();

        foreach($userHeaders as $userHeader) {
            $menus[$increment] = array(
                'id' => $userHeader->header->id,
                'name' => $userHeader->header->name,
                'slug' => $userHeader->header->slug,
            );

            $headerID = $userHeader->header->id;
            $userModules = RoleModule::with([
                'module' => function($q) {
                    $q->select(['header_id', 'id', 'name', 'slug', 'icon'])->orderBy('order', 'asc');
                },
            ])
            ->where('role_id', $userRole->role_id)
            ->whereIn('module_id', Module::select('id')->where(['header_id' => $headerID, 'is_active' => 1])->orderBy('order', 'asc'))
            ->get();
                
            $modulars = array();
            foreach ($userModules as $userModule) {
                $menus[$increment]['modules'][$userModule->module->id] = array(
                    'id' => $userModule->module->id,
                    'name' => $userModule->module->name,
                    'slug' => $userModule->module->slug,
                    'icon' => $userModule->module->icon
                );

                $moduleID = $userModule->module->id;
                $userSubModules = RoleSubModule::with([
                    'sub_module' => function($q) use ($moduleID) {
                        $q->select(['module_id', 'id', 'name', 'slug', 'icon'])->orderBy('order', 'asc'); 
                    },
                ])
                ->where('role_id', $userRole->role_id)
                ->whereIn('sub_module_id', SubModule::select('id')->where(['module_id' => $moduleID, 'is_active' => 1])->orderBy('order', 'asc'))
                ->get();

                foreach ($userSubModules as $userSubModule) {
                    $menus[$increment]['sub_modules'][$moduleID][$userSubModule->sub_module->id] = array(
                        'id' => $userSubModule->sub_module->id,
                        'name' => $userSubModule->sub_module->name,
                        'slug' => $userSubModule->sub_module->slug,
                        'icon' => $userSubModule->sub_module->icon
                    );
                }
            }

            $increment++;
        }

        return $menus;
    }
}

