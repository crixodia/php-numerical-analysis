<?php

function read_CSV(string $filename, bool $has_header = false)
{
    $r = array_map('str_getcsv', file($filename));
    $r = $has_header ? array_shift($r) : $r;
    $x = $y = array();
    for ($i = 0; $i < count($r); $i++) {
        if (!in_array($r[$i][0], array('', ' ', '   '))) {
            list($x[], $y[]) = $r[$i];
        }
    }
    return array($x, $y);
}
