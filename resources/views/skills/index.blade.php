@extends('layout')

@section('title', "Listado de habilidades");

@section('content')

    <h1>{{ $title }}</h1>

    @if(!$skills->isEmpty())
        <table class="table table-bordered table-hover table-striped mt-3">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($skills as $skill)
                <tr>
                    <td>{{ $skill->id }}</td>
                    <td>{{ $skill->name }}</td>
                    <td class="buttons"> 
                        <form class="" action="{{ route('skills.destroy', ['skill' => $skill]) }}" method="POST"> 
                            @method('DELETE')
                            @csrf
                            <button class="deleteBtn" type="submit"><i class="fas fa-trash-alt"></i></button> 
                        </form> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay habilidades registradas</p>
    @endif

@endsection

@section('sidebar')
    @parent
@endsection