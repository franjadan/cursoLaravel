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

    <a class="btn btn-outline-primary" href="{{ route('users.index') }}">Regresar al listado de usuarios</a>

@endsection