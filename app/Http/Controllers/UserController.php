<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() 
    {

        $users = [
            'Joel',
            'Ellie',
            'Tess',
            'Tommy',
            'Bill'
        ];

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
        return "Mostrando detalle del usuario: {$id}";
    }

    public function create() 
    {
        return 'Crear nuevo usuario';
    }

    public function edit($id) {
        return "Editando al usuario {$id}";
    }
}
