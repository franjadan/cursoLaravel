@extends('layout')

@section('title', "Listado de usuarios");

@section('content')

    <h1>{{ $title }}</h1>

    @if ($route == 'Listado')
        <a href="{{ route('users.create') }}" class="btn btn-primary mt-2">Nuevo usuario</a>
        <a href="{{ route('users.trashed') }}" class="btn btn-danger mt-2">Ver papelera</a>
    @endif

    <!-- @includeWhen(isset($states), 'users._filters') -->
    @include('users._filters')

    @if(!$users->isEmpty())

        <p>Viendo página {{ $users->currentPage() }} de {{ $users->lastPage() }}</p>

        <table class="table table-bordered table-hover table-striped mt-3">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Registro</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>
                @each('users._row', $users, 'user')
            </tbody>
        </table>

        {{ $users->appends(request(['team','search', 'state', 'role', 'skills', 'date_start', 'date_end']))->links() }}
        
    @else
        <p class="mt-3">No hay usuarios</p>
    @endif

    @if ($route == 'Papelera')
            <a class="btn btn-outline-primary" href="{{ route('users.index') }}">Regresar al listado de usuarios</a>
    @endif

@endsection

@section('sidebar')
    @parent
@endsection