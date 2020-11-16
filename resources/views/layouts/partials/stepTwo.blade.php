@php
    $alfabeto = '';
    $automataUno = 'afd';
    $automataDos = 'afd';
@endphp

@isset($_GET['alfabetoAutomata'])
    @php
        $alfabeto = $_GET['alfabetoAutomata'];
        $automataUno = $_GET['automataUno'];
        $automataDos = $_GET['automataDos'];
        $transicionA = '';
        $transicionB = '';
    @endphp

    <h1 class="text-center display-1">Autómata</h1>
    <div class="container">
        <div class="row">
            <div class="col-sm"> {{-- PRIMERA COLUMNA --}}
                <h1 class="text-center display-3">{{$automataUno}}</h1>
                @include('layouts.partials.' . $automataUno, ['alfabeto' => $alfabeto, 'transicion' => $transicionA, 'iden' => 'p', 'cantEstado' => 'cantidadEstados1'])
            </div>
            <div class="col-sm"> {{-- SEGUNDA COLUMNA --}}
                <h1 class="text-center display-3">{{$automataDos}}</h1>
                @include('layouts.partials.' . $automataDos, ['alfabeto' => $alfabeto, 'transicion' => $transicionB, 'iden' => 'q', 'cantEstado' => 'cantidadEstados2'])
            </div>
        </div>
        @prepend('menu')

        @if(isset($_GET['cantidadEstados1_identificadores']) && isset($_GET['cantidadEstados2_identificadores']))
            @php

                $alfabeto = $_GET['alfabetoAutomata'];
                /* automata 1 */
                $identificadores1 = $_GET['cantidadEstados1_identificadores'];
                $estadoInicial1 = $_GET['cantidadEstados1_eInicial'];
                $estadosFinales1 = $_GET['cantidadEstados1_estadosfinales'];
                $fTrans1 = $_GET['cantidadEstados1_transicion'];
                /* automata 2 */
                $identificadores2 = $_GET['cantidadEstados2_identificadores'];
                $estadoInicial2 = $_GET['cantidadEstados2_eInicial'];
                $estadosFinales2 = $_GET['cantidadEstados2_estadosfinales'];
                $fTrans2 = $_GET['cantidadEstados2_transicion'];

            @endphp
            <a style="text-decoration: none;" id="gotomenu" href="{{route('automata_home') . '?a=' . base64_encode($alfabeto) . '&i1=' . base64_encode($identificadores1) . '&i2=' . base64_encode($identificadores2) . '&ei1=' . base64_encode($estadoInicial1) . '&ei2=' . base64_encode($estadoInicial2) . '&ef1=' . base64_encode($estadosFinales1) . '&ef2=' . base64_encode($estadosFinales2) . '&f1=' . base64_encode($fTrans1) . '&f2=' . base64_encode($fTrans2) . '&au1=' . base64_encode($automataUno) . '&au2=' . base64_encode($automataDos)}}">
                <button style="margin-top: 2%;" type="button" class="btn btn-success btn-lg btn-block">Ir al menu</button>
            </a>
        @endif
        @endprepend
    </div>
@endisset