<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

//Verificar si NO hay 'idped' en la URL
if (!isset($_GET['idped'])) {

    // Si no hay 'idped' en la URL, comprobamos si el usuario tiene un pedido abierto (estado = 0)
    $dni_cliente = $_SESSION['dni']; // variable del dni del cliente

    $consulta_ped_abierto = "SELECT idped FROM pedido WHERE usuario = '$dni_cliente' AND estado = 0 LIMIT 1";
    $result_ped_abierto = mysqli_query($conn, $consulta_ped_abierto);

    //Comprobamos si hay un pedido activo para el cliente
    if ($result_ped_abierto && ($rowp = mysqli_fetch_assoc($result_ped_abierto))) {
        //Redirigimos a la página con el ID de pedido correcto
        $existe_pedido = (int)$rowp['idped'];
        mysqli_close($conn); 
        header("Location: pedidos.php?idped=" . $existe_pedido);
        exit;
    } else {
        // si no hay pedido activo, lo enviamos a la página de mesas
        mysqli_close($conn); 
        header("Location: mesas.php");
        exit;
    }
}

// Cogemos el ID del pedido de la URL de forma segura
$idped = (int)$_GET['idped'];

// Buscamos el número de mesa de ESE pedido (para el título)
$consulta_mesa = "SELECT nmesa FROM pedido WHERE idped = $idped";
$resultado_mesa = mysqli_query($conn, $consulta_mesa);

// Comprobamos si la consulta devolvió un resultado válido
if (!$resultado_mesa || mysqli_num_rows($resultado_mesa) === 0) {
    // Si el ID del pedido no existe, redirigimos a mesas
    mysqli_close($conn);
    header("Location: mesas.php");
    exit;
}

$fila_mesa = mysqli_fetch_assoc($resultado_mesa);
$nmesa_pedido = $fila_mesa['nmesa']; 

// Creamos una "llave" única para el carrito en la sesión
$carrito = 'carrito_' . $idped;

// Si no existe un carrito para ESTE pedido, lo creamos como un array vacío
if (!isset($_SESSION[$carrito])) {
    $_SESSION[$carrito] = [];
}

//Obtener todas las categorías para los botones (usando la tabla 'categoria')

$consulta_categorias = "SELECT idcat, nombre FROM categoria ORDER BY idcat";
$resultado_categorias = mysqli_query($conn, $consulta_categorias);

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

// Fin de la lógica de filtro

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $accion = $_POST['accion'];

    // --- ACCIÓN: AÑADIR ---
    if ($accion == 'añadir') {
        $idprod = (int)$_POST['idprod'];
        $cantidad = (int)$_POST['cantidad'];
        $comentario = trim($_POST['comentario_prod']);
        $item_key = $idprod . '_' . md5($comentario);

        
        // Antes de añadir, consultamos el stock REAL de la BBDD
        $consultastock="SELECT stock FROM producto WHERE idprod = $idprod";

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
                    'comentario'  => $comentario
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
            $consulta_devolverstock = "UPDATE producto SET stock = stock + $cantidad_a_devolver WHERE idprod = $producto_a_devolver";
            mysqli_query($conn, $consulta_devolverstock); 
            
            //Ahora sí, lo borramos del array de sesión
            unset($_SESSION[$carrito][$item_key_a_quitar]);
        }
    }

    // REDIRECCIÓN (Importante: para limpiar el POST)
    // Redirigimos manteniendo el 'idped' y el 'idcat' actual.

    $redirect_url = "Location:pedidos.php?idped=" . $idped;
    if ($filtro_idcat !== 0) {
        $redirect_url .= "&idcat=" . $filtro_idcat;
    }
    header($redirect_url);
    exit;
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
                <div class="row g-4">

                    <div class="col-lg-7">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light"><h4 class="mb-0">Menú</h4></div>
                            <div class="card-body">
                                
                                <div class="category-button-container mb-4 d-flex flex-wrap gap-2">
                                    
                                    <!-- Botón para mostrar TODAS las categorías -->
                                    <a href="pedidos.php?idped=<?php echo $idped; ?>&idcat=0" 
                                       class="btn btn-sm <?php echo ($filtro_idcat == 0 ? 'btn-dark' : 'btn-outline-dark'); ?>">
                                        Todas
                                    </a>
                                    
                                    <?php
                                    // Bucle para crear los botones de las categorías
                                    while ($cat = mysqli_fetch_assoc($resultado_categorias)) {
                                        $categoria_id = (int)$cat['idcat'];
                                        $categoria_nombre = $cat['nombre'];
                                        $is_active = ($filtro_idcat === $categoria_id) ? 'btn-dark' : 'btn-outline-dark';
                                        
                                        // El enlace incluye el idped y el ID de la categoría (idcat)
                                        echo '<a href="pedidos.php?idped=' . $idped . '&idcat=' . $categoria_id . '" class="btn btn-sm ' . $is_active . '">';
                                        echo $categoria_nombre;
                                        echo '</a>';
                                    }
                                   
                                    ?>
                                </div>
                                <div style="max-height: 60vh; overflow-y: auto;">

                                    <?php
                                    // Ejecutamos la consulta de productos (ya filtrada si aplica)
                                    $resultado_productos = mysqli_query($conn, $consultaproductos);

                                    $categoria_actual = '';
                                    
                                    while ($prod = mysqli_fetch_assoc($resultado_productos)) {

                                        // Muestra el nombre de la categoría (usando el alias 'categoria_nombre') si cambia
                                        if ($prod['categoria_nombre'] !== $categoria_actual) {
                                            $categoria_actual = $prod['categoria_nombre'];
                                            echo '<h5 class="mt-3 mb-2 p-2 bg-light rounded text-primary">'. $categoria_actual .'</h5>';
                                        }

                                    ?>
                                        <div class="mb-3 p-2 border rounded">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5 class="mb-0"><?php echo $prod['nombre']; ?></h5>
                                                    <small class="text-muted"><?php echo number_format($prod['precio'], 2); ?> €</small>
                                                </div>
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
                                <h4 class="mb-0">Tu Pedido (ID: <?php echo $idped; ?>)</h4>
                            </div>
                            <div class="card-body">
                                <?php
                                $total_pedido = 0; 
                                
                                if (empty($_SESSION[$carrito])) {
                                    echo "<p class='text-center text-muted'>El carrito está vacío.</p>";
                                } else {
                                    // Recorremos el array de sesión
                                    foreach ($_SESSION[$carrito] as $item_key => $item) {
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
                                
                                <a href="enviar_comanda.php" class="btn btn-warning w-100 mt-3">
                                    Mandar a cocina
                                </a>
                                 <a href="#" class="btn btn-outline-secondary w-100 mt-3">
                                    Ver pedido completo
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