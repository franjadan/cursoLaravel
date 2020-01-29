<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Profession;
use App\UserProfile;
use App\Skill;
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

        $professions = Profession::orderBy('title', 'ASC')->get();
        $skills = Skill::orderBy('name', 'ASC')->get();

        return view('users.create', [
            'professions' => $professions,
            'skills' => $skills
        ]);
    }

    public function store(CreateUserRequest $request)
    {
        $request->createUser();

        return redirect()->route('users.index');
    }

    public function edit(User $user) 
    {

        $professions = Profession::orderBy('title', 'ASC')->get();

        return view('users.edit', [
            'user' => $user,
            'professions' => $professions
            
        ]);
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'present', 'min:6'],
            'admin' => 'required',
            'profession_id' => ['required', Rule::exists('professions', 'id')]
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser válido',
            'email.unique' => 'El campo email debe ser único',
            'password.min' => 'El campo password debe tener mínimo 6 caracteres',
            'admin.required' => 'El campo administrador debe ser obligatorio',
            'profession_id.required' => 'El campo profesión debe ser obligatorio'
        ]);

        if($data['password'] != null){
            $data['password'] = bcrypt($data['password']);
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'is_admin' => $data['admin'] == 'true' ? true : false,
                'profession_id' => (int)$data['profession_id']
            ]);
        } else {
            unset($data['password']);
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'is_admin' => $data['admin'] == 'true' ? true : false,
                'profession_id' => (int)$data['profession_id']
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
