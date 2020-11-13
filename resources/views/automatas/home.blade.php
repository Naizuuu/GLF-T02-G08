@extends('layouts.plantilla')

@section('title', 'Trabajo 2 - Autómatas')

@section('content')

<form id="form" method="GET"{{-- action="{{route('automata_home')}} --}}>
    @php $r = 0; @endphp
    <div id="test1">@include('layouts.partials.stepOne')</div>
    {{-- <div id="test2" style="visibility: hidden; max-height: 0;">@include('layouts.partials.stepTwo')</div> --}}
    <div id="test2">@include('layouts.partials.stepTwo')</div>

    {{-- <button type="button" class="btn btn-info btn-lg btn-block custom-btn" onclick="history.back(-1)">Volver atrás</button> --}}
    <button type="submit" class="btn btn-info btn-lg btn-block custom-btn" onclick="showDiv()">Confirmar</button>
</form>
@endsection