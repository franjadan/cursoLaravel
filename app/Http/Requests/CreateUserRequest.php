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
            'password' => ['required', 'present', 'min:6'],
            'bio' => 'required',
            'twitter' => ['nullable', 'present', 'url'],
            'profession_id' => ['nullable', 'present', Rule::exists('professions', 'id')],
            'admin' => 'required',
            'skills' => ['array'. Rule::exits('skills', 'id')]
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
            'profession_id.exists' => 'El campo profesión debe ser válido',
            'profession_id.present' => 'El campo profesión debe estar presente',
            'twitter.url' => 'El campo twitter debe ser una url válida',
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
                'is_admin' => $data['admin'] == 'true' ? true : false
            ]);
    
            $user->profile()->create([
                'bio' => $data['bio'],
                'twitter' => $data['twitter'],
                'profession_id' => $data['profession_id'] ?? null
            ]);

            if(! empty($data['skills'])) {
                $user->skills()->attach($data['skills']);
            }
        });
    }
}
