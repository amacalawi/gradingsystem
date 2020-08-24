<?php

namespace App;

use Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Student;
use App\Models\Staff;
use App\Models\GuardianUser;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'type', 'secret_question_id', 'secret_password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function fetch($id)
    {
        $user = self::with([
            'role' => function($q) {
                $q->select(['user_id', 'role_id']); 
            },
        ])->where('id', $id)->first();

        if ($user) {
            $results = array(
                'id' => ($user->id) ? $user->id : '',
                'name' => ($user->name) ? $user->name : '',
                'email' => ($user->email) ? $user->email : '',
                'username' => ($user->username) ? $user->username : '',
                'password' => ($user->password) ? $user->password : '',
                'secret_question_id' => ($user->secret_question_id) ? $user->secret_question_id : '',
                'secret_password' => ($user->secret_password) ? $user->secret_password : '',
                'role_id' => ($user->role->role_id) ? $user->role->role_id : 0
            );
        } else {
            $results = array(
                'id' => '',
                'name' => '',
                'email' => '',
                'username' => '',
                'password' => '',
                'secret_question_id' => '',
                'secret_password' => '',
                'role_id' => 0
            );
        }
        return (object) $results;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
        $this->attributes['secret_password'] = Hash::make($value);
    }

    public function role()
    {
        return $this->hasOne('App\Models\UserRole', 'user_id', 'id');
    }

    public function get_msisdn_via_user($userID)
    {
        $user = self::where('id', $userID)->get();
        if ($user->count() > 0) {
            if ($user->first()->type == 'student') {
                return ((new Student)->where('user_id', $user->first()->id)->pluck('mobile_no') !== NULL) ? (new Student)->where('user_id', $user->first()->id)->pluck('mobile_no') : '';
            } else if ($user->first()->type == 'parent') {
                $guardian = (new GuardianUser)->with([
                    'guardian' =>  function($q) { 
                        $q->select(['id', 'mother_contact_no', 'mother_email', 'father_contact_no', 'father_email']);
                    },
                ])->where('user_id', '=', $user->first()->id)->get();

                if ($guardian->count() > 0) {
                    if ($user->first()->email == $guardian->first()->mother_email) {
                        return ($guardian->first()->mother_contact_no !== NULL) ? $guardian->first()->mother_contact_no : '';
                    } else {
                        return ($guardian->first()->father_contact_no !== NULL) ? $guardian->first()->father_contact_no : '';
                    }
                }
            } else if ($user->first()->type == 'staff') {
                return ((new Staff)->where('user_id', $user->first()->id)->pluck('mobile_no') !== NULL) ? (new Staff)->where('user_id', $user->first()->id)->pluck('mobile_no') : '';
            } else {
                return '09283164164';
            }
        }
    }
}
