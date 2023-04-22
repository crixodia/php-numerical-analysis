<?php

/**
 * Muestra la matriz en consola. Usado para pruebas.
 */
function show_matrix_cli(array $x)
{
    for ($i = 0; $i < count($x); $i++) {
        echo implode(', ', $x[$i]) . "\n";
    }
}

/**
 * Muestra un vector en consola. Usado para pruebas.
 */
function show_vector_cli(array $x)
{
    echo implode(", ", $x) . "\n";
}

/**
 * Suma entre dos vectores
 * 
 * @param array $vector_a primero vector
 * @param array $vector_b segundo vector
 * @return array $vector_c = $vector_a y $vector_b
 */
function add_vector(array $vector_a, array $vector_b)
{
    $vector_c = array();
    for ($i = 0; $i < count($vector_a); $i++) {
        $vector_c[$i] = round($vector_a[$i] + $vector_b[$i], 15);
    }
    return $vector_c;
}

/**
 * Calcula la norma de un vector
 * 
 * @param array $x vector a calcular la norma.
 * @return float la norma del vector $x
 */
function get_norm(array $x)
{
    $r = 0;
    for ($i = 0; $i < count($x); $i++) {
        $r += pow($x[$i], 2);
    }
    return sqrt($r);
}

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
    //show_matrix_cli($A);
    $n = count($A);
    $lower = array();
    for ($j = 0; $j <= $n; $j++) {
        for ($i = 0; $i <= $n - 1; $i++) {
            if ($i > $j) {
                //Ordena la matriz en caso de ser necesario
                //solo es valido si se encuentra caso de pivoteo
                //en la primera posición de la matriz
                if ($A[$j][$j] == 0) {
                    rsort($A);
                }
                // En caso de que a pesar del pivoteo se de división
                // por cero
                try {
                    $lower[$i][$j] = $A[$i][$j] / $A[$j][$j];
                } catch (DivisionByZeroError $e) {
                    return retro_substitution($A, $b);
                }
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
        case "upper":       //Upper from LU
            return $A;
        case "lower":       //Lower from LU
            return $lower;
        case "upper_coef":  //Upper with coefficients
            return array($A, $b);
        case "solve":       //Solution
            return retro_substitution($A, $b);
        default:            //Upper and Lower form LU
            return  array($lower, $A);
    }
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
        if ($A[$i][$i] == 0) {  //Obliga a converger en caso de división para cero
            return $x;
        }
        $x[$i] = ($b[$i] - $sum) / $A[$i][$i];
    }
    return $x;  //Solution
}
