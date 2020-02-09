<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $guarded = [];

    public function profession() //profession_id
    {
        return $this->belongsTo(Profession::class);
    }
}
