<?php

/**
 * Eliminación gaussiana dada la matriz de coeficientes y el vector de solución
 * devuelve el vector de soluciones del sistema de ecuaciones.
 *
 * @param array $A matriz de coeficiente de ecuaciones (cuadrada)
 * @param array $b vector de solución.
 * @param string $lu "solve" para obtener las soluciones del sistema,
 * "lower" par obtener L de LU, "upper" para obtenerr U de LU, de otro modo
 * de obtendrá L y U de LU.
 */
function gaussian_elimination(array $A, array $b, string $lu = "solve")
{
    $n = count($A);
    $lower = array();
    for ($j = 0; $j <= $n; $j++) {
        for ($i = 0; $i <= $n - 1; $i++) {
            if ($i > $j) {
                $lower[$i][$j] = $A[$i][$j] / $A[$j][$j];
                for ($k = 0; $k < $n; $k++) {
                    $A[$i][$k] -= $lower[$i][$j] * $A[$j][$k];
                }
                $b[$i] -= $lower[$i][$j] * $b[$j];
            } else if ($i == $j) {
                $lower[$i][$j] = 1;
            } else if ($j < $n) {
                $lower[$i][$j] = 0;
            }
        }
    }

    switch ($lu) {
        case "upper":
            return $A;
        case "lower":
            return $lower;
        case "upper_coef":
            return array($A, $b);
        case "solve":
            return retro_substitution($A, $b);
        default:
            return  array($lower, $A);
    }
}

/**
 * Método de Thomas dada la matriz de coeficientes y el vector de solución
 * devuelve el vector de soluciones del sistema de ecuaciones.
 * La matriz debe ser tridiagonal.
 *
 * @param array $A matriz de coeficiente de ecuaciones (cuadrada)
 * @param array $b vector de solución.
 * @param string $lu "solve" para obtener las soluciones del sistema,
 * "lower" par obtener L de LU, "upper" para obtenerr U de LU, de otro modo
 * de obtendrá L y U de LU.
 */
function thomas_elimination(array $A, array $b, string $lu = "solve")
{
    $lower = array_fill(0, count($A), array_fill(0, count($A), 0));
    $lower[0][0] = 1;
    for ($i = 1; $i < count($A); $i++) {
        $A[$i][$i] -= $A[$i][$i - 1] * $A[$i - 1][$i] / $A[$i - 1][$i - 1];

        $lower[$i][$i] = 1;
        $lower[$i][$i - 1] = $A[$i][$i - 1] / $A[$i - 1][$i - 1];

        $b[$i] -= $A[$i][$i - 1] * $b[$i - 1] / $A[$i - 1][$i - 1];
        $A[$i][$i - 1] = 0;
    }

    switch ($lu) {
        case "upper":
            return $A;
        case "lower":
            return $lower;
        case "upper_coef":
            return array($A, $b);
        case "solve":
            return retro_substitution($A, $b);
        default:
            return  array($lower, $A);
    }
}

// Paso básico para Gauss-Jacobi
function gauss_jacobi(array $A, array $b, array $x)
{
    $n = count($A);
    $x_new = array_fill(0, $n, 0);
    for ($i = 0; $i < $n; $i++) {
        $sum = 0;
        for ($j = 0; $j < $n; $j++) {
            if ($j != $i) {
                $sum += $A[$i][$j] * $x[$j];
            }
        }
        $x_new[$i] = ($b[$i] - $sum) / $A[$i][$i];
    }
    return $x_new;
}

/**
 * Método de Gauss-Jacobi dada la matriz de coeficientes y el vector de solución
 * devuelve el vector de soluciones del sistema de ecuaciones.
 *
 * @param array $A matriz de coeficiente de ecuaciones (cuadrada)
 * @param array $b vector de solución
 * @param array $x aproximación inicial
 * @param float $tolerance tolerancia al error para Gauss-Jacobi
 * @param int $max número máximo de iteraciones
 */
function gauss_jacobi_iterative(array $A, array $b, array $x, float $tolerance = 1e-15, int $max = 50, bool $all = false)
{
    $k = 0;
    $x_set = array($x);
    do {
        $last = $x;
        $x = gauss_jacobi($A, $b, $x);
        $x_set[] = $x;
        $k++;
    } while (!has_converged($last, $x, $tolerance) and $k <= $max);
    return $all ? $x_set : $x;
}

// Paso básico para Gauss-Seidel
function gauss_seidel(array $A, array $b, array $x)
{
    $n = count($A);
    $x_new = array_fill(0, $n, 0);
    for ($i = 0; $i < $n; $i++) {
        $sum = 0;
        for ($j = 0; $j < $i; $j++) {
            $sum += $A[$i][$j] * $x_new[$j];
        }
        for ($j = $i + 1; $j < $n; $j++) {
            $sum += $A[$i][$j] * $x[$j];
        }
        $x_new[$i] = ($b[$i] - $sum) / $A[$i][$i];
    }
    return $x_new;
}

/**
 * Método de Gauss-Seidel dada la matriz de coeficientes y el vector de solución
 * devuelve el vector de soluciones del sistema de ecuaciones.
 *
 * @param array $A matriz de coeficiente de ecuaciones (cuadrada)
 * @param array $b vector de solución
 * @param array $x aproximación inicial
 * @param float $tolerance tolerancia al error para Gauss-Jacobi
 * @param int $max número máximo de iteraciones
 */
