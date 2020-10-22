@extends('layouts.plantilla')

@section('title', 'Tarea 02 - Autómatas')

@section('content')

    <h1 class="text-center display-1">Autómatas</h1>
    <p class="text-center lead">Tarea 2 Grafos y Lenguajes Formales</p>    
    <a style="text-decoration: none; display: flex; place-content: center;" href="{{route('automatas')}}">
        <button style="margin-top: 2%; width: 35%; border-radius: 50px;" type="button" class="btn btn-success btn-lg btn-block">IR A AUTÓMATAS</button>
    </a>   

@endsection