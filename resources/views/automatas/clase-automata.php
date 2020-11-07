<?php
class AFD {
    protected $conjuntoDeIdentificadores = [];
    protected $alfabetoDeEntrada = [];
    private $estadoInicial = "";
    protected $estadosFinales = [];
    private $funcionDeTransicion = [];

    public function __construct($identificadores, $alfabeto, $estadoI, $estadosF) {
        $this->conjuntoDeIdentificadores = explode(",", $identificadores);
        $this->alfabetoDeEntrada = explode(",", $alfabeto);
        $this->estadoInicial = $estadoI;
        $this->estadosFinales = explode(",", $estadosF);
    }
    public function llenarFuncionDeTransicion($funcion) {
        $funcionPuntoYComa = explode(";", $funcion);
        for ($i = 0;$i < count($funcionPuntoYComa);$i++) {
            $transiciones = explode(",", $funcionPuntoYComa[$i]);
            $this->funcionDeTransicion[$transiciones[0]] = [];
            for ($j = 1;$j < count($transiciones);$j += 2) {
                $this->funcionDeTransicion[$transiciones[0]][$transiciones[$j]][] = $transiciones[$j + 1];
            }
        }
    }
    private function iniciarTablaDeEstadosDistinguibles() {
        $tablaDeEstadosDistinguibles = [];
        for ($i = 1;$i < count($this->conjuntoDeIdentificadores);$i++) {
            for ($j = 0;$j < $i;$j++) {
                $tablaDeEstadosDistinguibles[$this->conjuntoDeIdentificadores[$i]][$this->conjuntoDeIdentificadores[$j]] = ["", []];
            }
        }
        return $tablaDeEstadosDistinguibles;
    }
    private function distinguirFinalesYNoFinales($tablaDeEstadosDistinguibles) {
        foreach ($tablaDeEstadosDistinguibles as $estadoI => $arreglo) {
            foreach ($arreglo as $estadoJ => $marca) {
                if ((in_array($estadoI, $this->estadosFinales) && !in_array($estadoJ, $this->estadosFinales)) || (!in_array($estadoI, $this->estadosFinales) && in_array($estadoJ, $this->estadosFinales))) {
                    $tablaDeEstadosDistinguibles[$estadoI][$estadoJ][0] = 'x';
                }
            }
        }
        return $tablaDeEstadosDistinguibles;
    }
    private function llenar($e1, $e2, $tablaDeEstadosDistinguibles, $estadoI, $estadoJ) {
        if ($tablaDeEstadosDistinguibles[$e1][$e2][0] == 'x') {
            $tablaDeEstadosDistinguibles[$estadoI][$estadoJ][0] = 'x';
            for ($j = 0;$j < count($tablaDeEstadosDistinguibles[$estadoI][$estadoJ][1]);$j++) {
                $tablaDeEstadosDistinguibles[$tablaDeEstadosDistinguibles[$estadoI][$estadoJ][1][$j][0]][$tablaDeEstadosDistinguibles[$estadoI][$estadoJ][1][$j][1]][0] = 'x';
            }
        }
        else {
            if ($e1 != $estadoI && $e2 != $estadoJ) {
                $tablaDeEstadosDistinguibles[$e1][$e2][1][] = [$estadoI, $estadoJ];
            }
        }
        return $tablaDeEstadosDistinguibles;
    }
    private function llenarTabla($estado1, $estado2, $tablaDeEstadosDistinguibles, $estadoI, $estadoJ) {
        if (array_key_exists($estado1, $tablaDeEstadosDistinguibles) && array_key_exists($estado2, $tablaDeEstadosDistinguibles[$estado1])) {
            $tablaDeEstadosDistinguibles = $this->llenar($estado1, $estado2, $tablaDeEstadosDistinguibles, $estadoI, $estadoJ);
        }
        else {
            if (array_key_exists($estado2, $tablaDeEstadosDistinguibles) && array_key_exists($estado1, $tablaDeEstadosDistinguibles[$estado2])) {
                $tablaDeEstadosDistinguibles = $this->llenar($estado2, $estado1, $tablaDeEstadosDistinguibles, $estadoI, $estadoJ);
            }
        }
        return $tablaDeEstadosDistinguibles;
    }
    private function tablaDeEstadosDistinguibles() {
        $tablaDeEstadosDistinguibles = $this->iniciarTablaDeEstadosDistinguibles();
        $tablaDeEstadosDistinguibles = $this->distinguirFinalesYNoFinales($tablaDeEstadosDistinguibles);
        foreach ($tablaDeEstadosDistinguibles as $estadoI => $arreglo) {
            foreach ($arreglo as $estadoJ => $marca) {
                if ($tablaDeEstadosDistinguibles[$estadoI][$estadoJ][0] != 'x') {
                    for ($i = 0;$i < count($this->alfabetoDeEntrada);$i++) {
                        $estado1 = $this->funcionDeTransicion[$estadoI][$this->alfabetoDeEntrada[$i]][0];
                        $estado2 = $this->funcionDeTransicion[$estadoJ][$this->alfabetoDeEntrada[$i]][0];
                        $tablaDeEstadosDistinguibles = $this->llenarTabla($estado1, $estado2, $tablaDeEstadosDistinguibles, $estadoI, $estadoJ);
                    }
                }
            }
        }
        return $tablaDeEstadosDistinguibles;
    }
    private function redireccionarTransicionesDeLlegada($estadoI, $estadoJ) {
        foreach ($this->funcionDeTransicion as $posicionI => $transiciones) {
            foreach ($transiciones as $alfabeto => $estado) {
                if ($estado == $estadoI) {
                    $this->funcionDeTransicion[$posicionI][$alfabeto][0] = (string)$estadoJ;
                }
            }
        }
    }
    public function simplificacion() {
        $tablaDeEstadosDistinguibles = $this->tablaDeEstadosDistinguibles();
        foreach ($tablaDeEstadosDistinguibles as $estadoI => $arreglo) {
            foreach ($arreglo as $estadoJ => $marca) {
                if ($tablaDeEstadosDistinguibles[$estadoI][$estadoJ][0] != 'x') {
                    unset($this->funcionDeTransicion[$estadoI]);
                    unset($this->conjuntoDeIdentificadores[array_search($estadoI, $this->conjuntoDeIdentificadores) ]);
                    if (in_array($estadoI, $this->estadosFinales)) {
                        unset($this->estadosFinales[array_search($estadoI, $this->estadosFinales) ]);
                    }
                    if ($estadoI == $this->estadoInicial) {
                        $this->estadoInicial = (string)$estadoJ;
                    }
                    $this->redireccionarTransicionesDeLlegada($estadoI, $estadoJ);
                }
            }
        }
    }
    public function complemento() {
        $nuevosEstadosFinales = [];
        foreach ($this->conjuntoDeIdentificadores as $identificador) {
            if (!in_array($identificador, $this->estadosFinales)) {
                $nuevosEstadosFinales[] = $identificador;
            }
        }
        $this->estadosFinales = $nuevosEstadosFinales;
    }
}