function gauss_seidel_iterative(array $A, array $b, array $x, float $tolerance = 1e-15, int $max = 50, bool $all = false)
{
    $k = 0;
    $x_set = array($x);
    do {
        $x = gauss_seidel($A, $b, $x);
        $x_set[] = $x;
        $k++;
    } while (!has_converged($x_set[$k - 1], $x, $tolerance) and $k <= $max);
    return $all ? $x_set : $x;
}
/**
 * Criterio de convergencia para métodos iterativos
 *
 * @param array $last array con los valores de la iteración anterior
 * @param array $next array con los valores de la iteración actual
 * @param float $tolerance tolerancia al error del método
 * 
 * @return bool retorno si converge o no
 **/
function has_converged(array $last, array $next, float $tolerance = 1e-15)
{
    $sum_last = $sum_next = 0;
    for ($i = 0; $i < count($next); $i++) {
        $sum_last += pow($last[$i], 2);
        $sum_next += pow($next[$i], 2);
    }
    return abs($sum_last - $sum_next) <= $tolerance;
}

/**
 * Restrosubstitución para resolver sistemas de ecuacione lineales.
 * 
 * @param array $A matriz formada por eliminación gaussiana.
 * @param array $b vector de solución.
 * @return array solución del sisatema de ecuaciones.
 */
function retro_substitution(array $A, array $b)
{
    $n = count($A);
    $x = array_fill(0, count($A), 0);
    for ($i = $n - 1; $i >= 0; $i--) {
        $sum = 0;
        for ($j = $i + 1; $j < $n; $j++) {
            $sum += $A[$i][$j] * $x[$j];
        }
        $x[$i] = ($b[$i] - $sum) / $A[$i][$i];
    }
    return $x;
}

function gauss_seidel_relaxation(array $A, array $b, array $x, float $w)
{
    $n = count($A);
    $x_new = array_fill(0, $n, 0);
    for ($i = 0; $i < $n; $i++) {
        $sum = 0;
        for ($j = 0; $j < $i; $j++) {
            $sum += $A[$i][$j] * $x_new[$j];
        }
        for ($j = $i + 1; $j < $n; $j++) {
            $sum += $A[$i][$j] * $x[$j];
        }
        $x_new[$i] = (1 - $w) * $x[$i] + $w * ($b[$i] - $sum) / $A[$i][$i];
    }
    return $x_new;
}

function successive_over_relaxaion(array $A, array $b, array $x, float $w, float $tolerance = 1e-15, int $max = 50,  bool $all = false)
{
    $k = 0;
    $x_set = array($x);
    do {
        $x = gauss_seidel_relaxation($A, $b, $x, $w);
        $x_set[] = $x;
        $k++;
    } while (!has_converged($x_set[$k - 1], $x, $tolerance) and $k <= $max);
    return $all ? $x_set : $x;
}


function transpose(array $A)
{
    $n = count($A);
    $AT = array();
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < count($A[$i]); $j++) {
            $AT[$j][$i] = $A[$i][$j];
        }
    }
    return $AT;
}

function get_norm(array $a)
{
    $n = count($a);
    $norm = 0;
    for ($i = 0; $i < $n; $i++) {
        $norm += $a[$i] ** 2;
    }
    return sqrt($norm);
}

function get_unit_vector(array $a)
{
    $n = count($a);
    $unit = array();
    $norm = get_norm($a);
    for ($i = 0; $i < $n; $i++) {
        $unit[$i] = $a[$i] / $norm;
    }
    return $unit;
}

function dot_product(array $a, array $b)
{
    $n = count($a);
    $dot = 0;
    for ($i = 0; $i < $n; $i++) {
        $dot += $a[$i] * $b[$i];
    }
    return $dot;
}

function add_vector(array $a, array $b)
{
    $n = count($a);
    $c = array();
    for ($i = 0; $i < $n; $i++) {
        $c[$i] = $a[$i] + $b[$i];
    }
    return $c;
}

function times_vector(float $a, array $b)
{
    $n = count($b);
    $c = array();
    for ($i = 0; $i < $n; $i++) {
        $c[$i] = $a * $b[$i];
    }
    return $c;
}

function multiply_matrix(array $a, array $b)
{
    $c = array();
    $n = count($a);
    $bT = transpose($b);
    $m = count($bT);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $m; $j++) {
            $c[$i][$j] = dot_product($a[$i], $bT[$j]);
        }
    }
    return $c;
}

function gram_schmidt(array $A)
{
    $n = count($A);
    $AT = transpose($A);
    $U = array();
    $e = array();
    for ($i = 0; $i < $n; $i++) {
        $sum = array_fill(0, $n, 0);
        for ($j = 0; $j < $i; $j++) {
            $dot = dot_product($AT[$i], $e[$j]);
            $times = times_vector($dot, $e[$j]);
            $sum = add_vector($times, $sum);
        }
        $U[$i] = add_vector($AT[$i], times_vector(-1, $sum));
        $e[$i] = get_unit_vector($U[$i]);
    }
    return transpose($U);
}

function qr_decomposition(array $A, string $qr = "both")
{
    $n = count($A);
    $UT = transpose(gram_schmidt($A));
    $Q = array();
    for ($i = 0; $i < $n; $i++) {
        $Q[$i] = get_unit_vector($UT[$i]);
    }

    $R = multiply_matrix($Q, $A);
    $Q = transpose($Q);
    switch ($qr) {
        case "r":
        case "R":           //R from QR
            return $R;
        case "q":
        case "Q":           //Q from QR
            return $Q;
        default:            //Q and R from QR
            return  array($Q, $R);
    }
}
