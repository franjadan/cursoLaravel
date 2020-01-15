<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() 
    {

        if(request()->has('empty')) {
            $users = [];
        } else {
            $users = [
                'Joel',
                'Ellie',
                'Tess',
                'Tommy',
                'Bill'
            ];
        }
        

        /*
        return view('users', [
            'users' => $users,
            'title' => 'Listado de usuarios'
        ]);
        */

        /*
        return view('users')
            ->with('users', $users)
            ->with('title', 'Listado de usuarios');
        */

        $title = 'Listado de usuarios';

        return view('users.list', compact('users', 'title'));
    }

    public function show($id) 
    {
        return view('users.show', [
            'id' => $id
        ]);
    }

    public function create() 
    {
        return view('users.create');
    }

    public function edit($id) {
        return view('users.edit', [
            'id' => $id
        ]);
    }
}
