<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

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

        //return redirect('usuarios/nuevo')->withInput();

        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser válido',
            'email.unique' => 'El campo email debe ser único',
            'password.required' => 'El campo password debe ser obligatorio',
            'password.min' => 'El campo password debe tener mínimo 6 caracteres'
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return redirect()->route('users.index');
    }

    public function edit($id) {
        return view('users.edit', [
            'id' => $id
        ]);
    }
}
