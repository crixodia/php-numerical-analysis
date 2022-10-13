<?php

/**
 * Escuela Politécnica Nacional
 * Cristian Bastidas
 */

//Funciones por default y parser de funciones
include('diferenciacion.php');



/**
 * Comprueba si hay cambio de signo en una función en el intervalo [a, b]
 */
function sign_changed($f, float $a, float $b)
{
    return $f($a) * $f($b) <= 0;
}

/**
 * Crea un array de n subintervalos entre a y b
 */
function get_intervals(float $a, float $b, int $n)
{
    $intervals = array();
    $h = ($b - $a) / $n;
    $last = $a;
    for ($i = 1; $i <= $n; $i++) {
        $intervals[] = array($last, $last + $h);
        $last += $h;
    }
    return $intervals;
}

/**
 * Método de bisección para búsqueda de raíces en un intervalo [a,b]
 * donde f(a) y f(b) son de diferente signo.
 */
function bisection($f, float $a, float $b, float $tolerance = 1e-15)
{
    $_a = $a;
    $_b = $b;
    $c = $i = 0;
    $table = array();
    do {
        $c = ($_b + $_a) / 2;
        //echo $i . ',' . $_a . ',' . $_b . ',' . $c . ',' . $f($c) . "\r\n";
        $table[] = array($i, $_a, $_b, $c, $f($c));

        if (sign_changed($f, $_a, $c)) {
            $_b = $c;
        } else {
            $_a = $c;
        }

        $i++;
    } while (abs($b - $a) / pow(2, $i) > $tolerance and $f($c) != 0);
    return $table;
}
/**
 * Método de bisección analizando varios subintervalos
 * Devuelve un array de intervalos junto a su respectiva tabla de bisección.
 */
function interval_bisection($f, float $a, float $b, int $n, float $tolerance = 1e-15)
{
    //Obtiene n intervalos entre a y b
    $intervals = get_intervals($a, $b, $n);

    $data = array();
    foreach ($intervals as $interval) {
        //echo implode(",", $interval) . "\n";
        list($a, $b) = $interval;
        if (sign_changed($f, $a, $b)) { //Analiza solo intervalos válidos
            $data[] = array($interval, bisection($f, $a, $b, $tolerance));
        } else {
            $data[] = array($interval);
        }
    }
    return $data;
}

/**
 * Método de newton dado un punto inicial y máximo número de iteraciones
 * Devuelve un array con la información de cada iteración.
 */
function newton_raphson($f, float $x_0, int $max, float $tolerance = 1e-15)
{
    $table = array();
    $x = $x_0;
    $k = 0;
    do {

        $xnext = $x - $f($x) / d_iterative_value($f, $x, 1e-5, $tolerance);;
        $error = $xnext == 0 ? 0 : abs($xnext - $x) / abs($xnext);

        $table[] = array($k, $x, $error, $xnext, $f($xnext));

        $x = $xnext;
        $k++;
        $d = d_iterative_value($f, $x, 1e-5, $tolerance);
    } while ($error > $tolerance and $k < $max and $x != 0 and $d != 0);
    return $table;
}

/**
 * Método de newton para subintervalos de tamaño n entre a y b
 * Devuelve un array de intervalos junto a su respectivo array de las iteraciones.
 */
function interval_newton($f, float $a, float $b, int $n, float $tolerance = 1e-15)
{
    //Obtiene n intervalos entre a y b
    $intervals = get_intervals($a, $b, $n);

    $data = array();
    foreach ($intervals as $interval) {
        //echo implode(",", $interval) . "\n";
        list($a, $b) = $interval;
        $x = ($a + $b) / 2;

        $max = ceil(log(abs($a - $b) / $tolerance, 2));
        $newton = newton_raphson($f, $x, $max, $tolerance);
        $data[] = array($interval, $newton);
    }
    return $data;
}

/**
 * TESTS
 */
//$intervals = getIntervals(-2, 2, 10);
/*for ($i = 0; $i < count($intervals); $i++) {
    echo '[' . implode(",", $intervals[$i]) . ']';
}*/
//bisection(makeFunction("(63*x^5 - 70*x^3 + 15*x)/8"), -1, -0.6, 1e-15);
//bisection(makeFunction("x^2-1"), 0, 1, 1e-15);
//interval_bisection(makeFunction("(63*x^5 - 70*x^3 + 15*x)/8"), -1, 1, 5);
//interval_bisection(makeFunction("x^2-1"), -1, 1, 5);

/*$table = newton_raphson(makeFunction("(63*x^5 - 70*x^3 + 15*x)/8"), 0.4, 100);
for ($i = 0; $i < count($table); $i++) {
    echo implode(",", $table[$i]) . "\n";
}*/
