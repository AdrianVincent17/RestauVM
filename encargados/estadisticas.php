<?php

include("../seguridad.php");
proteger(2);
include("../conexion.php");

if (isset($_SESSION['fecha_inicio'])) {
    $fecha_inicio = $_SESSION['fecha_inicio'];
    $fecha_fin = $_SESSION['fecha_fin'];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include("../head.php");
    ?>
    <title>Estadisticas - Restaurante La Despensar</title>

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
                    <input type="date" id="fechainicial" name="fechainicial" class="form-control" value="<?php echo $fecha_inicio; ?>" required />
                </div>
                <div class="col-md-6">
                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                    <input type="date" id="fechafinal" name="fechafinal" class="form-control" value="<?php echo $fecha_fin; ?>" required />
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-success">Generar Informe</button>
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
                            echo "<tr>";
                            echo "<td colspan ='3' class='alert text-danger pb-0'>No hay informes de esas fechas..</td>";
                            echo "</tr>";
                            unset($_SESSION['error']);

                        } else {

                            if (isset($_SESSION['informe'])) {

                                // Recorremos el informe
                                foreach ($_SESSION['informe'] as $indice => $datos) {
                                    echo "<tr>";
                                    echo "<td>" . $datos['fecha'] . "</td>";
                                    echo "<td align='center'>" . $datos['comensales'] . "</td>";
                                    echo "<td align='center'>" . number_format($datos['ingresos'], 2) . " €</td>";
                                    echo "</tr>";
                                }
                                unset($_SESSION['informe']);
                                unset($_SESSION['fecha_inicio']);
                                unset($_SESSION['fecha_fin']);
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>



    </main>

    <?php include '../footer.php'; ?>

</body>

</html>