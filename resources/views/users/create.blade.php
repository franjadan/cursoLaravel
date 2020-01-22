@extends('layout')

@section('title', "Nuevo usuario");


@section('content')
    <h1>Crear usuario</h1>

    <form method="POST" action="{{ url('usuarios/crear') }}">

        {{ csrf_field() }}

        <input type="submit" class="btn btn-success" value="Crear usuario">
    </form>

    <a href="{{ route('users.index') }}">Regresar al listado de usuarios</a>

@endsection