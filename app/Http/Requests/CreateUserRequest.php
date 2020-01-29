<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\User;

class CreateUserRequest extends FormRequest
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
        return [
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'bio' => 'required',
            'twitter' => ['nullable', 'url'],
            'profession_id' => ['required', Rule::exists('professions', 'id')],
            'admin' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser válido',
            'email.unique' => 'El campo email debe ser único',
            'password.required' => 'El campo password debe ser obligatorio',
            'password.min' => 'El campo password debe tener mínimo 6 caracteres',
            'bio.required' => 'El campo bio es obligatorio',
            'twitter.url' => 'El campo twitter debe ser una url válida',
            'profession_id.required' => 'El campo profesión debe ser obligatorio',
            'admin.required' => 'El campo administrador es obligatorio'
        ];
    }

    public function createUser()
    {
        DB::transaction(function () {
            $data = $this->validated();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'is_admin' => $data['admin'] == 'true' ? true : false,
                'profession_id' => (int)$data['profession_id']
            ]);
    
            $user->profile()->create([
                'bio' => $data['bio'],
                'twitter' => $data['twitter'] ?? null
            ]);
        });
    }
}
