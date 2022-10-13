<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDO Método de múltiples pasos</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">

    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/function-plot.js"></script>
    <script src="./js/mathjax/tex-mml-chtml.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
</head>

<body onload="">

    <div class="pattern"></div>
    <div class="container">

        <div class="container about pdtop" style="max-width: 800px;">
            <div class="row">
                <div class="col-auto profile-picture pdbot">
                    <img name="profile-picture-img" src="assets/EPN.png" width="150px">
                </div>
                <div class="col-lg text-center">
                    <h5>Escuela Politécnica Nacional</h5>
                    <h6>Facultad de Ingeniería en Sistemas</h6>
                    <h6>Ingeniería en Ciencias de la Computación</h6>
                    <br>
                    <p class="text-justify">
                        <b>Nombre: </b>Cristian Bastidas
                    </p>
                    <p class="text-justify">
                        <b>Asignatura: </b> Métodos Numéricos
                    </p>
                </div>
            </div>
        </div>

        <div class="container pdtop maxwidth-900">
            <div class="accordion" id="accordion_' . $i . '">
                <div class="card bg-light">
                    <h5 class="card-header" style="background-color: #e7f1ff;">EDO Método de múltiples pasos</h5>
                    <div class="card-body">
                        <form action="index.php" enctype="multipart/form-data" method="GET" class="font-monospace">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-auto col-form-label" for="punto_interes">Función</label>
                                    <!--div class="col"-->
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">f(x,y)</span>
                                        <input id="funcion" name="funcion" placeholder="Escriba una función" value=<?php if (!empty($_GET)) {
                                                                                                                        echo $_GET["funcion"];
                                                                                                                    } else {
                                                                                                                        echo "(1/(1+x**2))-2*y**2";
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
                                            <input id="limite_a" name="limite_a" placeholder="0" value=<?php if (!empty($_GET)) {
                                                                                                            echo $_GET["limite_a"];
                                                                                                        } else {
                                                                                                            echo "0";
                                                                                                        } ?> type="number" step="any" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <label class="col col-form-label" for="delta">Superior</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text">b</span>
                                            <input id="limite_b" name="limite_b" placeholder="0.2" value=<?php if (!empty($_GET)) {
                                                                                                                echo $_GET["limite_b"];
                                                                                                            } else {
                                                                                                                echo "0.2";
                                                                                                            } ?> type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <label class="col col-form-label" for="step">x_0</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text">x</span>
                                            <input id="x_init" name="x_init" placeholder="0" value=<?php if (!empty($_GET)) {
                                                                                                        echo $_GET["x_init"];
                                                                                                    } else {
                                                                                                        echo "0";
                                                                                                    } ?> type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <label class="col col-form-label" for="step">y_0</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text">y</span>
                                            <input id="y_init" name="y_init" placeholder="0" value=<?php if (!empty($_GET)) {
                                                                                                        echo $_GET["y_init"];
                                                                                                    } else {
                                                                                                        echo "0";
                                                                                                    } ?> type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <label class="col col-form-label" for="step">N</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text">n</span>
                                            <input id="n_inicial" name="n_inicial" placeholder="4" value=<?php if (!empty($_GET)) {
                                                                                                                echo $_GET["n_inicial"];
                                                                                                            } else {
                                                                                                                echo "4";
                                                                                                            } ?> min="1" type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <label class="col col-form-label" for="step">Tolerancia</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text">ɛ</span>
                                            <input id="tolerancia" name="tolerancia" placeholder="1e-10" value=<?php if (!empty($_GET)) {
                                                                                                                    echo $_GET["tolerancia"];
                                                                                                                } else {
                                                                                                                    echo "1e-10";
                                                                                                                } ?> min="1" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
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
        </div>

        <div class="container pdtop text-break">

            <?php
            if (!empty($_GET)) {
                include('scripts/edo_euler.php');
                list($x, $y, $a, $b, $n, $f, $tolerancia) = array($_GET["x_init"], $_GET["y_init"], $_GET["limite_a"], $_GET["limite_b"], $_GET["n_inicial"], build_xy_function($_GET["funcion"]), $_GET["tolerancia"]);
                list($ans_x, $all_y) = multi_step($x, $y, ($b - $a) / $n, $n, $tolerancia, "edo_euler_improved", $f);
                $header = array('m', 'x_m');
                for ($i = 0; $i < count($all_y); $i++) {
                    $header[] = 'y_{' . $i . ',m}';
                }
            ?>

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
                        for ($i = 0; $i < count($ans_x); $i++) {
                            echo "<tr>";
                            echo "<th class='text-center table-primary' scope ='row'>" . $i . "</th>";
                            echo "<td class='text-end'>" . $ans_x[$i] . "</td>";
                            for ($j = 0; $j < count($all_y); $j++) {
                                echo "<td class='text-end'>" . $all_y[$j][$i] . "</td>";
                            }
                        }
                        echo "</tr>";

                        echo "</table>";
                        ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <h6 class="text-center text-muted pdtop">Cristian Bastidas - EDO: Método de Múltiples Pasos</h6>
</body>

</html>