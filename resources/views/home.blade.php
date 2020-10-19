@extends('layouts.plantilla')

@section('title', 'Poner titulo bonito acá')

@section('content')
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="text-center display-4">Tarea 2 de Grafos y Lenguajes Formales</h1>
            <p class="text-center lead">Diseñar una aplicación web (página web) que, en base a los contenidos de la asignatura, permita:</p>
            <hr class="my-4">
            <p class="text-center">1. Ingresar un grafo a la aplicación (puede ser simple, dirigido, etiquetado, etc.)</p>
            <p class="text-center">2. A partir del grafo ingresado, debe:</p>
            <p class="text-center">     a. Mostrar matriz de caminos e indicar si el grafo es o no conexo.</p>
            <p class="text-center">     b. Mostrar el camino más corto para dos nodos a elección del usuario, mostrando la duración
                y la ruta de dicho camino (nodos por los que pasa).</p>
            <p class="text-center">     c. Indicar si es hamiltoniano y/o euleriano, indicando el camino hamiltoniano y/o euleriano
                que lo define como tal.</p>
            <p class="text-center">     d. Indicar el flujo máximo para un nodo de origen/entrada y otro de destino/salida a elección
                del usuario.</p>
            <p class="text-center">     e. Obtener el árbol generador mínimo mediante prim o kruskal.</p>
        </div>
    </div>
@endsection