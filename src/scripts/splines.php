<?php
include('solve.php');

/**
 * Los valores 'h' del método de splines cúbicos
 * @param array $x el conjunto de valores de x
 * 
 * @return array un array con los valores h
 */
function get_h(array $x)
{
    $h = array(null);
    for ($i = 1; $i < count($x); $i++) {
        $h[] = $x[$i] - $x[$i - 1];
    }
    return $h;
}

/**
 * Los valores 'sigma' del método de splines cúbicos
 * @param array $y el conjunto de valores de y
 * @param array $h los valores de h
 * 
 * @return array un array con los valores sigma
 */
function get_sigma(array $y, array $h)
{
    $sigma = array(null);
    for ($i = 1; $i < count($y); $i++) {
        $sigma[] = ($y[$i] - $y[$i - 1]) / $h[$i];
    }
    return $sigma;
}

/**
 * Los valores 'lambda' del método de splines cúbicos
 * @param array $h los valores de h
 * 
 * @return array un array con los valores lambda
 */
function get_lambda(array $h)
{
    $lambda = array(null);
    for ($i = 1; $i < count($h) - 1; $i++) {
        $lambda[] = $h[$i + 1] / ($h[$i] + $h[$i + 1]);
    }
    $lambda[] = null;
    return $lambda;
}

/**
 * Los valores 'mu' del método de splines cúbicos
 * @param array $lambda los valores de lambda
 * 
 * @return array un array con los valores mu
 */
function get_miu(array $lambda)
{
    $miu = array(null);
    for ($i = 1; $i < count($lambda) - 1; $i++) {
        $miu[] = 1 - $lambda[$i];
    }
    $miu[] = null;
    return $miu;
}

/**
 * Los valores 'd' del método de splines cúbicos
 * @param array $sigma los valores de sigma
 * @param array $h los valores de h
 * 
 * @return array un array con los valores d
 */
function get_d(array $sigma, array $h)
{
    $d = array(null);
    for ($i = 1; $i < count($sigma) - 1; $i++) {
        $d[] = 6 * ($sigma[$i + 1] - $sigma[$i]) / ($h[$i] + $h[$i + 1]);
    }
    $d[] = null;
    return $d;
}

/**
 * Crea una matriz para resolver el sistema de ecuaciones
 * para desarrollar el método de splines cúbicos
 * @param array $lambda los valores de lambda
 * @param array $miu los valores de mu
 * 
 * @return array una matriz formada con $lambda y $miu
 */
function create_matrix(array $lambda, array $miu)
{
    $matrix = array();
    for ($i = 0; $i < count($lambda) - 2; $i++) {
        $M[] = array();
        for ($j = 0; $j < count($miu) - 2; $j++) {
            if ($i == $j) {
                $matrix[$i][] = 2;
            } else if ($i == $j - 1) {
                $matrix[$i][] = $lambda[$j];
            } else if ($i - 1 == $j) {
                $matrix[$i][] = $miu[$i + 1];
            } else {
                $matrix[$i][] = 0;
            }
        }
    }
    return $matrix;
}

/**
 * Los valores 'M' del método de splines cúbicos.
 * se añade el 0 al inicio y al final de este.
 * @param array $matrix matriz formada por $lambda y $miu
 * @param array $d array de valores d
 * @param bool $thomas true para usar Thomas caso contrario
 * se usará el método de Gauss-Seidel para lo cual se deberá
 * especificar los siguientes parámetros:
 * @param array $aprox aproximación inicial para Seidel
 * @param float $tolerancie tolerancia al error para Seidel
 * @param int $max número máximo de iteraciones para Seidel.
 * 
 * @return array un array con los valores M.
 */
function get_M(array $matrix, array $d, bool $thomas, array $aprox = null, float $tolerance = 1e-15, int $max = 50)
{
    if ($thomas) {
        $sol = thomas_elimination($matrix, array_slice($d, 1));
    } else {
        $sol = gauss_seidel_iterative($matrix, array_slice($d, 1), $aprox, $tolerance, $max);
    }
    $M = array_merge(array(0), $sol);
    return array_merge($M, array(0));
}

