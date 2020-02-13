<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class UserQuery extends QueryBuilder
{
    public function findByEmail($email)
    {
        return $this->where('email', '=', $email)->first();
    }

}