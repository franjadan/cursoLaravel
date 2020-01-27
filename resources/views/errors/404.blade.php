@extends('layout')

@section('title', "Página no encontrada");


@section('content')
    <h1>Página no encontrada</h1>
    <a class="btn btn-secondary" href="{{ url('/') }}">Regresar al inicio</a>

@endsection