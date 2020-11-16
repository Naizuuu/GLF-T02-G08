@extends('layouts.plantilla')

@include('automatas/clase-automata')

@section('title', 'Trabajo 2 - Autómatas')

@section('content')

@php
    $alfabeto = base64_decode($_GET['a']);
    $identificadores1 = base64_decode($_GET['i1']);
    $estadoInicial1 = base64_decode($_GET['ei1']);
    $estadosFinales1 = base64_decode($_GET['ef1']);
    $fTrans1 = base64_decode($_GET['f1']);
    $automataUno = base64_decode($_GET['au1']);
    /* automata 2 */
    $identificadores2 = base64_decode($_GET['i2']);
    $estadoInicial2 = base64_decode($_GET['ei2']);
    $estadosFinales2 = base64_decode($_GET['ef2']);
    $fTrans2 = base64_decode($_GET['f2']);
    $automataDos = base64_decode($_GET['au2']);

    if($automataUno == "AFD" && $automataDos == "AFND") {
        $automata1 = new AFD();
        $automata1->crearAFD($identificadores1, $alfabeto, $estadoInicial1, $estadosFinales1);
        $automata1->llenarFuncionDeTransicion($fTrans1);
        $automata2 = new AFND();
        $automata2->crearAFND($identificadores2, $alfabeto, $estadoInicial2, $estadosFinales2);
        $automata2->llenarRelacionDeTransicion($fTrans2);
    }
    else {
        if($automataUno == "AFD" && $automataDos == "AFD") {
            $automata1 = new AFD();
            $automata1->crearAFD($identificadores1, $alfabeto, $estadoInicial1, $estadosFinales1);
            $automata1->llenarFuncionDeTransicion($fTrans1);
            $automata2 = new AFD();
            $automata2->crearAFD($identificadores2, $alfabeto, $estadoInicial2, $estadosFinales2);
            $automata2->llenarFuncionDeTransicion($fTrans2);
        }
        else {
            if($automataUno == "AFND" && $automataDos == "AFD") {
                $automata1 = new AFND();
                $automata1->crearAFND($identificadores1, $alfabeto, $estadoInicial1, $estadosFinales1);
                $automata1->llenarRelacionDeTransicion($fTrans1);
                $automata2 = new AFD();
                $automata2->crearAFD($identificadores2, $alfabeto, $estadoInicial2, $estadosFinales2);
                $automata2->llenarFuncionDeTransicion($fTrans2);
            }
            else {
                if($automataUno == "AFND" && $automataDos == "AFND") {
                    $automata1 = new AFND();
                    $automata1->crearAFND($identificadores1, $alfabeto, $estadoInicial1, $estadosFinales1);
                    $automata1->llenarRelacionDeTransicion($fTrans1);
                    $automata2 = new AFND();
                    $automata2->crearAFND($identificadores2, $alfabeto, $estadoInicial2, $estadosFinales2);
                    $automata2->llenarRelacionDeTransicion($fTrans2);
                }
            }
        }
    }

    $dibujoUno = 'dibujar' . $automataUno;
    $dibujoDos = 'dibujar' . $automataDos;

@endphp
<h1 style="margin-bottom: 2%;" class="text-center display-2">Resultado Autómatas</h1>
<div class="procesoUno" style="display: none;">
    <h2 style="margin-bottom: 2%;" class="text-center display-4">Inicio</h2>
    <div class="row">
        <div class="col-sm">
            <h2 class="text-center">{{$automataUno}}</h1>
            <p>En base a los datos ingresados por usted, el diseño de su autómata {{$automataUno}} es el siguiente:</p>
            <img src="{{$automata1->$dibujoUno()}}" alt="Automata {{$automataUno}}">
        </div>
        <div class="col-sm">
            <h2 class="text-center">{{$automataDos}}</h1>
            <p>En base a los datos ingresados por usted, el diseño de su autómata {{$automataDos}} es el siguiente:</p>
            <img src="{{$automata2->$dibujoDos()}}" alt="Automata {{$automataDos}}">
        </div>
    </div>
</div>

<div class="procesoDos" style="display: none;">
    <h2 style="margin-bottom: 2%;" class="text-center display-4">Simplificación</h2>
    @php
        $automata1S = clone $automata1;
        $automata2S = clone $automata2;
        $dibujoUnoS = $dibujoUno;
        $dibujoDosS = $dibujoDos;
        if($automataUno == 'AFND') {
            $automata1S = $automata1S->transformarAFNDaAFD($automata1S);
            $dibujoUnoS = 'dibujarAFD';
        }
        if($automataDos == 'AFND') {
            $automata2S = $automata2S->transformarAFNDaAFD($automata2S);
            $dibujoDosS = 'dibujarAFD';
        }
        $automata1S->simplificacion();
        $automata2S->simplificacion();
    @endphp

    <div class="row">
        <div class="col-sm">
            <h2 class="text-center">{{$automataUno}}</h1>
            <p>En base a los datos ingresados por usted, el diseño de su autómata {{$automataUno}} es el siguiente:</p>
            <img src="{{$automata1S->$dibujoUnoS()}}" alt="Automata {{$automataUno}} Simplificado">
        </div>
        <div class="col-sm">
            <h2 class="text-center">{{$automataDos}}</h1>
            <p>En base a los datos ingresados por usted, el diseño de su autómata {{$automataDos}} es el siguiente:</p>
            <img src="{{$automata2S->$dibujoDosS()}}" alt="Automata {{$automataUno}} Simplificado">
        </div>
    </div>
