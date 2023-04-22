<?php

include 'derivative-helper.php';
include 'linear_algebra.php';

/**
 * Método de newton multivariable de un solo paso.
 * 
 * @param string $expression expresión multivariable (campo escalar).
 * @param array $variables variables presentes en la expresión multivariable.
 * @param array $x aproximación inicial.
 * @return array nueva aproximación resolviendo el sistema con su jacobiana y
 * gradiente usando eliminación gaussiana.
 */
function multivariable_newton(string $expression, array $variables, array $x)
{
    $gradient = build_gradient($expression, $variables);
    $jacobian = build_jacobian($expression, $variables, $x);

    for ($i = 0; $i < count($jacobian); $i++) {
        for ($j = 0; $j < count($jacobian[$i]); $j++) {
            for ($k = 0; $k < count($variables); $k++) {
                $jacobian[$i][$j] = str_replace($variables[$k], $x[$k], $jacobian[$i][$j]);
                $gradient[$i] = str_replace($variables[$k], $x[$k], $gradient[$i]);
            }
            $jacobian[$i][$j] = optimize_h($jacobian[$i][$j]);
        }
        $gradient[$i] = -optimize_h($gradient[$i]);
    }
    return gaussian_elimination($jacobian, $gradient);
}

/**
 * Método de newton multivariable de forma iterativa. Toma
 * el método multivariable_newton en cada iteración para obtener
 * una nueva aproximación hasta llegar a la convergencia.
 * Converge cuando las normas de la anterior aproximaxión y la aproximación
 * actual son menores o iguales a la tolreancia.
 * 
 * @param string $expression expresión multivariable.
 * @param array $variables variables usadas en la expresión multivariable.
 * @param array $init aproximación inicial para el método.
 * @param float $tolerance tolerancia al error.
 * @param int $max máximo número de iteraciones.
 * @return array mínimo local del campo escalar especificado en base a la aproximación inicial
 */
function multivariable_newton_iterative(string $expression, array $variables, array $init, float $tolerance = 1e-14, int $max = 20, $all = false)
{
    $x_last = $x_next = $init;
    $k = 0;
    $table = array();
    do {
        $x_last = $x_next;
        $x_next = add_vector(multivariable_newton($expression, $variables, $x_last), $x_last);
        $table[] = $x_next;
        $k++;
    } while (abs(get_norm($x_last) - get_norm($x_next)) > $tolerance and $k < $max);
    return $all ? $table : $x_next;
}
