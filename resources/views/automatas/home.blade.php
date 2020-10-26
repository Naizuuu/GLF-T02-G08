@extends('layouts.plantilla')

@section('title', 'Trabajo 2 - Autómatas')

@section('content')

    <h1 class="text-center display-1">¿Qué tipo de autómatas ingresará?</h1>
    <div class="container">

      <form style="margin-top: 5%;" method="GET" action="{{route('afd_afd')}}">
        <div class="row">
          <div class="col-sm"> 
              <div class="input-group" style="margin-top: 3%;">
                  <select class="custom-select" name="automataUno">
                      <option value="AFD">AFD</option>
                      <option value="AFND" disabled>AFND</option>  {{-- AFND está bloqueado ya que aún no pasamos esa materia --}}
                  </select>
              </div>
          </div>
          <div class="col-sm">
              <div class="input-group" style="margin-top: 3%;">
                <select class="custom-select" name="automataDos">
                  <option value="AFD" >AFD</option>
                  <option value="AFND" disabled>AFND</option>  {{-- AFND está bloqueado ya que aún no pasamos esa materia --}}
                </select>
              </div>
          </div>
        </div>
        {{-- <a style="text-decoration: none;" href="{{route('afd_afd') . '?t=' . base64_encode($_GET['automataUno']) . '&v=' . base64_encode($_GET['automataDos'])}}"> --}}
        <button type="submit" class="btn btn-info btn-lg btn-block custom-btn">Confirmar</button>
      </form>

      {{-- Acá debería ir un @isset para verificar si se ingresa un AFD/AFD, un AFD/AFND, un AFND/AFD o AFND/AFND --}}
      {{-- @isset($_GET['automataUno'])
        
      @endisset--}}
  </div>

@endsection