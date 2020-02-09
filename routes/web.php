<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return view('home');
});

Route::get('/usuarios', 'UserController@index')
    ->name('users.index');

Route::get('/usuarios/{user}', 'UserController@show')
    ->where('user', '[0-9]+')
    ->name('users.show');

Route::post('/usuarios/crear', 'UserController@store');

Route::get('/usuarios/nuevo', 'UserController@create')
    ->name('users.create');

Route::get('/usuarios/{user}/editar', 'UserController@edit')
    ->name('users.edit');

Route::put('/usuarios/{user}', 'UserController@update');

Route::get('/usuarios/papelera', 'UserController@trashed')
    ->name('users.trashed');

Route::post('/usuarios/{id}/restaurar', 'UserController@restore')
    ->name('users.restore');

Route::patch('/usuarios/{user}/papelera', 'UserController@trash')
    ->name('users.trash');

Route::delete('/usuarios/{user}', 'UserController@destroy')
    ->name('users.destroy');

Route::get('/saludo/{name}', 'WelcomeUserController@greetWithoutNickname');

Route::get('/profesiones', 'ProfessionController@index')
    ->name('professions.index');

Route::delete('/profesiones/{profession}', 'ProfessionController@destroy')
    ->name('professions.destroy');

Route::get('/habilidades', 'SkillController@index')
    ->name('skills.index');

Route::delete('/habilidades/{skill}', 'SkillController@destroy')
    ->name('skills.destroy');

Route::get('/saludo/{name}/{nickname}', 'WelcomeUserController@greetWithNickname');

