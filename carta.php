<?php
session_start();
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include("head.php"); ?>
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Carta - Restaurante La Despensa</title>

</head>

<body class="d-flex flex-column min-vh-100">
    <div class="wrapper">


        <main class="container my-5">
            <h1 class="mb-5">Carta - Restaurante La Despensa</h1>

            <?php

            // --- Obtener categorías ---
            $categorias = mysqli_query($conn, "SELECT * FROM categoria");

              

            if (mysqli_num_rows($categorias) > 0) {
                
                
                while ($cat = mysqli_fetch_assoc($categorias)) {
                    echo "<section class='category mb-4'>";

                

                    // --- Obtener productos activos de esa categoría ---
                    $productos = mysqli_query($conn, "SELECT * FROM producto WHERE categoria = " . $cat['idcat'] . " AND estado = 0");


                    if ($cat['nombre']) echo "<h2>" . $cat['nombre'] . "</h2>";
                    
                  

                    // Mostrar productos
                    if (mysqli_num_rows($productos) > 0) {

                        // Contenedor para los items
                        echo "<div class='list-group list-group-flush'>";

                        while ($prod = mysqli_fetch_assoc($productos)) {

                            // Usamos d-flex justify-content-between para alinear nombre y precio
                            // Añadimos padding vertical (py-2) para espaciar

                            echo "<div class='list-group-item d-flex justify-content-between align-items-center p-2 bg-stripped'>";
                            echo "<span>" . $prod['nombre'] . "</span>";

                            // Añadimos fw-bold (negrita) al precio para destacarlo
                            echo "<span class='price fw-bold text-success'>" . $prod['precio'] . " €</span>";
                            echo "</div>";
                        }

                        echo "</div>"; // Fin del list-group


                    } else {
                        echo "<p class='alert alert-danger'>No hay productos disponibles en esta categoría.</p>";
                    }


                    echo "</section>";
                    // Añadimos un separador entre categorías para más claridad
                    echo "<hr class='my-4'>";
                }
            } else {
                echo "<p class='alert alert-danger'>No hay categorías registradas.</p>";
            }

            
               echo "<a href='index.php' class='btn btn-primary'><i class='bi bi-arrow-left me-2'></i>Volver</a>"; 
            

            ?>
        </main>
    </div>

    <?php include("footer.php"); ?>
</body>

</html>