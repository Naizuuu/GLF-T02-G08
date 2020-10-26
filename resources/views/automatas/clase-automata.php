<?php
    class AFD
    {
        private $conjuntoDeIdentificadores = [];
        private $alfabetoDeEntrada = [];
        private $estadoInicial = "";
        private $estadosFinales = [];
        private $funcionDeTransicion = [];
        
        public function __construct($identificadores, $alfabeto, $estadosIF)
        { //Entran al método tres variables -> Identificadores "q0,q1,q2"| Alfabeto "a,b"| Estados (El primero es el estado inicial) "q0,q1,q2"
            $this->conjuntoDeIdentificadores = explode(",", $identificadores); //Se llenan los identificadores
            $this->alfabetoDeEntrada = explode(",", $alfabeto); //Se llena el alfabeto
            $estadosSeparadosPorComa = explode(",", $estadosIF); //Primero se separan los estados por ","
            for ($i = 0; $i < count($estadosSeparadosPorComa); $i++) {
                if ($i == 0) {
                    $this->estadoInicial = $estadosSeparadosPorComa[$i]; //La primera posicion es el estado inicial
                } else {
                    $this->estadosFinales[$i - 1] = $estadosSeparadosPorComa[$i]; //El resto es(son) el(los) estado(s) final(es)
                }
            }
        }
        //Este método hace lo que dice. Entra un string ordenado de la manera como se explica abajo.
        public function llenarFuncionDeTransicion($funcion)
        { //"q0,a,q1,b,q2;q1,a,q2,b,q1" "Origen, simbolo, llegada, simbolo, llegada ; Origen, simbolo, llegada, simbolo, llegada"
            $funcionPuntoYComa = explode(";", $funcion); //Se dividen las transicion por ";"
            for ($i = 0; $i < count($funcionPuntoYComa); $i++) { //Se recorre cada separación
                $transiciones = explode(",", $funcionPuntoYComa[$i]); //Ahora se divide esa posición por ","
                $this->funcionDeTransicion[$transiciones[0]] = []; //La posición ej: "q0" será un arreglo 
                for ($j = 1; $j < count($transiciones); $j += 2) { //Se sigue recorriendo el arreglo desde la posición 1
                    $this->funcionDeTransicion[$transiciones[0]][$transiciones[$j]] = $transiciones[$j + 1];
                }
            }
        }
        private function crearTablaDeEstadosDistinguibles()
        {
            $tablaDeEstadosDistinguibles = [];
            for ($i = 1; $i < count($this->conjuntoDeIdentificadores); $i++) {
                for ($j = 0; $j < $i; $j++) {
                    $tabla_de_estados_distinguibles[$this->conjuntoDeIdentificadores[$i]][$this->conjuntoDeIdentificadores[$j]] = "";
                }
            }
            return $tabla_de_estados_distinguibles;
        }
        private function sonDistinguibles($estadoI, $estadoJ)
        {
            if((in_array($estadoI, $this->estadosFinales) && !in_array($estadoJ, $this->estadosFinales)) || (!in_array($estadoI, $this->estadosFinales) && in_array($estadoJ, $this->estadosFinales)))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        public function simplificacion()
        {
            $tablaDeEstadosDistinguibles = $this->crearTablaDeEstadosDistinguibles();
            foreach($tablaDeEstadosDistinguibles as $estadoI => $arreglo){
                foreach($arreglo as $estadoJ => $marca){
                    if($this->sonDistinguibles($estadoI, $estadoJ)){
                        $tablaDeEstadosDistinguibles[$estadoI][$estadoJ] = 'x';
                    }
                }
            }
            foreach($tablaDeEstadosDistinguibles as $estadoI => $arreglo)
            {
                foreach($arreglo as $estadoJ => $marca)
                {
                    if($tablaDeEstadosDistinguibles[$estadoI][$estadoJ]!='x'){
                        for($i = 0; $i < count($this->alfabetoDeEntrada); $i++)
                        if($this->funcionDeTransicion)
                    }
                }
            }
        }
    }
?>