</div>
<div class="procesoTres" style="display: none;">
    <h2 style="margin-bottom: 2%;" class="text-center display-4">Complemento</h2>
    @php
        $automata1CP = clone $automata1;
        $automata2CP = clone $automata2;
        $dibujoUnoCP = $dibujoUno;
        $dibujoDosCP = $dibujoDos;
        if($automataUno == 'AFND') {
            $automata1CP = $automata1CP->transformarAFNDaAFD($automata1CP);
            $dibujoUnoCP = 'dibujarAFD';
        }
        if($automataDos == 'AFND') {
            $automata2CP = $automata2CP->transformarAFNDaAFD($automata2CP);
            $dibujoDosCP = 'dibujarAFD';
        }
    @endphp
    <div class="row">
        <div class="col-sm">
            <h2 class="text-center">Complemento {{$automataUno}}</h1>
            @php $automata1CP->complemento(); @endphp
            <img src="{{$automata1CP->$dibujoUnoCP()}}" alt="Complemento Automata {{$automataUno}}">
        </div>
        <div class="col-sm">
            <h2 class="text-center"> Complemento {{$automataDos}}</h1>
            @php $automata2CP->complemento(); @endphp
            <img src="{{$automata2CP->$dibujoDosCP()}}" alt="Complemento Automata {{$automataUno}}">
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <h2 class="text-center">Simplificación del Complemento {{$automataUno}}</h1>
            @php $automata1CP->simplificacion(); @endphp
            <img src="{{$automata1CP->$dibujoUnoCP()}}" alt="Simplificación del Complemento">
        </div>
        <div class="col-sm">
            <h2 class="text-center">Simplificación del Complemento {{$automataDos}}</h1>
            @php $automata2CP->simplificacion(); @endphp
            <img src="{{$automata2CP->$dibujoDosCP()}}" alt="Simplificación del Complemento">
        </div>
    </div>
</div>

<div class="procesoCuatro" style="display: none;">
    <h2 style="margin-bottom: 2%;" class="text-center display-4">Unión</h2>
    @php
        $automataU = new AFND();
        $automataU = $automataU->union($automata1, $automata2);
        $dibujoUnoU = 'dibujarAFND';
        var_dump($automataU->$dibujoUnoU());
    @endphp

    <div class="row">
        <div class="col-sm">
        <h2 class="text-center">Unión {{$automataUno}} & {{$automataDos}}</h1>
            <img src="{{$automataU->$dibujoUnoU()}}" alt="Automata Unión {{$automataUno}} y {{$automataDos}}">
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-sm">
            <h2 class="text-center">Simplificación de la Unión</h1>
            @php 
                $automataU = $automataU->transformarAFNDaAFD($automataU); 
                $automataU->simplificacion();
                $dibujoUnoU = 'dibujarAFD';
            @endphp
            <img src="{{$automataU->$dibujoUnoU()}}" alt="Simplificación de la Unión">
        </div>
    </div> --}}

</div>

<div class="procesoCinco" style="display: none;">
    <h2 style="margin-bottom: 2%;" class="text-center display-4">Concatenación</h2>
    @php
        $automataCT = new AFND();
        $automataCT = $automataCT->concatenacion($automata1, $automata2);
        $dibujoUnoCT = 'dibujarAFND';
    @endphp    
    <div class="row">
        <div class="col-sm">
            <h2 class="text-center">Concatenación {{$automataUno}} & {{$automataDos}}</h1>
            <img src="{{$automataCT->$dibujoUnoCT()}}" alt="Concatenación {{$automataUno}} & {{$automataDos}}">
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <h2 class="text-center">Simplificación de la Concatenación</h1>
            @php 
                $automataCT = $automataCT->transformarAFNDaAFD($automataCT); 
                $automataCT->simplificacion();
                $dibujoUnoCT = 'dibujarAFD';
            @endphp
            <img src="{{$automataCT->$dibujoUnoCT()}}" alt="Simplificación de la Concatenación">
        </div>
    </div>
</div>

<div class="procesoSeis" style="display: none;">
    <h2 style="margin-bottom: 2%;" class="text-center display-4">Intersección</h2>
    {{-- @php
        $automataI = new AFND();
        $automataI = $automataI->interseccion($automata1, $automata2);
        $dibujoUnoI = 'dibujarAFND';
    @endphp    
    <div class="row">
        <div class="col-sm">
            <h2 class="text-center">Intersección {{$automataUno}} & {{$automataDos}}</h1>
            <img src="{{$automataI->$dibujoUnoI()}}" alt="Intersección {{$automataUno}} & {{$automataDos}}">
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <h2 class="text-center">Simplificación de la Intersección</h1>
            @php 
                $automataI = $automataI->transformarAFNDaAFD($automataI); 
                $automataI->simplificacion();
                $dibujoUnoI = 'dibujarAFD';
            @endphp
            <img src="{{$automataI->$dibujoUnoI()}}" alt="Simplificación de la Intersección">
        </div>
    </div> --}}
</div>

<nav aria-label="..." style="display: inline-block; text-shadow: none; margin-top: 3%;">
    <ul class="pagination pagination-lg">
        <li class="page-item"><button type="button" class="page-link" id="navUno" onclick="">Resultado Inicio</button></li>
        <li class="page-item"><button type="button" class="page-link" id="navDos" onclick="">Simplificación</button></li>
        <li class="page-item"><button type="button" class="page-link" id="navTres" onclick="">Complemento</button></li>
        <li class="page-item"><button type="button" class="page-link" id="navCuatro" onclick="">Unión</button></li>
        <li class="page-item"><button type="button" class="page-link" id="navCinco" onclick="">Concatenación</button></li>
        <li class="page-item"><button type="button" class="page-link" id="navSeis" onclick="">Intersección</button></li>
    </ul>
</nav>

@endsection