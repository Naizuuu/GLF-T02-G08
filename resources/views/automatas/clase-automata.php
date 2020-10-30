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
        private function iniciarTablaDeEstadosDistinguibles()
        {
            $tablaDeEstadosDistinguibles = [];
            for ($i = 1; $i < count($this->conjuntoDeIdentificadores); $i++) {
                for ($j = 0; $j < $i; $j++) {
                    $tablaDeEstadosDistinguibles[$this->conjuntoDeIdentificadores[$i]][$this->conjuntoDeIdentificadores[$j]] = ["",[]];
                }
            }
            return $tablaDeEstadosDistinguibles;
        }
        public function distinguirFinalesYNoFinales($tablaDeEstadosDistinguibles){
            foreach($tablaDeEstadosDistinguibles as $estadoI => $arreglo){
                foreach($arreglo as $estadoJ => $marca){
                    if((in_array($estadoI, $this->estadosFinales) && !in_array($estadoJ, $this->estadosFinales)) || (!in_array($estadoI, $this->estadosFinales) && in_array($estadoJ, $this->estadosFinales))){
                        $tablaDeEstadosDistinguibles[$estadoI][$estadoJ][0] = 'x';
                    }
                }
            }
            return $tablaDeEstadosDistinguibles;
        }
        public function tablaDeEstadosDistinguibles()
        {
            $tablaDeEstadosDistinguibles = $this->iniciarTablaDeEstadosDistinguibles();
            $tablaDeEstadosDistinguibles = $this->distinguirFinalesYNoFinales($tablaDeEstadosDistinguibles);
            foreach($tablaDeEstadosDistinguibles as $estadoI => $arreglo)
            {
                foreach($arreglo as $estadoJ => $marca)
                {
                    if($tablaDeEstadosDistinguibles[$estadoI][$estadoJ][0]!='x'){
                        for($i = 0; $i < count($this->alfabetoDeEntrada); $i++){
                            $estado1 = $this->funcionDeTransicion[$estadoI][$this->alfabetoDeEntrada[$i]];
                            $estado2 = $this->funcionDeTransicion[$estadoJ][$this->alfabetoDeEntrada[$i]];
                            if(array_key_exists($estado1, $tablaDeEstadosDistinguibles) && array_key_exists($estado2, $tablaDeEstadosDistinguibles[$estado1])){
                                if($tablaDeEstadosDistinguibles[$estado1][$estado2][0]=='x'){
                                    $tablaDeEstadosDistinguibles[$estadoI][$estadoJ][0]='x';
                                    for($j=0;$j<count($tablaDeEstadosDistinguibles[$estadoI][$estadoJ][1]);$j++){
                                        $tablaDeEstadosDistinguibles[$tablaDeEstadosDistinguibles[$estadoI][$estadoJ][1][$j][0]][$tablaDeEstadosDistinguibles[$estadoI][$estadoJ][1][$j][1]][0]='x';
                                    }
                                }
                                else{
                                    if($estado1 != $estadoI && $estado2 != $estadoJ){
                                        $tablaDeEstadosDistinguibles[$estado1][$estado2][1][] = [$estadoI, $estadoJ];
                                    }
                                }
                            }
                            else{
                                if(array_key_exists($estado2, $tablaDeEstadosDistinguibles) && array_key_exists($estado1, $tablaDeEstadosDistinguibles[$estado2])){
                                    if($tablaDeEstadosDistinguibles[$estado2][$estado1][0]=='x'){
                                        $tablaDeEstadosDistinguibles[$estadoI][$estadoJ][0]='x';
                                        for($j=0;$j<count($tablaDeEstadosDistinguibles[$estadoI][$estadoJ][1]);$j++){
                                            $tablaDeEstadosDistinguibles[$tablaDeEstadosDistinguibles[$estadoI][$estadoJ][1][$j][0]][$tablaDeEstadosDistinguibles[$estadoI][$estadoJ][1][$j][1]][0]='x';
                                        }
                                    }
                                    else{
                                        if($estado2 != $estadoI && $estado1 != $estadoJ){
                                            $tablaDeEstadosDistinguibles[$estado2][$estado1][1][] = [$estadoI, $estadoJ];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $tablaDeEstadosDistinguibles;
        }
        public function simplificacion ()
        {
            $tablaDeEstadosDistinguibles = $this->tablaDeEstadosDistinguibles();
            foreach($tablaDeEstadosDistinguibles as $estadoI => $arreglo)
            {
                foreach($arreglo as $estadoJ => $marca)
                {
                    if($tablaDeEstadosDistinguibles[$estadoI][$estadoJ][0]!='x'){
                        unset($this->funcionDeTransicion[$estadoI]);
                        unset($this->conjuntoDeIdentificadores[array_search($estadoI, $this->conjuntoDeIdentificadores)]);
                        if(in_array($estadoI, $this->estadosFinales)){
                            unset($this->estadosFinales[array_search($estadoI, $this->estadosFinales)]);
                        }
                        if($estadoI == $this->estadoInicial){
                            $this->estadoInicial = (string)$estadoJ;
                        }
                        foreach ($this->funcionDeTransicion as $posicionI => $transiciones) {
                            foreach ($transiciones as $alfabeto => $estado) {
                                if ($estado == $estadoI) {
                                    $this->funcionDeTransicion[$posicionI][$alfabeto] = (string)$estadoJ;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>