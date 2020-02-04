@extends('layout')

@section('title', "Usuario {$user->id}");

@section('content')

        @card
            @slot('header', 'Editar usuario')

            @slot('content')
                @include('shared._errors')

                <form method="POST" action="{{ url("usuarios/{$user->id}") }}">
            
                    {{ method_field('PUT') }}
                    
                    @include('users._fields')
            
                    <input type="submit" class="btn btn-success" value="Guardar cambios">
                    <a class="btn btn-outline-primary" href="{{ route('users.index') }}">Regresar al listado de usuarios</a>
            
                </form>
            @endslot
        @endcard

@endsection