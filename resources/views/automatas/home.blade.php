@extends('layouts.plantilla')

@section('title', 'Trabajo 2 - Autómatas')

@section('content')

<form id="form" method="GET" autocomplete="off">
    
    <div id="stepOne">@include('layouts.partials.stepOne')</div>
    <div id="stepTwo">@include('layouts.partials.stepTwo')</div>

    <button type="submit" style="margin-bottom: 3%;" class="btn btn-info btn-lg btn-block custom-btn" onclick="">Confirmar</button>
    @stack('menu')
</form>

@endsection