/**
 * Los valores 'r' del método de splines cúbicos
 * @param array $M los valores de M
 * @param array $h los valores de h
 * 
 * @return array un array con los valores r
 */
function get_r(array $M, array $h)
{
    $r = array(null);
    for ($i = 1; $i < count($h); $i++) {
        $r[$i] = $M[$i - 1] / (6 * $h[$i]);
    }
    return $r;
}

/**
 * Los valores 'S' del método de splines cúbicos
 * @param array $M los valores de M
 * @param array $h los valores de h
 * 
 * @return array un array con los valores S
 */
function get_S(array $M, array $h)
{
    $S = array(null);
    for ($i = 1; $i < count($h); $i++) {
        $S[$i] = $M[$i] / (6 * $h[$i]);
    }
    return $S;
}

/**
 * Los valores 't' del método de splines cúbicos
 * @param array $y conjunto de valores de y
 * @param array $M los valores de M
 * @param array $h los valores de h
 * 
 * @return array un array con los valores t
 */
function get_t(array $y, array $M, array $h)
{
    $t = array(null);
    for ($i = 1; $i < count($h); $i++) {
        $t[$i] = ($y[$i - 1] - $M[$i - 1] * ($h[$i] ** 2) / 6) / $h[$i];
    }
    return $t;
}


/**
 * Los valores 'U' del método de splines cúbicos
 * @param array $y conjunto de valores de y
 * @param array $M los valores de M
 * @param array $h los valores de h
 * 
 * @return array un array con los valores U
 */
function get_U(array $y, array $M, array $h)
{
    $U = array(null);
    for ($i = 1; $i < count($h); $i++) {
        $U[$i] = ($y[$i] - $M[$i] * ($h[$i] ** 2) / 6) / $h[$i];
    }
    return $U;
}


/**
 * Los valores 'v' del método de splines cúbicos
 * @param array $r los valores de r
 * @param array $S los valores de S
 * 
 * @return array un array con los valores v
 */
function get_v(array $r, array $S)
{
    $v = array(null);
    for ($i = 1; $i < count($S); $i++) {
        $v[] = $S[$i] - $r[$i];
    }
    return $v;
}

/**
 * Los valores 'w' del método de splines cúbicos
 * @param array $x conjunto de valores de x
 * @param array $r los valores de r
 * @param array $S los valores de S
 * 
 * @return array un array con los valores w
 */
function get_w(array $x, array $r, array $S)
{
    $w = array(null);
    for ($i = 1; $i < count($S); $i++) {
        $w[] = 3 * ($r[$i] * $x[$i] - $S[$i] * $x[$i - 1]);
    }
    return $w;
}

/**
 * Los valores 'f' del método de splines cúbicos
 * @param array $x conjunto de valores de x
 * @param array $r los valores de r
 * @param array $S los valores de S
 * @param array $t los valores de t
 * @param array $U los valores de U
 * 
 * @return array un array con los valores f
 */
function get_f(array $x, array $r, array $S, array $t, array $U)
{
    $f = array(null);
    for ($i = 1; $i < count($S); $i++) {
        $f[] = 3 * ($S[$i] * $x[$i - 1] ** 2 - $r[$i] * $x[$i] ** 2) + $U[$i] - $t[$i];
    }
    return $f;
}

/**
 * Los valores 'g' del método de splines cúbicos
 * @param array $x conjunto de valores de x
 * @param array $r los valores de r
 * @param array $S los valores de S
 * @param array $t los valores de t
 * @param array $U los valores de U
 * 
 * @return array un array con los valores g
 */
function get_g(array $x, array $r, array $S, array $t, array $U)
{
    $g = array(null);
    for ($i = 1; $i < count($S); $i++) {
        $g[] = $x[$i] * ($r[$i] * $x[$i] ** 2 + $t[$i]) - $x[$i - 1] * ($S[$i] * $x[$i - 1] ** 2 + $U[$i]);
    }
    return $g;
}

