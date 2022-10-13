<?php

/**
 * Escuela Politécnica Nacional
 * Cristian Bastidas
 */

//Esta función retorna funciones anponimas en base a su nombre
function getFunction(string $value = "lineal")
{

    //Función lineal - Modificar $a, $b para variar la función
    $lineal = function (float $x) {
        $a = 1;
        $b = 0;
        return $a * $x + $b;
    };

    //Función cuadrática - Modificar $a, $b, $c para variar la función
    $cuadratica = function (float $x) {
        $a = 1;
        $b = 0;
        $c = 0;
        return $a * $x * $x + $b * $x + $c;
    };

    //Función exponencial
    $exponencial = function (float $x) {
        return exp($x);
    };

    //Función Cosena
    $coseno = function (float $x) {
        return cos($x);
    };

    //Array con claves para obtener funciones
    $funciones = array(
        'lineal' => $lineal,
        'cuadratica' => $cuadratica,
        'exponencial' => $exponencial,
        'coseno' => $coseno,
    );

    //Devueleve la función deseada
    return $funciones[$value];
}

//Crear una función en base a una cadena de texto
function makeFunction(string $expression = "x")
{
    if ($expression == "") {
        return function () {
            return 0;
        };
    } else {
        $expr = strtolower($expression);
        $expr = str_replace('x', '$x', $expr);
        $expr = str_replace('^', '**', $expr);
        $expr = str_replace('e', exp(1), $expr);
        $expr = str_replace(' ', "", $expr);
        return eval('return function($x){return ' . $expr . ';};');
        //return eval('return function($x){ try{$r = ' . $expr . ';}catch(Error $e){$r = 0;} return $r;};');
    }
}
