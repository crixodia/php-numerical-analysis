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
    <title>Integración Numérica - Cristian Bastidas</title>

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/custom.css">

    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
</head>

<body>
    <div class="pattern"></div>
    <div class="container">

        <div class="container pdtop maxwidth-700">
            <div class="card bg-light">
                <h5 class="card-header" style="background-color: #f8d7da;"><a href="index.php"><img src="assets/left.png" width="24px"></a> Integración Numérica: Regla de Simpson</h5>

                <div class="card-body">
                    <form action="./integrate_simpson.php" method="GET" class="font-monospace">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-auto col-form-label" for="punto_interes">Función</label>
                                <!--div class="col"-->
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text">f(x)</span>
                                    <input id="funcion" name="funcion" placeholder="Escriba una función" value=<?php if (!empty($_GET)) {
                                                                                                                    echo $_GET["funcion"];
                                                                                                                } else {
                                                                                                                    echo "1/(1+x^2)";
                                                                                                                } ?> type="text" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
                                </div>
                                <!--/div-->
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label class="col col-form-label" for="punto_interes">Límite inferior</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">a</span>
                                        <input id="limite_a" name="limite_a" placeholder="-1" value=<?php if (!empty($_GET)) {
                                                                                                        echo $_GET["limite_a"];
                                                                                                    } else {
                                                                                                        echo "0";
                                                                                                    } ?> type="number" step="any" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col col-form-label" for="delta">Límite superior</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">b</span>
                                        <input id="limite_b" name="limite_b" placeholder="1" value=<?php if (!empty($_GET)) {
                                                                                                        echo $_GET["limite_b"];
                                                                                                    } else {
                                                                                                        echo "10";
                                                                                                    } ?> type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col col-form-label" for="step">Tolerancia</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">ε</span>
                                        <input id="tolerancia" name="tolerancia" placeholder="1e-5" value=<?php if (!empty($_GET)) {
                                                                                                                echo $_GET["tolerancia"];
                                                                                                            } else {
                                                                                                                echo "1e-5";
                                                                                                            } ?> type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col col-form-label" for="step">n inicial</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">n</span>
                                        <input id="n_inicial" name="n_inicial" placeholder="4" value=<?php if (!empty($_GET)) {
                                                                                                            echo $_GET["n_inicial"];
                                                                                                        } else {
                                                                                                            echo "2";
                                                                                                        } ?> type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-0" style="padding-top: 10px;">
                            <button name="submit" type="submit" class="btn btn-danger">Calcular</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container pdtop maxwidth-700">
            <?php
            if (!empty($_GET)) {
                include('./scripts/integracion.php');

                $title = ["k", "I[k-1]", "error", "n", "I[k]"];

                $funcion = makeFunction($_GET["funcion"]);
                $table = i_iterative_simpson($funcion, $_GET["limite_a"], $_GET["limite_b"], $_GET["tolerancia"], $_GET["n_inicial"]);

                $integrales = $table[count($table) - 1];
                $ultima_integral = $table[count($table) - 1][count($integrales) - 1];
            ?>
                <div class="pdbot">
                    <div class="card bg-light">
                        <div class="card-header" style="background-color: #f8d7da;">Valores</div>
                        <div class="card-body">
                            <div class="row">
                                <h6 class="col text-center font-monospace">f(x) = <?php echo $_GET["funcion"]; ?></h6>
                                <h6 class="col text-center font-monospace">a = <?php echo $_GET["limite_a"]; ?></h6>
                                <h6 class="col text-center font-monospace">b = <?php echo $_GET["limite_b"]; ?></h6>
                                <h6 class="col text-center font-monospace">ε = <?php echo $_GET["tolerancia"]; ?></h6>
                            </div>
                        </div>
                        <div class="card-footer text-center font-monospace">
                            <b>I(f,<?php echo $_GET["limite_a"] . "," . $_GET["limite_b"]; ?>) ≈ <?php echo round($ultima_integral, 6); ?></b>
                        </div>
                        <div class="card-footer text-center font-monospace">
                            <p>Tolerancia alcanzada en <b><?php echo count($table) ?></b> intervalos</p>
                        </div>
                    </div>
                </div>
        </div>
        <div class="container text-break maxwidth-700">
        <?php
                echo '<table class="table container table-light table-hover table-bordered font-monospace"><thead>';
                foreach ($title as $head) {
                    echo "<th scope='col' class='text-center table-danger'>" . $head . "</th>";
                }
                echo '</thead>';
                $counter = 0;
                foreach ($table as $line) {
                    echo "<tr>";
                    foreach ($line as $value) {
                        if ($counter == 0) {
                            echo "<th class='text-center table-danger' scope ='row'>" . $value . "</th>";
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
            }
        ?>

        </div>
    </div>
    <br>
    <h6 class="text-center text-muted"><a href="https://github.com/crixodia?tab=repositories" target="_blank">Cristian Bastidas</a></h6>
    <br>
</body>

</html>