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
    <title>Ajuste de curvas (Cuadrática)</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>

    <!--script id="MathJax-script" async src="js/tex-mml-chtml.js"></script-->
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
</head>

<body>

    <div class="pattern"></div>
    <div class="container">
        <div class="container pdtop maxwidth-800">
            <div class="accordion" id="accordion_' . $i . '">
                <div class="card bg-light">
                    <h5 class="card-header" style="background-color: #e7f1ff;">Ajuste de curvas (Cuadrática)</h5>
                    <div class="card-body">
                        <form action="index.php" method="GET" class="font-monospace">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-auto col-form-label" for="punto_interes">Valores variable independiente</label>
                                    <!--div class="col"-->
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">X</span>
                                        <input id="X" name="X" placeholder="X real" value=<?php if (!empty($_GET)) {
                                                                                                echo $_GET["X"];
                                                                                            } else {
                                                                                                echo "2,4,6,8";
                                                                                            } ?> type="text" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
                                    </div>
                                    <!--/div-->
                                </div>
                                <div class="row">
                                    <label class="col-auto col-form-label" for="punto_interes">Valores variable dependiente</label>
                                    <!--div class="col"-->
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">Y</span>
                                        <input id="Y" name="Y" placeholder="Y real" value=<?php if (!empty($_GET)) {
                                                                                                echo $_GET["Y"];
                                                                                            } else {
                                                                                                echo "5,15,37,63";
                                                                                            } ?> type="text" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
                                    </div>
                                    <!--/div-->
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-auto col-form-label" for="punto_interes">{a,b,c} inicial para newton multivariable</label>
                                    <!--div class="col"-->
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">{a, b, c}<sub>0</sub></span>
                                        <input id="aprox" name="aprox" placeholder="Indique la aproximación inicial" value=<?php if (!empty($_GET)) {
                                                                                                                                echo $_GET["aprox"];
                                                                                                                            } else {
                                                                                                                                echo "1,1,1";
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
                                                                                                        echo "50";
                                                                                                    } ?> min="10" type="number" step="10" aria-describedby="deltaHelpBlock" required="required" class="form-control">
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
            if (!empty($_GET)) {
                include('scripts/newton.php');
                include('scripts/curve_fitting.php');

                $x_init = explode(',', str_replace(' ', '', $_GET["aprox"]));

                $S = build_quadratic_fit(explode(',', str_replace(' ', '', $_GET["X"])), explode(',', str_replace(' ', '', $_GET["Y"])));

                $variables = get_variables($S);

                $x = multivariable_newton_iterative($S, $variables, $x_init, $_GET["tolerance"], $_GET["iter_max"]);
                $table = multivariable_newton_iterative($S, $variables, $x_init, $_GET["tolerance"], $_GET["iter_max"], true);
            ?>
                <div class="pdbot">
                    <div class="card bg-light">
                        <div class="card-header" style="background-color: #e7f1ff;">Modelo&nbsp;</div>
                        <div class="card-body">
                            $$
                            f(x) =<?php echo $x[0] . "x^2" . ($x[1] < 0 ? "" : "+") . $x[1] . "x" . ($x[2] < 0 ? "" : "+") . $x[2] ?>
                            $$
                        </div>
                    </div>
                </div>

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
    <h6 class="text-center text-muted pdtop">Cristian Bastidas - Tarea ??</h6>
</body>

</html>