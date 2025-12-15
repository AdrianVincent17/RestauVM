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

    <style>
        body {
            background: url('img/restauLD.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .category {
            background-color: rgba(255, 255, 255, 0.65);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            width: 100%;
            max-width: 700px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .list-group-item{
             background-color: rgba(255, 255, 255, 0.60);
             margin-bottom: 5px;
    
        }
        
    </style>

</head>

<body class="d-flex flex-column min-vh-100">
    <div class="wrapper">


        <main class="container my-5">
            <h1 class="mb-5">Carta - Restaurante La Despensa</h1>

            <?php

            // --- OBTENER CATEGORIAS ---
            $categorias = mysqli_query($conn, "SELECT * FROM categoria");



            if (mysqli_num_rows($categorias) > 0) {


                while ($cat = mysqli_fetch_assoc($categorias)) {
                    echo "<section class='category mb-4'>";


                    // --- OBTENER LOS PRODUCTOS ACTIVOS DE LA CATEGORIA ---
                    $productos = mysqli_query($conn, "SELECT * FROM producto WHERE categoria = " . $cat['idcat'] . " AND estado = 0");


                    if ($cat['nombre']) echo "<h2 class='text-dark'>" . $cat['nombre'] . "</h2>";


                    //######################
                    //
                    // LISTAR PRODUCTOS
                    //
                    //#####################

                    if (mysqli_num_rows($productos) > 0) {

                        echo "<div class='list-group'>";

                        while ($prod = mysqli_fetch_assoc($productos)) {

                            echo "<div class='list-group-item d-flex justify-content-between align-items-center p-3'>";
                            echo "<span>" . $prod['nombre'] . "</span>";

                            echo "<span class='price fw-bold text-success'>" . $prod['precio'] . " €</span>";
                            echo "</div>";
                        }

                        echo "</div>";
                    } else {
                        echo "<p class='alert alert-danger'>No hay productos disponibles en esta categoría.</p>";
                    }


                    echo "</section>";
                   
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