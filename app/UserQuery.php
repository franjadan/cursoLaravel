<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class UserQuery extends Builder
{
    public function findByEmail($email)
    {
        return static::where('email', '=', $email)->first();
    }

    public function search($team, $search)
    {

        if($team) {
            $this->when($team, function($query, $team) {
                if ($team === 'with_team') {
                    $query->has('team');
                } elseif ($team === 'without_team') {
                    $query->doesntHave('team');
                }
            });
        }

        if($search) {
            $this->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('team', function($query) use ($search){
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            });
        }

        return $this;
    }

    public function byState($state)
    {
        if ($state == 'active') {
            return $this->where('active', true);
        } elseif ($state == 'inactive') {
            return $this->where('active', false);
        }

        return $this;
    }

    public function byRole($role)
    {
        if (in_array($role, ['user', 'admin'])) {
            $this->where('role', $role);
        }

        return $this;
    }

}