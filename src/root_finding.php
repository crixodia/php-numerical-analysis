<!DOCTYPE html>
<html lang="en">
<!--
    Escuela Politécnica Nacional
    Cristian Bastidas
-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda de raíces</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
</head>

<body>

    <div class="pattern"></div>
    <div class="container">
        <div class="container pdtop maxwidth-700">
            <div class="card bg-light">
                <h5 class="card-header" style="background-color: #e7f1ff;"><a href="index.php"><img src="assets/left.png" width="24px"></a> Búsqueda de Raíces - Todos los métodos</h5>

                <div class="card-body">
                    <form action="root_finding.php" method="GET" class="font-monospace">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-auto col-form-label" for="punto_interes">Función</label>
                                <!--div class="col"-->
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text">f(x)</span>
                                    <input id="funcion" name="funcion" placeholder="Escriba una función" value=<?php if (!empty($_GET)) {
                                                                                                                    echo $_GET["funcion"];
                                                                                                                } else {
                                                                                                                    echo "cos(x)";
                                                                                                                } ?> type="text" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
                                </div>
                                <!--/div-->
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-auto col-form-label" for="metodo">Método</label>
                                <!--div class="col"-->
                                <div class="input-group flex-nowrap">
                                    <select class="form-select" name="metodo" aria-label="Default select example">
                                        <?php $values = array('', '', '', '', '');
                                        if (!empty($_GET)) {

                                            $values[$_GET["metodo"]] = 'selected';
                                        } ?>
                                        <option value="0" <?php echo $values[0] ?>>Bisección</option>
                                        <option value="1" <?php echo $values[1] ?>>Newton</option>
                                        <option value="2" <?php echo $values[2] ?>>Secante</option>
                                        <option value="3" <?php echo $values[3] ?>>Secante - Bisección</option>
                                        <option value="4" <?php echo $values[4] ?>>Aproximaciones Sucesivas</option>
                                    </select>
                                </div>
                                <!--/div-->
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label class="col col-form-label" for="punto_interes">Inferior</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">a</span>
                                        <input id="limite_a" name="limite_a" placeholder="-1" value=<?php if (!empty($_GET)) {
                                                                                                        echo $_GET["limite_a"];
                                                                                                    } else {
                                                                                                        echo "10";
                                                                                                    } ?> type="number" step="any" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col col-form-label" for="delta">Superior</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">b</span>
                                        <input id="limite_b" name="limite_b" placeholder="1" value=<?php if (!empty($_GET)) {
                                                                                                        echo $_GET["limite_b"];
                                                                                                    } else {
                                                                                                        echo "30";
                                                                                                    } ?> type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col col-form-label" for="step">Tolerancia</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">ε</span>
                                        <input id="tolerancia" name="tolerancia" placeholder="1e-10" value=<?php if (!empty($_GET)) {
                                                                                                                echo $_GET["tolerancia"];
                                                                                                            } else {
                                                                                                                echo "1e-10";
                                                                                                            } ?> type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col col-form-label" for="step">Subintervalos</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">n</span>
                                        <input id="n_inicial" name="n_inicial" placeholder="4" value=<?php if (!empty($_GET)) {
                                                                                                            echo $_GET["n_inicial"];
                                                                                                        } else {
                                                                                                            echo "4";
                                                                                                        } ?> min="1" type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-0" style="padding-top: 10px;">
                            <button name="submit" type="submit" class="btn btn-primary">Calcular</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container pdtop maxwidth-900">
            <?php
            if (!empty($_GET)) {

                /*ini_set('error_prepend_string', "<div class='alert alert-info align-items-center'><h3>Posible división por cero 🤷‍♀️</h3>");
                ini_set('error_append_string', "</div>");
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 0);
                error_reporting(E_ALL);*/

                include('scripts/raices.php');

                $funcion = makeFunction($_GET["funcion"]);
                $go_forward = false;
                try {
                    switch ($_GET["metodo"]) {
                        case 0: //Biseccion
                            $title = ["k", "a[k]", "b[k]", "c[k]", "f(c[k])"];
                            $header = "- Método: Bisección";
                            $table = interval_bisection($funcion, $_GET["limite_a"], $_GET["limite_b"], $_GET["n_inicial"], $_GET["tolerancia"]);
                            break;
                        case 1: //Newton
                            $title = ["k", "x[k]", "error", "x[k+1]", "f(x[k+1])"];
                            $header = "- Método: Newton";
                            $table = interval_newton($funcion, $_GET["limite_a"], $_GET["limite_b"], $_GET["n_inicial"], $_GET["tolerancia"]);
                            break;
                        case 2: //Secante
                            $title = ["k", "x[k-1]", "x[k]", "x[k+1]", "f(x[k+1])"];
                            $header = "- Método Secante";
                            $table = interval_secante($funcion, $_GET["limite_a"], $_GET["limite_b"], $_GET["n_inicial"], $_GET["tolerancia"]);
                            break;
                        case 3: //Secante - Biseccion
                            $title = ["k", "a[k]", "b[k]", "c[k]", "f(c[k])"];
                            $header = "- Método: Secante - Bisección";
                            $table = interval_secante_bisect($funcion, $_GET["limite_a"], $_GET["limite_b"], $_GET["n_inicial"], $_GET["tolerancia"]);
                            break;
                        case 4: //Aproximaciones Sucesivas
                            $title = ["k", "x[k]", "x[k+1]", "f(x[k])", "f(x[k+1])"];
                            $header = "- Método: Aproximaciones Sucesivas";
                            $table = interval_aproximaciones_sucesivas($funcion, $_GET["limite_a"], $_GET["limite_b"], $_GET["n_inicial"], $_GET["tolerancia"]);
                            break;
                    }
                    $go_forward = true;
                } catch (Error $e) {
                    echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <div>
                        Error, posible división por cero en el intervalo especificado. Intenta cambiando el número de subintervalos.
                    </div>
                </div>';
                    $go_forward = false;
                }
            ?>
                <div class="pdbot">
                    <div class="card bg-light">
                        <div class="card-header" style="background-color: #e7f1ff;">Valores <?php echo $header ?></div>
                        <div class="card-body">
                            <div class="row">
                                <h6 class="col text-center font-monospace">f(x) = <?php echo $_GET["funcion"]; ?></h6>
                                <h6 class="col text-center font-monospace">a = <?php echo $_GET["limite_a"]; ?></h6>
                                <h6 class="col text-center font-monospace">b = <?php echo $_GET["limite_b"]; ?></h6>
                                <h6 class="col text-center font-monospace">ε = <?php echo $_GET["tolerancia"]; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="container text-break maxwidth-900">
        <?php
                if ($go_forward) {
                    $i = 0;
                    echo '<div class="alert alert-info d-flex align-items-center" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg><div>Haz clic en los subintervalos para ver su tabla de iteraciones.';
                    if ($_GET["metodo"] == 1) {
                        echo '<br>
                            El indicador <span class="badge rounded-pill bg-danger">FINALIZADO</span> en algún subintervalo quiere decir que el método se tuvo que finalizar abruptamente.
                        ';
                    }
                    echo '</div></div>';
                    echo '<div class="accordion" id="accordion_' . $i . '">';
                    foreach ($table as $interval_table) {
                        $i++;
                        echo '<div class="accordion-item">';
                        echo '<h2 class="accordion-header" id="acc_' . $i . '_open">';
                        echo '<button class="accordion-button collapsed font-monospace" type="button" data-bs-toggle="collapse" data-bs-target="#acc_' . $i . '_close" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">';
                        echo 'Subintervalo ' . $i . ' = [' . round($interval_table[0][0], 3) . ',' . round($interval_table[0][1], 3) . "]";
                        if (count($interval_table) == 2) {
                            echo ', &nbsp;<strong>Raíz en x = ' . round($interval_table[1][count($interval_table[1]) - 1][3], 9) . '</strong>';
                            if ($interval_table[1][count($interval_table[1]) - 1][2] > $_GET["tolerancia"] and $_GET["metodo"] == 1) {
                                echo '&nbsp;<span class="badge rounded-pill bg-danger">FINALIZADO</span>';
                            }
                        } else {
                            echo ', No se encontró un cambio de signo.';
                        }
                        echo '</button></h2>';
                        echo '<div id="acc_' . $i . '_close" class="accordion-collapse collapse" aria-labelledby="acc_' . $i . '_open">';
                        echo '<div class="accordion-body">';
                        if (count($interval_table) == 2) {
                            echo '<table class="table container table-light table-hover table-bordered font-monospace"><thead>';
                            foreach ($title as $head) {
                                echo "<th scope='col' class='text-center table-primary'>" . $head . "</th>";
                            }
                            echo '</thead>';
                            $counter = 0;
                            foreach ($interval_table[1] as $line) {
                                echo "<tr>";
                                foreach ($line as $value) {
                                    if ($counter == 0) {
                                        echo "<th class='text-center table-primary' scope ='row'>" . $value . "</th>";
                                    } else {
                                        echo "<td class='text-end'>" . $value . "</td>";
                                    }
                                    if ($counter > 3) {
                                        $counter = 0;
                                    } else {
                                        $counter++;
                                    }
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {
                            echo '<div class="text-center container interval-error"><p>No se encontró cambio de signo para este intervalo</p>';
                            echo '<img src="/img/sad.png">';
                            echo '<h5 class="font-monospace">f(' . $interval_table[0][0] . ')*f(' . $interval_table[0][1] . ')>0</h5></div>';
                        }
                        echo '</div></div></div>';
                    }
                    echo '</div>';
                }
            } ?>
        </div>
    </div>
    <br>
    <h6 class="text-center text-muted"><a href="https://github.com/crixodia?tab=repositories" target="_blank">Cristian Bastidas</a></h6>
    <br>
</body>

</html>