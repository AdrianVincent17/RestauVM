<?php 

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

                    // Contenedor flex para título + filtro
                    echo "<div class='d-flex justify-content-between align-items-center mb-3'>";

                    // Título con emoji según categoría
                    if ($cat['nombre'] == 'Entrantes') echo "<h2>🍤 " . $cat['nombre'] . "</h2>";
                    if ($cat['nombre'] == 'Platos principales') echo "<h2>🍽️ " . $cat['nombre'] . "</h2>";
                    if ($cat['nombre'] == 'Postres') echo "<h2>🍰 " . $cat['nombre'] . "</h2>";
                    if ($cat['nombre'] == 'Bebidas') echo "<h2>🍷 " . $cat['nombre'] . "</h2>";

                    // Formulario filtro
                    echo "<form method='POST'>
                    <select name='filtro' class='form-select' onchange='this.form.submit()'>
                    <option selected disabled>Filtrar por...</option>
                    <option value='nombre'>Nombre</option>
                    <option value='precio'>Precio</option>
                    </select>
                    </form>";

                    echo "</div>"; // fin del contenedor flex

                    // --- Obtener productos activos de esa categoría ---
                    $productos = mysqli_query($conn, "SELECT * FROM producto WHERE categoria = " . $cat['idcat'] . " AND estado = 0");

                    // Filtrado
                    if (isset($_POST['filtro'])) {
                        $filtro = $_POST['filtro'];
                        switch ($filtro) {
                            case 'nombre':
                                $productos = mysqli_query($conn, "SELECT * FROM producto WHERE categoria = " . $cat['idcat'] . " AND estado = 0 ORDER BY nombre ASC;");
                                break;
                            case 'precio':
                                $productos = mysqli_query($conn, "SELECT * FROM producto WHERE categoria = " . $cat['idcat'] . " AND estado = 0 ORDER BY precio ASC;");
                                break;
                        }
                    }

                    // Mostrar productos
                    if (mysqli_num_rows($productos) > 0) {
                        while ($prod = mysqli_fetch_assoc($productos)) {
                            echo "<div class='menu-item'>";
                            echo "<span>" . $prod['nombre'] . "</span>";
                            echo "<span class='price'>" . $prod['precio'] . " €</span>";
                            echo "</div>";
                        }
                        
                    } else {
                        echo "<p class='text-muted'>No hay productos disponibles en esta categoría.</p>";
                    }

                    echo "</section>";
                }
            } else {
                echo "<p>No hay categorías registradas.</p>";
            }
            echo "<a href='index.php' class='btn btn-sm btn-primary'><i class='bi bi-caret-left me-2'></i>Volver</a>";
            ?>
        </main>
    </div>

    <?php include("footer.php"); ?>
</body>

</html>