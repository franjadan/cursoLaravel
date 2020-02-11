<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\User;
use App\Role;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user)],
            'password' => ['nullable', 'present', 'min:6'],
            'bio' => 'required',
            'twitter' => ['nullable', 'present', 'url'],
            'profession_id' => ['nullable', 'present', Rule::exists('professions', 'id')],
            'role' => [Rule::in(Role::getList())],
            'skills' => ['array', Rule::exists('skills', 'id')]
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'El campo nombre es obligatorio',
            'last_name.required' => 'El campo apellido es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser válido',
            'email.unique' => 'El campo email debe ser único',
            'password.min' => 'El campo password debe tener mínimo 6 caracteres',
            'bio.required' => 'El campo bio es obligatorio',
            'profession_id.exists' => 'El campo profesión debe ser válido',
            'profession_id.present' => 'El campo profesión debe estar presente',
            'twitter.url' => 'El campo twitter debe ser una url válida',
            'role.in' => 'El rol debe ser válido'
        ];
    }

    public function updateUser(User $user)
    {
       $user->forceFill([
           'first_name' => $this->first_name,
           'last_name' => $this->last_name,
           'email' => $this->email,
           'role' => $this->role
       ]);

        if($this->password != null){
            $user->password = bcrypt($this->password);
        }

        $user->save();

        $user->profile->update([
            'twitter' => $this->twitter,
            'bio' => $this->bio,
            'profession_id' => $this->profession_id
        ]);

        $user->skills()->sync($this->skills ?? []);
    }
}
