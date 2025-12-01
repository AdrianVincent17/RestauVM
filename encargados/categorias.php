<?php
include("../seguridad.php");
proteger(2);
include("../conexion.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include("../head.php"); ?>
    <title>Categorias - Restaurante La Despensa</title>
    <style>
        .editable-form-row>td {
            padding: 0;
            /* Quitamos el padding para que el form interno lo maneje */
            /* Ocultar el colapsable si Bootstrap no lo hace por defecto */
            transition: height 0.3s ease-in-out;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include("../nav.php"); ?>

    <div class="wrapper">
        <?php include("navbar.php"); ?>

        <main class="container my-5">

            <div class="mb-2">
                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#usuario" aria-expanded="false" aria-controls="usuario">
                    Añadir categoria
                </button>
            </div>

            <div style="min-height: 10px;">
                <div class="collapse" id="usuario">

                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="añadircategorias.php" method="POST">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre"
                                            placeholder="Ej: Cafes e infusiones" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Registrar Nueva categoria</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <h1 class="mb-4">Gestión de las categorías</h1>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>

                            <th>Nombre Categoria</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        //Consulta de categorias

                        $consulta = "SELECT *
                                         FROM categoria";



                        $categorias = mysqli_query($conn, $consulta);

                        if ($categorias && mysqli_num_rows($categorias) > 0) {

                            while ($cat = mysqli_fetch_assoc($categorias)) {

                                echo "<tr class='justify-content-center align-items-center mx-auto'>";
                                echo "<td>" . $cat['nombre']."</td>";

                                echo "<td>" ;
                                echo "<div class='d-flex flex-column flex-sm-row gap-2'>";

                                // Botón Bloquear/Desbloquear
                                if ($cat['estado'] == 0) {
                                    echo "<a href='bloquearcategoria.php?idcat=" . $cat['idcat'] . "' class='btn btn-sm btn-outline-success'>Disponible</a>";
                                } else {
                                    echo "<a href='bloquearcategoria.php?idcat=" . $cat['idcat'] . "' class='btn btn-sm btn-outline-danger'>Bloqueado</a>";
                                }
                                echo "</div>";
                                echo "</td>";
                            }
                        } else {
                            echo "<tr><td colspan=2><div class='fw-bold alert alert-danger'>No hay categorias registradas.</div></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <?php include("../footer.php"); ?>
</body>

</html>