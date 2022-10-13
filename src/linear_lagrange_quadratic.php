<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interpolaciones</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">

    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/function-plot.js"></script>
    <script src="./js/mathjax/tex-mml-chtml.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
</head>

<body onload="graph();graph1();graph2();">

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
                    <h5 class="card-header" style="background-color: #e7f1ff;">Interpolaciones</h5>
                    <div class="card-body">
                        <form action="index.php" enctype="multipart/form-data" method="POST" class="font-monospace">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-auto col-form-label" for="punto_interes">Archivo CSV con valores (Los pares deben estar ordenados respecto a x)</label>
                                    <!--div class="col"-->
                                    <div class="input-group flex-nowrap">
                                        <input class="form-control" type="file" id="file" name="file">
                                    </div>
                                    <!--/div-->
                                </div>
                            </div>
                            <div class="m-0" style="padding-top: 10px;">
                                <button name="submit" type="submit" class="btn btn-primary">Interpolar</button>
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
            include('scripts/csv_file.php');
            include('scripts/quad_inter.php');
            include('scripts/lineal_inter.php');
            include('scripts/lagrange_inter.php');

            if ($uploaded) {
                list($x, $y) = read_CSV($_SERVER['DOCUMENT_ROOT'] . "//files//custom.csv");

                $linear_poly = linear_interpolation($x, $y);
                echo gen_graphic_linear($x, $y, $linear_poly);

                $quad_poly = quadratic_interpolation($x, $y);
                echo gen_graphic_quadratic($x, $y, $quad_poly);

                $lagrange_poly = lagrange_interpolation($x, $y, l_set($x, $y));
                echo gen_graphic_lagrange($x, $y, $lagrange_poly);
            ?>

                <div class="pdbot">
                    <div class="card bg-light">
                        <div class="card-header" style="background-color: #e7f1ff;">Interpolación lineal</div>
                        <div class="card-body plot-card">
                            <div id="linear" class="d-flex justify-content-center"></div>
                        </div>
                    </div>
                </div>

                <div class="pdbot">
                    <div class="card bg-light">
                        <div class="card-header" style="background-color: #e7f1ff;">Lineal</div>
                        <div class="card-body font-monospace">
                            <?php
                            for ($i = 0; $i < count($linear_poly); $i++) {
                                echo chr(102 + $i) . "(x) = " . str_replace("+-", "-", $linear_poly[$i]) . "<br>";
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="pdbot">
                    <div class="card bg-light">
                        <div class="card-header" style="background-color: #e7f1ff;">Interpolación cuadrática</div>
                        <div class="card-body plot-card">
                            <div id="quadratic" class="d-flex justify-content-center"></div>
                        </div>
                    </div>
                </div>

                <div class="pdbot">
                    <div class="card bg-light">
                        <div class="card-header" style="background-color: #e7f1ff;">Cuadrática</div>
                        <div class="card-body font-monospace">
                            <?php
                            for ($i = 0; $i < count($quad_poly); $i++) {
                                echo chr(102 + $i) . "(x) = " . str_replace("+-", "-", $quad_poly[$i]) . "<br>";
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="pdbot">
                    <div class="card bg-light">
                        <div class="card-header" style="background-color: #e7f1ff;">Interpolación de Lagrange</div>
                        <div class="card-body plot-card">
                            <div id="lagrange" class="d-flex justify-content-center"></div>
                        </div>
                    </div>
                </div>

                <div class="pdbot">
                    <div class="card bg-light">
                        <div class="card-header" style="background-color: #e7f1ff;">Lagrange</div>
                        <div class="card-body font-monospace">
                            <?php
                            echo "f(x) = " . str_replace("+-", "-", $lagrange_poly) . "<br>";
                            ?>
                        </div>
                    </div>
                </div>
        </div>
    <?php } ?>
    </div>
    </div>
    <h6 class="text-center text-muted pdtop">Cristian Bastidas - Tarea 16</h6>
</body>

</html>