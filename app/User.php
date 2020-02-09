<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

   protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
    public function profession() //profession_id
    {
        return $this->belongsTo(Profession::class);
    }
    */

    public static function findByEmail($email)
    {
        return static::where('email', '=', $email)->first();
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class)->withDefault([
            'bio' => ''
        ]);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
