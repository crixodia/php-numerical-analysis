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

            <div class="card">
                <a href="integrate_gauss_quadrature.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/legendre.png" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Integración numérica: Cuadratura de Gauss</h6>
                            <p class="mb-0 opacity-75">Integración numérica por cuadratura de Gauss dado el límite inferior, superior una tolerancia y el grado del polinomio.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="lu_decomposition_gaussian_elimination.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/gaussian_elimination.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Eliminación Gaussiana y Factorización LU</h6>
                            <p class="mb-0 opacity-75">Obtiene las soluciones de un sistema de ecuaciones a través de la Eliminación Gaussiana. Además muestra la factorización LU.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="thomas.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Método de Thomas para matrices tridiagonales</h6>
                            <p class="mb-0 opacity-75">Obtiene las soluciones de un sistema de ecuaciones a través del método de Thomas para matrices tridiagonales.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="gauss_jacobi_seidel.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Gauss-Jacobi y Seidel</h6>
                            <p class="mb-0 opacity-75">Obtiene las soluciones de un sistema de ecuaciones a través de los métodos de Gauss-Jacobi o Seidel.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="over_relaxation.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Relajaciones sucesivas</h6>
                            <p class="mb-0 opacity-75">Obtiene las soluciones de un sistema de ecuaciones a través del método de relajaciones sucesivas.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="qr_decomposition.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Factorización QR</h6>
                            <p class="mb-0 opacity-75">Factorización QR de matrices.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="root_finding.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Todos los métodos de búsqueda de raíces</h6>
                            <p class="mb-0 opacity-75">Búsqueda de raíces por todos los métodos mostrados anteriormente.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="quadratic_fitting.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Ajuste de curvas por método cuadrático</h6>
                            <p class="mb-0 opacity-75">Ajusta una serie de puntos a curvas cuadráticas.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="cubic_splines.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Splines cúbicos</h6>
                            <p class="mb-0 opacity-75">Ajusta una serie de puntos con el método de splines cúbicos. Se debe proporcionar un archivo con los puntos. Permite dos métodos para la solución de sistemas de ecuadiones.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="linear_lagrange_quadratic.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Ajuste de curvas lineal, cuadrático y lagrange</h6>
                            <p class="mb-0 opacity-75">Ajusta una serie de puntos de forma lineal, cuadrática o usando la interpolación de lagrange.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="edo_euler.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Método de Euler para solución de ecuación diferenciales</h6>
                            <p class="mb-0 opacity-75">Solución de ecuaciones diferenciales por el método de Euler. Se especifican la función de dos variables y las aproximaciones iniciales.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="edo_euler_improved.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Método de Euler mejorado para solución de ecuación diferenciales</h6>
                            <p class="mb-0 opacity-75">Solución de ecuaciones diferenciales por el método de Euler. Se especifican la función de dos variables y las aproximaciones iniciales.</p>
                        </div>
                    </div>
                </a>
            </div>



            <div class="card">
                <a href="edo_euler_modified.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Método de Euler modificado para solución de ecuación diferenciales</h6>
                            <p class="mb-0 opacity-75">Solución de ecuaciones diferenciales por el método de Euler. Se especifican la función de dos variables y las aproximaciones iniciales.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="rugen_kutta.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Método de Rugen Kutta para solución de ecuaciones diferenciales</h6>
                            <p class="mb-0 opacity-75">Solución de ecuaciones diferenciales por el método de Euler. Se especifican la función de dos variables y las aproximaciones iniciales.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="linear_multistep_method.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Método de múltiples pasos para solución de ecuaciones diferenciales</h6>
                            <p class="mb-0 opacity-75">Solución de ecuaciones diferenciales por el método de Euler. Se especifican la función de dos variables y las aproximaciones iniciales.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="multivariable_newton.php" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="assets/tridiagonal.jpg" alt="twbs" width="64" height="64" class="flex-shrink-0">
                    <div class="d-flex gap-2 w-1lo00 justify-content-between">
                        <div>
                            <h6 class="mb-0">Método de Newton para funciones multivariables</h6>
                            <p class="mb-0 opacity-75">Solución de ecuaciones diferenciales por el método de Euler. Se especifican la función de dos variables y las aproximaciones iniciales.</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</body>

</html>