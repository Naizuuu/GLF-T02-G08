@extends('layouts.plantilla')

@section('title', 'Trabajo 2 - Autómatas')

@section('content')

    <h1 class="text-center display-1">¿Qué tipo de autómatas ingresará?</h1>
    <div class="container">

      <form style="margin-top: 5%;" method="GET">
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
                  <label for="automataDos">uwu</label>
                  <option value="AFD" >AFD</option>
                  <option value="AFND" disabled>AFND</option>  {{-- AFND está bloqueado ya que aún no pasamos esa materia --}}
                </select>
              </div>
          </div>
        </div>
        <button style="" type="submit" class="btn btn-success btn-lg btn-block custom-btn" onclick="">Confirmar</button> 



      </form>

  </div>

@endsection