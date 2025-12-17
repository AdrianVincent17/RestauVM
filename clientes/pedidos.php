<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

$idmesa = 'N/A'; 
$idped_activo = false;

if (isset($_SESSION['idped'])) {
    $idped = $_SESSION['idped'];
    $idped_activo = true;

    if (isset($_SESSION['idmesa'])) {
        $idmesa = $_SESSION['idmesa'];
    }

    $consulta = "SELECT estado FROM pedido WHERE idped = '$idped'";
    $result = mysqli_query($conn, $consulta);
    $row = mysqli_fetch_array($result);

    // Si el estado es '1' (asumiendo que significa "pedido cerrado/pagado"), redirige
    if ($row && $row['estado'] == '1') {
        unset($_SESSION['idped']);

        mysqli_close($conn);
        header('Location:mesas.php');
        exit();
    }
}

if (!$idped_activo) {
    mysqli_close($conn);
    header('Location:mesas.php'); // Redirige a donde el usuario pueda iniciar un pedido/seleccionar mesa
    exit();
}

?>
<!doctype html>
<html lang="es">

<head>
    <?php include("../head.php"); ?>
    <title>Restaurante La Despensa - Mi pedido</title>
</head>

<body>
    <?php include("../nav.php"); ?>
    <div class="wrapper">
        <?php include("navbar.php"); ?>
        <div id="content">
            <div class="container-fluid">

                <h1 class="page-heading">Pedido para la Mesa Nº <?php echo $idmesa; ?></h1>
                <p class="subheading">Añada los productos a su pedido.</p>
                <div class="row g-4">

                    <div class="col-lg-7">
                        <div class="card shadow-sm">
                            <div class="card-header ">
                                <h4 class="mb-5">Menú</h4>
                                <form method="GET" class="mb-4">
                                    <div class="input-group">
                                        <input type="text" name="buscar" class="form-control" placeholder="Buscar producto...">
                                        <button class="btn btn-outline-primary" type="submit">Buscar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div style="max-height: 60vh; overflow-y: auto;">

                                    <?php

                                    // 1. Obtener el término de búsqueda
                                    if (isset($_GET['buscar'])) {
                                        $busqueda = $_GET['buscar'];
                                    } else {
                                        $busqueda = '';
                                    }

                                    // 2. Consulta para obtener todas las categorías activas
                                    $consulta_categorias = "SELECT idcat, nombre FROM categoria ORDER BY idcat ASC";
                                    $result_categorias = mysqli_query($conn, $consulta_categorias);

                                    if (mysqli_num_rows($result_categorias) > 0) {

                                        // 3. Iterar sobre las categorías
                                        while ($categoria = mysqli_fetch_assoc($result_categorias)) {
                                            $idcat = $categoria['idcat'];
                                            $nombre_categoria = $categoria['nombre'];

                                            $consulta_productos = "SELECT idprod, nombre, precio, stock FROM producto WHERE categoria = '$idcat' AND estado = 0";
                                            if ($busqueda != '') {
                                                $consulta_productos .= " AND nombre LIKE '%$busqueda%'";
                                            }
                                            $consulta_productos .= " ORDER BY nombre ASC";

                                            $result_productos = mysqli_query($conn, $consulta_productos);

                                            // Si hay productos en la categoría (o que coinciden con la búsqueda)

                                            if (mysqli_num_rows($result_productos) > 0) {
                                                echo "<h4 class='mt-4 mb-2 p-2 bg-secondary text-white rounded'>{$nombre_categoria}</h4>";

                                                // 5. Iterar sobre los productos
                                                while ($producto = mysqli_fetch_assoc($result_productos)) {
                                                    $idprod = $producto['idprod'];
                                                    $nombre_producto = $producto['nombre'];
                                                    $precio_producto = number_format($producto['precio'], 2); // Formatear precio a 2 decimales
                                                    $stock_producto = (int)$producto['stock'];


                                    ?>
                                                    <div class="mb-3 p-2 border rounded">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <h5 class="mb-0"><?php echo $nombre_producto; ?></h5>
                                                                <small><?php echo $precio_producto; ?>€</small>
                                                            </div>
                                                            <?php if ($stock_producto <= 0) { ?>
                                                                <span class="badge bg-danger align-self-center">Agotado</span>
                                                            <?php } ?>
                                                        </div>

                                                        <?php if (($stock_producto > 0) && isset($idped)) { // Mostrar formulario solo si hay stock y el pedido existe 
                                                        ?>
                                                            <form action="añadir_carro.php" method="POST" class="d-flex flex-wrap gap-2 mt-2">
                                                                <input type="hidden" name="idped" value="<?php echo $idped; ?>">
                                                                <input type="hidden" name="idprod" value="<?php echo $idprod; ?>">
                                                                <input type="hidden" name="nombre" value="<?php echo $nombre_producto; ?>">
                                                                <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">

                                                                <div class="flex-grow-1" style="min-width: 150px;">
                                                                    <input type="text" name="comentario" class="form-control form-control-sm" placeholder="Ej: Sin cebolla, poco hecho..." maxlength="250">
                                                                </div>

                                                                <div class="d-flex gap-2">
                                                                    <input type="number" name="cantidad" value="1" min="1" max="<?php echo $stock_producto; ?>" class="form-control form-control-sm" style="width: 70px;">
                                                                    <button type="submit" class="btn btn-primary btn-sm">Añadir</button>
                                                                </div>
                                                            </form>
                                                        <?php } else { // Bloque que se muestra si NO hay stock disponible o no hay pedido activo 
                                                        ?>
                                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                                <div class="flex-grow-1" style="min-width: 150px;">
                                                                    <input type="text" class="form-control form-control-sm" placeholder="Ej: Sin cebolla, poco hecho..." disabled>
                                                                </div>
                                                                <div class="d-flex gap-2">
                                                                    <input type="number" value="0" class="form-control form-control-sm" style="width: 70px;" disabled>
                                                                    <button type="button" class="btn btn-outline-danger btn-sm" disabled>Añadir</button>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                    <?php
                                                }
                                            }
                                        }
                                    } else {
                                        // Si no hay categorías
                                        echo "<p class='alert alert-warning'>No se encontraron categorías de productos activas.</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card shadow-sm" style="position: sticky; top: 20px;">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Tu pedido (Mesa: <?php echo $idmesa; ?>)</h4>
                            </div>
                            <div class="card-body">

                                <?php
                                $total_pedido = 0.00;

                                // Inicia el div para el scroll del carrito
                                echo '<div style="max-height: 15vh; overflow-y: auto;" class="mb-3">';

                                if (!empty($_SESSION['carrito'])) {
                                    foreach ($_SESSION['carrito'] as $indice => $producto) {

                                        // Calcula el subtotal de esta línea
                                        $subtotal = $producto['precio'] * $producto['cantidad'];
                                        $total_pedido += $subtotal; // Acumula al total general

                                ?>
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <strong><?php echo $producto['cantidad']; ?>  x  <?php echo $producto['nombre']; ?></strong>

                                                <?php if (!empty($producto['comentario'])) { ?>
                                                    <br><small class="text-muted"><span class="fs-5">↳</span> <?php echo $producto['comentario']; ?></small>
                                                <?php } ?>

                                            </div>
                                            <div class="text-end d-flex align-items-center gap-2">
                                                <span><?php echo number_format($subtotal, 2); ?>€</span>
                                                <form action="quitar_carro.php" method="POST" style="margin: 0;">
                                                    <input type="hidden" name="eliminar_producto" value="1">
                                                    <input type="hidden" name="indice_carrito" value="<?php echo $indice; ?>">
                                                    <input type="hidden" name="idprod_eliminado" value="<?php echo $producto['id']; ?>">
                                                    <input type="hidden" name="cantidad_eliminada" value="<?php echo $producto['cantidad']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-md p-2">
                                                        X</button>
                                                </form>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<p class='text-center text-muted'>El carrito está vacío.</p>";
                                }

                                echo '</div>'; // Cierre del div de scroll del carrito
                                ?>

                                <hr>
                                <h3 class="d-flex justify-content-between">
                                    <span>Total:</span>
                                    <span><?php echo number_format($total_pedido, 2); ?>€</span>
                                </h3>

                                <form action="enviar_carro.php" method="POST" class="d-grid">
                                    <button class="btn btn-outline-success btn-lg" <?php if (empty($_SESSION['carrito'])) echo 'disabled'; ?>>
                                        <span>Enviar Pedido</span>
                                    </button>
                                </form>
                                <a href="pedido_completo.php" class="btn btn-outline-secondary w-100 mt-3">
                                    Ver pedido completo
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
    mysqli_close($conn);
    include("../footer.php");
    ?>
</body>

</html>