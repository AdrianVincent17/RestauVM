<?php
include("../seguridad.php");
proteger(2);
include("../conexion.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include("../head.php"); ?>
    <title>Carta - Restaurante La Despensa</title>
    <style>
        .category h2 {
            border-bottom: 2px solid #ddd;
            padding-bottom: 8px;
            margin-top: 40px;
        }

        .menu-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .price {
            font-weight: bold;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include("../nav.php"); ?>

    <div class="wrapper">
        <?php include("navbar.php"); ?>

        <main class="container my-5">
              <h1 class="mb-4">Gestión de la Carta</h1>

            <table class="table table-responsive table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nombre del Producto</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Precio (€)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Unir producto con su categoría
                    $query = "SELECT p.*, c.nombre AS categoria_nombre 
                              FROM producto p 
                              INNER JOIN categoria c ON p.categoria = c.idcat
                              ORDER BY c.idcat ASC, p.nombre ASC";

                    $productos = mysqli_query($conn, $query);

                    if ($productos && mysqli_num_rows($productos) > 0) {
                        while ($prod = mysqli_fetch_assoc($productos)) {
                            echo "<tr>";
                            echo "<td>" . $prod['nombre'] . "</td>";
                            echo "<td>" . $prod['categoria_nombre'] . "</td>";
                            echo "<td>" . $prod['stock'] . "</td>";
                            echo "<td>" . number_format($prod['precio'], 2) . "</td>";
                            echo "<td>";

                            // Botón Editar
                            echo "<a href='editarproducto.php?id=" . $prod['idprod'] . "' class='btn btn-primary'>Editar</a> ";



                            // Botón Bloquear/Desbloquear
                            if ($prod['estado'] == 0) {
                                echo "<a href='bloquearproducto.php?id=" . $prod['idprod'] . "' class='btn btn-outline-warning'>Bloquear</a>";
                            } else {
                                echo "<a href='bloquearproducto.php?id=" . $prod['idprod'] . "' class='btn btn-outline-warning'>Desbloquear</a>";
                            }

                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No hay productos registrados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>

    <?php include("../footer.php"); ?>
</body>

</html>