<?php
include("../seguridad.php");
proteger(1);
include("../conexion.php");

// Recibimos el número de mesa desde la URL
$id_mesa = $_GET['id'];

// Marcamos el producto como servido
if (isset($_POST['marcar_servido'])) {

    $id_linea = $_POST['id_linea'];
    //actualizamos cada vez que sirvamos un producto
    $actualizar_servido = "UPDATE pedido_producto SET servido = 1 WHERE idline = $id_linea";
    mysqli_query($conn, $actualizar_servido);
    //y redirigimos a la misma pagina para que se vea el cambio actualizado
    header("Location:servir_pedido.php?id=".$id_mesa);
    exit();
}

// Generamos la cuenta (imprimir ticket)
if (isset($_POST['generar_cuenta'])) {
  
    $idped = $_POST['idped'];

    // Liberamos la mesa
    mysqli_query($conn, "UPDATE mesa SET estado = 0 WHERE nmesa = $id_mesa");
    // Marcamos la reserva como terminada
    mysqli_query($conn, "UPDATE reserva SET estado = 1 WHERE nmesa = $id_mesa");
    // Marcamos el pedido como pagado
    mysqli_query($conn, "UPDATE pedido SET estado = 1 WHERE nmesa = $id_mesa AND estado = 0");


    // header("Location:servir_pedido.php?id=".$id_mesa."&idp=".$idped);
    // exit();

    header("Location:tickets/generar_ticket.php?idm=" . $id_mesa . "&idp=" . $idped);
    exit();
}

// Buscamos si hay un pedido activo en esta mesa
$consulta_pedido = "SELECT * FROM pedido WHERE nmesa = $id_mesa AND estado = 0";
$resultado_pedido = mysqli_query($conn, $consulta_pedido);
$pedido = mysqli_fetch_assoc($resultado_pedido);

// Comprobamos si hay productos pendientes de servir
$productos_pendientes = false;

if ($pedido) {
    $idped = $pedido['idped'];
    $sql_pendientes = "SELECT * FROM pedido_producto WHERE idped = $idped AND servido = 0";
    $res_pendientes = mysqli_query($conn, $sql_pendientes);
    if (mysqli_num_rows($res_pendientes) > 0) {
        $productos_pendientes = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("../head.php"); ?>
    <title>Mesa <?php echo $id_mesa;?> - Restaurante La Despensa</title>
</head>
<body>
    <?php include("../nav.php"); ?>
    <div class="wrapper">
        <?php include("navbar.php"); ?>
        <div class="container-fluid">
            <h1 class="mt-5 mb-5">Resumen del Pedido de la Mesa <?php echo $id_mesa;?></h1>
            <div class="row justify-content-center ">
                <!--Lista de productos -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">Productos del Pedido</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class='text-center'>
                                            <th>Producto</th>
                                            <th>Comentarios</th>
                                            <th>Cantidad</th>
                                            <th>Estado</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($pedido) {

                                        //consulta de productos del pedido
                                        $sql_productos = "SELECT * FROM pedido_producto WHERE idped = $idped";
                                        $resultado_productos = mysqli_query($conn, $sql_productos);
                                        while ($producto = mysqli_fetch_assoc($resultado_productos)) {

                                            $idprod = $producto['idprod'];
                                            $sql_nombre = "SELECT nombre FROM producto WHERE idprod = $idprod";
                                            $nombre_producto = mysqli_fetch_assoc(mysqli_query($conn, $sql_nombre));
                                            
                                            $estado_texto = $producto['servido'] == 0 ? "PENDIENTE" : "SERVIDO";
                                            $infocolorin = $producto['servido'] == 0 ? "warning" : "success";
                                            $esta_servido = $producto['servido'] == 1;
                                    ?>
                                            <tr class='text-center'>
                                                <td ><?php echo $nombre_producto['nombre'];?></td>
                                                <td><?php echo $producto['comentario']; ?></td>
                                                <td class="text-center"><?php echo $producto['cant']; ?></td>
                                                <td><span class='btn btn-sm btn-<?php echo $infocolorin; ?> disabled'><?php echo $estado_texto; ?></span></td>
                                                <td>
                                                    <form method='POST' style='display:inline;'>
                                                        <input type='hidden' name='id_linea' value='<?php echo $producto['idline'];?>'>
                                                        <?php if (!$esta_servido): ?>
                                                            <button type='submit' name='marcar_servido' class='btn btn-sm btn-outline-success'>SERVIR</button>
                                                        <?php else: ?>
                                                            <button class='btn btn-sm btn-outline-secondary' disabled>SERVIDO</button>
                                                        <?php endif; ?>
                                                    </form>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>No hay pedidos activos en esta mesa</td></tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Generar cuenta -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white"><h4>Generar Cuenta</h4></div>
                        <div class="card-body text-center">
                            <p>El cliente ha pedido la cuenta. Pulsa aquí para imprimir el ticket.</p>
                            <form method="POST">
                                <input type="hidden" name="idped" value="<?php echo $pedido['idped'] ?? 0; ?>">
                                <button type="submit" name="generar_cuenta" class="btn btn-outline-success btn-lg w-100"
                                    <?php if ($productos_pendientes) echo 'disabled'; ?>>
                                    GENERAR TICKET Y CERRAR MESA
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="gestionarmesas.php" class="btn btn-outline-info rounded-5 text-secondary">← VOLVER</a>
            </div>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
