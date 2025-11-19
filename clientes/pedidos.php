<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

// Verificar si NO hay 'idped' en la URL
if (!isset($_GET['idped'])) {
    // Si no hay 'idped' en la URL, comprobamos si el usuario tiene un pedido abierto (estado = 0)
    $dni_cliente = $_SESSION['dni']; // Asegúrate de que esta variable sea la correcta

    $sql_pedido_abierto = "SELECT idped FROM pedido WHERE usuario = '$dni_cliente' AND estado = 0 LIMIT 1";
    $res_pedido_abierto = mysqli_query($conn, $sql_pedido_abierto);

    //Comprobamos si hay un pedido activo para el cliente
    if ($res_pedido_abierto && ($rowp = mysqli_fetch_assoc($res_pedido_abierto))) {
        //Redirigimos a la página con el ID de pedido correcto
        $pedido_existente = (int)$rowp['idped'];
        mysqli_free_result($res_pedido_abierto);
        mysqli_close($conn);
        header("Location: pedidos.php?idped=" . $pedido_existente);
        exit();
    } else {
        //No hay pedido activo, lo enviamos a la página de mesas
        mysqli_close($conn);
        header("Location: mesas.php");
        exit();
    }
}

// Cogemos el ID del pedido de la URL de forma segura
$idped = (int)$_GET['idped'];

// Buscamos el número de mesa de ESE pedido (para el título)
$sql_mesa = "SELECT nmesa FROM pedido WHERE idped = $idped";
$res_mesa = mysqli_query($conn, $sql_mesa);

// Comprobamos si la consulta devolvió un resultado válido
if (!$res_mesa || mysqli_num_rows($res_mesa) === 0) {

    // Si el ID del pedido no existe, redirigimos a mesas
    mysqli_close($conn);
    header("Location: mesas.php");
    exit();
}


$fila_mesa = mysqli_fetch_assoc($res_mesa);
$nmesa_pedido = $fila_mesa['nmesa'];
mysqli_free_result($res_mesa);

// Creamos una "llave" única para el carrito en la sesión
$carrito = 'carrito_' . $idped;

// Si no existe un carrito para ESTE pedido, lo creamos como un array vacío
if (!isset($_SESSION[$carrito])) {
    $_SESSION[$carrito] = [];
}

// Define la vista actual: 'pendiente' (carrito) o 'total' (DB)
$vista_actual = isset($_GET['vista']) ? $_GET['vista'] : 'pendiente';

// Lógica para el Pedido Total (Items ya enviados a BBDD)
$sql_pedido_completo = "
    SELECT 
        pp.idprod, 
        p.nombre, 
        p.precio, 
        pp.comentario,
        SUM(pp.cant) AS cantidad_total 
    FROM pedido_producto pp
    JOIN producto p ON pp.idprod = p.idprod
    WHERE pp.idped = $idped
    GROUP BY pp.idprod, pp.comentario, p.nombre, p.precio
    ORDER BY p.nombre";
$res_pedido_completo = mysqli_query($conn, $sql_pedido_completo);

$total_pedido_completo = 0; //variable que almacena el precio total del pedido

$items_completos = [];
if ($res_pedido_completo) {
    while ($item = mysqli_fetch_assoc($res_pedido_completo)) {
        $items_completos[] = $item;
        $total_pedido_completo += $item['precio'] * $item['cantidad_total'];
    }
    mysqli_free_result($res_pedido_completo);
}



//Obtener todas las categorías para los botones (usando la tabla 'categoria')
$sql_categorias = "SELECT idcat, nombre FROM categoria ORDER BY idcat";
$res_categorias = mysqli_query($conn, $sql_categorias);

//Inicializar el filtro de ID de categoría (usa 0 para "todas")
$filtro_idcat = isset($_GET['idcat']) ? (int)$_GET['idcat'] : 0;

//Construir la consulta de productos con JOIN a 'categoria' para obtener el nombre
$consultaproductos = "SELECT 
                        p.idprod, 
                        p.nombre, 
                        p.precio, 
                        p.stock, 
                        c.nombre AS categoria_nombre, 
                        c.idcat AS categoria_id 
                      FROM producto p
                      JOIN categoria c ON p.categoria = c.idcat
                      WHERE p.estado = 0";

if ($filtro_idcat !== 0) {
    // Si hay un filtro, se usa el ID de la categoría (p.categoria)
    $consultaproductos .= " AND p.categoria = " . $filtro_idcat;
}

