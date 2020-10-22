<header class="masthead mb-auto">
    <div class="inner" style="{{request()->routeIs('home') ? 'display: none;' : 'display: block'}}">
        <h3 class="masthead-brand">Tarea 2</h3>
        <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link {{request()->routeIs('home') ? 'active' : ''}}" href="{{route('home')}}">Inicio</a>
            <a class="nav-link {{request()->routeIs('automatas') ? 'active' : ''}}" href="{{route('automatas')}}">Autómatas</a>
            <a class="nav-link disabled" href="#">Contact</a>
        </nav>
    </div>
</header>