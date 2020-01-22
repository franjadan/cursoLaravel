@extends('layout')

@section('title', "Nuevo usuario");


@section('content')
    <h1>Crear usuario</h1>

    <form method="POST" action="{{ url('usuarios/crear') }}">

        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
        </div>

        <input type="submit" class="btn btn-success" value="Crear usuario">
    </form>

    <a href="{{ route('users.index') }}">Regresar al listado de usuarios</a>

@endsection