/**
 * Los valores 'f' del método de splines cúbicos
 * @param array $f los valores de f
 * @param array $g los valores de g
 * @param array $v los valores de v
 * @param array $w los valores de w
 * @param string $power símbolo usado para representar la potencia
 * se usará '^' por defecto.
 * 
 * @return array un array con los polinimos de tercer grado
 * Básicamente es la solución del método de splines cúbicos
 */
function get_polynomial(array $f, array $g, array $v, array $w, string $power = "^")
{
    $P = array();
    for ($i = 1; $i < count($f); $i++) {
        $P[] = $v[$i] . "*x" . $power . "3+" . $w[$i] . "*x" . $power . "2+" . $f[$i] . "*x+" . $g[$i];
    }
    return $P;
}

/**
 * Genera un array con todos los valores usados en el método
 * de splines cúbicos. Esto con el objetivo de mostrar estos
 * valores en el frontend de la aplicación.
 * 
 * @param array $x conjunto de valores de x
 * @param array $y conjunto de valores de y
 * @param bool $thomas true para usar Thomas caso contrario
 * se usará el método de Gauss-Seidel para lo cual se deberá
 * especificar los siguientes parámetros:
 * @param array $aprox aproximación inicial para Seidel
 * @param float $tolerance tolerancia al error para Seidel
 * por defecto 1e-15
 * @param int $max número máximo de iteraciones para Seidel.
 * por defecto 50 iteraciones
 * 
 * @return array un array con todo los valores usados
 */
function create_all(array $x, array $y, bool $thomas, array $aprox = null, float $tolerance = 1e-15, int $max = 50)
{
    $h = get_h($x);
    $s = get_sigma($y, $h);
    $l = get_lambda($h);
    $u = get_miu($l);
    $d = get_d($s, $h);

    $matrix = create_matrix($l, $u);
    $M = get_M($matrix, $d, $thomas, $aprox, $tolerance, $max);

    $r = get_r($M, $h);
    $S = get_S($M, $h);
    $t = get_t($y, $M, $h);
    $U = get_U($y, $M, $h);

    $v = get_v($r, $S);
    $w = get_w($x, $r, $S);
    $f = get_f($x, $r, $S, $t, $U);
    $g = get_g($x, $r, $S, $t, $U);

    $P = get_polynomial($f, $g, $v, $w);

    return array($h, $s, $l, $u, $d, $M, $r, $S, $t, $U, $v, $w, $f, $g, $P);
}

/**
 * Genera un string con el script js para generar el gráfico de
 * un conjuntos de datos junto a sus puntos.
 * 
 * @param array $x conjunto de valores de x.
 * @param array $y conjunto de valores de y.
 * @param array $P conjunto de polinomios obtenidos por splines
 * 
 * @return string cadena con función generadora del gráfico.
 */
function generate_graphic_data($x, $y, $P, $k)
{
    $domain = "[" . (min($x) - .1) . "," . (max($x) + .1) . "]";
    $range = "[" . (min($y) - .1) . "," . (max($y) + .1) . "]";

    $function_data = "";
    $point_data = "";
    for ($i = 0; $i < count($P); $i++) {
        $function_data = $function_data . "{ fn: '" . $P[$i] . "', range: [" . $x[$i] . "," . $x[$i + 1] . "], nSamples:" . 10000 . "},";
        $point_data = $point_data . "[" . $x[$i] . "," . $y[$i] . "],";
    }
    $point_data = $point_data . "[" . $x[count($x) - 1] . "," . $y[count($y) - 1] . "],";

    $script =
        "<script>
            'use strict';

            function graph" . $k . "() {
                var functionPlot = window.functionPlot;
                functionPlot({
                    target: '#plot" . $k . "',
                    disableZoom: true,
                    //title: 'Splines cúbicos',
                    //width: 400,
                    //height: 400,
                    yAxis: {
                        domain: " . $range . ",
                        label: 'f(x)'
                    },
                    xAxis: {
                        domain: " . $domain . ",
                        label: 'x'
                    },
                    tip: {
                        renderer: function(x, y) {
                            return '(' + parseFloat(x).toFixed(3) + ', ' + parseFloat(y).toFixed(3) + ')';
                        }
                    },
                    grid: true,
                    data: [" . $function_data . "
                        {
                            points: [
                                " . $point_data . "
                            ],
                            fnType: 'points',
                            graphType: 'scatter',
                            color: 'black',
                            nSamples: 1,
                        }
                    ]
                })
            }
        </script>";
    return $script;
}

