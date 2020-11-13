@php
    $alfabetoArray = explode(",", $alfabeto);
    /* var_dump($alfabetoArray); */

    echo    '<script type="text/javascript">',
            'showDiv();',
            '</script>';
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
        /* var_dump($cant_estados); */
    @endphp
@endisset

@for($i = 0; $i < $cant_estados; $i++)
    @if($i == 0)
            <label style="margin-bottom: 2%;">Seleccione las transiciones</label>
    @endif
        @foreach($alfabetoArray as $simbolo)
        <div class="row" style="margin-top: 0%;">
            <div class="col-sm">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="q{{$i}}" disabled>
                </div>
            </div>
            <div class="col-sm">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="{{$simbolo}}" disabled>
                </div>
            </div>
            <div class="col-sm">
                <div class="input-group">
                <select class="custom-select" name="test_{{$i}}">
                        @for($j = 0; $j < $cant_estados; $j++)
                            <option value="{{$simbolo}}">q{{$j}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        @endforeach
@endfor