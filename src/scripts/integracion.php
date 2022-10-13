<?php

/**
 * Escuela Politécnica Nacional
 * Cristian Bastidas
 */

//Funciones por default y parser de funciones
include('funciones.php');

//Integral por la regla del trapecio
function i_trapecio($f, float $a, float $b, float $n)
{
    $delta = $h = ($b - $a) / $n;
    $I = $f($a);
    for ($i = 1; $i < $n; $i++) {
        $I += 2 * $f($a + $delta);
        $delta += $h;
    }
    $I += $f($b);
    return $I * $h / 2;
}

//Integral por la regla de Simpson
function i_simpson($f, float $a, float $b, float $n)
{
    $delta = $h = ($b - $a) / $n;
    $I = $f($a);
    for ($i = 1; $i < $n; $i++) {
        $I += ($i % 2 == 0 ? 2 : 4) * $f($a + $delta);
        //echo $i . " " . 4 * $f($a + $delta) . " " . 2 * $f($a + $delta) . "\n";
        $delta += $h;
    }
    $I += $f($b);
    return $I * $h / 3;
}

//Integral iterativa con criterio de parada Trapecios
function i_iterative_trapecio($f, float $a, float $b, float $error, float $n = 1)
{
    $table = array();
    $I = array();

    $k = 0;
    $delta = $n;
    do {
        $I[] = i_trapecio($f, $a, $b, $delta);
        if ($k >= 1) {
            $table[] = array($k, $I[$k - 1], abs($I[$k] - $I[$k - 1]), $delta, i_trapecio($f, $a, $b, $delta));
            if (abs($I[$k] - $I[$k - 1]) <= $error) {
                break;
            }
        } else {
            $table[] = array($k, '-', '-', $delta, i_trapecio($f, $a, $b, $delta));
        }
        $delta += 1;
        $k++;
    } while (true);
    return $table;
}


//Integral iterativa con criterio de parada Simpson
function i_iterative_simpson($f, float $a, float $b, float $error, float $n = 2)
{
    $table = array();
    $I = array();

    $k = 0;
    $delta = $n < 1 ? 2 : ($n % 2 == 0 ? $n : $n + 1);
    do {
        $I[] = i_simpson($f, $a, $b, $delta);
        if ($k >= 1) {
            $table[] = array($k, $I[$k - 1], abs($I[$k] - $I[$k - 1]), $delta, i_simpson($f, $a, $b, $delta));
            if (abs($I[$k] - $I[$k - 1]) <= $error) {
                break;
            }
        } else {
            $table[] = array($k, '-', '-', $delta, i_simpson($f, $a, $b, $delta));
        }
        $delta += 2;
        $k++;
    } while (true);
    return $table;
}

//TEST
/*echo i_simpson(function ($x) {
    return exp($x);
}, 0, 6, 6);*/