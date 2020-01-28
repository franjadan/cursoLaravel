<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
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
        'name', 'email', 'password', 'profession_id', 'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $cast = [
        'is_admin' => 'boolean'
    ];

    public static function createUser($data){
         DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'is_admin' => $data['admin'] == 'true' ? true : false,
                'profession_id' => (int)$data['professions']
            ]);
    
            $user->profile()->create([
                'bio' => $data['bio'],
                'twitter' => $data['twitter']
            ]);
        });
    }

    public function profession() //profession_id
    {
        return $this->belongsTo(Profession::class);
    }

    public static function findByEmail($email)
    {
        return static::where('email', '=', $email)->first();
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function isAdmin()
    {
        return $this->email === 'francisco.adan@escuelaestech.es';
    }
}
