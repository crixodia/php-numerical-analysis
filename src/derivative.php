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
    <title>Diferenciación Numérica</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="pattern"></div>
    <div class="container">

        <div class="container pdtop maxwidth-700">
            <div class="card bg-light">
                
                <h5 class="card-header" style="background-color: #cfe2ff;"><a href="index.php"><img src="assets/left.png" width="24px"></a> Diferenciación Numérica</h5>

                <div class="card-body">
                    <form action="derivative.php" method="GET" class="font-monospace">

                        <div class="form-group font-monospace">
                            <label class="">f(x) =</label>
                            <div class="form-check form-check-inline">
                                <input name="funcion" id="radio_2" type="radio" class="form-check-input" value="exponencial" aria-describedby="radioHelpBlock" required="required" checked>
                                <label for="radio_2" class="form-check-label">e^x</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input name="funcion" id="radio_0" type="radio" class="form-check-input" value="lineal" aria-describedby="radioHelpBlock" required="required">
                                <label for="radio_0" class="form-check-label">x</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input name="funcion" id="radio_1" type="radio" class="form-check-input" value="cuadratica" aria-describedby="radioHelpBlock" required="required">
                                <label for="radio_1" class="form-check-label">x^2</label>
                            </div>
                        </div>

                        <div class="form-group" style="padding-top: 10px;">
                            <label class="">Método: &nbsp;</label>
                            <div class="form-check form-check-inline">
                                <input name="metodo" id="radio_2" type="radio" class="form-check-input" value="atras" aria-describedby="radioHelpBlock" required="required">
                                <label for="radio_2" class="form-check-label">Atrás</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input name="metodo" id="radio_0" type="radio" class="form-check-input" value="central" aria-describedby="radioHelpBlock" required="required" checked>
                                <label for="radio_0" class="form-check-label">Central</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input name="metodo" id="radio_1" type="radio" class="form-check-input" value="adelante" aria-describedby="radioHelpBlock" required="required">
                                <label for="radio_1" class="form-check-label">Adelante</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label class="col col-form-label" for="punto_interes">Punto de interés</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">x</span>
                                        <input id="punto_interes" name="punto_interes" placeholder="10" value=<?php if (!empty($_GET)) {
                                                                                                                    echo $_GET["punto_interes"];
                                                                                                                } else {
                                                                                                                    echo "10";
                                                                                                                } ?> type="number" step="any" aria-describedby="punto_interesHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col col-form-label" for="delta">Desplazamiento inicial</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">Δ</span>
                                        <input id="delta" name="delta" placeholder="0.01" value=<?php if (!empty($_GET)) {
                                                                                                    echo $_GET["delta"];
                                                                                                } else {
                                                                                                    echo "0.1";
                                                                                                } ?> type="number" step="any" aria-describedby="deltaHelpBlock" required="required" class="form-control">
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="col col-form-label" for="step">Divisor [1,10]</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text">/</span>
                                        <input id="step" name="step" placeholder="0.01" value=<?php if (!empty($_GET)) {
                                                                                                    echo $_GET["step"];
                                                                                                } else {
                                                                                                    echo "1.1";
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

        <div class="container pdtop maxwidth-700">
            <?php
            if (!empty($_GET)) {
                include('scripts/diferenciacion.php');

                $title = ["k", "f(x - Δx)", "f(x + Δx)", "Δx", "f'(x)"];
                $table = null;
                switch ($_GET["metodo"]) {
                    case "central":
                        $table = d_interval_central(getFunction($_GET["funcion"]), $_GET["punto_interes"], $_GET["delta"], $_GET["step"]);
                        break;
                    case "adelante":
                        $table = d_interval_adelante(getFunction($_GET["funcion"]), $_GET["punto_interes"], $_GET["delta"], $_GET["step"]);
                        $title = ["k", "f(x)", "f(x + Δx)", "Δx", "f'(x)"];
                        break;
                    case "atras":
                        $table = d_interval_atras(getFunction($_GET["funcion"]), $_GET["punto_interes"], $_GET["delta"], $_GET["step"]);
                        $title = ["k", "f(x - Δx)", "f(x)", "Δx", "f'(x)"];
                        break;
                }
                $derivadas = $table[count($table) - 1];
                $ultima_derivada = $table[count($table) - 1][count($derivadas) - 1];

                $funciones = array("lineal" => "x", "cuadratica" => "(x/2)**2-cos(x)", "exponencial" => "e^x");
            ?>
                <div class="pdbot">
                    <div class="card bg-light">
                        <div class="card-header" style="background-color: #cfe2ff;">Resultados</div>
                        <div class="card-body">
                            <div class="row">
                                <h6 class="col text-center font-monospace">f(x) = <?php echo $funciones[$_GET["funcion"]]; ?></h6>
                                <h6 class="col text-center font-monospace">x = <?php echo $_GET["punto_interes"]; ?></h6>
                                <h6 class="col text-center font-monospace">Δx = <?php echo $_GET["delta"]; ?></h6>
                                <h6 class="col text-center font-monospace">ε = <?php echo $_GET["step"]; ?></h6>
                            </div>
                        </div>
                        <div class="card-footer text-center font-monospace">
                            <b>f'(<?php echo $_GET["punto_interes"]; ?>) ≈ <?php echo round($ultima_derivada, 6); ?></b>
                        </div>
                    </div>
                </div>
        </div>
        <div class="container text-break maxwidth-900">
        <?php
                echo '<table class="table container table-light table-hover table-bordered font-monospace"><thead>';
                foreach ($title as $head) {
                    echo "<th scope='col' class='text-center table-primary'>" . $head . "</th>";
                }
                echo '</thead>';
                $counter = 0;
                foreach ($table as $line) {
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
            }
        ?>

        </div>
    </div>
    <br>
    <h6 class="text-center text-muted"><a href="https://github.com/crixodia?tab=repositories" target="_blank">Cristian Bastidas</a></h6>
    <br>
</body>

</html>