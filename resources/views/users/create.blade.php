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
            <label for="bio">Bio</label>
            <textarea class="form-control" rows="5" name="bio" id="bio">{{ old('bio') }}</textarea>
            @if ($errors->has('bio'))
                <p class="text-danger">{{ $errors->first('bio') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="twitter">Twitter</label>
            <input type="text" class="form-control" id="twitter" name="twitter" placeholder="https://twitter.com/pedrop" value="{{ old('twitter') }}">
            @if ($errors->has('password'))
                <p class="text-danger">{{ $errors->first('twitter') }}</p>
            @endif
        </div>

        <div class="form-group">
            <p>Habilidades</p>

            @foreach($skills as $skill)
                <div class="form-check form-check-inline">
                    <input name="skills[{{ $skill->id }}]" class="form-check-input" type="checkbox" id="skill_{{ $skill->id }}" value="{{ $skill->id }}" {{ old("skills.{$skill->id}") ? 'checked' : '' }}>
                    <label class="form-check-label" for="skill_{{ $skill->id }}">{{ $skill->name }}</label>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label for="profession_id">Profesión:</label>
            <select class="form-control" name="profession_id" id="profession_id">
                <option value="">Seleciona una profesión</option>
              @foreach ($professions as $profession)
                <option {{ $profession->id == old('profession_id') ? 'selected' : '' }} value="{{ $profession->id }}">{{ $profession->title }}</option>
              @endforeach
            </select>
            @if ($errors->has('profession_id'))
                <p class="text-danger">{{ $errors->first('profession_id') }}</p>
            @endif
          </div>

          <div class="form-group">
            <label>Rol</label>
            @foreach($roles as $role => $name)
                <div class="form-check">
                    <label class="form-check-label">
                    <input type="radio" {{ old('role') == $role ? 'checked' : '' }} class="form-check-input" value="{{ $role }}" id="role_{{ $role }}" name="role"> {{ $name }}
                    </label>
                </div>
            @endforeach
            @if ($errors->has('role'))
                <p class="text-danger">{{ $errors->first('role') }}</p>
            @endif
        </div>

        <input type="submit" class="btn btn-success" value="Crear usuario">
        <a class="btn btn-outline-primary" href="{{ route('users.index') }}">Regresar al listado de usuarios</a>

    </form>

@endsection