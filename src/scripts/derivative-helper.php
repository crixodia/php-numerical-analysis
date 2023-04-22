<?php
include 'function.php';

/**
 * Obtiene la expresión de la derivada numérica en función de una variable.
 * Se deberá optimizar x cuando x tiende a 0.
 *
 * @param string $expression expresión multivariable.
 * @param string $var variable de interés para obetner la expresión.
 * @return string expresión de la derivada en función de x en vez de h para
 * asegurar su funcionamiento con la función build_function.
 */
function d_central_expression(string $expression, string $var)
{
    $a = str_replace($var, "(" . $var . "+" .   "h)", $expression);
    $b = str_replace($var, "(" . $var . "-" . "h)", $expression);
    return "((" . $a . ")" . "-(" . $b . "))/(2*h)";
}

/**
 * Genera el gradiente de una función multivariable (campo escalar)
 * como un array de strings con las expresiones de sus derivadas.
 *
 * @param string $expression expresión multivariable.
 * @param array $variables array con las variables existentes en la expresión.
 * @return array gradiente en forma de array para la expresión.
 */
function build_gradient(string $expression, array $variables)
{
    $gradient = array();
    for ($i = 0; $i < count($variables); $i++) {
        $gradient[] = d_central_expression($expression, $variables[$i]);
    }
    return $gradient;
}

/**
 * Genera la matriz jacobiana de una función multivariable (campo escalar)
 * como un array de arrays de strings con las expresiones de sus derivadas.
 *
 * @param string $expression expresión multivariable.
 * @param array $variables array con las variables existentes en la expresión.
 * @return array jacobiana en forma de array de arrays de strings para la expresión
 * multivaraiable
 */
function build_jacobian(string $expression, array $variables)
{
    $jacobian = array();
    $gradient = build_gradient($expression, $variables);
    for ($i = 0; $i < count($gradient); $i++) {
        $jacobian[$i] = array();
        for ($j = 0; $j < count($variables); $j++) {
            $jacobian[$i][$j] = d_central_expression($gradient[$i], $variables[$j]);
        }
    }
    return $jacobian;
}

/**
 * Optimiza el valor h para expresiones en string de derivadas. Uso en
 * gradiente y jacobiana.
 * 
 * @param string $expression expresión de una sola variable en función
 * los puntos deben ser reemplazados antes.
 * de h para optimizar (Basado en diferenciación numérica).
 * @return float el valor de la derivada en los puntos ya reemplazados
 */
function optimize_h(string $expression)
{
    $d = 0;
    $h = 1;
    do {
        $h /= 2;
        $last = $d;
        $d = abs(build_function($expression, "h")($h));
    } while ($last < $d);
    return build_function($expression, "h")($h);
}
