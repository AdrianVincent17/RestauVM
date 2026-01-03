<?php

include("../seguridad.php");
proteger(2);
include("../conexion.php");

if (isset($_SESSION['fechainicial'])) {
    $fechainicial = $_SESSION['fechainicial'];
    $fechafinal = $_SESSION['fechafinal'];
}else{
    $fechainicial = '';
    $fechafinal ='';
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include("../head.php");
    ?>
    <title>Estadisticas - Restaurante La Despensa</title>

</head>

<body class="d-flex flex-column min-vh-100">
    <?php include("../nav.php"); ?>

    <div class="wrapper">
        <?php include("navbar.php"); ?>


        <main class="container mt-4 card">
            <h1>Estadisticas del negocio</h1>

            <form action="logica_estadisticas.php" method="POST" class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="fechainicial" class="form-label">Fecha Inicio</label>
                    <input type="date" id="fechainicial" name="fechainicial" class="form-control" value="<?php echo $fechainicial; ?>" required />
                </div>
                <div class="col-md-6">
                    <label for="fechafinal" class="form-label">Fecha Fin</label>
                    <input type="date" id="fechafinal" name="fechafinal" class="form-control" value="<?php echo $fechafinal; ?>" required />
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-success">Generar estadisticas</button>
                </div>
            </form>

            <div>
                <h2>Estadisticas</h2>
                <table class="table table-responsive table-secondary table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>Fecha</th>
                            <th>Total Comensales</th>
                            <th>Total Ingresos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        // Mostramos mensaje de que no hay datos si no los hay en esas fechas

                        if (isset($_SESSION['error'])) {
                            echo "<tr class='text-center'>";
                            echo "<td colspan ='3' class='alert text-danger pb-0'>No hay estadisticass de esas fechas..</td>";
                            echo "</tr>";
                            unset($_SESSION['error']);  
                        } else {

                            if (isset($_SESSION['estadisticas'])) {

                                // Recorremos el informe
                                foreach ($_SESSION['estadisticas'] as $indice => $datos) {
                                    echo "<tr class='text-center'>";
                                    echo "<td>" . $datos['fecha'] . "</td>";
                                    echo "<td align='center'>" . $datos['comensales'] . "</td>";
                                    echo "<td align='center'>" . number_format($datos['ingresos'], 2) . " €</td>";
                                    echo "</tr>";
                                }
                                unset($_SESSION['estadisticas']);
                                unset($_SESSION['fechainicial']);
                                unset($_SESSION['fechafinal']);
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>


    <?php include '../footer.php'; ?>

</body>

</html>