$consultaproductos .= " ORDER BY c.idcat, p.nombre";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $accion = $_POST['accion'];

    // --- ACCIÓN: AÑADIR ---
    if ($accion == 'añadir') {
        $idprod = (int)$_POST['idprod'];
        $cantidad = (int)$_POST['cantidad'];
        $comentario = trim($_POST['comentario_prod']);
        
        // La clave del ítem se genera usando el ID del producto y el hash del comentario
        // para distinguir ítems iguales con comentarios diferentes.
        $item_key = $idprod . '_' . md5($comentario);


        // Antes de añadir, consultamos el stock REAL de la BBDD
        $consultastock = "SELECT stock FROM producto WHERE idprod = $idprod";

        $stockproducto = mysqli_query($conn, $consultastock);
        $rowproducto = mysqli_fetch_assoc($stockproducto);

        // Comprobamos si hay stock suficiente
        if ($rowproducto && $rowproducto['stock'] >= $cantidad) {

            // Si hay stock, procedemos a añadir al carrito y restar stock
            // Restamos el stock de la BBDD
            $restarstock = "UPDATE producto SET stock = stock - $cantidad WHERE idprod = $idprod";
            mysqli_query($conn, $restarstock);

            // Añadimos al array de sesión (como antes)
            if (isset($_SESSION[$carrito][$item_key])) {
                $_SESSION[$carrito][$item_key]['cant'] += $cantidad;
            } else {
                // Hay que consultar el nombre y el precio, que no están en $rowproducto si ya lo consultamos arriba
                $consultaprod_info = "SELECT nombre, precio FROM producto WHERE idprod = $idprod";
                $res_prod_info = mysqli_query($conn, $consultaprod_info);
                $row_prod_info = mysqli_fetch_assoc($res_prod_info);

                $_SESSION[$carrito][$item_key] = [
                    'idprod'      => $idprod,
                    'nombre'      => $row_prod_info['nombre'],
                    'precio'      => $row_prod_info['precio'],
                    'cant'        => $cantidad,
                    'comentario'  => $comentario // Guardamos el comentario en la sesión
                ];
            }
        }
    }

    // --- ACCIÓN: QUITAR (Limpiar un item) ---
    if ($accion == 'quitar') {
        $item_key_a_quitar = $_POST['item_key'];


        // Lógica para DEVOLVER el stock
        if (isset($_SESSION[$carrito][$item_key_a_quitar])) {

            // Leemos cuántos vamos a quitar ANTES de borrarlo
            $item_a_quitar = $_SESSION[$carrito][$item_key_a_quitar];
            $producto_a_devolver = $item_a_quitar['idprod'];
            $cantidad_a_devolver = $item_a_quitar['cant'];

            // Devolvemos el stock a la BBDD
            $sql_devolverstock = "UPDATE producto SET stock = stock + $cantidad_a_devolver WHERE idprod = $producto_a_devolver";
            mysqli_query($conn, $sql_devolverstock);

            //Ahora sí, lo borramos del array de sesión
            unset($_SESSION[$carrito][$item_key_a_quitar]);
        }
    }

    // REDIRECCIÓN (Importante: para limpiar el POST)
    // Redirigimos manteniendo el 'idped' y el 'idcat' actual y la vista actual.
    
    $redirect_url = "Location: " . $_SERVER['PHP_SELF'] . "?idped=" . $idped;
    if ($filtro_idcat !== 0) {
        $redirect_url .= "&idcat=" . $filtro_idcat;
    }
    $redirect_url .= "&vista=" . $vista_actual;
    header($redirect_url);
    exit();
}
?>
<!doctype html>
<html lang="es">

