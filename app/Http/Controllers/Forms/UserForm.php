<?php

namespace App\Http\Controllers\Forms;

use App\{Profession, Skill, User};
use Illuminate\Contracts\Support\Responsable;

class UserForm implements Responsable
{

    private $view;
    private $user;

    public function __construct($view, $user)
    {
        $this->view = $view;
        $this->user = $user;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return view($this->view, [
            'user' => $this->user,
            'professions' => Profession::orderBy('title', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
            'roles' => trans('users.roles')
        ]);
    }
}