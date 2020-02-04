@extends('layout')

@section('title', "Usuario {$user->id}");


@section('content')
    <h1>Editar usuario</h1>

    @include('shared._errors')

    <form method="POST" action="{{ url("usuarios/{$user->id}") }}">

        {{ method_field('PUT') }}
        
        @include('users._fields')

        <input type="submit" class="btn btn-success" value="Guardar cambios">
        <a class="btn btn-outline-primary" href="{{ route('users.index') }}">Regresar al listado de usuarios</a>

    </form>


@endsection