<head>
    <?php include("../head.php"); ?>
    <title>Restaurante La Despensa - Mi pedido</title>
    <style>
        /* Estilos CSS para mejorar la apariencia de los botones */
        .category-button-container {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .nav-tabs .nav-link {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include("../nav.php"); ?>
    <div class="wrapper">
        <?php include("navbar.php"); ?>
        <div id="content">
            <div class="container-fluid">

                <h1 class="page-heading">Pedido para la Mesa Nº <?php echo $nmesa_pedido; ?></h1>
                <p class="subheading">Añada los productos a su pedido.</p>

                <!-- Mensaje de éxito al enviar comanda -->
                <?php if (isset($_GET['comanda']) && $_GET['comanda'] == 'enviada'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        ¡Comanda enviada a cocina! El carrito se ha vaciado para que pueda añadir la siguiente tanda.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="row g-4">

                    <div class="col-lg-7">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h4 class="mb-0">Menú</h4>
                            </div>
                            <div class="card-body">

                                <div class="category-button-container mb-4 d-flex flex-wrap gap-2">
                                    <h6 class="w-100 mb-2">Filtrar por:</h6>

                                    <!-- Botón para mostrar TODAS las categorías -->
                                    <a href="pedidos.php?idped=<?php echo $idped; ?>&idcat=0&vista=<?php echo $vista_actual; ?>"
                                        class="btn btn-sm <?php echo ($filtro_idcat == 0 ? 'btn-dark' : 'btn-outline-dark'); ?>">
                                        Todas
                                    </a>

                                    <?php
                                    // Bucle para crear los botones de las categorías
                                    mysqli_data_seek($res_categorias, 0); // Resetear puntero
                                    while ($cat = mysqli_fetch_assoc($res_categorias)) {
                                        $categoria_id = (int)$cat['idcat'];
                                        $categoria_nombre = htmlspecialchars($cat['nombre']);
                                        $is_active = ($filtro_idcat === $categoria_id) ? 'btn-dark' : 'btn-outline-dark';

                                        // El enlace incluye el idped y el ID de la categoría (idcat)
                                        echo '<a href="pedidos.php?idped=' . $idped . '&idcat=' . $categoria_id . '&vista=' . $vista_actual . '" class="btn btn-sm ' . $is_active . '">';
                                        echo $categoria_nombre;
                                        echo '</a>';
                                    }
                                    
                                    ?>
                                </div>
                               

                                <div style="max-height: 60vh; overflow-y: auto;">
                                    <?php
                                    // Ejecutamos la consulta de productos (ya filtrada si aplica)
                                    $resultado_productos = mysqli_query($conn, $consultaproductos);

                                    $current_category = '';

                                    while ($prod = mysqli_fetch_assoc($resultado_productos)) {
                                        // Muestra el nombre de la categoría (usando el alias 'categoria_nombre') si cambia
                                        if ($prod['categoria_nombre'] !== $current_category) {
                                            $current_category = $prod['categoria_nombre'];
                                            echo '<h5 class="mt-3 mb-2 p-2 bg-light rounded text-primary">' . htmlspecialchars($current_category) . '</h5>';
                                        }

                                    ?>
                                        <div class="mb-3 p-2 border rounded">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5 class="mb-0"><?php echo $prod['nombre']; ?></h5>
                                                    <small class="text-muted"><?php echo number_format($prod['precio'], 2); ?> €</small>
                                                </div>
                                                <!-- Muestra el stock disponible -->
                                                <span class="badge bg-secondary align-self-start">Stock: <?php echo $prod['stock']; ?></span>
                                            </div>


                                            <?php if ($prod['stock'] > 0): ?>
                                                <!-- Formulario para AÑADIR producto (con stock disponible) -->
                                                <form action="" method="POST" class="d-flex flex-wrap gap-2 mt-2">
                                                    <input type="hidden" name="accion" value="añadir">
                                                    <input type="hidden" name="idped" value="<?php echo $idped; ?>">
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
                                                <!-- Bloque que se muestra si NO hay stock disponible -->
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
                                    <?php } // Fin del 'while' de productos 
                              
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card shadow-sm" style="position: sticky; top: 20px;">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Tu Pedido</h4>
                            </div>
                            <div class="card-body p-0">

                                <!-- Pestañas de Navegación -->
                                <ul class="nav nav-tabs justify-content-center pt-2" id="orderTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link <?php echo ($vista_actual === 'pendiente' ? 'active' : ''); ?>"
                                            href="pedidos.php?idped=<?php echo $idped; ?>&vista=pendiente"
                                            title="Productos en el carrito de sesión, pendientes de enviar a cocina">
                                            <i class="fas fa-shopping-basket me-1"></i> Pendiente
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link <?php echo ($vista_actual === 'total' ? 'active' : ''); ?>"
                                            href="pedidos.php?idped=<?php echo $idped; ?>&vista=total"
                                            title="Productos ya enviados y registrados en la base de datos">
                                            <i class="fas fa-list-ul me-1"></i> Total Enviado
                                        </a>
                                    </li>
                                </ul>

                                <div class="p-3">
                                    <?php if ($vista_actual === 'pendiente'): ?>
                                        <h6 class="text-muted border-bottom pb-1 mb-2">Productos a enviar ahora:</h6>

                                        <?php
                                        $total_comanda_pendiente = 0;
                                        $carrito_vacio = empty($_SESSION[$carrito]);

                                        if ($carrito_vacio) {
                                            echo "<p class='text-center text-muted'>El carrito está vacío. ¡Añada productos para enviar la siguiente comanda!</p>";
                                        } else {
                                            // Recorremos el array de sesión
                                            foreach ($_SESSION[$carrito] as $item_key => $item) {
                                                $subtotal = $item['precio'] * $item['cant'];
                                                $total_comanda_pendiente += $subtotal;
                                        ?>
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div>
                                                        <strong><?php echo $item['cant']; ?> x <?php echo $item['nombre']; ?></strong><br>

                                                        <?php if (!empty($item['comentario'])): ?>
                                                            <small class="text-info fst-italic ps-2">↳ "<?php echo htmlspecialchars($item['comentario']); ?>"</small><br>
                                                        <?php endif; ?>

                                                        <small class="text-muted ps-2"><?php echo number_format($subtotal, 2); ?> €</small>
                                                    </div>

                                                    <form action="" method="POST">
                                                        <input type="hidden" name="accion" value="quitar">
                                                        <input type="hidden" name="item_key" value="<?php echo htmlspecialchars($item_key); ?>">
                                                        <!-- Se mantiene el filtro de vista al enviar el formulario -->
                                                        <input type="hidden" name="vista" value="<?php echo $vista_actual; ?>">
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
                                            <span>Total Comanda:</span>
                                            <span><?php echo number_format($total_comanda_pendiente, 2); ?> €</span>
                                        </h3>

                                        <?php if (!$carrito_vacio): ?>

                                            <!-- BOTÓN ENVIAR COMANDA -->
                                            <a href="enviar_comanda.php?idped=<?php echo $idped; ?>" class="btn btn-success w-100 mt-3 mb-2">
                                                <i class="fas fa-paper-plane me-2"></i>
                                                Enviar Comanda (<?php echo count($_SESSION[$carrito]); ?> ítems)
                                            </a>
                                        <?php endif; ?>

                                        <!-- <button type="button" class="btn btn-outline-secondary w-100" onclick="alert('Funcionalidad de finalizar y cerrar el pedido aún no implementada.')">
                                            Finalizar y Cerrar Pedido
                                        </button> -->

                                    <?php else: // $vista_actual === 'total' 
                                    ?>

                                        <h6 class="text-muted border-bottom pb-1 mb-2">Productos ya enviados a cocina:</h6>

                                        <div style="max-height: 40vh; overflow-y: auto;">
                                            <?php if (empty($items_completos)): ?>
                                                <p class='text-center text-muted'>Aún no se ha enviado ninguna comanda a cocina.</p>
                                            <?php else: ?>
                                                <?php foreach ($items_completos as $item):
                                                    $subtotal = $item['precio'] * $item['cantidad_total'];
                                                ?>
                                                        <div class="d-flex justify-content-between align-items-center mb-2 p-1 border-bottom">
                                                            <div>
                                                                <strong><?php echo $item['cantidad_total']; ?> x <?php echo $item['nombre']; ?></strong><br>
                                                                <?php if (!empty($item['comentario'])): ?>
                                                                    <small class="text-info fst-italic ps-2">↳ "<?php echo $item['comentario']; ?>"</small><br>
                                                                <?php endif; ?>
                                                            </div>
                                                            <small class="text-muted text-end"><?php echo number_format($subtotal, 2); ?> €</small>
                                                        </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>

                                        <hr>
                                        <h3 class="d-flex justify-content-between text-success">
                                            <span>Total Acumulado:</span>
                                            <span><?php echo number_format($total_pedido_completo, 2); ?> €</span>
                                        </h3>

                                        <!-- Botón para volver a la vista pendiente si el carrito tiene ítems -->
                                        <?php if (!empty($_SESSION[$carrito])): ?>
                                            <a href="pedidos.php?idped=<?php echo $idped; ?>&vista=pendiente" class="btn btn-warning w-100 mt-2">
                                                Ver Comanda Pendiente (<?php echo count($_SESSION[$carrito]); ?> ítems)
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
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