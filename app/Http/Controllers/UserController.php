<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Profession;
use Illuminate\Validation\Rule;

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

        $professions = Profession::all();

        return view('users.create', [
            'professions' => $professions
        ]);
    }

    public function store()
    {

        //return redirect('usuarios/nuevo')->withInput();

        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'admin' => 'required',
            'professions' => 'required'
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser válido',
            'email.unique' => 'El campo email debe ser único',
            'password.required' => 'El campo password debe ser obligatorio',
            'password.min' => 'El campo password debe tener mínimo 6 caracteres',
            'admin.required' => 'El campo administrador debe ser obligatorio',
            'professions.required' => 'El campo profesión debe ser obligatorio'
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'is_admin' => $data['admin'] == 'true' ? true : false,
            'profession_id' => (int)$data['professions']
        ]);

        return redirect()->route('users.index');
    }

    public function edit(User $user) 
    {
        return view('users.edit', [
            'user' => $user,
            
        ]);
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'min:6'],
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser válido',
            'email.unique' => 'El campo email debe ser único',
            'password.min' => 'El campo password debe tener mínimo 6 caracteres'
        ]);

        if($data['password'] != null){
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.show', ['user' => $user]);
    }

    public function destroy(User $user)
    {

        $user->delete();

        return redirect()->route('users.index');
    }
}
