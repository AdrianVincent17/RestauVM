<?php
// 1. OBLIGATORIO: Iniciar la sesión para leer el array
session_start(); 

include("../seguridad.php");
proteger(0);
include("../conexion.php");

// 2. Comprobar que nos pasan un idped por la URL
if (!isset($_GET['idped'])) {
    header("Location: mesas.php?error=nofinalid");
    exit;
}
$id_pedido_actual = (int)$_GET['idped'];

// 3. Definir la "llave" del carrito de sesión que vamos a leer
$cart_session_key = 'carrito_' . $id_pedido_actual;

// 4. Comprobar que el carrito de sesión existe y no está vacío
if (!isset($_SESSION[$cart_session_key]) || empty($_SESSION[$cart_session_key])) {
    // Si está vacío, no hay nada que finalizar.
    // Lo mandamos de vuelta a la "carta" (pedidos.php)
    header("Location: pedidos.php?idped=" . $id_pedido_actual . "&error=carritovacio");
    exit;
}

// 5. ¡AQUÍ LA MAGIA! Guardamos el carrito en la BBDD
$total_final_pedido = 0;

// 6. Recorremos el array de sesión item por item
foreach ($_SESSION[$cart_session_key] as $item_key => $item) {
    
    // Sacamos los datos de CADA item
    $idprod_db = $item['idprod'];
    $cant_db = $item['cant'];
    // (Como pediste simplificar, no limpiamos el comentario, pero ten cuidado aquí)
    $comentario_db = $item['comentario']; 

    // Sumamos el subtotal de este item al total final
    $total_final_pedido += ($item['precio'] * $cant_db);

    // 7. Creamos el INSERT para guardar este item en la tabla permanente 'pedido_producto'
    $sql_insert = "INSERT INTO pedido_producto (idped, idprod, cant, comentario) 
                   VALUES ($id_pedido_actual, $idprod_db, $cant_db, '$comentario_db')";
    
    mysqli_query($conn, $sql_insert);
}

// 8. Actualizamos el pedido principal
// Lo marcamos como "finalizado" (estado = 1) y guardamos el total calculado.
// (Asegúrate de que '1' es tu estado para "finalizado")
$sql_update_pedido = "UPDATE pedido 
                      SET estado = 1, total = $total_final_pedido 
                      WHERE idped = $id_pedido_actual";
mysqli_query($conn, $sql_update_pedido);

// 9. "Limpiamos" el carrito de la sesión
// Ya no lo necesitamos, está guardado para siempre en la BBDD
unset($_SESSION[$cart_session_key]);

// 10. Cerramos conexión y redirigimos
mysqli_close($conn);

// ¡Éxito! Lo mandamos a la página de mesas.
// Ahora puede "volver a pedir" (empezar un pedido nuevo).
header("Location: mesas.php?pedido_finalizado=true");
exit;
?>