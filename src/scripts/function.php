<?php

/**
 * Crea una función a partir de una expresión matemática
 * para una sola variable obligatoriamente en función de
 * una variable especificada.
 * 
 * @param string $expression expresión matemática para la función.
 * @param string $var variable para la función.
 * @return function función anónima para ser evaluada de una variable.
 */
function build_function(string $expression = "x", string $var = "x")
{
    if ($expression == "") {
        return function () {
            return 0;
        };
    } else {
        $expr = strtolower($expression);
        $expr = str_replace($var, '$x', $expr);
        $expr = str_replace('^', '**', $expr);
        //$expr = str_replace('e', exp(1), $expr);
        //$expr = str_replace(' ', "", $expr);
        return eval('return function($x){return ' . $expr . ';};');
    }
}

/**
 * Regresa un array con todas las variables en una expresión multivariable
 * en campos escalares.
 * 
 * @param string $expression expresión multivariable.
 * @return array array con los identificadores de las variables en la
 * expresión multivariable.
 */
function get_variables(string $expression)
{
    $vars = array();
    $expression = str_replace("sin", "", $expression);
    $expression = str_replace("cos", "", $expression);
    $expression = str_replace("tan", "", $expression);
    $expression = str_replace("abs", "", $expression);
    $expression = str_replace("sqrt", "", $expression);
    $expression = str_replace("exp", "", $expression);
    $expression = str_replace("log", "", $expression);
    for ($i = 0; $i < strlen($expression); $i++) {
        if (ctype_alpha($expression[$i]) and !in_array($expression[$i], $vars)) {
            $vars[] = $expression[$i];
        }
    }
    sort($vars);    //Se ordenan las varibales para generar vectores ordenados
    return $vars;
}
