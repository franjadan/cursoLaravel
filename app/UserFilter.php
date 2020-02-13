<?php

namespace App;

use Illuminate\Support\Facades\DB;

class UserFilter extends QueryFilter
{
    public function rules(): array
    {
        return [
            'team' => 'in:with_team,without_team',
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:admin,user',
            'skills' => 'array|exists:skills,id',
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

    public function filterBySkills($query, $skills)
    {

        $subquery = DB::table('user_skills AS s')
            ->selectRaw('COUNT(`s`.`id`)')
            ->whereColumn('s.user_id', 'users.id')
            ->whereIn('skill_id', $skills);

        $query->whereQuery($subquery, count($skills));


        /*
        $query->whereHas('skills', function ($q) use ($skills) {
            $q->whereIn('skills.id', $skills)
                ->havingRaw('COUNT(skills.id) = ?', [count($skills)]);
        });
        */
    }
}