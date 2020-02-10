<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Profession;
use App\UserProfile;
use App\Skill;
use App\Role;
use App\Http\Controllers\Forms\UserForm;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index() 
    {
        $users = User::orderBy('created_at', 'DESC')->paginate();
        $route = "Listado";
        $title = 'Listado de usuarios';

        return view('users.index', compact('users', 'route', 'title'));
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->paginate();
        $route = "Papelera";
        $title = 'Listado de usuarios en papelera';

        return view('users.index', compact('users', 'route', 'title'));
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

    public function update(UpdateUserRequest $request, User $user)
    {

        $request->updateUser($user);
        
        return redirect()->route('users.show', ['user' => $user]);
    }

    public function trash(User $user)
    {
        $user->delete();
        $user->profile()->delete();

        return redirect()->route('users.index');
    }

    public function restore($id)
    {
        User::onlyTrashed()->where('id', $id)->firstOrFail()->restore();  
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->firstOrFail();

        $user->forceDelete();

        return redirect()->route('users.trashed');
    }
}
