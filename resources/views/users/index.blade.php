@extends('layout')

@section('title', "Listado de usuarios");

@section('content')

    <h1>{{ $title }}</h1>

    @if ($route == 'Listado')
        <a href="{{ route('users.create') }}" class="btn btn-primary mt-2">Nuevo usuario</a>
        <a href="{{ route('users.trashed') }}" class="btn btn-danger mt-2">Ver papelera</a>
    @endif

    @if(!$users->isEmpty())
        <table class="table table-bordered table-hover table-striped mt-3">
            <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }} @if ($user->isAdmin()) (Admin) @endif</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->trashed())
                            <div class="buttons">
                                <form class="" action="{{ route('users.restore', $user) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success" type="submit"><i class="fas fa-trash-restore"></i></button>
                                </form>
                                <form class="" action="{{ route('users.destroy', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit"><i class="fas fa-times-circle"></i></button>
                                </form>
                            </div>
                        @else
                            <form class="" action="{{ route('users.trash', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <a class="btn btn-primary" href="{{ route('users.show', ['user' => $user]) }}"><i class="fas fa-eye"></i></a>
                                <a class="btn btn-primary" href="{{ route('users.edit', ['user' => $user]) }}"><i class="fas fa-edit"></i></a>
                                <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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