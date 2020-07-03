<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $guarded = ['id'];

    protected $table = 'groups_users';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $usergroup = self::find($id);
        if ($usergroup) {
            $results = array(
                'id' => ($usergroup->id) ? $usergroup->id : '',
                'group_id' => ($usergroup->group_id) ? $usergroup->group_id : '',
                'users_id' => ($usergroup->users_id) ? $usergroup->users_id : '',
                'batch_id' => ($usergroup->batch_id) ? $usergroup->batch_id : ''
            );
        } else {
            $results = array(
                'id' => '',
                'group_id' => '',
                'users_id' => '',
                'batch_id' => ''
            );
        }
        return (object) $results;
    }

    public function get_this_groupsusers($id)
    {
        $groupsusers = GroupUser::select('groups_users.*', 'students.id as stud_id', 'students.user_id', 'students.identification_no', 'students.firstname', 'students.lastname')->where('groups_users.group_id', $id)->join('students', 'students.id', 'groups_users.users_id')->get();
        return $groupsusers;
    }
}
