@extends('layout')

@section('title', "Usuario {$user->id}");


@section('content')
    <h1>Usuario #{{ $user->id }}</h1>

    <p>Nombre del usuario: {{ $user->name }}</p>
    <p>Correo electrónico: {{ $user->email }}</p>
    
    @if (isset($user->profile))
        @if (isset($user->profile->profession_id))
            <p>Profesión: {{ $user->profile->profession->title }}</p>
        @endif
        <p>Bio: {{ $user->profile->bio }}</p>
        @if (isset($user->profile->twitter))
            <p>Twitter: {{ $user->profile->twitter }}</p>
        @endif
    @endif

    <p>Es administrador?: @if ($user->is_admin) Sí @else No @endif</p>
    @if (isset($user->profession))
        <p>Profesión: {{ $user->profession->title }}</p>
    @endif

    <div class="buttons">
        <!--<a href="{{ url('/usuarios') }}">Regresar</a>-->
        <!--<a href="{{ url()->previous() }}">Regresar</a>-->
        <!--<a href="{{ action('UserController@index') }}">Regresar</a>-->
        <a class="btn btn-primary" href="{{ route('users.edit', ['user' => $user]) }}">Editar usuario</a>
        <form class="" action="{{ route('users.destroy', ['user' => $user]) }}" method="POST">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <input class="btn btn-danger" type="submit" value="Eliminar usuario">
        </form>
        <a class="btn btn-secondary" href="{{ route('users.index') }}">Regresar al listado de usuarios</a>
    </div>
@endsection