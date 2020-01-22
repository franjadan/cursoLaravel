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

    public function show(User $user) 
    {

        /*
        $user = User::find($id);

        if($user == null) {
            return response()->view('errors.404', [], 404);
        }
        */

        //$user = User::findOrFail($id);
        
        return view('users.show', [
            'user' => $user
        ]);
    }

    public function create() 
    {
        return view('users.create');
    }

    public function store()
    {
        return "Procesando información...";
    }

    public function edit($id) {
        return view('users.edit', [
            'id' => $id
        ]);
    }
}
