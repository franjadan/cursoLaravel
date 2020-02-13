<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

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
            'from' => 'date_format:d/m/Y',
            'to' => 'date_format:d/m/Y'
        ];
    }

    public function team($query, $team)
    {
        $query->when($team, function($query, $team) {
            if ($team === 'with_team') {
                $query->has('team');
            } elseif ($team === 'without_team') {
                
                $query->doesntHave('team');
            }
        });
    }

    public function search($query, $search)
    {        
       
        $query->where(function ($query) use ($search) {
            $query->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhereHas('team', function($query) use ($search){
                    $query->where('name', 'like', "%{$search}%");
                });
        });   
    }

    public function state($query, $state)
    {
         return $query->where('active', $state == 'active');
    }

    public function skills($query, $skills)
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

    public function from($query, $date)
    {
        $date = Carbon::createFromFormat('d/m/Y', $date);

        $query->whereDate('created_at', '>=', $date);
    }

    public function to($query, $date)
    {
        $date = Carbon::createFromFormat('d/m/Y', $date);

        $query->whereDate('created_at', '<=', $date);
    }
}