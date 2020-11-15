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
    </div>
@endisset