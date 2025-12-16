<?php
include("../seguridad.php");
proteger(1);
include("../conexion.php");
// Recibimos el número de mesa desde la URL
$id_mesa = $_GET['id'];

// Variable para controlar si ya se pidió la cuenta (0 = no, 1 = sí)
if (!isset($_SESSION['cuenta_pedida_mesa_' . $id_mesa])) {
    $_SESSION['cuenta_pedida_mesa_' . $id_mesa] = 0;
}

// ===== ACCIONES QUE PUEDE HACER EL USUARIO =====

// ACCIÓN 1: Marcar un producto como servido
if (isset($_POST['marcar_servido'])) {
    $id_linea = $_POST['id_linea'];
    
    // Actualizamos el estado del producto a "servido" (1)
    $sql = "UPDATE pedido_producto SET servido = 1 WHERE idline = $id_linea";
    mysqli_query($conn, $sql);
    
    // Recargamos la página para ver los cambios
    header("Location: servir_pedido.php?id=" . $id_mesa);
    exit();
}

// ACCIÓN 2: Generar la cuenta (imprimir ticket)
if (isset($_POST['generar_cuenta'])) {
    // Marcamos que ya se pidió la cuenta
    $_SESSION['cuenta_pedida_mesa_' . $id_mesa] = 1;
    
    $idped = $_POST['idped'];
    
    // Redirigimos a la página que genera el ticket
    header("Location: generar_ticket.php?mesa=" . $id_mesa . "&pedido=" . $idped);
    exit();
}

// ACCIÓN 3: Cerrar la mesa (el cliente ya pagó)
if (isset($_POST['cerrar_mesa'])) {
    // Liberamos la mesa (estado = 0 significa libre)
    $sql1 = "UPDATE mesa SET estado = 0 WHERE nmesa = $id_mesa";
    mysqli_query($conn, $sql1);
    
    // Marcamos la reserva como terminada
    $sql2 = "UPDATE reserva SET estado = 1 WHERE nmesa = $id_mesa";
    mysqli_query($conn, $sql2);
    
    // Marcamos el pedido como pagado
    $sql3 = "UPDATE pedido SET estado = 1 WHERE nmesa = $id_mesa AND estado = 0";
    mysqli_query($conn, $sql3);
    
    // Reiniciamos la variable de sesión
    $_SESSION['cuenta_pedida_mesa_' . $id_mesa] = 0;
    
    // Volvemos a la página principal de mesas
    header("Location: gestionarmesas.php");
    exit();
}

// ===== CONSULTAS PARA MOSTRAR INFORMACIÓN =====

// Buscamos si hay un pedido activo en esta mesa
$sql_pedido = "SELECT * FROM pedido WHERE nmesa = $id_mesa AND estado = 0";
$resultado_pedido = mysqli_query($conn, $sql_pedido);
$pedido = mysqli_fetch_assoc($resultado_pedido);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
    include("../head.php");
    ?>
    <title>Mesa <?php echo $id_mesa; ?> - Restaurante</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestión de Mesa <?php echo $id_mesa; ?></h1>
        
        <div class="row">
            <!-- COLUMNA IZQUIERDA: Lista de productos -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Productos del Pedido</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Comentarios</th>
                                    <th>Cantidad</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
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
                                            $estado_texto = "Pendiente";
                                            $color_badge = "warning";
                                            $ya_servido = false;
                                        } else {
                                            $estado_texto = "Servido";
                                            $color_badge = "success";
                                            $ya_servido = true;
                                        }
                                        
                                        // Mostramos la fila de la tabla
                                        echo "<tr>";
                                        echo "<td>" . $nombre_producto['nombre'] . "</td>";
                                        echo "<td>" . $producto['comentario'] . "</td>";
                                        echo "<td class='text-center'>" . $producto['cant'] . "</td>";
                                        echo "<td><span class='badge bg-" . $color_badge . "'>" . $estado_texto . "</span></td>";
                                        echo "<td>";
                                        
                                        // Formulario para marcar como servido
                                        echo "<form method='POST' style='display:inline;'>";
                                        echo "<input type='hidden' name='id_linea' value='" . $producto['idline'] . "'>";
                                        
                                        if (!$ya_servido) {
                                            echo "<button type='submit' name='marcar_servido' class='btn btn-sm btn-success'>Marcar Servido</button>";
                                        } else {
                                            echo "<button class='btn btn-sm btn-secondary' disabled>Ya Servido</button>";
                                        }
                                        
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    // No hay pedidos activos
                                    echo "<tr><td colspan='5' class='text-center'>No hay pedidos activos en esta mesa</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
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
                        <div class="card-header bg-warning">
                            <h4>Generar Cuenta</h4>
                        </div>
                        <div class="card-body">
                            <p>El cliente ha pedido la cuenta. Pulsa aquí para imprimir el ticket.</p>
                            <form method="POST">
                                <input type="hidden" name="idped" value="<?php echo $pedido['idped']; ?>">
                                <button type="submit" name="generar_cuenta" class="btn btn-warning btn-lg w-100">
                                    📄 Generar Ticket
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
                            <p>La cuenta ya fue generada. Pulsa este botón solo cuando el cliente haya pagado.</p>
                            <form method="POST">
                                <button type="submit" name="cerrar_mesa" class="btn btn-danger btn-lg w-100">
                                    ✓ Marcar como Pagada
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
            <a href="gestionarmesas.php" class="btn btn-secondary">← Volver a Mesas</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// Cerramos la conexión a la base de datos
mysqli_close($conn);
?>