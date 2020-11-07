@extends('layouts.plantilla')

@section('title', 'Trabajo 2 - AFD/AFD')

@section('content')

    {{-- <input type="button" class="btn btn-success btn-sm" value="Volver" onclick="history.back(-1)"/> --}}

    <h1 class="text-center display-1">Autómata AFD AFD</h1>
    <div class="container">
    <form style="margin-top: 5%;" method="GET">
        <div class="row">
            <div class="col-sm"> 
                <div class="form-group" style="margin-top: 2%;">
                    <label for="identificadores_afd1">Identificadores AFD</label>
                    <input type="text" class="form-control" name="identificadores_afd1" id="identificadores_afd1" title="Debe ingresar los identificadores como el ejemplo: q0,q1,q2" pattern="^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$" placeholder="Ingrese los identificadores separados por comas. (Ej: q0,q1,q2)" autocomplete="off" value="<?php echo htmlspecialchars($_GET['identificadores_afd1'] ?? '', ENT_QUOTES); ?>" required>
                </div>
            </div>
            <div class="col-sm"> 
                <div class="form-group" style="margin-top: 2%;">
                    <label for="identificadores_afd2">Identificadores AFD</label>
                    <input type="text" class="form-control" name="identificadores_afd2" id="identificadores_afd2" title="Debe ingresar los identificadores como el ejemplo: q0,q1,q2" pattern="^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$" placeholder="Ingrese los -identificadores separados por comas. (Ej: q0,q1,q2)" autocomplete="off" value="<?php echo htmlspecialchars($_GET['identificadores_afd2'] ?? '', ENT_QUOTES); ?>" required>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-info btn-lg btn-block custom-btn" onclick="history.back(-1)">Volver atrás</button>
        <button style="" type="submit" class="btn btn-info btn-lg btn-block custom-btn" onclick="">Confirmar</button>
    </form>


    {{-- ESTO HAY QUE EDITARLO YA QUE SE CAMBIO TODO A LA VIEW DE: automata_home --}}
@endsection