<?php

namespace App;

use Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'secret_question_id', 'secret_password'
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
}
