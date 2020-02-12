<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class UserQuery extends Builder
{

    use FiltersQueries;

    public function findByEmail($email)
    {
        return static::where('email', '=', $email)->first();
    }

    protected function filterRules(): array
    {
        $rules = [
            'team' => 'in:with_team,without_team',
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:admin,user',
            
        ];

        return $rules;
    }

    public function filterByTeam($team)
    {
        $this->when($team, function($query, $team) {
            if ($team === 'with_team') {
                $query->has('team');
            } elseif ($team === 'without_team') {
                
                $query->doesntHave('team');
            }
        });
    }

    public function filterBySearch($search)
    {        
       return $this->when($search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('team', function($query) use ($search){
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
         });
        
    }

    public function filterByState($state)
    {
         return $this->where('active', $state == 'active');
    }

}