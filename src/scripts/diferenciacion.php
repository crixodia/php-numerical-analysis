<?php

/**
 * Escuela Politécnica Nacional
 * Cristian Bastidas
 */

//Llamamos al script de funciones
include('funciones.php');

//Fórmula básica para diferenciación central
function d_central($f, float $x = 0, float $h = 0.01)
{
    return ($f($x + $h) - $f($x - $h)) / (2 * $h);
}

//Fórmula básica para diferenciación hacia adelante
function d_adelante($f, float $x = 0, float $h = 0.01)
{
    return ($f($x + $h) - $f($x)) / $h;
}

//Fórmula básica para diferenciación hacia atrás
function d_atras($f, float $x = 0, float $h = 0.01)
{
    return ($f($x) - $f($x - $h)) / $h;
}

/**
 * Función iterativa para obtener la derivada en un punto de una función
 * Método:
 *      Central
 * Parámetros:
 *      $f: función anónima
 *      $x: el punto de interés en la función
 *      $h: el desplazamiento inicial
 *      $step: el valor con el que se dividrá en cada iteración
 */
function d_interval_central($f, float $x, float $h, float $step = 2)
{
    $table = array();

    $delta = $h;
    $k = 0;

    $last = $next = abs(d_central($f, $x, $h));

    $flag = true;
    while ($last > $next or $flag) {

        $table[] = array($k, $f($x - $delta), $f($x + $delta), $delta, d_central($f, $x, $delta));

        $delta /= $step;
        $k++;

        $last = $next;
        $next = abs(d_central($f, $x, $delta));

        $flag = false;
    }

    return $table;
}


/**
 * Función iterativa para obtener la derivada en un punto de una función
 * Método:
 *      Hacia atrás
 * Parámetros:
 *      $f: función anónima
 *      $x: el punto de interés en la función
 *      $h: el desplazamiento inicial
 *      $step: el valor con el que se dividrá en cada iteración
 */
function d_interval_atras($f, float $x, float $h, float $step = 2)
{
    $table = array();

    $delta = $h;
    $k = 0;

    $last = $next = abs(d_atras($f, $x, $h));

    $flag = true;
    while ($last < $next or $flag) {

        $table[] = array($k, $f($x - $delta), $f($x), $delta, d_atras($f, $x, $delta));

        $delta /= $step;
        $k++;

        $last = $next;
        $next = abs(d_atras($f, $x, $delta));

        $flag = false;
    }

    return $table;
}

/**
 * Función iterativa para obtener la derivada en un punto de una función
 * Método:
 *      Hacia adelante
 * Parámetros:
 *      $f: función anónima
 *      $x: el punto de interés en la función
 *      $h: el desplazamiento inicial
 *      $step: el valor con el que se dividrá en cada iteración
 */
function d_interval_adelante($f, float $x, float $h, float $step = 2)
{
    $table = array();

    $delta = $h;
    $k = 0;

    $last = $next = abs(d_adelante($f, $x, $h));

    $flag = true;
    while ($last > $next or $flag) {

        $table[] = array($k, $f($x), $f($x + $delta), $delta, d_adelante($f, $x, $delta));

        $delta /= $step;
        $k++;

        $last = $next;
        $next = abs(d_adelante($f, $x, $delta));

        $flag = false;
    }

    return $table;
}

/**
 * DESCARTADO
 */
function d_iterative($f, float $x, float $h, float $error = 1e-10)
{
    $table = array();
    $d = array();

    $k = 0;
    $delta = $h;
    do {
        $table[] = array($k, $f($x - $delta), $f($x + $delta), $delta, d_central($f, $x, $delta));
        $d[] = d_central($f, $x, $delta);

        $delta /= 1.1;
        if ($k > 1) {
            if (abs($d[$k]) == 0) {
                break;
            }
            if (abs($d[$k] - $d[$k - 1]) / abs($d[$k]) < $error) {
                break;
            }
        }
        $k++;
    } while (true);
    return $table;
}

function d_iterative_value($f, float $x, float $h, float $error = 1e-10)
{
    $table = d_iterative($f, $x, $h, $error);
    return $table[count($table) - 1][4];
}
