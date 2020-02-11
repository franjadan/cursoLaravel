@extends('layout')

@section('title', "Usuario {$user->id}");


@section('content')

    @card
        @slot('header', $user->name )

        @slot('content')

            <h5>ID del usuario: {{ $user->id }}</h5>
            <p><b>Correo electrónico:</b> {{ $user->email }}</p>
        
            @if (isset($user->team_id))
                <p><b>Equipo:</b> {{ $user->team->name }}</p>
            @endif
        
            <p><b>Bio:</b> {{ $user->profile->bio }}</p>
        
            @if (isset($user->profile->twitter))
                <p><b>Twitter:</b> {{ $user->profile->twitter }}</p>
            @endif
        
            @if (isset($user->profile->profession_id))
                    <p><b>Profesión:</b> {{ $user->profile->profession->title }}</p>
            @endif
        
            @if(!$user->skills->isEmpty())
                <p><b>Skills:</b> {{ $user->skills->implode('name', ', ') }}</p>
            @endif
        
            <p><b>Rol:</b> {{ $user->role }}</p>
            <p><b>Fecha de registro:</b> {{ $user->created_at }}</p>
    
        @endslot
    @endcard
    
    <a class="btn btn-outline-primary mt-3" href="{{ route('users.index') }}">Regresar al listado de usuarios</a>

@endsection