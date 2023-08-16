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
        $xnext = $x - $f($x) / d_iterative_value($f, $x, 1e-5, $tolerance);
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
function interval_newton($f, float $a, float $b, int $n, float $tolerance = 1e-10)
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

function interval_newton_roots($f, float $a, float $b, int $n, float $tolerance = 1e-10)
{
    $roots = array();
    $table = interval_bisection($f, $a, $b, $n, $tolerance);
    foreach ($table as $interval_table) {
        $roots[] = $interval_table[1][count($interval_table[1]) - 1][3];
    }
    return $roots;
}

function interval_bisection_roots($f, float $a, float $b, int $n, float $tolerance = 1e-10)
{
    $roots = array();
    $table = interval_newton($f, $a, $b, $n, $tolerance);
    foreach ($table as $interval_table) {
        $roots[] = $interval_table[1][count($interval_table[1]) - 1][3];
    }
    return $roots;
}

/**
 * Método de la secante
 */
function secante($f, float $x1, float $x2, float $tolerance = 1e-15)
{
    $x3 = $k = 0;

    if (abs($f($x1)) < abs($f($x2))) {
        list($x1, $x2) = array($x2, $x1);
    }

    $fx1 = $f($x1);
    $fx2 = $f($x2);

    $table = array(array($k, $x1, $x2, $x3, $f($x3)));
    do {
        $x3 = $x2 - ($fx2 * ($x1 - $x2)) / ($fx1 - $fx2);
        $fx3 = $f($x3);

        list($x1, $x2) = array($x2, $x3);

        $fx1 = $f($x1);
        $fx2 = $f($x2);
        $fx3 = $f($x3);

        $k++;
        $table[] = array($k, $x1, $x2, $x3, $fx3);
    } while (abs($x1 - $x2) > $tolerance);
    return $table;
}

function interval_secante($f, float $a, float $b, int $n, float $tolerance = 1e-15)
{
    //Obtiene n intervalos entre a y b
    $intervals = get_intervals($a, $b, $n);

    $data = array();
    foreach ($intervals as $interval) {
        //echo implode(",", $interval) . "\n";
        list($a, $b) = $interval;
        $secante = secante($f, $a, $b, $tolerance);
        $data[] = array($interval, $secante);
    }
    return $data;
}

/**
 * Método de la secante-bisección o regla falsi.
 */
function secante_bisec($f, float $a, float $b, float $tolerance = 1e-15)
{
    $c = $k = 0;

    if (abs($f($a)) < abs($f($b))) {
        list($a, $b) = array($b, $a);
    }

    $table = array(array($k, $a, $b, $c, $f($c)));
    do {
        $c = $b - $f($b) * ($b - $a) / ($f($b) - $f($a));
        if (sign_changed($f, $b, $c)) {
            list($a, $b) = array($c, $b);
        } else {
            list($a, $b) = array($a, $c);
        }

        $k++;

        $table[] = array($k, $a, $b, $c, $f($c));
    } while (abs($b - $c) > $tolerance or abs($f($c)) >= $tolerance);
    return $table;
}


function interval_secante_bisect($f, float $a, float $b, int $n, float $tolerance = 1e-15)
{
    //Obtiene n intervalos entre a y b
    $intervals = get_intervals($a, $b, $n);

    $data = array();
    foreach ($intervals as $interval) {
        //echo implode(",", $interval) . "\n";
        list($a, $b) = $interval;
        $secante_bisect = secante_bisec($f, $a, $b, $tolerance);
        $data[] = array($interval, $secante_bisect);
    }
    return $data;
}

function aproximaciones_sucesivas($f, float $a, float $tolerance = 1e-15)
{
    $x_next = $a;
    $k = 0;
    $table = array();
    do {
        $x_last = $x_next;
        $x_next = $x_last + $f($x_last);
        $table[] = array($k, $x_last, $f($x_last), $x_next, $f($x_next));
        $k++;
    } while (abs($x_next - $x_last) > $tolerance);
    return $table;
}

function interval_aproximaciones_sucesivas($f, float $a, float $b, int $n, float $tolerance = 1e-15)
{
    //Obtiene n intervalos entre a y b
    $intervals = get_intervals($a, $b, $n);

    $data = array();
    foreach ($intervals as $interval) {
        //echo implode(",", $interval) . "\n";
        list($a, $b) = $interval;
        $aproximaciones_sucesivas = aproximaciones_sucesivas($f, ($a + $b) / 2, $tolerance);
        $data[] = array($interval, $aproximaciones_sucesivas);
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
/*$table = secante_bisec(makeFunction("(63*x^5 - 70*x^3 + 15*x)/8"), -1, -0.8);
for ($i = 0; $i < count($table); $i++) {
    echo implode(",", $table[$i]) . "\n";
}*/
