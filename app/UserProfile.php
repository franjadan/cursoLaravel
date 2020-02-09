<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserProfile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'bio', 'twitter', 'user_id', 'profession_id'
    ];

    public function profession() //profession_id
    {
        return $this->belongsTo(Profession::class);
    }
}
