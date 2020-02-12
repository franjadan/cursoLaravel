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
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index(Request $request) 
    {
        $users = User::query()
            ->with('team', 'skills', 'profile.profession')
            ->filterBy($request->only(['state', 'role', 'team', 'search']))
            ->orderByDesc('created_at')
            ->paginate();

        $view = "index";
        $title = 'Listado de usuarios';

        return view('users.index', [
            'users' => $users,
            'title' => $title,
            'view' => $view,
            'skills' => Skill::orderBy('name')->get(),
            'checkedSkills' => collect(request('skills'))
        ]);
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->paginate();
        $title = 'Listado de usuarios en papelera';
        $view = 'trashed';

        return view('users.index', compact('users', 'view', 'title'));
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