class AFND extends AFD {
    private $relacionDeTransicion = [];

    public function __construct() {
        // Inicia el objeto sin parámetros.
    }
    public function crearAFND($identificadores, $alfabeto, $estadoI, $estadosF) {
        $this->conjuntoDeIdentificadores = explode(",", $identificadores);
        $this->alfabetoDeEntrada = explode(",", $alfabeto);
        $this->estadoInicial = $estadoI;
        $this->estadosFinales = explode(",", $estadosF);
    }
    public function llenarRelacionDeTransicion($funcion) {
        $funcionPuntoYComa = explode(";", $funcion);
        for ($i = 0;$i < count($funcionPuntoYComa);$i++) {
            $transiciones = explode(",", $funcionPuntoYComa[$i]);
            $this->relacionDeTransicion[$transiciones[0]] = [];
            for ($j = 1;$j < count($transiciones);$j += 2) {
                $this->relacionDeTransicion[$transiciones[0]][$transiciones[$j]][] = $transiciones[$j + 1];
            }
        }
    }
    private function unirFuncionesDeTransicion($tipoAutomata1, $tipoAutomata2, $automata1, $automata2) {
        $arregloDeRelacionDeTransicion = [];
        if ($tipoAutomata1 == "AFD" && $tipoAutomata2 == "AFD") {
            $arregloDeRelacionDeTransicion = array_merge($automata1->funcionDeTransicion, $automata2->funcionDeTransicion);
        }
        if ($tipoAutomata1 == "AFD" && $tipoAutomata2 == "AFND") {
            $arregloDeRelacionDeTransicion = array_merge($automata1->funcionDeTransicion, $automata2->relacionDeTransicion);
        }
        if ($tipoAutomata1 == "AFND" && $tipoAutomata2 == "AFD") {
            $arregloDeRelacionDeTransicion = array_merge($automata1->relacionDeTransicion, $automata2->funcionDeTransicion);
        }
        if ($tipoAutomata1 == "AFND" && $tipoAutomata2 == "AFND") {
            $arregloDeRelacionDeTransicion = array_merge($automata1->relacionDeTransicion, $automata2->relacionDeTransicion);
        }
        return array_merge(["z0" => ["@" => [$automata1->estadoInicial, $automata2->estadoInicial]]], $arregloDeRelacionDeTransicion);
    }
    public function union($automata1, $automata2) {
        $automata3 = new AFND;
        $automata3->conjuntoDeIdentificadores[] = "z0";
        $automata3->conjuntoDeIdentificadores = array_merge($automata1->conjuntoDeIdentificadores, $automata2->conjuntoDeIdentificadores);
        array_unshift($automata3->conjuntoDeIdentificadores, "z0");
        $automata3->alfabetoDeEntrada = $automata1->alfabetoDeEntrada;
        $automata3->estadoInicial = "z0";
        $automata3->estadosFinales = array_merge($automata1->estadosFinales, $automata2->estadosFinales);
        $automata3->relacionDeTransicion = $this->unirFuncionesDeTransicion(get_class($automata1), get_class($automata2), $automata1, $automata2);
        return $automata3;
    }
    private function concatenarFuncionesDeTransicion($tipoAutomata1, $tipoAutomata2, $automata1, $automata2) {
        $arregloDeRelacionDeTransicion = [];
        if ($tipoAutomata1 == "AFD" && $tipoAutomata2 == "AFD") {
            $arregloDeRelacionDeTransicion = array_merge($automata1->funcionDeTransicion, $automata2->funcionDeTransicion);
        }
        if ($tipoAutomata1 == "AFD" && $tipoAutomata2 == "AFND") {
            $arregloDeRelacionDeTransicion = array_merge($automata1->funcionDeTransicion, $automata2->relacionDeTransicion);
        }
        if ($tipoAutomata1 == "AFND" && $tipoAutomata2 == "AFD") {
            $arregloDeRelacionDeTransicion = array_merge($automata1->relacionDeTransicion, $automata2->funcionDeTransicion);
        }
        if ($tipoAutomata1 == "AFND" && $tipoAutomata2 == "AFND") {
            $arregloDeRelacionDeTransicion = array_merge($automata1->relacionDeTransicion, $automata2->relacionDeTransicion);
        }
        foreach ($automata1->estadosFinales as $estadoFinal) {
            $arregloDeRelacionDeTransicion[$estadoFinal]["@"][] = $automata2->estadoInicial;
        }
        return $arregloDeRelacionDeTransicion;
    }
    public function concatenacion($automata1, $automata2) {
        $automata3 = new AFND;
        $automata3->conjuntoDeIdentificadores = array_merge($automata1->conjuntoDeIDentificadores, $automata2->conjuntoDeIdentificadores);
        $automata3->alfabetoDeEntrada = $automata1->alfabetoDeEntrada;
        $automata3->estadoInicial = $automata1->estadoInicial;
        $automata3->estadosFinales = $automata2->estadosFinales;
        $automata3->relacionDeTransicion = $this->concatenarFuncionesDeTransicion(get_class($automata1), get_class($automata2), $automata1, $automata2);
        return $automata3;
    }
}
?>
