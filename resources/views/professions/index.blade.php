@extends('layout')

@section('title', "Listado de profesiones");

@section('content')

    <h1>{{ $title }}</h1>

    @if(!$professions->isEmpty())
        <table class="table table-bordered table-hover table-striped mt-3">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Título</th>
                <th scope="col">Perfiles</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($professions as $profession)
                <tr>
                    <td>{{ $profession->id }}</td>
                    <td>{{ $profession->title }}</td>
                    <td>{{ $profession->profiles_count }}</td>
                    <td class="buttons"> 
                        @if ($profession->profiles_count == 0)
                            <form class="" action="{{ route('professions.destroy', ['profession' => $profession]) }}" method="POST"> 
                                @method('DELETE')
                                @csrf
                                <button class="deleteBtn" type="submit"><i class="fas fa-trash-alt"></i></button> 
                            </form>
                        @else
                            <form class="" action="{{ route('professions.destroy', ['profession' => $profession]) }}" method="POST"> 
                                @method('DELETE')
                                @csrf
                                <button disabled class="deleteBtnDisabled" type="submit"><i class="fas fa-trash-alt"></i></button> 
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay profesiones registradas</p>
    @endif

@endsection

@section('sidebar')
    @parent
@endsection