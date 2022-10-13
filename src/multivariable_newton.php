<!DOCTYPE html>
<html lang="en">
<!--
    Escuela Politécnica Nacional
    Facultad de Ingeniería en Sistemas
    Carrera de Ingeniería en Ciencias de la Computación
    Métodos Numéricos
    Método de Newton Multivariable

    Grupo 1
-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Método de Newton Multivariable</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>

    <script id="MathJax-script" async src="js/tex-mml-chtml.js"></script>
</head>

<body>

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
                        <b>Nombres: </b>Andrés Albarracín, Leornardo Andrade, Cristian Bastidas, Ricardo Barros.
                    </p>
                    <p class="text-justify">
                        <b>Asignatura: </b> Métodos Numéricos
                    </p>
                </div>
            </div>
        </div>

        <div class="container pdtop maxwidth-800">
            <div class="accordion" id="accordion_' . $i . '">
                <div class="card bg-light">
                    <h5 class="card-header" style="background-color: #e7f1ff;">Método de Newton Multivariable</h5>
                    <div class="card-body">
                        <form action="index.php" method="GET" class="font-monospace">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-auto col-form-label" for="punto_interes">Función escalar</label>
                                    <!--div class="col"-->
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">f(X)</span>
                                        <input id="function" name="function" placeholder="Indique un campo escalar" value=<?php if (!empty($_GET)) {
                                                                                                                                echo $_GET["function"];
                                                                                                                            } else {
                                                                                                                                echo "x**2+y**2+z**2";
                                                                                                                            } ?> type="text" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
                                    </div>
                                    <!--/div-->
                                </div>
                                <div class="row">
                                    <label class="col-auto col-form-label" for="punto_interes">Aproximación inicial</label>
                                    <!--div class="col"-->
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">X<sub>0</sub></span>
                                        <input id="aprox" name="aprox" placeholder="Indique la aproximación inicial" value=<?php if (!empty($_GET)) {
                                                                                                                                echo $_GET["aprox"];
                                                                                                                            } else {
                                                                                                                                echo "5,5,5";
                                                                                                                            } ?> type="text" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
                                    </div>
                                    <!--/div-->
                                </div>



                            </div>

                            <div class="row">
                                <div class="col">
                                    <label class="col col-form-label" for="step">Tolerancia</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">ε</span>
                                        <input id="tolerance" name="tolerance" placeholder="1e-15" value=<?php if (!empty($_GET)) {
                                                                                                                echo $_GET["tolerance"];
                                                                                                            } else {
                                                                                                                echo "1e-14";
                                                                                                            } ?> type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col col-form-label" for="step">Máximo iteraciones</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">n</span>
                                        <input id="iter_max" name="iter_max" placeholder="50" value=<?php if (!empty($_GET)) {
                                                                                                        echo $_GET["iter_max"];
                                                                                                    } else {
                                                                                                        echo "20";
                                                                                                    } ?> min="10" type="number" step="10" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="m-0" style="padding-top: 10px;">
                                <button name="submit" type="submit" class="btn btn-primary">Encontrar mínimo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="container pdtop text-break maxwidth-900">

            <?php
            if (!empty($_GET)) {
                include('scripts/newton.php');

                $x_init = explode(',', str_replace(' ', '', $_GET["aprox"]));
                $variables = get_variables($_GET["function"]);

                $x = multivariable_newton_iterative($_GET["function"], $variables, $x_init, $_GET["tolerance"], $_GET["iter_max"]);
                $table = multivariable_newton_iterative($_GET["function"], $variables, $x_init, $_GET["tolerance"], $_GET["iter_max"], true);
            ?>
                <div class="pdbot">
                    <div class="card bg-light">
                        <div class="card-header" style="background-color: #e7f1ff;">Mínimo aproximado en:&nbsp;
                            <?php
                            for ($i = 0; $i < count($x); $i++) {
                                echo  '\(' . $variables[$i] . '=' . $x[$i] . '\)&nbsp;&nbsp;&nbsp;';
                            }
                            ?>
                            <span class="badge position-absolute end-0 me-2 rounded-pill <?php echo $_GET["iter_max"] <= count($table) ? "bg-danger" : "bg-primary"; ?>"> <?php echo count($table); ?></span>
                        </div>
                        <div class="card-body">
                            $$\begin{bmatrix}
                            <?php
                            for ($i = 0; $i < count($variables); $i++) {
                                echo  $variables[$i] . '\\' . '\\';
                            }
                            ?>
                            \end{bmatrix}
                            =
                            \begin{bmatrix}
                            <?php
                            for ($i = 0; $i < count($x); $i++) {
                                echo  $x[$i] . '\\' . '\\';
                            }
                            ?>
                            \end{bmatrix}
                            $$
                        </div>
                    </div>
                </div>

                <div class="pdbot">
                    <table class="table container table-light table-hover table-bordered font-monospace">
                        <thead>
                            <?php
                            for ($i = 0; $i < count($variables) + 1; $i++) {
                                echo "<th scope='col' class='text-center table-primary'>\(" . ($i == 0 ? "i" : $variables[$i - 1]) . "\)</th>";
                            }
                            ?>
                        </thead>
                        <?php
                        for ($i = 0; $i < count($table); $i++) {
                            echo "<tr>";
                            echo "<th class='text-center table-primary' scope ='row'>" . ($i + 1) . "</th>";
                            for ($j = 0; $j < count($table[$i]); $j++) {
                                echo "<td class='text-end'>" . $table[$i][$j] . "</td>";
                            }
                        }
                        echo "</tr>";

                        echo "</table>";
                        ?>

                </div>
            <?php } ?>
        </div>
    </div>
    <h6 class="text-center text-muted pdtop">Grupo 1 - Andrés Albarracín, Leonardo Andrade, Cristian Bastidas, Ricardo Barros</h6>
</body>

</html>