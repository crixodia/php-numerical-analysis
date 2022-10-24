<?php

/**
 * Escuela Politécnica Nacional
 * Cristian Bastidas
 */

//Funciones por default y parser de funciones
include('raices.php');


function get_legendre(int $n)
{
    if ($n == 0) {
        return "1";
    } else if ($n == 1) {
        return "x";
    } else {
        return "(" . (2 * $n - 1) . "*x*" . get_legendre($n - 1) . "-" . ($n - 1) . "*" . get_legendre($n - 2) . ")/" . $n;
    }
}

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


function gauss_quadrature($f, float $a, float $b, int $n, float $tolerance = 1e-10)
{
    $table = array();
    $legendre = MakeFunction(get_legendre($n));
    $roots = interval_bisection_roots($legendre, -1, 1, $n, $tolerance);
    $sum = 0;
    $legendre_last = MakeFunction(get_legendre($n + 1));
    for ($i = 0; $i < count($roots); $i++) {
        $div = (($n + 1) * d_iterative_value($legendre, $roots[$i], 1, $tolerance) * $legendre_last($roots[$i]));
        $w = -2 / $div;
        $x = ($roots[$i] * ($b - $a) / 2) + ($b + $a) / 2;
        $sum += $f($x) * $w;
        $table[] = array($i, $w, $x, $sum, (($b - $a) / 2) * $sum);
    }
    return array((($b - $a) / 2) * $sum, $table);
}

function gauss_quadrature_iterative($f, float $a, float $b, int $n,  float $tolerance = 1e-10)
{
    $table = array();
    $k = 1;
    do {
        $row = gauss_quadrature($f, $a, $b, $k, $tolerance);
        $table[] = array(get_legendre($k), $row[1]);
        $k++;
    } while ($k <= $n);
    return $table;
}
