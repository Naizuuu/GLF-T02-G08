<?php
class AFD
{
    private $conjunto_de_identificadores = [];
    private $alfabeto_de_entrada = [];
    private $estado_inicial = "";
    private $estados_finales = [];
    private $funcion_de_transicion = [];

    public function __construct($identificadores, $alfabeto, $estados_i_f)
    { //"q0,q1,q2"|"a,b"|"q0,q1"
        $this->conjunto_de_identificadores = explode(",", $identificadores);
        $this->alfabeto_de_entrada = explode(",", $alfabeto);
        $estados_separados_por_coma = explode(",", $estados_i_f);
        for ($i = 0; $i < count($estados_separados_por_coma); $i++) {
            if ($i == 0) {
                $estado_incial = $estados_separados_por_coma[$i];
            } else {
                $estados_finales[$i - 1] = $estados_separados_por_coma[$i];
            }
        }
    }

    public function llenar_funcion_de_transicion($funcion)
    { //"q0,a,q1,b,q2;q1,a,q2,b,q1" Origen, simbolo, llegada, simbolo, llegada
        $funcion_punto_y_coma = explode(";", $funcion);
        for ($i = 0; $i < count($funcion_punto_y_coma); $i++) {
            $transiciones = explode(",", $funcion_punto_y_coma[$i]);
            $this->funcion_de_transicion[$transiciones[0]] = [];
            for ($j = 1; $j < count($transiciones); $j += 2) {
                $this->funcion_de_transicion[$transiciones[0]][$transiciones[$j]] = $transiciones[$j + 1];
            }
        }
    }
}
