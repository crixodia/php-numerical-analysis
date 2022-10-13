<?php

/**
 * Lee un archivo CSV o TXT y procesa sus datos en arreglos
 * @param string $filename ruta del archivo
 * @param bool $has_header True si el archivo tiene encabezado
 * caso contrario se asume que no tiene encabezado
 * 
 * @return array array en la primera posición los valores de x
 * y en la segunta un array de arrays con los valores de y
 * necesario para generalizar la entrada de datos con varios
 * conjuntos de datos de y
 */
function read_CSV(string $filename, bool $has_header = false)
{
    $r = array_map('str_getcsv', file($filename));
    $r = $has_header ? array_shift($r) : $r;
    $x = $y = array();
    for ($i = 0; $i < count($r); $i++) {
        if (!in_array($r[$i][0], array('', ' ', '   '))) {
            $x[] = $r[$i][0];
            $aux = array_slice($r[$i], 1);
            for ($k = 0; $k < count($aux); $k++) {
                $y[$k][$i] = $aux[$k];
            }
        }
    }
    return array($x, $y);
}
