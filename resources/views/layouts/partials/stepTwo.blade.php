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
        @if(!empty($_GET['cantidadEstados1_estadosfinales']) && !empty($_GET['cantidadEstados2_estadosfinales']))
            @php
                echo 'Cantidad Estados: '; var_dump($_GET['cantidadEstados1']); 
                echo '<br>Estado Inicial: '; var_dump($_GET['cantidadEstados1_eInicial']);
                echo '<br>Estados Finales: '; var_dump($_GET['cantidadEstados1_estadosfinales']);
                echo '<br>F. Transicion: '; var_dump($_GET['cantidadEstados1_transicion']); 
                echo '<br>Identificadores: '; var_dump($_GET['cantidadEstados1_identificadores']);
            @endphp
            <a style="text-decoration: none;" id="gotomenu" href="{{route('home')}}">
                <button style="margin-top: 2%;" type="button" class="btn btn-success btn-lg btn-block">Ir al menu</button>
            </a>
        @endif
        @endprepend
    </div>
@endisset