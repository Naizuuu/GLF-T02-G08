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

    /* echo '<br>Estado Inicial 1: '; var_dump($estadoInicial1);
    echo '<br>Estados Finales 1: '; var_dump($estadosFinales1);
    echo '<br>F. Transicion 1: '; var_dump($fTrans1); 
    echo '<br>Identificadores 1: '; var_dump($identificadores1);
    echo '<br>Alfabeto: '; var_dump($alfabeto);
    echo '<br>Tipo 1: '; var_dump($automataUno);
    echo '<br><br>';
    echo '<br>Estado Inicial 2: '; var_dump($estadoInicial2);
    echo '<br>Estados Finales 2: '; var_dump($estadosFinales2);
    echo '<br>F. Transicion 2: '; var_dump($fTrans2); 
    echo '<br>Identificadores 2: '; var_dump($identificadores2);
    echo '<br>Alfabeto: '; var_dump($alfabeto);
    echo '<br>Tipo 2: '; var_dump($automataDos); */

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
    {{-- @if($automataUno == "AFD" && $automataDos == "AFND") --}}
    @php
        $automata1S = $automata1;
        $automata2S = $automata2;
        if($automataUno == 'AFND') {
            $automata1S = $automata1S->transformarAFNDaAFD($automata1S);
        }
        if($automataDos == 'AFND') {
            $automata2S = $automata2S->transformarAFNDaAFD($automata2S);
        }
        $automata1S->simplificacion();
        var_dump($automata1S);
        $automata2S->simplificacion();
    @endphp

    <div class="row">
        <div class="col-sm">
            <h2 class="text-center">{{$automataUno}}</h1>
            <p>En base a los datos ingresados por usted, el diseño de su autómata {{$automataUno}} es el siguiente:</p>
            <img src="{{$automata1S->$dibujoUno()}}" alt="Automata {{$automataUno}}">
        </div>
        <div class="col-sm">
            <h2 class="text-center">{{$automataDos}}</h1>
            <p>En base a los datos ingresados por usted, el diseño de su autómata {{$automataDos}} es el siguiente:</p>
            <img src="{{$automata2S->$dibujoDos()}}" alt="Automata {{$automataDos}}">
        </div>
    </div>

    {{-- @elseif($automataUno == "AFD" && $automataDos == "AFD")
    @php
    $automata1S = $automata1;
    $automata1S->simplificacion();
    //$automata1S->dibujarAFD();
    $automata2S = $automata2;
    $automata2S->simplificacion();
    //$automata2S->dibujarAFD();
    @endphp
    <div class="row">
        <div class="col-sm">
            <h2 class="text-center">{{$automataUno}}</h1>
            <p>En base a los datos ingresados por usted, el diseño de su autómata {{$automataUno}} es el siguiente:</p>
            <img src="{{$automata1S->$dibujoUno()}}" alt="Automata {{$automataUno}}">
        </div>
        <div class="col-sm">
            <h2 class="text-center">{{$automataDos}}</h1>
            <p>En base a los datos ingresados por usted, el diseño de su autómata {{$automataDos}} es el siguiente:</p>
            <img src="{{$automata2S->$dibujoDos()}}" alt="Automata {{$automataDos}}">
        </div>
    </div>
    @elseif($automataUno == "AFND" && $automataDos == "AFD")
    @php
    $automata1S = $automata1;
    $automata1S = $automata1S->transformarAFNDaAFD($automata1S);
    $automata1S->simplificacion();
    //$automata1S->dibujarAFND();
    $automata2S = $automata2;
    $automata2S->simplificacion();
    //$automata2S->dibujarAFD();
    @endphp
    <div class="row">
        <div class="col-sm">
            <h2 class="text-center">{{$automataUno}}</h1>
            <p>En base a los datos ingresados por usted, el diseño de su autómata {{$automataUno}} es el siguiente:</p>
            <img src="{{$automata1S->$dibujoUno()}}" alt="Automata {{$automataUno}}">
        </div>
        <div class="col-sm">
            <h2 class="text-center">{{$automataDos}}</h1>
            <p>En base a los datos ingresados por usted, el diseño de su autómata {{$automataDos}} es el siguiente:</p>
            <img src="{{$automata2S->$dibujoDos()}}" alt="Automata {{$automataDos}}">
        </div>
    </div>
    @elseif($automataUno == "AFND" && $automataDos == "AFND")
    @php
    $automata1S = $automata1;
    $automata1S = $automata1S->transformarAFNDaAFD($automata1S);
    $automata1S->simplificacion();
    //$automata1S->dibujarAFND();
    $automata2S = $automata2;
    $automata2S = $automata2S->transformarAFNDaAFD($automata2S);
    $automata2S->simplificacion();
    //$automata2S->dibujarAFND();
    @endphp
    <div class="row">
        <div class="col-sm">
            <h2 class="text-center">{{$automataUno}}</h1>
            <p>En base a los datos ingresados por usted, el diseño de su autómata {{$automataUno}} es el siguiente:</p>
            <img src="{{$automata1S->$dibujoUno()}}" alt="Automata {{$automataUno}}">
        </div>
        <div class="col-sm">
            <h2 class="text-center">{{$automataDos}}</h1>
            <p>En base a los datos ingresados por usted, el diseño de su autómata {{$automataDos}} es el siguiente:</p>
            <img src="{{$automata2S->$dibujoDos()}}" alt="Automata {{$automataDos}}">
        </div>
    </div>
    @endif --}}

    {{-- simplificacion(si es afnd se convierte a AFD y se simplifica--}}
        {{-- complemento (si uno es afnd se convierte a afd y se realiza el complemento y simplificar--}}
        {{-- Union afd y simplificar--}}
        {{-- Concatenacion afd y simplificar --}}
        {{-- interseccion  simplificar--}}
</div>
<div class="procesoTres" style="display: none;">
    <h2 style="margin-bottom: 2%;" class="text-center display-4">Complemento</h2>
    {{-- @if($automataUno == "AFD" && $automataDos == "AFND")
    @php
    $automata1CP = $automata1;
    $automata1CP->complemento();
    $automata1CP->dibujarAFD();
    $automata1CP->simplificacion();
    $automata1CP->dibujarAFD();
    $automata2CP = $automata2;
    $automata2CP = $automata2CP->transformarAFNDaAFD($automata2CP);
    $automata2CP->complemento();
    $automata2CP->dibujarAFD();
    $automata2CP->simplificacion();
    $automata2CP->dibujarAFD();
    @endphp
    @elseif($automataUno == "AFD" && $automataDos == "AFD")
    @php
    $automata1CP = $automata1;
    $automata1CP->complemento();
    $automata1CP->dibujarAFD();
    $automata1CP->simplificacion();
    $automata1CP->dibujarAFD();
    $automata2CP = $automata2;
    $automata2CP->complemento();
    $automata2CP->dibujarAFD();
    $automata2CP->simplificacion();
    $automata2CP->dibujarAFD();
    @endphp
    @elseif($automataUno == "AFND" && $automataDos == "AFD")
    @php
    $automata1CP = $automata1;
    $automata1CP = $automata1CP->transformarAFNDaAFD($automata1CP);
    $automata1CP->complemento();
    $automata1CP->dibujarAFD();
    $automata1CP->simplificacion();
    $automata1CP->dibujarAFD();
    $automata2CP = $automata2;
    $automata2CP->complemento();
    $automata2CP->dibujarAFD(); 
    $automata2CP->simplificacion();
    $automata2CP->dibujarAFD();
    @endphp
    @elseif($automataUno == "AFND" && $automataDos == "AFND")
    @php
    $automata1CP = $automata1;
    $automata1CP = $automata1CP->transformarAFNDaAFD($automata1CP);
    $automata1CP->complemento();
    $automata1CP->dibujarAFD();
    $automata1CP->simplificacion();
    $automata1CP->dibujarAFD();
    $automata2CP = $automata2;
    $automata2CP = $automata2CP->transformarAFNDaAFD($automata2CP);
    $automata2CP->complemento();
    $automata2CP->dibujarAFD();
    $automata2CP->simplificacion();
    $automata2CP->dibujarAFD();
    @endphp
    @endif --}}
</div>

<div class="procesoCuatro" style="display: none;">
    <h2 style="margin-bottom: 2%;" class="text-center display-4">Unión</h2>
    {{-- @php
        $automataU = new AFND();
        $automataU = $automataU->union($automata1, $automata2);
        $automataU->dibujarAFND();
        $automataU = $automataU->transformarAFNDaAFD($automataU);
        $automataU->simplificacion();
        $automataU->dibujarAFD();         
    @endphp --}}
</div>

<div class="procesoCinco" style="display: none;">
    <h2 style="margin-bottom: 2%;" class="text-center display-4">Concatenación</h2>
    {{-- @php
        $automataCT = new AFND();
        $automataCT = $automataCT->concatenacion($automata1, $automata2);
        $automataCT->dibujarAFND();
        $automataCT = $automataCT->transformarAFNDaAFD($automataCT);
        $automataCT->simplificacion();     
        $automataCT->dibujarAFD();    
    @endphp --}}
</div>

<div class="procesoSeis" style="display: none;">
    <h2 style="margin-bottom: 2%;" class="text-center display-4">Intersección</h2>
    {{-- @php
        $automataI = new AFND();
        $automataI = $automataI->interseccion($automata1, $automata2);
        $automataI->dibujarAFND();
        $automataI->simplificacion();
        $automataI->dibujarAFD();
    @endphp --}}
</div>



{{-- NAV PULENTO --}}
<nav aria-label="..." style="display: inline-block; text-shadow: none; margin-top: 3%;">
    <ul class="pagination pagination-lg">
        {{-- <li class="page-item"><span class="page-link" href="#" id="TEST1" onclick="myFunction();">1</span></li>
        <li class="page-item"><span class="page-link" href="#" id="TEST2" onclick="myFunction();">2</span></li>
        <li class="page-item"><span class="page-link" href="#" id="TEST3" onclick="">3</span></li>
        <li class="page-item"><span class="page-link" href="#" id="TEST4" onclick="">4</span></li>
        <li class="page-item"><span class="page-link" href="#" id="TEST5" onclick="">5</span></li>
        <li class="page-item"><span class="page-link" href="#" id="TEST6" onclick="">6</span></li> --}}
        <li class="page-item"><button type="button" class="page-link" id="navUno" onclick="">Resultado Inicio</button></li>
        <li class="page-item"><button type="button" class="page-link" id="navDos" onclick="">Simplificación</button></li>
        <li class="page-item"><button type="button" class="page-link" id="navTres" onclick="">Complemento</button></li>
        <li class="page-item"><button type="button" class="page-link" id="navCuatro" onclick="">Unión</button></li>
        <li class="page-item"><button type="button" class="page-link" id="navCinco" onclick="">Concatenación</button></li>
        <li class="page-item"><button type="button" class="page-link" id="navSeis" onclick="">Intersección</button></li>
    </ul>
</nav>

@endsection