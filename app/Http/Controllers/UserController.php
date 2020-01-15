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

        return view('users', compact('users', 'title'));
    }

    public function show($id) 
    {
        return view('usersDetail', [
            'id' => $id
        ]);
    }

    public function create() 
    {
        return view('usersCreate');
    }

    public function edit($id) {
        return view('usersEdit', [
            'id' => $id
        ]);
    }
}
