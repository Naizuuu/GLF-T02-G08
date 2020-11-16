<?php
class AFD {
    public $conjuntoDeIdentificadores = [];
    public $alfabetoDeEntrada = [];
    public $estadoInicial = "";
    public $estadosFinales = [];
    public $funcionDeTransicion = [];

    public function __construct() {
        // Crea el objeto sin parámetros.
        
    }

    public function crearAFD($identificadores, $alfabeto, $estadoI, $estadosF) {
        $this->conjuntoDeIdentificadores = explode(",", $identificadores);
        $this->alfabetoDeEntrada = explode(",", $alfabeto);
        $this->estadoInicial = $estadoI;
        $this->estadosFinales = explode(",", $estadosF);
    }
    public function llenarFuncionDeTransicion($funcion) {
        $funcionPuntoYComa = explode(";", $funcion);
        for ($i = 0;$i < count($funcionPuntoYComa);$i++) {
            $transiciones = explode(",", $funcionPuntoYComa[$i]);
            $this->funcionDeTransicion[$transiciones[0]][$transiciones[1]][] = $transiciones[2];
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
    private function buscarMasTransiciones($estadoInicial, $estadoDeLlegada) {
        foreach ($this->funcionDeTransicion[$estadoInicial] as $a => $transicion) {
            if ($transicion[0] == $estadoDeLlegada) {
                $caracteres[] = $a;
            }
        }
        return implode(",", $caracteres);
    }
    public function dibujarAFD() {
        $link = "https://image-charts.com/chart?cht=gv&chl=digraph {";
        foreach ($this->estadosFinales as $estadoFinal) {
            if ($estadoFinal != "") {
                $link = $link . $estadoFinal . "[shape=doublecircle];";
            }
        }
        $link = $link . "ei[shape=point]; ei -> " . $this->estadoInicial . ';';

        foreach ($this->funcionDeTransicion as $estado => $transiciones) {
            $listos = [];
            foreach ($transiciones as $transicion) {
                if (!in_array($transicion[0], $listos)) {
                    $link = $link . $estado . " -> " . $transicion[0] . '[label="' . $this->buscarMasTransiciones($estado, $transicion[0]) . '"];';
                    $listos[] = $transicion[0];
                }
            }
        }
        $link = $link . "}";
        return $link;
    }
}

class AFND extends AFD {
    public $relacionDeTransicion = [];

    public function __construct() {
        // Crea el objeto sin parámetros.
        
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
            $this->relacionDeTransicion[$transiciones[0]][$transiciones[1]][] = $transiciones[2];
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
        $automata3->relacionDeTransicion = $this->unirFuncionesDeTransicion(get_class($automata1) , get_class($automata2) , $automata1, $automata2);
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
        $automata3->conjuntoDeIdentificadores = array_merge($automata1->conjuntoDeIdentificadores, $automata2->conjuntoDeIdentificadores);
        $automata3->alfabetoDeEntrada = $automata1->alfabetoDeEntrada;
        $automata3->estadoInicial = $automata1->estadoInicial;
        $automata3->estadosFinales = $automata2->estadosFinales;
        $automata3->relacionDeTransicion = $this->concatenarFuncionesDeTransicion(get_class($automata1) , get_class($automata2) , $automata1, $automata2);
        return $automata3;
    }
    private function separarLasTransiciones($afnd) {
        $n = 0;
        foreach ($afnd->relacionDeTransicion as $key1 => $transiciones) {
            foreach ($transiciones as $key2 => $estadosDeLlegada) {
                if (strlen((string)$key2) > 1) {
                    foreach ($estadosDeLlegada as $estadoDeLlegada) {
                        $estado = $key1;
                        for ($i = 0;$i < (strlen((string)$key2) - 1);$i++) {
                            $afnd->relacionDeTransicion[$estado][$key2[$i]][] = "n" . $n;
                            $estado = "n" . $n;
                            $afnd->conjuntoDeIdentificadores[] = "n" . $n;
                            $n++;
                        }
                        $afnd->relacionDeTransicion[$estado][$key2[strlen((string)$key2) - 1]][] = $estadoDeLlegada;
                    }
                    unset($afnd->relacionDeTransicion[$key1][$key2]);
                }
            }
        }
    }
    private function iniciales($estado, $afnd) {
        if (!array_key_exists("@", $afnd->relacionDeTransicion[$estado])) {
            return [$estado];
        }
        else {
            foreach ($afnd->relacionDeTransicion[$estado]["@"] as $e) {
                $valor[] = $estado;
                $valor = array_merge($valor, $this->iniciales($e, $afnd));

            }
            return $valor;
        }
    }
    private function transicionesConElAlfabeto($caracter, $estado, $afnd) {
        if ($caracter == "" && array_key_exists("@", $afnd->relacionDeTransicion[$estado]) && count($afnd->relacionDeTransicion[$estado]["@"]) == 1 && $afnd->relacionDeTransicion[$estado]["@"][0] == $estado) {
            return [$estado];
        }
        else {
            if ($caracter == "" && !array_key_exists("@", $afnd->relacionDeTransicion[$estado])) {
                return [$estado];
            }
            else {
                if (array_key_exists($caracter, $afnd->relacionDeTransicion[$estado]) && array_key_exists("@", $afnd->relacionDeTransicion[$estado])) {
                    foreach ($afnd->relacionDeTransicion[$estado][$caracter] as $c) {
                        $arreglo = [];
                        $arreglo = array_merge($arreglo, $this->transicionesConElAlfabeto("", $c, $afnd));
                    }
                    foreach ($afnd->relacionDeTransicion[$estado]["@"] as $d) {
                        $arreglo = array_merge($arreglo, $this->transicionesConElAlfabeto($caracter, $d, $afnd));
                    }
                    return $arreglo;
                }
                else {
                    if (array_key_exists($caracter, $afnd->relacionDeTransicion[$estado]) && !array_key_exists("@", $afnd->relacionDeTransicion[$estado])) {
                        foreach ($afnd->relacionDeTransicion[$estado][$caracter] as $c) {
                            $arreglo = [];
                            $arreglo = array_merge($arreglo, $this->transicionesConElAlfabeto("", $c, $afnd));
                        }
                        return $arreglo;
                    }
                    else {
                        if (!array_key_exists($caracter, $afnd->relacionDeTransicion[$estado]) && array_key_exists("@", $afnd->relacionDeTransicion[$estado]) && $caracter == "") {
                            foreach ($afnd->relacionDeTransicion[$estado]["@"] as $c) {
                                $arreglo[] = $estado;
                                $arreglo = array_merge($arreglo, $this->transicionesConElAlfabeto($caracter, $c, $afnd));
                            }
                            return $arreglo;
                        }
                        else {
                            if (!array_key_exists($caracter, $afnd->relacionDeTransicion[$estado]) && !array_key_exists("@", $afnd->relacionDeTransicion[$estado])) {
                                return ["-"];
                            }
                        }
                    }
                }
            }
        }
    }
    private function crearTabla($afnd) {
        $estadosIniciales = $this->iniciales($afnd->estadoInicial, $afnd);
        for ($i = 0;$i < count($afnd->conjuntoDeIdentificadores);$i++) {
            if (in_array($afnd->conjuntoDeIdentificadores[$i], $estadosIniciales)) {
                $tabla[$i][] = "*";
            }
            else {
                $tabla[$i][] = " ";
            }
            $tabla[$i][] = $afnd->conjuntoDeIdentificadores[$i];
            for ($j = 0;$j < count($afnd->alfabetoDeEntrada);$j++) {
                $tabla[$i][$afnd->alfabetoDeEntrada[$j]] = $this->transicionesConElAlfabeto($afnd->alfabetoDeEntrada[$j], $afnd->conjuntoDeIdentificadores[$i], $afnd);
            }
        }
        return $tabla;
    }
    private function buscarPosicionEnTabla($estado, $tabla) {
        for ($i = 0;$i < count($tabla);$i++) {
            if ($tabla[$i][1] == $estado) {
                return $i;
            }
        }
    }
    private function crearElNuevoAutomata($tabla, $afnd) {
        $afd = new AFD();
        $afd->estadoInicial = "";
        for ($i = 0;$i < count($tabla);$i++) {
            if ($tabla[$i][0] == "*" && $afd->estadoInicial == "") {
                $afd->estadoInicial = $afd->estadoInicial . $tabla[$i][1];
            }
            else {
                if ($tabla[$i][0] == "*" && $afd->estadoInicial != "") {
                    $afd->estadoInicial = $afd->estadoInicial . "," . $tabla[$i][1];
                }
            }
        }
        $afd->conjuntoDeIdentificadores[] = $afd->estadoInicial;
        $afd->funcionDeTransicion[$afd->estadoInicial] = [];
        $afd->alfabetoDeEntrada = $afnd->alfabetoDeEntrada;
        $estadosPorRevisar[] = $afd->estadoInicial;
        while (!empty($estadosPorRevisar)) {
            $arregloProvisorio = [];
            $identificadorProvisorio = $estadosPorRevisar[array_key_last($estadosPorRevisar) ];
            $identificador = explode(",", $identificadorProvisorio);
            foreach ($identificador as $estado) {
                $posicionDeEstadoEnTabla = $this->buscarPosicionEnTabla($estado, $tabla);
                foreach ($tabla[$posicionDeEstadoEnTabla] as $caracter => $estadosDeLlegada) {
                    if (!is_numeric($caracter) && array_key_exists($caracter, $arregloProvisorio)) {
                        $arregloProvisorio[$caracter] = array_merge($arregloProvisorio[$caracter], array_unique($estadosDeLlegada));
                        $arregloProvisorio[$caracter] = array_unique($arregloProvisorio[$caracter]);
                    }
                    else {
                        if (!is_numeric($caracter)) {
                            $arregloProvisorio[$caracter] = [];
                            $arregloProvisorio[$caracter] = array_merge($arregloProvisorio[$caracter], array_unique($estadosDeLlegada));
                            $arregloProvisorio[$caracter] = array_unique($arregloProvisorio[$caracter]);
                        }
                    }
                }
            }
            foreach ($arregloProvisorio as $key => $estados) {
                if (count($estados) > 1 && in_array("-", $estados)) {
                    unset($arregloProvisorio[$key][array_search("-", $estados) ]);
                }
            }
            foreach ($arregloProvisorio as $caracter => $arreglos) {
                $afd->funcionDeTransicion[$identificadorProvisorio][$caracter][] = implode(",", $arreglos);
            }
            if (!in_array($identificadorProvisorio, $afd->conjuntoDeIdentificadores)) {
                $afd->conjuntoDeIdentificadores[] = $identificadorProvisorio;
            }
            unset($estadosPorRevisar[array_search($identificadorProvisorio, $estadosPorRevisar) ]);
            foreach ($arregloProvisorio as $estados) {
                if (!array_key_exists(implode(",", $estados) , $afd->funcionDeTransicion) && implode(",", $estados) != "-") {
                    array_unshift($estadosPorRevisar, implode(",", $estados));
                }
            }
        }
        foreach ($afd->conjuntoDeIdentificadores as $ident) {
            foreach (explode(",", $ident) as $id) {
                if (in_array($id, $afnd->estadosFinales)) {
                    $afd->estadosFinales[] = $ident;
                }
            }
        }
        $sumidero = 0;
        foreach ($afd->funcionDeTransicion as $key1 => $trnscns) {
            foreach ($trnscns as $key2 => $trnscn) {
                if ($trnscn[0] == "-") {
                    $afd->funcionDeTransicion[$key1][$key2][0] = "S";
                    $sumidero = 1;
                }
            }
        }
        if ($sumidero == 1) {
            foreach ($afd->alfabetoDeEntrada as $c) {
                $afd->funcionDeTransicion["S"][$c][] = "S";
            }
            $afd->conjuntoDeIdentificadores[] = "S";
        }
        return $afd;
    }
    public function transformarAFNDaAFD($afnd) {
        $this->separarLasTransiciones($afnd);
        $tablaParaAutomataAFD = $this->crearTabla($afnd);
        return $this->crearElNuevoAutomata($tablaParaAutomataAFD, $afnd);
    }
    public function interseccion($afd1, $afd2) {
        $afd1->complemento();
        $afd2->complemento();
        $afnd = new AFND();
        $afnd = $afnd->union($afd1, $afd2);
        $afd3 = $afnd->transformarAFNDaAFD($afnd);
        $afd3->complemento();
        return $afd3;
    }
    private function buscarMasTransicionesAFND($estado1, $estado2) {
        foreach ($this->relacionDeTransicion[$estado1] as $a => $transicion) {
            foreach ($transicion as $t) {
                if ($t == $estado2) {
                    $caracteres[] = $a;
                }
            }
        }
        return implode(",", $caracteres);
    }
    public function dibujarAFND() {
        $link = "https://image-charts.com/chart?cht=gv&chl=digraph {";
        foreach ($this->estadosFinales as $estadoFinal) {
            if ($estadoFinal != "") {
                $link = $link . $estadoFinal . "[shape=doublecircle];";
            }
        }
        $link = $link . "ei[shape=point]; ei -> " . $this->estadoInicial . ';';

        foreach ($this->relacionDeTransicion as $estado => $transiciones) {
            $listos = [];
            foreach ($transiciones as $transicion) {
                foreach ($transicion as $t) {
                    if (!in_array($t, $listos)) {
                        $link = $link . $estado . " -> " . $t . '[label="' . $this->buscarMasTransicionesAFND($estado, $t) . '"];';
                        $listos[] = $t;
                    }
                }
            }
        }
        $link = $link . "}";
        return $link;
    }
}
?>