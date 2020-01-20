<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
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
        'name', 'email', 'password',
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

    public function profession() //profession_id
    {
        return $this->belongsTo(Profession::class);
    }

    public static function findByEmail($email)
    {
        return static::where('email', '=', $email)->first();
    }

    public function isAdmin()
    {
        return $this->email === 'francisco.adan@escuelaestech.es';
    }
}
