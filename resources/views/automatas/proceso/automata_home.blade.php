@extends('layouts.plantilla')

@section('title', 'Trabajo 2 - Autómatas')

@section('content')

    @php
        $alfabeto = $_GET['alfabetoAutomata'];
        $automataUno = $_GET['automataUno'];
        $automataDos = $_GET['automataDos'];
    @endphp

    {{-- @php
        $alfabeto = base64_decode($_GET['a']);
        $automataUno = base64_decode($_GET['af']);
        $automataDos = base64_decode($_GET['at']);
    @endphp --}}

    {{-- @isset($_GET['alfabetoAutomata'])
        @php $alfabeto = $_GET['alfabetoAutomata']; var_dump($alfabeto); @endphp
    @endisset --}}

    <h1 class="text-center display-1">Autómata {{$automataUno}} {{$automataDos}}</h1>
    {{-- <h1 class="text-center display-1">Autómata AFD AFD</h1> --}}
    <div class="container">
    <form style="margin-top: 5%;" method="GET" action="{{route('automata_home')}}">
        <div class="row">
            <div class="col-sm"> {{-- PRIMERA COLUMNA --}}
                @include('layouts.partials.' . $automataUno, ['alfabeto' => $alfabeto, 'cantEstado' => 'cantidadEstados1'])
            </div>
            <div class="col-sm"> {{-- SEGUNDA COLUMNA --}}
                @include('layouts.partials.' . $automataDos, ['alfabeto' => $alfabeto, 'cantEstado' => 'cantidadEstados2'])
            </div>
        </div>
        
        <button type="button" class="btn btn-info btn-lg btn-block custom-btn" onclick="history.back(-1)">Volver atrás</button>
        <button type="submit" class="btn btn-info btn-lg btn-block custom-btn" onclick="">Confirmar</button>
        {{-- <a style="text-decoration: none;" href="{{route('automata_home') . '?alfabetoAutomata=' . $alfabeto . '&automataUno=' . $automataUno . '&automataDos=' . $automataDos . '&cantidadEstados1' . $_GET['cantidadEstados1'] . '&cantidadEstados2' . $_GET['cantidadEstados2']}}">
            <button style="margin-top: 2%;" type="button" class="btn btn-info btn-lg btn-block custom-btn">Confirmar</button>
        </a> --}}
    </form>

@endsection