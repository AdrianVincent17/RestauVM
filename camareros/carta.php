<?php
include("../seguridad.php");
proteger(1);
include("../conexion.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include("../head.php"); ?>
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

                    // justify-content-between empuja el título a la izq y el filtro a la der.
                    echo "<div class='d-flex justify-content-between align-items-center mb-3'>";

                    if ($cat['nombre'] == 'Entrantes') echo "<h2>🍤 " . $cat['nombre'] . "</h2>";
                    if ($cat['nombre'] == 'Platos principales') echo "<h2>🍽️ " . $cat['nombre'] . "</h2>";
                    if ($cat['nombre'] == 'Postres') echo "<h2>🍰 " . $cat['nombre'] . "</h2>";
                    if ($cat['nombre'] == 'Bebidas') echo "<h2>🍷 " . $cat['nombre'] . "</h2>";

                    // Formulario filtro - Se quitan las clases w-100 y w-md-auto
                    // formulario (y el select) solo ocupa su ancho natural.
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

                        // Contenedor para los items
                        echo "<div class='list-group list-group-flush'>";

                        while ($prod = mysqli_fetch_assoc($productos)) {
                            // Usamos d-flex justify-content-between para alinear nombre y precio
                            // Añadimos padding vertical (py-2) para espaciar
                            echo "<div class='list-group-item d-flex justify-content-between align-items-center p-2 bg-stripped'>";
                            echo "<span>" . $prod['nombre'] . "</span>";
                            // Añadimos fw-bold (negrita) al precio para destacarlo
                            echo "<span class='price fw-bold fs-10px'>" . $prod['precio'] . " €</span>";
                            echo "</div>";
                        }

                        echo "</div>"; // Fin del list-group


                    } else {
                        echo "<p class='text-muted'>No hay productos disponibles en esta categoría.</p>";
                    }


                    echo "</section>";
                    // Añadimos un separador entre categorías para más claridad
                    echo "<hr class='my-4'>";
                }
            } else {
                echo "<p>No hay categorías registradas.</p>";
            }

            
               echo "<a href='indexCamareros.php' class='btn btn-primary'><i class='bi bi-arrow-left me-2'></i>Volver</a>"; 
            

            ?>
        </main>
    </div>

    <?php include("../footer.php"); ?>
</body>

</html>