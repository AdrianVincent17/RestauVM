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
        /* Estilo para la fila de edición que ocupa todo el ancho */
        .editable-form-row>td {
            padding: 1rem;
            /* Ocultar el colapsable si Bootstrap no lo hace por defecto para evitar CLS */
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
                    Añadir producto
                </button>
            </div>

            <div style="min-height: 10px;">
                <div class="collapse" id="usuario">

                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="añadirproductos.php" method="POST">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="nombre" class="form-label">Nombre </label>
                                        <input type="text" class="form-control" name="nombre" id="nombre"
                                            placeholder="Ej: Albondigas estofadas" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="precio" class="form-label">Precio</label>
                                        <input type="text" class="form-control" name="precio" id="precio"
                                            placeholder="Ej: 12.50€">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="stock" class="form-label">Stock</label>
                                        <input type="number" class="form-control" name="stock" id="stock"
                                            placeholder="Ej: 25 Unidades" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="cat" class="form-label">Categoría</label>
                                        <select class="form-select" id="cat" name="cat" required>
                                            <option value="" selected disabled>Selecciona una categoría</option>
                                            <?php

                                            $consultacat = "SELECT * FROM categoria";

                                            $categorias = mysqli_query($conn, $consultacat);

                                            // Esto iteraría sobre las categorías reales si la consulta existiera
                                            if ($categorias && mysqli_num_rows($categorias) > 0) {  //si el numero de filas es mayor que 0...
                                                while ($cat = mysqli_fetch_assoc($categorias)) {
                                                    echo "<option value='{$cat['idcat']}'>" . $cat['nombre'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="estado" class="form-label">Disponibilidad</label>
                                        <select class="form-select" id="estado" name="estado" required>
                                            <option value="0" selected>Disponible (0)</option>
                                            <option value="1">Bloqueado (1)</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Registrar Nuevo Producto</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

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
                    $consultaprod = "SELECT p.*, c.nombre AS categoria_nombre 
                              FROM producto p 
                              INNER JOIN categoria c ON p.categoria = c.idcat
                              ORDER BY c.idcat ASC, p.nombre ASC";

                    $productos = mysqli_query($conn, $consultaprod);

                    if ($productos && mysqli_num_rows($productos) > 0) {  //si el numero de filas es mayor que 0...
                        while ($prod = mysqli_fetch_assoc($productos)) { //el fetch_assoc es mas limpio que el fetch_array
                            echo "<tr>";
                            echo "<td>" . $prod['nombre'] . "</td>";
                            echo "<td>" . $prod['categoria_nombre'] . "</td>";
                            echo "<td>" . $prod['stock'] . "</td>";
                            echo "<td>" . number_format($prod['precio'], 2) . "</td>"; //utilizo el number format para que me de varios decimales
                            echo "<td>";


                            // Botón Bloquear/Desbloquear
                            if ($prod['estado'] == 0) {
                                echo "<a href='bloquearproducto.php?idprod=" . $prod['idprod'] . "' class='btn btn-outline-success'>Disponible</a>";
                            } else {
                                echo "<a href='desbloquearproducto.php?idprod=" . $prod['idprod'] . "' class='btn btn-outline-danger'>Bloqueado</a>";
                            }
                            // Botón Editar
                    ?>
                            <a data-bs-toggle="collapse" data-bs-target="#<?php echo $prod['idprod'] ?>;" aria-expanded="false" aria-controls="<?php echo $prod['idprod']; ?>" href='editarproducto.php?idprod="<?php echo $prod['idprod'] ?>;"' class="btn btn-primary">Editar</a>

                            </td>
                            </tr>
                            <tr class="editable-form-row collapse" id="<?php echo $prod['idprod'] ?>;">
                                <td colspan="5">

                                    <form action="editarproductos.php" method="POST">
                                        <div class="row">
                                            <div class="col-md-5 ms-5 me-5">
                                                <input type="text" class="text-center form-control" name="nombre" id="nombre"
                                                    value="<?php echo $prod['nombre']; ?>" required>
                                            </div>
                                            <div class="col-md-2 ms-3">
                                                <select class="text-center form-select" id="cat" name="cat" required>

                                                    <?php
                                                    $consultacat = "SELECT * FROM categoria";
                                                    $categorias = mysqli_query($conn, $consultacat);
                                                    $row = mysqli_fetch_assoc($categorias);
                                                    ?>
                                                    <option value='<?php echo $cat['idcat']; ?>' selected><?php echo $row['nombre']; ?></option>;


                                                    <?php


                                                    // Esto iteraría sobre las categorías reales si la consulta existiera
                                                    if ($categorias && mysqli_num_rows($categorias) > 0) {  //si el numero de filas es mayor que 0...
                                                        while ($cat = mysqli_fetch_assoc($categorias)) {
                                                            echo "<option value='{$cat['idcat']}'>" . $cat['nombre'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-1">
                                                <input type="number" class="text-center form-control" name="stock" id="stock" value="<?php echo $prod['stock']; ?>" required>
                                            </div>
                                            <div class="col-md-1">
                                                <input type="text" class="text-center form-control" name="precio" id="precio" value="<?php echo $prod['precio']; ?>">
                                            </div>
                                            <div class="col-md-1 ms-5">
                                                <input type="hidden" id="idprod" name="idprod" value="<?php echo $prod['idprod']; ?>">
                                                <button type="submit" class="btn btn-md btn-success"><i class="bi bi-check"></i></button>

                                            </div>
                                        </div>
                                    </form>
    </div>

<?php



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