/**
 * Genera un string con el script js para generar el gráfico de
 * todos los conjuntos de datos en uno solo.
 * 
 * @param array $x conjunto de valores de x.
 * @param array $y conjunto de conjuntos de valores de y.
 * @param array $P conjunto de polinomios obtenidos por splines
 * para cada conjunto de valores de y.
 * 
 * @return string cadena con función generadora del gráfico.
 */
function generate_multigraphic_data(array $x, array $y, array $P)
{
    $domain = "[" . (min($x) - .1) . "," . (max($x) + .1) . "]";

    $min_y = min($y[0]);
    $max_y =  max($y[0]);

    $function_data = "";

    $colors = array("green", "orange", "red", "indigo", "pink", "teal", "silver");
    shuffle($colors);

    for ($k = 0; $k < count($P); $k++) {
        if (min($y[$k]) < $min_y) {
            $min_y = min($y[$k]);
        }
        if (max($y[$k]) + 1 > $max_y) {
            $max_y = max($y[$k]);
        }
        for ($i = 0; $i < count($P[$k]); $i++) {
            $function_data = $function_data . "{ fn: '" . $P[$k][$i] . "', range: [" . $x[$i] . "," . $x[$i + 1] . "], nSamples:" . 10000 . ", color : '" . $colors[$k] . "'},";
        }
    }
    $range = "[" . ($min_y - .1) . "," . ($max_y + .1) . "]";
    $script =
        "<script>
            'use strict';

            function graph_all() {
                var functionPlot = window.functionPlot;
                functionPlot({
                    target: '#plot',
                    disableZoom: true,
                    //title: 'Splines cúbicos',
                    //width: 400,
                    //height: 400,
                    yAxis: {
                        domain: " . $range . ",
                        label: 'f(x)'
                    },
                    xAxis: {
                        domain: " . $domain . ",
                        label: 'x'
                    },
                    tip: {
                        renderer: function(x, y) {
                            return '(' + parseFloat(x).toFixed(3) + ', ' + parseFloat(y).toFixed(3) + ')';
                        }
                    },
                    grid: true,
                    data: [" . $function_data . "
                    ]
                })
            }
        </script>";
    return $script;
}


/**
 * Obtienes los intervalos para cada polinomio de splines cúbicos
 * 
 * @param array $x el array con los valores de x
 * @return array array de arrays de dos dimensiones con cada intervalo
 */
function get_ranges(array $x)
{
    $ranges = array();
    for ($i = 0; $i < count($x) - 1; $i++) {
        $ranges[] = array($x[$i], $x[$i + 1]);
    }
    return $ranges;
}


/**
 * Obtiene la expresión genérica para GeoGebra
 * ES UNA FUNCION RECURSIVA
 * 
 * @param array $ranges intervalos de cada polinomio
 * @param array $P polinomios obtenidos por splines
 * 
 * @return retorna la expresión a pegar en GeoGebra
 */
function get_slice_function(array $ranges, array $P)
{
    if (!empty($ranges)) {
        list($a, $b) = array_shift($ranges);
        $p = array_shift($P);
        if (empty($ranges)) {
            return "if(" . $a . "&lt;x&lt;=" . $b . "," . $p . ")";
        } else {
            return "if(" . $a . "&lt;x&lt;=" . $b . "," . $p . "," . get_slice_function($ranges, $P) . ")";
        }
    }
    return "";
}
