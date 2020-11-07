@extends('layouts.plantilla')

@section('title', 'Trabajo 2 - Autómatas')

@section('content')

    @php
        $automataUno = $_GET['automataUno'];
        $automataDos = $_GET['automataDos'];
    @endphp

    <h1 class="text-center display-1">Autómata {{$automataUno}} {{$automataDos}}</h1>
    <div class="container">
    <form style="margin-top: 5%;" method="GET">
        <div class="row">
            <div class="col-sm"> 
                {{-- ALFABETO --}}
                <div class="form-group" style="margin-top: 2%;">
                    <label for="alfabetoAutomata">Alfabeto</label>
                    <input type="text" class="form-control" name="alfabetoAutomata" id="alfabetoAutomata" title="Debe ingresar el alfabeto como el siguiente ejemplo: a,b,c" pattern="^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$" placeholder="Ingrese el alfabeto para los autómatas separados por comas. (Ej: a,b,c)" autocomplete="off" value="<?php echo htmlspecialchars($_GET['alfabetoAutomata'] ?? '', ENT_QUOTES); ?>" required>
                </div>
                {{-- ESTADOS --}}
                <div class="form-group" style="margin-top: 2%;"> 
                    <label for="cantidadEstados">Cantidad de Estados</label>
                    <input type="number" class="form-control" name="cantidadEstados" title="Debe ingresar la cantidad de estados del autómata." placeholder="Ingrese la cantidad de estados." min="1" autocomplete="off" value="<?php echo htmlspecialchars($_GET['cantidadEstados'] ?? '', ENT_QUOTES); ?>" required>
                </div>
            </div>
        </div>
        
        <button type="button" class="btn btn-info btn-lg btn-block custom-btn" onclick="history.back(-1)">Volver atrás</button>
        <button style="" type="submit" class="btn btn-info btn-lg btn-block custom-btn" onclick="">Confirmar</button>
    </form>

@endsection