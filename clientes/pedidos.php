<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

// 3. Cogemos el ID del pedido de la URL
$id_pedido_actual = (int)$_GET['idped']; 

// 4. Buscamos el número de mesa de ESE pedido (para el título)
$sql_mesa = "SELECT nmesa FROM pedido WHERE idped = $id_pedido_actual";
$res_mesa = mysqli_query($conn, $sql_mesa);
$fila_mesa = mysqli_fetch_assoc($res_mesa);
$nmesa_pedido = $fila_mesa['nmesa']; 

//Creamos una "llave" única para el carrito en la sesión
$cart_session_key = 'carrito_' . $id_pedido_actual;

// Si no existe un carrito para ESTE pedido, lo creamos como un array vacío
if (!isset($_SESSION[$cart_session_key])) {
    $_SESSION[$cart_session_key] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $accion = $_POST['accion'];

    // --- ACCIÓN: AÑADIR ---
    if ($accion == 'añadir') {
        $idprod = (int)$_POST['idprod'];
        $cantidad = (int)$_POST['cantidad'];
        $comentario = trim($_POST['comentario_prod']);
        $item_key = $idprod . '_' . md5($comentario);

        // --- ¡CAMBIO 1! ---
        // Antes de añadir, consultamos el stock REAL de la BBDD
        $res_prod = mysqli_query($conn, "SELECT nombre, precio, stock FROM producto WHERE idprod = $idprod");
        $prod_db = mysqli_fetch_assoc($res_prod);

        // Comprobamos si hay stock suficiente
        if ($prod_db['stock'] >= $cantidad) {
            
            // ¡Sí hay!
            // 1. Restamos el stock de la BBDD
            $sql_restar_stock = "UPDATE producto SET stock = stock - $cantidad WHERE idprod = $idprod";
            mysqli_query($conn, $sql_restar_stock);

            // 2. Añadimos al array de sesión (como antes)
            if (isset($_SESSION[$cart_session_key][$item_key])) {
                $_SESSION[$cart_session_key][$item_key]['cant'] += $cantidad;
            } else {
                $_SESSION[$cart_session_key][$item_key] = [
                    'idprod'     => $idprod,
                    'nombre'     => $prod_db['nombre'],
                    'precio'     => $prod_db['precio'],
                    'cant'       => $cantidad,
                    'comentario' => $comentario
                ];
            }
        }
        // Si no hay stock (el 'if' falla), simplemente no hace nada.
        // El usuario verá el botón rojo y no podrá añadir.
    }

    // --- ACCIÓN: QUITAR (Limpiar un item) ---
    if ($accion == 'quitar') {
        $item_key_a_quitar = $_POST['item_key'];
        
        // --- ¡CAMBIO 2! ---
        // Lógica para DEVOLVER el stock
        if (isset($_SESSION[$cart_session_key][$item_key_a_quitar])) {
            
            // 1. Leemos cuántos vamos a quitar ANTES de borrarlo
            $item_a_quitar = $_SESSION[$cart_session_key][$item_key_a_quitar];
            $idprod_a_devolver = $item_a_quitar['idprod'];
            $cantidad_a_devolver = $item_a_quitar['cant'];

            // 2. Devolvemos el stock a la BBDD
            $sql_devolver_stock = "UPDATE producto SET stock = stock + $cantidad_a_devolver WHERE idprod = $idprod_a_devolver";
            mysqli_query($conn, $sql_devolver_stock);
            
            // 3. Ahora sí, lo borramos del array de sesión
            unset($_SESSION[$cart_session_key][$item_key_a_quitar]);
        }
    }

    // 8. REDIRECCIÓN (Importante: para limpiar el POST)
    header("Location: " . $_SERVER['PHP_SELF'] . "?idped=" . $id_pedido_actual);
    exit;
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
                
                <h1 class="page-heading">Pedido para la Mesa Nº <?php echo $nmesa_pedido; ?></h1>
                <p class="subheading">Añada los productos a su pedido.</p>
                <div class="row g-4">

                    <div class="col-lg-7">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light"><h4 class="mb-0">Menú</h4></div>
                            <div class="card-body" style="max-height: 70vh; overflow-y: auto;">
                                <?php
                                // Esta consulta ahora trae el stock actualizado
                                $consultaproductos = "SELECT idprod, nombre, precio, stock FROM producto WHERE estado = 0 ORDER BY categoria, nombre";
                                $resultado_productos = mysqli_query($conn, $consultaproductos);

                                while ($prod = mysqli_fetch_assoc($resultado_productos)) {
                                ?>
                                    <div class="mb-3 p-2 border rounded">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h5 class="mb-0"><?php echo $prod['nombre']; ?></h5>
                                                <small class="text-muted"><?php echo number_format($prod['precio'], 2); ?> €</small>
                                            </div>
                                            </div>
                                        
                                        
                                        <?php if ($prod['stock'] > 0): ?>
                                            <form action="" method="POST" class="d-flex flex-wrap gap-2 mt-2">
                                                <input type="hidden" name="accion" value="añadir">
                                                <input type="hidden" name="idped" value="<?php echo $id_pedido_actual; ?>">
                                                <input type="hidden" name="idprod" value="<?php echo $prod['idprod']; ?>">

                                                <div class="flex-grow-1" style="min-width: 150px;">
                                                    <input type="text" name="comentario_prod" class="form-control form-control-sm" placeholder="Ej: Sin cebolla, poco hecho..." maxlength="250">
                                                </div>
                                                
                                                <div class="d-flex gap-2">
                                                    <input type="number" name="cantidad" value="1" min="1" max="<?php echo $prod['stock']; ?>" class="form-control form-control-sm" style="width: 70px;">
                                                    <button type="submit" class="btn btn-primary btn-sm">Añadir</button>
                                                </div>
                                            </form>
                                        
                                        <?php else: ?>
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                <div class="flex-grow-1" style="min-width: 150px;">
                                                    <input type="text" class="form-control form-control-sm" placeholder="Ej: Sin cebolla, poco hecho..." disabled>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <input type="number" value="0" class="form-control form-control-sm" style="width: 70px;" disabled>
                                                    <button type="button" class="btn btn-danger btn-sm" disabled>Sin Stock</button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        </div>
                                <?php } // Fin del 'while' de productos ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card shadow-sm" style="position: sticky; top: 20px;">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Tu Pedido</h4>
                            </div>
                            <div class="card-body">
                                <?php
                                $total_pedido = 0; 
                                
                                if (empty($_SESSION[$cart_session_key])) {
                                    echo "<p class='text-center text-muted'>El carrito está vacío.</p>";
                                } else {
                                    // Recorremos el array de sesión
                                    foreach ($_SESSION[$cart_session_key] as $item_key => $item) {
                                        $subtotal = $item['precio'] * $item['cant'];
                                        $total_pedido += $subtotal; 
                                ?>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <strong><?php echo $item['cant']; ?> x <?php echo $item['nombre']; ?></strong><br>
                                            
                                            <?php if (!empty($item['comentario'])): ?>
                                                <small class="text-info fst-italic ps-2">↳ "<?php echo $item['comentario']; ?>"</small><br>
                                            <?php endif; ?>
                                            
                                            <small class="text-muted ps-2"><?php echo number_format($subtotal, 2); ?> €</small>
                                        </div>
                                        
                                        <form action="" method="POST">
                                            <input type="hidden" name="accion" value="quitar">
                                            <input type="hidden" name="item_key" value="<?php echo $item_key; ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Quitar producto">
                                                X
                                            </button>
                                        </form>
                                    </div>
                                <?php
                                    } // Fin del 'foreach'
                                } // Fin del 'else'
                                ?>
                                
                                <hr>
                                <h3 class="d-flex justify-content-between">
                                    <span>Total:</span>
                                    <span><?php echo number_format($total_pedido, 2); ?> €</span>
                                </h3>
                                
                                <a href="finalizar_pedido.php" class="btn btn-success w-100 mt-3">
                                    Confirmar y Finalizar
                                </a>
                            </div>
                        </div>
                    </div>

                </div> </div>
        </div>
    </div>
    <?php 
    mysqli_close($conn); 
    include("../footer.php"); 
    ?>
</body>
</html>