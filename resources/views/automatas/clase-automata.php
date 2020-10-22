<?php
class AFD
{
    private $conjunto_de_identificadores = [];
    private $alfabeto_de_entrada = [];
    private $estado_inicial = "";
    private $estados_finales = [];
    private $funcion_de_transicion = [];

    /*El constructor llena los siguientes arreglos:
        $conjunto_de_indentificadores
        $alfabeto_de_entrada
        $estado_inicial
        $estados_finales
    - La función de transición se llena más abajo.
    */

    public function __construct($identificadores, $alfabeto, $estados_i_f)
    { //Entran al método tres variables -> Identificadores "q0,q1,q2"| Alfabeto "a,b"| Estados (El primero es el estado inicial) "q0,q1,q2"
        $this->conjunto_de_identificadores = explode(",", $identificadores);//Se llenan los identificadores
        $this->alfabeto_de_entrada = explode(",", $alfabeto);//Se llena el alfabeto
        $estados_separados_por_coma = explode(",", $estados_i_f);//Primero se separan los estados por ","
        for ($i = 0; $i < count($estados_separados_por_coma); $i++) {
            if ($i == 0) {
                $this->estado_inicial = $estados_separados_por_coma[$i];//La primera posicion es el estado inicial
            } else {
                $this->estados_finales[$i - 1] = $estados_separados_por_coma[$i];//El resto es(son) el(los) estado(s) final(es)
            }
        }
    }
    //Este método hace lo que dice. Entra un string ordenado de la manera como se explica abajo.
    public function llenar_funcion_de_transicion($funcion)
    { //"q0,a,q1,b,q2;q1,a,q2,b,q1" "Origen, simbolo, llegada, simbolo, llegada ; Origen, simbolo, llegada, simbolo, llegada"
        $funcion_punto_y_coma = explode(";", $funcion);//Se dividen las transicion por ";"
        for ($i = 0; $i < count($funcion_punto_y_coma); $i++) {//Se recorre cada separación
            $transiciones = explode(",", $funcion_punto_y_coma[$i]);//Ahora se divide esa posición por ","
            $this->funcion_de_transicion[$transiciones[0]] = [];//La posición ej: "q0" será un arreglo 
            for ($j = 1; $j < count($transiciones); $j += 2) {//Se sigue recorriendo el arreglo desde la posición 1
                $this->funcion_de_transicion[$transiciones[0]][$transiciones[$j]] = $transiciones[$j + 1];
            }
        }
    }
    /*
    "q0,a,q1,b,q2;q1,a,q2,b,q1"
    array(2) {
                ["q0"] => array(2) { 
                                    ["a"]=> string(2) "q1" 
                                    ["b"]=> string(2) "q2"
                                    }
                ["q1"] => array(2) { 
                                    ["a"]=> string(2) "q2" 
                                    ["b"]=> string(2) "q1"
                                    }
             }
    public function Para simplificar un automata

    public function Para complemento, union, concatenacion, e interseccion entre ambos automatas

    public function simplificar cada uno de los de arriba
*/
}
/* class AFND
{
    private

} */
