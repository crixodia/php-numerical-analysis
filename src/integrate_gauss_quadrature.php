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
    <title>Cuadratura de Gauss - Cristian Bastidas</title>

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/custom.css">

    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
</head>

<body>

    <div class="pattern"></div>
    <div class="container">

        <div class="container about pdtop" style="max-width: 700px;">
            <div class="row">
                <div class="col-auto profile-picture pdbot">
                    <img name="profile-picture-img" src="https://upload.wikimedia.org/wikipedia/commons/8/8c/Escudo_de_la_Escuela_Polit%C3%A9cnica_Nacional.png" width="150px">
                </div>
                <div class="col-lg text-center">
                    <h5>Escuela Politécnica Nacional</h5>
                    <h6>Facultad de Ingeniería en Sistemas</h6>
                    <h6>Ingeniería en Ciencias de la Computación</h6>
                    <br>
                    <p class="text-justify">
                        <b>Nombre: </b>Cristian Bastidas &nbsp;&nbsp;&nbsp;<b>Asignatura: </b> Métodos Numéricos
                    </p>
                </div>
            </div>
        </div>
        <div class="container pdtop maxwidth-700">
            <div class="card bg-light">
                <h5 class="card-header" style="background-color: #e7f1ff;">Cuadratura de Gauss</h5>

                <div class="card-body">
                    <form action="index.php" method="GET" class="font-monospace">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-auto col-form-label" for="punto_interes">Función</label>
                                <!--div class="col"-->
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text">f(x)</span>
                                    <input id="funcion" name="funcion" placeholder="Escriba una función" value=<?php if (!empty($_GET)) {
                                                                                                                    echo $_GET["funcion"];
                                                                                                                } else {
                                                                                                                    echo "e^x";
                                                                                                                } ?> type="text" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
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
                                        <input id="limite_a" name="limite_a" placeholder="1" value=<?php if (!empty($_GET)) {
                                                                                                        echo $_GET["limite_a"];
                                                                                                    } else {
                                                                                                        echo "1";
                                                                                                    } ?> type="number" step="any" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col col-form-label" for="delta">Superior</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">b</span>
                                        <input id="limite_b" name="limite_b" placeholder="7" value=<?php if (!empty($_GET)) {
                                                                                                        echo $_GET["limite_b"];
                                                                                                    } else {
                                                                                                        echo "7";
                                                                                                    } ?> type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col col-form-label" for="step">Tolerancia</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">ε</span>
                                        <input id="tolerancia" name="tolerancia" placeholder="1e-15" value=<?php if (!empty($_GET)) {
                                                                                                                echo $_GET["tolerancia"];
                                                                                                            } else {
                                                                                                                echo "1e-10";
                                                                                                            } ?> type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col col-form-label" for="step">Grado</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">n</span>
                                        <input id="grado" name="grado" placeholder="10" value=<?php if (!empty($_GET)) {
                                                                                                    echo $_GET["grado"];
                                                                                                } else {
                                                                                                    echo "5";
                                                                                                } ?> type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
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
                include('scripts/integracion.php');

                $title = ["k", "w[k]", "x[k]", "suma[k]", "I[k]"];
                $table = gauss_quadrature_iterative(MakeFunction($_GET["funcion"]), $_GET["limite_a"], $_GET["limite_b"], $_GET["grado"], $_GET["tolerancia"]);

            ?>
                <div class="pdbot">
                    <div class="card bg-light">
                        <div class="card-header" style="background-color: #e7f1ff;">Valores</div>
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

                $i = 0;
                echo '<div class="alert alert-info d-flex align-items-center" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg><div>Haz clic en el grado del polinomio para ver su tabla de iteraciones.';
                echo '</div></div>';
                echo '<div class="accordion" id="accordion_' . $i . '">';
                foreach ($table as $interval_table) {
                    $i++;
                    echo '<div class="accordion-item">';
                    echo '<h2 class="accordion-header" id="acc_' . $i . '_open">';
                    echo '<button class="accordion-button collapsed font-monospace" type="button" data-bs-toggle="collapse" data-bs-target="#acc_' . $i . '_close" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">';
                    echo 'Polinomio de Legendre de grado ' . $i;
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
                                    echo "<th class='text-center table-primary' scope ='row'>" . $value + 1 . "</th>";
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
            } ?>
        </div>
    </div>
    <h6 class="text-center text-muted pdtop">Tarea 7 - Cristian Bastidas</h6>
</body>

</html>