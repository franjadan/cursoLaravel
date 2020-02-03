@extends('layout')

@section('title', "Listado de usuarios");

@section('content')

    <h1>{{ $title }}</h1>

    <a href="{{ route('users.create') }}" class="btn btn-primary mt-2">Nuevo usuario</a>

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
                    <td>{{ $user->name }} @if ($user->is_admin == 1) (Admin) @endif</td>
                    <td>{{ $user->email }}</td>
                    <td class="buttons">
                        <a class="showBtn" href="{{ route('users.show', ['user' => $user]) }}"><i class="fas fa-eye"></i></a>
                        <a class="editBtn" href="{{ route('users.edit', ['user' => $user]) }}"><i class="fas fa-edit"></i></a>
                        <form class="" action="{{ route('users.destroy', ['user' => $user]) }}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="deleteBtn" type="submit"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay usuarios registrados</p>
    @endif

@endsection

@section('sidebar')
    @parent
@endsection