<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'bio', 'twitter', 'user_id', 'profession_id'
    ];

    public function profession() //profession_id
    {
        return $this->belongsTo(Profession::class);
    }
}
