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
    <title>Eliminación y LU - Cristian Bastidas</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script type="text/x-mathjax-config">
        MathJax.Hub.Config({"HTML-CSS": { preferredFont: "TeX", availableFonts: ["STIX","TeX"] },
            tex2jax: { inlineMath: [ ["$", "$"], ["\\\\(","\\\\)"] ], displayMath: [ ["$$","$$"], ["\\[", "\\]"] ], processEscapes: true, ignoreClass: "tex2jax_ignore|dno" },
            TeX: { noUndefined: { attributes: { mathcolor: "red", mathbackground: "#FFEEEE", mathsize: "90%" } } },
            messageStyle: "none"
        });
    </script>
</head>

<body>

    <div class="pattern"></div>
    <div class="container">

        <div class="container pdtop maxwidth-700">
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                </svg>
                <div>Ingrese las columnas de la matriz separadas por coma ( , ) y las filas por ( ; ). Para el vector de soluciones ingrese sus valores separados por coma ( , ).
                </div>
            </div>
            <div class="accordion" id="accordion_' . $i . '">
                <div class="card bg-light">
                    <h5 class="card-header" style="background-color: #e7f1ff;"><a href="index.php"><img src="assets/left.png" width="24px"></a> Eliminación Guassiana y Descomposición LU</h5>
                    <div class="card-body">
                        <form action="lu_decomposition_gaussian_elimination.php" method="GET" class="font-monospace">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-auto col-form-label" for="punto_interes">Matriz</label>
                                    <!--div class="col"-->
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">A</span>
                                        <input id="matriz" name="matriz" placeholder="Escriba la matriz de coeficientes" value=<?php if (!empty($_GET)) {
                                                                                                                                    echo $_GET["matriz"];
                                                                                                                                } else {
                                                                                                                                    echo "3,2,3;1,3,1;5,1,3";
                                                                                                                                } ?> type="text" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
                                    </div>
                                    <!--/div-->
                                </div>
                                <div class="row">
                                    <label class="col-auto col-form-label" for="punto_interes">Vector de soluciones</label>
                                    <!--div class="col"-->
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">b</span>
                                        <input id="solucion" name="solucion" placeholder="Escriba la matriz de coeficientes" value=<?php if (!empty($_GET)) {
                                                                                                                                        echo $_GET["solucion"];
                                                                                                                                    } else {
                                                                                                                                        echo "3,-6,12";
                                                                                                                                    } ?> type="text" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
                                    </div>
                                    <!--/div-->
                                </div>
                            </div>
                            <div class="m-0" style="padding-top: 10px;">
                                <button name="submit" type="submit" class="btn btn-primary">Obtener soluciones y LU</button>
                                <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Ver ejemplos
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container pdtop maxwidth-700">
                <?php
                if (!empty($_GET)) {
                    include('scripts/solve.php');

                    $filas = explode(';', str_replace(' ', '', $_GET["matriz"]));
                    $A = array();
                    for ($i = 0; $i < count($filas); $i++) {
                        $A[$i] = explode(',', $filas[$i]);
                    }

                    $filas = explode(',', str_replace(' ', '', $_GET["solucion"]));
                    $b = array();
                    for ($i = 0; $i < count($filas); $i++) {
                        $b[$i] = $filas[$i];
                    }

                    $x = gaussian_elimination($A, $b);
                    list($L, $U) = gaussian_elimination($A, $b, "both");

                ?>
                    <div class="pdbot">
                        <div class="card bg-light">
                            <div class="card-header" style="background-color: #e7f1ff;">Solución de sistema:&nbsp;
                                <?php
                                for ($i = 0; $i < count($x); $i++) {
                                    echo  '\(x_' . $i . '=' . $x[$i] . '\)&nbsp;&nbsp;&nbsp;';
                                }
                                ?>
                            </div>
                            <div class="card-body">
                                $$\begin{bmatrix}
                                <?php
                                for ($i = 0; $i < count($A); $i++) {
                                    echo implode('&', $A[$i]) . '\\' . '\\';
                                }
                                ?>
                                \end{bmatrix}
                                \times
                                \begin{bmatrix}
                                <?php
                                for ($i = 0; $i < count($x); $i++) {
                                    echo  $x[$i] . '\\' . '\\';
                                }
                                ?>
                                \end{bmatrix}
                                =
                                \begin{bmatrix}
                                <?php
                                for ($i = 0; $i < count($b); $i++) {
                                    echo  $b[$i] . '\\' . '\\';
                                }
                                ?>
                                \end{bmatrix}
                                $$
                            </div>
                        </div>
                    </div>

                    <div class="pdbot">
                        <div class="card bg-light">
                            <div class="card-header" style="background-color: #e7f1ff;">Descomposición LU</div>
                            <div class="card-body">
                                $$\begin{bmatrix}
                                <?php
                                for ($i = 0; $i < count($L); $i++) {
                                    echo implode('&', array_map(function ($v) {
                                        return round($v, 3);
                                    }, $L[$i])) . '\\' . '\\';
                                }
                                ?>
                                \end{bmatrix}
                                \times
                                \begin{bmatrix}
                                <?php
                                for ($i = 0; $i < count($U); $i++) {
                                    echo implode('&', array_map(function ($v) {
                                        return round($v, 3);
                                    }, $U[$i])) . '\\' . '\\';
                                }
                                ?>
                                \end{bmatrix}
                                =
                                \begin{bmatrix}
                                <?php
                                for ($i = 0; $i < count($A); $i++) {
                                    echo implode('&', array_map(function ($v) {
                                        return round($v, 3);
                                    }, $A[$i])) . '\\' . '\\';
                                }
                                ?>
                                \end{bmatrix}
                                $$
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="container text-break maxwidth-900">
            </div>
        </div>
        <br>
        <h6 class="text-center text-muted"><a href="https://github.com/crixodia?tab=repositories" target="_blank">Cristian Bastidas</a></h6>
        <br>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ejemplos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Aquí hay unos ejemplos de matrices y sus respectivos vectores de solución para usar en el formulario.
                        </p>
                        <ol class="list-group list-group-numbered">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <b>A: </b>16,3;7,-11<br>
                                    <b>b: </b>11,13<br>
                                </div>
                                <span class="badge bg-primary rounded-pill">2x2</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <b>A: </b>7,5,0;8,6,9;0,1,2<br>
                                    <b>b: </b>3,1,4<br>
                                </div>
                                <span class="badge bg-primary rounded-pill">3x3</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <b>A: </b>1,2,-1,3;2,0,2,-1;-1,1,1,-1;3,3,-1,2<br>
                                    <b>b: </b>-8,13,8,-1<br>
                                </div>
                                <span class="badge bg-primary rounded-pill">4x4</span>
                            </li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Listo</button>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>