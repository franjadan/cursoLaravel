@extends('layout')

@section('title', "Nuevo usuario");


@section('content')
    <h1>Crear usuario</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h6>Por favor corrige los siguientes debajo:</h6>
            <!--
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            -->
        </div>
    @endif

    <form method="POST" action="{{ url('usuarios/crear') }}">

        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Pedro Perez" value="{{ old('name') }}">
            @if ($errors->has('name'))
                <p class="text-danger">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="pedro@example.com" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <p class="text-danger">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Mayor a 6 caracteres">
            @if ($errors->has('password'))
                <p class="text-danger">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label>¿Es administrador?</label>
            <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" value="true" name="admin">Sí
                </label>
              </div>
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" checked="true" value="false" class="form-check-input" name="admin">No
                </label>
              </div>
            @if ($errors->has('admin'))
                <p class="text-danger">{{ $errors->first('admin') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="professions">Select list:</label>
            <select class="form-control" name="professions" id="professions">
              @foreach ($professions as $profession)
                <option value="{{ $profession->id }}">{{ $profession->title }}</option>
              @endforeach
            </select>
            @if ($errors->has('professions'))
                <p class="text-danger">{{ $errors->first('professions') }}</p>
            @endif
          </div>

        <input type="submit" class="btn btn-success" value="Crear usuario">
    </form>

    <a href="{{ route('users.index') }}">Regresar al listado de usuarios</a>

@endsection