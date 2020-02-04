@extends('layout')

@section('title', "Nuevo usuario");


@section('content')
    <h1>Crear usuario</h1>

    @include('shared._errors')

    <form method="POST" action="{{ url('usuarios/crear') }}">

        @include('users._fields')

        <input type="submit" class="btn btn-success" value="Crear usuario">
        <a class="btn btn-outline-primary" href="{{ route('users.index') }}">Regresar al listado de usuarios</a>

    </form>

@endsection