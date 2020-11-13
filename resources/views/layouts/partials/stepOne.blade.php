<h1 style="margin-bottom: 5%;" class="text-center display-1">¿Qué tipo de autómatas ingresará?</h1>
<div class="container">
    <div class="row">
        <div class="col-sm"> 
            <div class="input-group" style="margin-top: 3%;">
                <select class="custom-select" name="automataUno">
                    <option value="AFD" <?php if(isset($_GET['automataUno']) && $_GET['automataUno'] == 'AFD') { echo 'selected="selected"'; } ?>>AFD</option>
                    <option value="AFND" <?php if(isset($_GET['automataUno']) && $_GET['automataUno'] == 'AFND') { echo 'selected="selected"'; } ?>>AFND</option>
                </select>
            </div>
        </div>
        <div class="col-sm">
            <div class="input-group" style="margin-top: 3%;">
            <select class="custom-select" name="automataDos">
                <option value="AFD" <?php if(isset($_GET['automataDos']) && $_GET['automataDos'] == 'AFD') { echo 'selected="selected"'; } ?>>AFD</option>
                <option value="AFND" <?php if(isset($_GET['automataDos']) && $_GET['automataDos'] == 'AFND') { echo 'selected="selected"'; } ?>>AFND</option>
            </select>
            </div>
        </div>
    </div>

    @isset($_GET['automataUno'])
        @php
            $automataUno = $_GET['automataUno'];
            $automataDos = $_GET['automataDos'];
            var_dump($_GET['automataUno']);
            var_dump($_GET['automataDos']);
        @endphp
    @endisset
    <div class="row">
        <div class="col-sm"> 
            <div class="form-group" style="margin-top: 2%;">
                <label for="alfabetoAutomata">Alfabeto</label>
                <input type="text" class="form-control" name="alfabetoAutomata" id="alfabetoAutomata" title="Debe ingresar el alfabeto como el siguiente ejemplo: a,b,c" pattern="^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$" placeholder="Ingrese el alfabeto para los autómatas separados por comas. (Ej: a,b,c)" autocomplete="off" value="<?php echo htmlspecialchars($_GET['alfabetoAutomata'] ?? '', ENT_QUOTES); ?>" required>
            </div>
        </div>
    </div>
    @isset($_GET['alfabetoAutomata'])
        @php
            $alfabeto = $_GET['alfabetoAutomata'];
            var_dump($alfabeto);
        @endphp
    @endisset
    {{-- <a style="text-decoration: none;" href="{{route('automata_home') . '?a=' . base64_encode($_GET['alfabetoAutomata']) . '&af=' . base64_encode($_GET['automataUno']) . '&at=' . base64_encode($_GET['automataDos'])}}">
        <button style="margin-top: 2%;" type="button" class="btn btn-info btn-lg btn-block custom-btn">Confirmar</button>
    </a> --}}
</div>

      {{-- Acá debería ir un @isset para verificar si se ingresa un AFD/AFD, un AFD/AFND, un AFND/AFD o AFND/AFND --}}
      {{-- @isset($_GET['automataUno'])
        
      @endisset--}}
    