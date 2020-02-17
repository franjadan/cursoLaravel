@extends('layout')

@if ($view == 'index')
    @section('title', "Listado de usuarios");
@else
    @section('title', "Papelera de usuarios");
@endif

@section('content')

    <h1>{{ $title }}</h1>

    @if ($view == 'index')
        <a href="{{ route('users.create') }}" class="btn btn-primary mt-2">Nuevo usuario</a>
        <a href="{{ route('users.trashed') }}" class="btn btn-danger mt-2">Ver papelera</a>
    @endif

    @includeWhen($view == 'index', 'users._filters')

    @if(!$users->isEmpty())

        <p>Viendo página {{ $users->currentPage() }} de {{ $users->lastPage() }}</p>

        <table class="table table-bordered table-hover table-striped mt-3">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col"><a href="{{ $sortable->url('first_name') }}" class="{{ $sortable->classes('first_name') }}">Nombre <i class="icon-sort"></i></a></th>
                <th scope="col"><a href="{{ $sortable->url('email') }}" class="{{ $sortable->classes('email') }}">Correo <i class="icon-sort"></i></a></th>
                <th scope="col"><a href="{{ $sortable->url('date') }}" class="{{ $sortable->classes('date') }}">Registrado el <i class="icon-sort"></i></a></th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>
                @each('users._row', $users, 'user')
            </tbody>
        </table>

        {{ $users->links() }}
        
    @else
        <p class="mt-3">No hay usuarios</p>
    @endif

    @if ($view == 'trashed')
            <a class="btn btn-outline-primary" href="{{ route('users.index') }}">Regresar al listado de usuarios</a>
    @endif

@endsection

@section('sidebar')
    @parent
@endsection