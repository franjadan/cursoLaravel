<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Rules\SortableColumn;

class UserFilter extends QueryFilter
{

    protected $aliases = [
        'date' => 'created_at'
    ];

    public function rules(): array
    {
        return [
            'team' => 'in:with_team,without_team',
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:admin,user',
            'skills' => 'array|exists:skills,id',
            'from' => 'date_format:d/m/Y',
            'to' => 'date_format:d/m/Y',
            'order' => [new SortableColumn(['first_name', 'email', 'date'])],
            'trashed' => 'accepted'
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

    public function order($query, $value)
    {

        [$column, $direction] = Sortable::info($value);

        $query->orderBy($this->getColumnName($column), $direction);
        
    }

    public function trashed($query, $value)
    {
         $query->onlyTrashed();
    }

    protected function getColumnName($alias)
    {
        return $this->aliases[$alias] ?? $alias;
    }

}