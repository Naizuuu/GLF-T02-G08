@php
    $alfabetoArray = explode(",", $alfabeto);
@endphp


<div class="row">
    <div class="col-sm"> 
        <div class="form-group">  {{-- ESTADOS --}}
            <label for="{{$cantEstado}}">Cantidad de Estados</label>
        <input type="number" class="form-control" name="{{$cantEstado}}" title="Debe ingresar la cantidad de estados del autómata." placeholder="Ingrese la cantidad de estados." min="1" autocomplete="off" value="<?php echo htmlspecialchars($_GET[$cantEstado] ?? '', ENT_QUOTES); ?>" required>
        </div>
    </div>
</div>

@php $cant_estados = 0; @endphp

@isset($_GET[$cantEstado])
    @php
        $cant_estados = (int)$_GET[$cantEstado];
    @endphp
@endisset

<div class="row">
    <div class="col-sm"> 
        <div class="form-group">  {{-- TRANSICIONES --}}
        <label for="cantTrans_{{$cantEstado}}">Cantidad de Transiciones</label>
        <input type="number" class="form-control" name="cantTrans_{{$cantEstado}}" title="Debe ingresar la cantidad de transiciones del autómata." placeholder="Ingrese la cantidad de transiciones." min="1" autocomplete="off" value="<?php echo htmlspecialchars($_GET['cantTrans_' . $cantEstado] ?? '', ENT_QUOTES); ?>" required>
        </div>
    </div>
</div>

@php $cant_trans = 0; $verificacion = true;  $nextStep = false; @endphp

@isset($_GET['cantTrans_' . $cantEstado])
    @php
        $cant_trans = (int)$_GET['cantTrans_' . $cantEstado];
        $auxMax = $cant_trans;
        $aux = 0;
    @endphp
@endisset

@for($i = 0; $i < $cant_trans; $i++)
    @if($i == 0) <label style="margin-bottom: 2%;">Seleccione las transiciones</label> @endif
    <div class="row" style="margin-top: 0%;">
        <div class="col-sm-auto">  {{-- PRIMERA COLUMNA --}}
            <div class="form-group">
                <select class="custom-select" name="{{$cantEstado}}_t{{$i}}_A">
                    @for($j = 0; $j < $cant_estados; $j++)
                        <option value="{{$iden . $j}}" <?php if(isset($_GET[$cantEstado. '_t' . $i . '_A']) && $_GET[$cantEstado. '_t' . $i . '_A'] == ($iden . $j)) { echo 'selected="selected"'; } ?>>{{$iden . $j}}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-sm">  {{-- SEGUNDA COLUMNA --}}
            <div class="form-group">
                <input type="text" class="form-control" id="transAlfabeto" name="{{$cantEstado}}_t{{$i}}_B" title="Debe ingresar la transición según el alfabeto (Ej: aabbb). Si desea ingresar una transición vacía use '@'." pattern="^([A-Za-z0-9]+|@)$" placeholder="Ingrese transicion según alfabeto (Ej: aabbb)" autocomplete="off" value="<?php echo htmlspecialchars($_GET[$cantEstado. '_t' . $i . '_B'] ?? '', ENT_QUOTES); ?>" required>
            </div>
        </div>
        <div class="col-sm-auto">  {{-- TERCERA COLUMNA --}}
            <div class="input-group">
                <select class="custom-select" name="{{$cantEstado}}_t{{$i}}_C">
                    @for($j = 0; $j < $cant_estados; $j++)
                        <option value="{{$iden . $j}}" <?php if(isset($_GET[$cantEstado. '_t' . $i . '_C']) && $_GET[$cantEstado. '_t' . $i . '_C'] == ($iden . $j)) { echo 'selected="selected"'; } ?>>{{$iden . $j}}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    @isset($_GET[$cantEstado. '_t' . $i . '_C'])
        @php
            $parteA = $_GET[$cantEstado. '_t' . $i . '_A'];
            $parteB = $_GET[$cantEstado. '_t' . $i . '_B'];
            $parteC = $_GET[$cantEstado. '_t' . $i . '_C'];
            $parteBsplit = str_split($parteB);
            for($k = 0; $k < sizeof($parteBsplit); $k++) {
                if(!in_array($parteBsplit[$k], $alfabetoArray, true)) {
                    $verificacion = false;
                    if($parteBsplit[$k] == '@') {
                        $verificacion = true;
                    }
                }
            }
            if($verificacion) {
                if($aux == $auxMax - 1) {
                    $transicion = $transicion . $parteA . ',' . $parteB . ',' . $parteC;
                    $aux++;
                } else {
                    $transicion = $transicion . $parteA . ',' . $parteB . ',' . $parteC . ';';
                    $aux++;
                }
            } else {
                echo 'La transición ingresada no tiene relación al alfabeto ingresado.';
                $parteB = '@';
            }
            $nextStep = true;
        @endphp
    @endisset
@endfor

@if($nextStep && $verificacion)
    <div class="row" style="margin-top: 2%;">
        <div class="col-sm">
            <label for="estadoInicial" style="margin-bottom: 2%;">Seleccione el estado inicial</label>
            <select class="custom-select" name="{{$cantEstado}}_eInicial">
                @for($j = 0; $j < $cant_estados; $j++)
                    <option value="{{$iden . $j}}" <?php if(isset($_GET[$cantEstado.'_eInicial']) && $_GET[$cantEstado.'_eInicial'] == ($iden . $j)) { echo 'selected="selected"'; } ?>>{{$iden . $j}}</option>
                @endfor
            </select>
        </div>
    </div>
    <div class="row" style="margin-top: 2%;">
        <div class="col-sm">
            <div class="form-group">
                <label style="margin-bottom: 0%;">Seleccione el estado final</label>
                <input type="text" class="form-control" style="display: none;" disabled>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 0%;">
        @for($i = 0; $i < $cant_estados; $i++)
        <div class="col-sm">
            <div class="pretty p-default p-round">
            <input type="checkbox" name="{{$cantEstado}}_eFinal_{{$i}}" value="{{$iden . $i}}" <?php if(isset($_GET[$cantEstado . '_eFinal_' . $i]) && $_GET[$cantEstado . '_eFinal_' . $i] == ($iden . $i)) { echo 'checked="checked"'; } ?>>
                <div class="state p-primary-o">
                <label>{{$iden . $i}}</label>
                </div>
            </div>
        </div>
        @endfor
    </div>
    <input type="text" style="display: none;" class="form-control" name="{{$cantEstado}}_transicion" value="{{$transicion}}">
@endif

{{-- @prepend('menu')
    @if(isset($_GET['cantidadEstados1_eInicial']) && isset($_GET['cantidadEstados2_eInicial']))
        <a style="text-decoration: none;" id="gotomenu" href="{{route('home')}}">
            <button style="margin-top: 2%;" type="button" class="btn btn-success btn-lg btn-block">Ir al menu</button>
        </a>
    @endif
@endprepend --}}

{{-- DEBUG FINAL --}}

{{-- @isset($_GET[$cantEstado.'_eInicial'])
    @php
        echo 'eInicial -> ';
        var_dump($_GET[$cantEstado.'_eInicial']);
    @endphp
    <br>
@endisset

@php $i = 0 @endphp
@for($i = 0; $i < $cant_estados; $i++)
    @isset($_GET[$cantEstado . '_eFinal_' . $i])
        @php
            echo 'eFinal -> ';
            var_dump($_GET[$cantEstado . '_eFinal_' . $i]);
        @endphp
        <br>
    @endisset
@endfor --}}


{{-- @php
    echo 'transicion -> ';
    var_dump($transicion);
@endphp --}}