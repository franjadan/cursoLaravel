<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Profession;
use App\UserProfile;
use App\Skill;
use App\Http\Controllers\Forms\UserForm;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateUserRequest;

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
        return view('users.show', [
            'user' => $user
        ]);
    }

    public function create() 
    {
        return new UserForm('users.create', new User);
    }

    public function store(CreateUserRequest $request)
    {
        $request->createUser();

        return redirect()->route('users.index');
    }

    public function edit(User $user) 
    {
        return new UserForm('users.edit', $user);
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'present', 'min:6'],
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser válido',
            'email.unique' => 'El campo email debe ser único',
            'password.min' => 'El campo password debe tener mínimo 6 caracteres',
        ]);

        if($data['password'] != null){
            $data['password'] = bcrypt($data['password']);
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        } else {
            unset($data['password']);
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);
        }

        return redirect()->route('users.show', ['user' => $user]);
    }

    public function destroy(User $user)
    {

        $user->delete();

        return redirect()->route('users.index');
    }
}
