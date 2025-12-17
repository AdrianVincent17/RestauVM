<?php
include("../seguridad.php");
proteger(1);
include("../conexion.php");

// Recibimos el número de mesa desde la URL
$id_mesa = $_GET['id'];


// Variable para controlar si ya se pidió la cuenta (0 = no, 1 = sí)
if (!isset($_SESSION['cuenta_pedida_mesa_'.$id_mesa])) {
    $_SESSION['cuenta_pedida_mesa_' . $id_mesa] = 0;
}

// marcamos el producto como servido
if (isset($_POST['marcar_servido'])) {
    $id_linea = $_POST['id_linea'];

    // Actualizamos el estado del producto a "servido" (1)
    $actualizar_servido = "UPDATE pedido_producto SET servido = 1 WHERE idline = $id_linea";
    mysqli_query($conn, $actualizar_servido);

    // Recargamos la página para ver los cambios
    header("Location:servir_pedido.php?id=".$id_mesa);
    exit();
}

// Generamos la cuenta (imprimir ticket)
if (isset($_POST['generar_cuenta'])) {

    // Marcamos que ya se pidió la cuenta
    $_SESSION['cuenta_pedida_mesa_'.$id_mesa] = 1;


    $idped = $_POST['idped'];

     header("Location:servir_pedido.php?id=".$id_mesa ."&idp=".$idped);
    exit();

    // // Redirigimos a la página que genera el ticket
    // header("Location:tickets/generar_ticket.php?idm=" . $id_mesa . "&idp=" . $idped);
    // exit();
}

//  Cerrar la mesa (el cliente ya pagó)
if (isset($_POST['cerrar_mesa'])) {

    // Liberamos la mesa (estado = 0 significa libre)
    $mesa_libre = "UPDATE mesa SET estado = 0 WHERE nmesa = $id_mesa";

    mysqli_query($conn, $mesa_libre);

    // Marcamos la reserva como terminada
    $reserva_terminada = "UPDATE reserva SET estado = 1 WHERE nmesa = $id_mesa";
    mysqli_query($conn, $reserva_terminada);

    // Marcamos el pedido como pagado
    $pedi_pagado = "UPDATE pedido SET estado = 1 WHERE nmesa = $id_mesa AND estado = 0";
    mysqli_query($conn, $pedi_pagado);

    // Reiniciamos la variable de sesión
    $_SESSION['cuenta_pedida_mesa_' . $id_mesa] = 0;

    // Volvemos a la página principal de mesas
    header("Location: gestionarmesas.php");
    exit();
}

// Buscamos si hay un pedido activo en esta mesa
$consulta_pedido = "SELECT * FROM pedido WHERE nmesa = $id_mesa AND estado = 0";
$resultado_pedido = mysqli_query($conn, $consulta_pedido);
$pedido = mysqli_fetch_assoc($resultado_pedido);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include("../head.php");
    ?>
    <title>Mesa <?php echo $id_mesa;?> - Restaurante La Despensa</title>
</head>

<body>
    <div class="d-flex flex-column w-100">
        <?php
        include("../nav.php");
        ?>
        <div class="wrapper">
            <?php
            include("navbar.php");
            ?>
            <div class="container-fluid">
                <h1 class="mt-5 mb-5">Resumen del Pedido de la Mesa <?php echo $id_mesa;?></h1>
                <div class="row justify-content-center ">
                    <!--Lista de productos -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                Productos del Pedido
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Comentarios</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        // Si hay un pedido activo, mostramos sus productos
                                        if ($pedido) {
                                            $idped = $pedido['idped'];

                                            // Buscamos todos los productos de este pedido
                                            $sql_productos = "SELECT * FROM pedido_producto WHERE idped = $idped";
                                            $resultado_productos = mysqli_query($conn, $sql_productos);

                                            // Recorremos cada producto
                                            while ($producto = mysqli_fetch_assoc($resultado_productos)) {

                                                // Buscamos el nombre del producto
                                                $idprod = $producto['idprod'];
                                                $sql_nombre = "SELECT nombre FROM producto WHERE idprod = $idprod";
                                                $resultado_nombre = mysqli_query($conn, $sql_nombre);
                                                $nombre_producto = mysqli_fetch_assoc($resultado_nombre);

                                                // Determinamos el estado del producto
                                                if ($producto['servido'] == 0) {
                                                    $estado_texto = "PENDIENTE";
                                                    $infocolorin = "warning";
                                                    $esta_servido = false;
                                                } else {
                                                    $estado_texto = "SERVIDO";
                                                    $infocolorin = "success";
                                                    $esta_servido = true;
                                                }
                                        ?>

                                                <!--  Mostramos la fila de la tabla -->
                                                <tr>
                                                    <td><?php echo $nombre_producto['nombre'];?></td>
                                                    <td class=><?php echo $producto['comentario']; ?></td>
                                                    <td class='text-center'><?php echo  $producto['cant']; ?></td>
                                                    <td><span class='btn btn-sm btn-<?php echo $infocolorin; ?> disabled'><?php echo $estado_texto; ?></span></td>
                                                    <td>

                                                        <!-- Formulario para marcar como servido -->
                                                        <form method='POST' style='display:inline;'>
                                                            <input type='hidden' name='id_linea' value='<?php echo $producto['idline'];?>'>
                                                            <?php

                                                            if (!$esta_servido) {

                                                            ?>

                                                                <button type='submit' name='marcar_servido' class='btn btn-sm btn-outline-success'>SERVIR</button>
                                                            <?php

                                                            } else {

                                                            ?>

                                                                <button class='btn btn-sm btn-outline-secondary' disabled>SERVIDO</button>
                                                            <?php
                                                            }
                                                            ?>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <!-- No hay pedidos activos -->
                                            <tr>
                                                <td colspan='5' class='text-center'>No hay pedidos activos en esta mesa</td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- COLUMNA DERECHA: Botones de acción -->
                    <div class="col-md-4">
                        <?php

                        // Mostramos diferentes botones según el estado
                        if ($_SESSION['cuenta_pedida_mesa_' . $id_mesa] == 0) {

                            // Aún no se ha pedido la cuenta
                        ?>
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h4>Generar Cuenta</h4>
                                </div>
                                <div class="card-body">
                                    <p class="text-center">El cliente ha pedido la cuenta. Pulsa aquí para imprimir el ticket.</p>
                                    <form method="POST">
                                        <input type="hidden" name="idped" value="<?php echo $pedido['idped']; ?>">
                                        <button type="submit" name="generar_cuenta" class="btn btn-outline-success btn-lg w-100">
                                           GENERAR TICKET
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php
                        } else {

                            // Ya se generó la cuenta, esperamos el pago
                        ?>
                            <div class="card">
                                <div class="card-header bg-danger text-white">
                                    <h4>Cerrar Mesa</h4>
                                </div>
                                <div class="card-body">
                                    <p class="text-center">La cuenta ya fue generada. Pulsa este botón solo cuando el cliente haya pagado.</p>
                                    <form method="POST">
                                        <button type="submit" name="cerrar_mesa" class="btn btn-outline-danger btn-lg w-100">
                                             CERRAR MESA
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="gestionarmesas.php" class="btn btn-outline-info rounded-5 text-secondary">← VOLVER</a>
                </div>
            </div>

</body>

</html>
<?php
// Cerramos la conexión a la base de datos
mysqli_close($conn);
?>