@extends('layout')

@section('title', "Usuario {$id}");


@section('content')
    <h1>Usuario #{{ $id }}</h1>
    <p>Editando al usuario {{ $id }}</p>
@endsection