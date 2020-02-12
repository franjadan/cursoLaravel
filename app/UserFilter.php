<?php

namespace App;

class UserFilter extends QueryFilter
{
    public function rules(): array
    {
        return [
            'team' => 'in:with_team,without_team',
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:admin,user'
        ];
    }

    public function filterByTeam($query, $team)
    {
        $query->when($team, function($query, $team) {
            if ($team === 'with_team') {
                $query->has('team');
            } elseif ($team === 'without_team') {
                
                $query->doesntHave('team');
            }
        });
    }

    public function filterBySearch($query, $search)
    {        
       return $query->when($search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('team', function($query) use ($search){
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
         });
    }

    public function filterByState($query, $state)
    {
         return $query->where('active', $state == 'active');
    }
}