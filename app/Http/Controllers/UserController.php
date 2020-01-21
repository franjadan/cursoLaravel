<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    public function index() 
    {
        $users = User::all();

        $title = 'Listado de usuarios';

        return view('users.index', compact('users', 'title'));
    }

    public function show($id) 
    {
        $user = User::find($id);
        
        return view('users.show', [
            'user' => $user
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
