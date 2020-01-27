@extends('layout')

@section('title', "Usuario {$user->id}");


@section('content')
    <h1>Usuario #{{ $user->id }}</h1>

    <p>Nombre del usuario: {{ $user->name }}</p>
    <p>Correo electrónico: {{ $user->email }}</p>

    <p>
        <!--<a href="{{ url('/usuarios') }}">Regresar</a>-->
        <!--<a href="{{ url()->previous() }}">Regresar</a>-->
        <!--<a href="{{ action('UserController@index') }}">Regresar</a>-->
        <a class="btn btn-primary" href="{{ route('users.edit', ['user' => $user]) }}">Editar usuario</a>
        <a class="btn btn-secondary" href="{{ route('users.index') }}">Regresar al listado de usuarios</a>
    </p>
@endsection