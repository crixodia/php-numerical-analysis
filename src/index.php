<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Numerical Analysis</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>

    <script id="MathJax-script" async src="js/tex-mml-chtml.js"></script>
    <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
</head>

<body>

    <div class="pattern"></div>
    <div class="container">

        <div class="container pdtop maxwidth-900 items">
            <div class="card">
                <a href="derivative.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/diferentiation.png" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">Diferenciación numérica</h6>
                            <p class="mb-0 opacity-75">Derivada numérica hacia atrás, adelante y central dado su punto de interés, un desplazamiento inicial y un factor de división en cada iteración.</p>
                        </div>
                        <!--span class="badge text-bg-primary">Primary</span-->
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="integrate_trapeze.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/trapezoidal.png" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">Integración numérica: Regla del Trapecio</h6>
                            <p class="mb-0 opacity-75">Integración numérica por la regla del trapecio dado el límite inferior, superior una tolerancia y el número de trapecios inicial.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="integrate_simpson.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/simpson.svg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">Integración numérica: Regla de Simpson</h6>
                            <p class="mb-0 opacity-75">Integración numérica por la regla de Simpson dado el límite inferior, superior una tolerancia y el número de trapecios inicial.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="bisection.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/bisection.png" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">Búsqueda de raíces: Bisección</h6>
                            <p class="mb-0 opacity-75">Búsqueda de raíces por el método de Bisección
                                dada una función, un intervalo de análisis, una tolerancia y el número de subintervalos a analizar.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="newton-raphson.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/newton-raphson.jpeg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">Búsqueda de raíces: Newton-Raphson</h6>
                            <p class="mb-0 opacity-75">Búsqueda de raíces por el método de Newton-Raphson dada una función, un intervalo de análisis, una tolerancia y el número de subintervalos a analizar.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="secant.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/secant.svg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">Búsqueda de raíces: Secante, Bisección, Newton-Raphson</h6>
                            <p class="mb-0 opacity-75">Búsqueda de raíces por los métodos Newton-Raphson, Secante, Bisección, Secante-Bisección. Se requiere una función, un intervalo de análisis, una tolerancia y el número de subintervalos a analizar.</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</body>

</html>