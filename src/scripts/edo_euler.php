<?php

function edo_euler(float $x, float $y, float $h, int $n, $f)
{
    $y_set = array($y);
    $x_set = array($x);
    for ($i = 1; $i <= $n; $i++) {
        $y_set[$i] = $y_set[$i - 1] + $h * $f($x_set[$i - 1], $y_set[$i - 1]);
        $x_set[$i] = $x_set[$i - 1] + $h;
    }
    return array($x_set, $y_set);
}

function edo_euler_improved(float $x, float $y, float $h, int $n, $f)
{
    $y_set = array($y);
    $x_set = array($x);
    for ($i = 1; $i <= $n; $i++) {
        $A = $f($x_set[$i - 1], $y_set[$i - 1]);
        $y_set[$i] = $y_set[$i - 1] + $h * ($A +  $f($x_set[$i - 1] + $h, $y_set[$i - 1] + $h * $A)) / 2;
        $x_set[$i] = $x_set[$i - 1] + $h;
    }
    return array($x_set, $y_set);
}

function has_converged(array $y, array $y_last, float $tolerance)
{
    for ($i = 1; $i < count($y); $i++) {
        if (abs($y[$i] - $y_last[$i]) < $tolerance) {
            return false;
        }
    }
    return true;
}

function step(float $x, float $y, array $last_y, float $h, int $n, $f)
{
    $y_set = array($y);
    $x_set = array($x);
    for ($i = 1; $i <= $n; $i++) {
        $x_set[$i] = $x_set[$i - 1] + $h;
        $y_set[$i] = $y_set[$i - 1] + $h * ($f($x_set[$i - 1], $y_set[$i - 1]) + $f($x_set[$i], $last_y[$i])) / 2;
    }
    return $y_set;
}


function multi_step(float $x, float $y, float $h, int $n, float $tolerance, callable $init, $f)
{
    list($x_set, $y_all[]) = $init($x, $y, $h, $n, $f);
    $i = 0;
    do {
        $i++;
        $y_all[$i] = step($x, $y, $y_all[$i - 1], $h, $n, $f);
    } while (/*abs(end($y_all[$i]) - end($y_all[$i - 1])) > $tolerance*/has_converged($y_all[$i], $y_all[$i - 1], $tolerance));
    return array($x_set, $y_all);
}

function fourth_order(float $x, float $y, float $h, int $n, $f)
{
    $y_set = array($y);
    $x_set = array($x);
    for ($i = 1; $i <= $n; $i++) {
        $k1 = $f($x_set[$i - 1], $y_set[$i - 1]);
        $k2 = $f($x_set[$i - 1] + $h / 2, $y_set[$i - 1] + $h * $k1 / 2);
        $k3 = $f($x_set[$i - 1] + $h / 2, $y_set[$i - 1] + $h * $k2 / 2);
        $k4 = $f($x_set[$i - 1] + $h, $y_set[$i - 1] + $h * $k3);
        $y_set[$i] = $y_set[$i - 1] + $h * ($k1 + 2 * $k2 + 2 * $k3 + $k4) / 6;
        $x_set[$i] = $x_set[$i - 1] + $h;
    }
    return array($x_set, $y_set);
}

function edo_euler_modified(float $x, float $y, float $h, int $n, $f)
{
    $y_set = array($y);
    $x_set = array($x);
    for ($i = 1; $i <= $n; $i++) {
        $A = $f($x_set[$i - 1], $y_set[$i - 1]);
        $y_set[$i] = $y_set[$i - 1] + $h * $f($x_set[$i - 1] + $h / 2, $y_set[$i - 1] + $h * $A / 2);
        $x_set[$i] = $x_set[$i - 1] + $h;
    }
    return array($x_set, $y_set);
}

function build_xy_function(string $expression)
{
    if ($expression == "") {
        return 0;
    }
    $expression = strtolower($expression);
    $expression = str_replace("x", '$x', $expression);
    $expression = str_replace("y", '$y', $expression);
    return eval('return function($x, $y){return ' . $expression . ';};');
}

/*
$f = build_xy_function("(1/(1+x**2))-2*y**2");
$x = 0;
$y = 0;
$a = 0;
$b = 0.2;
$n = 4;

$ans = edo_euler($x, $y, ($b - $a) / $n, $n, $f);
echo implode("\n", end($ans)) . "\n";

$ans = edo_euler_improved($x, $y, ($b - $a) / $n, $n, $f);
echo implode("\n", end($ans)) . "\n";

$ans = edo_euler_modified($x, $y, ($b - $a) / $n, $n, $f);
echo implode("\n", end($ans)) . "\n";
*/