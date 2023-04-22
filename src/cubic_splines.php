<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Splines cúbicos</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">

    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/function-plot.js"></script>
    <script src="./js/mathjax/tex-mml-chtml.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>

    <script>
        function showSeidelOptions(value) {
            document.getElementById('n_max_div').style.display = value == 0 ? 'none' : 'block';
            document.getElementById('tolerancia_div').style.display = value == 0 ? 'none' : 'block';
        }
    </script>
</head>

<body onload="graph(); showSeidelOptions(metodo.value)">

    <div class="pattern"></div>
    <div class="container">

        <div class="container pdtop maxwidth-900">
            <div class="accordion" id="accordion_' . $i . '">
                <div class="card bg-light">
                    <h5 class="card-header" style="background-color: #e7f1ff;"><a href="index.php"><img src="assets/left.png" width="24px"></a> Splines cúbicos</h5>
                    <div class="card-body">
                        <form action="cubic_splines.php" enctype="multipart/form-data" method="POST" class="font-monospace">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-auto col-form-label" for="punto_interes">
                                        Archivo CSV con valores (Los pares deben estar ordenados respecto a x).<br>
                                        Archivos de ejemplo:
                                        (<a href="samples/galerkin.csv" download="galerkin.csv">galerkin</a>, 
                                        <a href="samples/s20.csv" download="s20.csv">s20</a>, 
                                        <a href="samples/sample2.csv" download="sample2.csv">sample</a>)
                                    </label>
                                    <!--div class="col"-->
                                    <div class="input-group flex-nowrap">
                                        <input class="form-control" type="file" id="file" name="file">
                                    </div>
                                    <!--/div-->
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label class="col-auto col-form-label" for="metodo">Método</label>
                                        <div class="input-group flex-nowrap">
                                            <select class="form-select" name="metodo" aria-label="Default select example" id="metodo" onchange="showSeidelOptions(this.value)">
                                                <?php $values = array('', '');
                                                if (!empty($_POST)) {
                                                    $values[$_POST["metodo"]] = 'selected';
                                                } ?>
                                                <option value="0" <?php echo $values[0] ?>>Thomas</option>
                                                <option value="1" <?php echo $values[1] ?>>Seidel</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col" id="n_max_div" style="display: none;">
                                        <label class=" col col-form-label" for="step">Iteraciones máximas</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text">n</span>
                                            <input id="n_max" name="n_max" placeholder="50" value=<?php if (!empty($_POST)) {
                                                                                                        echo $_POST["n_max"];
                                                                                                    } else {
                                                                                                        echo "50";
                                                                                                    } ?> min="1" type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col" id="tolerancia_div" style="display: none;">
                                        <label class="col col-form-label" for="step">Tolerancia</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text">ɛ</span>
                                            <input id="tolerancia" name="tolerancia" placeholder="1e-10" value=<?php if (!empty($_POST)) {
                                                                                                                    echo $_POST["tolerancia"];
                                                                                                                } else {
                                                                                                                    echo "1e-10";
                                                                                                                } ?> min="1" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="m-0" style="padding-top: 10px;">
                                <button name="submit" type="submit" class="btn btn-primary">Modelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container pdtop text-break maxwidth-900">

            <?php
            $uploaded = false;
            include('scripts/upload.php');
            include('scripts/splines.php');
            include('scripts/csv_file.php');
            $graph_s = "<script>function graph(){";
            if ($uploaded) {
                list($x, $y) = read_CSV($_SERVER['DOCUMENT_ROOT'] . "//src//files//custom.csv");
                $all_poly = array();
                $ranges = get_ranges($x);
                echo '<div class="pdbot">
                <div class="card bg-light">
                    <div class="card-header" style="background-color: #e7f1ff;"><h6>Todas las curvas</h6></div>
                    <div class="card-body plot-card">
                        <div id="plot" class="d-flex justify-content-center"></div>
                    </div>
                </div>
            </div>';
                for ($k = 0; $k < count($y); $k++) {

                    list($h, $s, $l, $u, $d, $M, $r, $S, $t, $U, $v, $w, $f, $g, $P) = create_all($x, $y[$k], $_POST["metodo"] == 0, array_fill(0, count($x) - 2, 1), $_POST["tolerancia"], $_POST["n_max"]);
                    $all_poly[] = $P;
                    echo generate_graphic_data($x, $y[$k], $P, $k);
                    $header = array("i", "x_i", "y_i", "h_i", "\sigma_i", "\lambda_i", "\mu_i", "d_i", "M_i");
                    $header2 = array("i", "r_i", "s_i", "t_i", "u_i", "v_i", "w_i", "f_i", "g_i");
            ?>
                    <hr>
                    <div class="pdbot">
                        <div class="card bg-light">
                            <div class="card-header" style="background-color: #e7f1ff;">
                                <h5>Conjunto de datos <?php echo $k + 1 ?></h5>
                            </div>
                            <div class="card-body plot-card">
                                <div id="plot<?php echo $k ?>" class="d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                    <div class="pdbot">
                        <div class="card bg-light">
                            <div class="card-header" style="background-color: #e7f1ff;">Polinomios</div>
                            <div class="card-body font-monospace">
                                <?php
                                for ($i = 0; $i < count($P); $i++) {
                                    echo chr(102 + $i) . "(x) = " . str_replace("+-", "-", $P[$i]) . "<br>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="pdbot">
                        <div class="card bg-light">
                            <div class="card-header" style="background-color: #e7f1ff;">Compresión en una sola expresión</div>
                            <div class="card-body font-monospace">
                                <?php
                                echo get_slice_function($ranges, $P);
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="pdbot">
                        <table class="table container table-light table-hover table-bordered font-monospace">
                            <thead>
                                <?php
                                for ($i = 0; $i < count($header); $i++) {
                                    echo "<th scope='col' class='text-center table-primary'>\(" . $header[$i] . "\)</th>";
                                }
                                ?>
                            </thead>
                            <?php
                            for ($i = 0; $i < count($x); $i++) {
                                echo "<tr>";
                                echo "<th class='text-center table-primary' scope ='row'>" . $i . "</th>";
                                echo "<td class='text-end'>" . $x[$i] . "</td>";
                                echo "<td class='text-end'>" . $y[$k][$i] . "</td>";
                                echo "<td class='text-end'>" . $h[$i] . "</td>";
                                echo "<td class='text-end'>" . $s[$i] . "</td>";
                                echo "<td class='text-end'>" . $l[$i] . "</td>";
                                echo "<td class='text-end'>" . $u[$i] . "</td>";
                                echo "<td class='text-end'>" . $d[$i] . "</td>";
                                echo "<td class='text-end'>" . $M[$i] . "</td>";
                            }
                            echo "</tr>";

                            echo "</table>";
                            ?>
                    </div>

                    <div class="pdbot">
                        <table class="table container table-light table-hover table-bordered font-monospace">
                            <thead>
                                <?php
                                for ($i = 0; $i < count($header2); $i++) {
                                    echo "<th scope='col' class='text-center table-primary'>\(" . $header2[$i] . "\)</th>";
                                }
                                ?>
                            </thead>
                            <?php
                            error_reporting(E_ERROR | E_PARSE);

                            for ($i = 1; $i < count($x); $i++) {
                                echo "<tr>";
                                echo "<th class='text-center table-primary' scope ='row'>" . $i . "</th>";
                                echo "<td class='text-end'>" . round($r[$i], 5) . "</td>";
                                echo "<td class='text-end'>" . round($s[$i], 5) . "</td>";
                                echo "<td class='text-end'>" . round($t[$i], 5) . "</td>";
                                echo "<td class='text-end'>" . round($u[$i], 5) . "</td>";
                                echo "<td class='text-end'>" . round($v[$i], 5) . "</td>";
                                echo "<td class='text-end'>" . round($w[$i], 5) . "</td>";
                                echo "<td class='text-end'>" . round($f[$i], 5) . "</td>";
                                echo "<td class='text-end'>" . round($g[$i], 5) . "</td>";
                            }
                            echo "</tr>";

                            echo "</table>";
                            ?>
                    </div>
            <?php $graph_s = $graph_s . "graph" . $k . "();";
                    echo generate_multigraphic_data($x, $y, $all_poly);
                }
            }

            $graph_s = $graph_s  . "graph_all() ;}</script>";
            ?>
        </div>
    </div>
    <br>
    <h6 class="text-center text-muted"><a href="https://github.com/crixodia?tab=repositories" target="_blank">Cristian Bastidas</a></h6>
    <br>
    <?php echo $graph_s; ?>
</body>

</html>