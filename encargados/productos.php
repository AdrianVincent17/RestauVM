<?php
include("../seguridad.php");
proteger(2);
include("../conexion.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include("../head.php"); ?>
    <title>Productos - Restaurante La Despensa</title>
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
             <h1 class="mb-4">Gestión de Productos</h1>

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
                                    <div class="col-12 col-md-6 col-lg-3 mb-3">
                                        <label for="nombre" class="form-label">Nombre </label>
                                        <input type="text" class="form-control" name="nombre" id="nombre"
                                            placeholder="Ej: Albondigas estofadas" required>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-1 mb-3">
                                        <label for="precio" class="form-label">Precio</label>
                                        <input type="text" class="form-control" name="precio" id="precio"
                                            placeholder="Ej: 12.50€">
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-1 mb-3">
                                        <label for="stock" class="form-label">Stock</label>
                                        <input type="number" class="form-control" name="stock" id="stock"
                                            placeholder="Ej: 25 Unidades" required>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3 mb-3">
                                        <label for="cat" class="form-label">Categoría</label>
                                        <select class="form-select" id="cat" name="cat" required>
                                            <option value="" selected disabled>Selecciona una categoría</option>

                                            <!-- aqui hacemos la consulta para obtener las categorias -->
                                            <?php


                                            $consultacat = "SELECT * FROM categoria";
                                            $categorias = mysqli_query($conn, $consultacat);


                                            if ($categorias && mysqli_num_rows($categorias) > 0) { //si las categorias obtenidas tienen al menos una fila imprime las categorias
                                                while ($cat = mysqli_fetch_assoc($categorias)) {
                                                    echo "<option value='{$cat['idcat']}'>" . $cat['nombre'] . "</option>";
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3 mb-3">
                                        <label for="imagen" class="form-label">imagen</label>
                                        <input type="file" class="form-control" name="imagen" id="imagen"
                                            placeholder="img/C2.png" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Registrar Nuevo Producto</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

           

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre del Producto</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Precio (€)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        //unir el producto con su categoria, hacemos una consulta conjunta

                        $consultaprod = "SELECT p.*, c.nombre AS categoria_nombre, c.estado AS categoria_estado
                                         FROM producto p 
                                         INNER JOIN categoria c ON p.categoria = c.idcat
                                         ORDER BY c.idcat ASC, p.idprod ASC";





                        $productos = mysqli_query($conn, $consultaprod);

                        if ($productos && mysqli_num_rows($productos) > 0) {
                            while ($prod = mysqli_fetch_assoc($productos)) {
                                echo "<tr class='text-center align-middle'>";
                                echo "<td><img class='img-fluid' style='width: 80px; height: auto; object-fit: cover;' src='../img/" . $prod['imagen'] . "'></td>";
                                echo "<td>" . $prod['nombre'] . "</td>";
                                echo "<td>" . $prod['categoria_nombre'] . "</td>";
                                echo "<td>" . $prod['stock'] . "</td>";
                                echo "<td>" . number_format($prod['precio'], 2) . "</td>";  //esta fila con el number format lo que hace es poner dos digitos al numero
                                echo "<td>";

                                // Mobile-First para botones:
                                // d-flex flex-column (apilado en móvil)
                                // flex-sm-row (en fila desde 'sm' hacia arriba)
                                // gap-2 (espacio entre botones)
                                echo '<div class="d-flex flex-column flex-sm-row gap-2">';

                                // --- LÓGICA DE BOTONES ---
                                // 1. Si la Categoría está bloqueada, mostramos un aviso gris (no clickable o aviso claro)
                                if ($prod['categoria_estado'] == '1') {
                                    echo "<button class='btn btn-sm btn-warning' disabled>Cat.Bloqueada</button>";
                                }
                                // 2. Si la Categoría está activa, miramos el estado del producto
                                else {
                                    if ($prod['estado'] == '0') {
                                        echo "<a href='bloquearproducto.php?idprod=" . $prod['idprod'] . "' class='btn btn-sm btn-outline-success'>Disponible</a>";
                                    } else {
                                        echo "<a href='bloquearproducto.php?idprod=" . $prod['idprod'] . "' class='btn btn-sm btn-outline-danger'>Bloqueado</a>";
                                    }
                                }
                                // Botón Editar
                        ?>
                                <a data-bs-toggle="collapse" data-bs-target="#<?php echo $prod['idprod'] ?>;" aria-expanded="false" aria-controls="<?php echo $prod['idprod']; ?>" href='editarproducto.php?idprod="<?php echo $prod['idprod'] ?>;"' class="btn btn-sm btn-primary">Editar</a>
                                <?php
                                echo '</div>'; // Cierre del div flex
                                echo "</td>";
                                echo "</tr>";
                                // Fila colapsable para edición
                                ?>
                                <tr class="editable-form-row collapse" id="<?php echo $prod['idprod'] ?>;">
                                    <td colspan="6">
                                        <form action="editarproductos.php" method="POST" enctype="multipart/form-data">
                                            <div class="row g-3 px-3 py-2 justify-content-center">

                                                <div class="col-12 col-md-5 ms-5 ps-5">
                                                    <label for="nombre_<?php echo $prod['idprod']; ?>" class="visually-hidden">Nombre</label>
                                                    <input type="text" class="text-center form-control" name="nombre" id="nombre_<?php echo $prod['idprod']; ?>"
                                                        value="<?php echo $prod['nombre']; ?>" required>
                                                </div>

                                                <div class="col-12 col-md-2  ms-3 ps-5">
                                                    <label for="cat_<?php echo $prod['idprod']; ?>" class="visually-hidden">Categoría</label>
                                                    <select class="text-center form-select" id="cat_<?php echo $prod['idprod']; ?>" name="cat" required>
                                                        <option value="" disabled>Categoría</option>
                                                        <?php

                                                        //aqui volvemos a hacer uso de la consulta de categorias para poder imprimir en el selected
                                                        //de manera que dejara como predefinido por defecto la categoria asignada a ese producto
                                                        mysqli_data_seek($categorias, 0); //esta linea seria como rebobinar o volver al principio de la lista
                                                        
                                                        if ($categorias && mysqli_num_rows($categorias) > 0) {
                                                            while ($cat = mysqli_fetch_assoc($categorias)) {
                                                                // Marcar la categoría actual del producto como seleccionada
                                                                $selected = ($cat['idcat'] == $prod['categoria']) ? 'selected' : '';
                                                                echo "<option value='{$cat['idcat']}' $selected>" . $cat['nombre'] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-6 col-md-1">
                                                    <label for="stock_<?php echo $prod['idprod']; ?>" class="visually-hidden">Stock</label>
                                                    <input type="number" class="text-center form-control" name="stock" id="stock_<?php echo $prod['idprod']; ?>" value="<?php echo $prod['stock']; ?>" required>
                                                </div>

                                                <div class="col-6 col-md-1">
                                                    <label for="precio_<?php echo $prod['idprod']; ?>" class="visually-hidden">Precio</label>
                                                    <input type="text" class="text-center form-control" name="precio" id="precio_<?php echo $prod['idprod']; ?>" value="<?php echo $prod['precio']; ?>">
                                                </div>

                                                <div class="col-12 col-md-1 text-center">
                                                    <input type="hidden" id="idprod" name="idprod" value="<?php echo $prod['idprod']; ?>">
                                                    <button type="submit" class="btn btn-md btn-success w-100 w-md-auto"><i class="bi bi-check"></i></button>
                                                </div>

                                                <div class="col-9">
                                                    <label for="imagen_<?php echo $prod['idprod']; ?>" class="visually-hidden">imagen</label>
                                                    <input type="file" class="text-center form-control" name="imagen" id="imagen_<?php echo $prod['idprod'];?>">
                                                </div>

                                                

                                            </div>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>No hay productos registrados.</td></tr>";
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