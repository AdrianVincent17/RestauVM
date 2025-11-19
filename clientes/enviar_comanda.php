<?php
include("../seguridad.php");
proteger(0); // Proteger para que solo usuarios logeados puedan acceder
include("../conexion.php");

//Verificar el ID del pedido
if (!isset($_GET['idped']) || !is_numeric($_GET['idped'])) {
    header("Location: mesas.php");
    exit;
}

$idped = (int)$_GET['idped'];
$carrito = 'carrito_' . $idped;

//Verificar que el carrito no esté vacío
if (empty($_SESSION[$carrito])) {
    // Si está vacío, redirigir sin hacer nada
    header("Location: pedidos.php?idped=" . $idped);
    exit;
}

//Obtener los datos del carrito
$items_a_enviar = $_SESSION[$carrito];
$transaccion_exitosa = true;

// 4. Iniciar Transacción para asegurar la integridad de los datos
mysqli_begin_transaction($conn);

try {
    // 5. Insertar cada producto del carrito en la tabla 'pedido_producto'
    foreach ($items_a_enviar as $item) {
        $idprod = (int)$item['idprod'];
        $cant = (int)$item['cant'];
        $comentario = isset($item['comentario']) ? $item['comentario'] : '';
        // Escapar el comentario para evitar problemas con caracteres especiales
        $comentario_esc = mysqli_real_escape_string($conn, $comentario);

        $sql_insert = "INSERT INTO pedido_producto (idped, idprod, cant, comentario) VALUES ($idped, $idprod, $cant, '$comentario_esc')";

        if (!mysqli_query($conn, $sql_insert)) {
            // Si una inserción falla, marcamos la transacción como fallida
            $transaccion_exitosa = false;
            break;
        }
    }

    if ($transaccion_exitosa) {
        // 6. Si todo fue bien, confirmar los cambios en la base de datos
        mysqli_commit($conn);
        
        // 7. Vaciar el carrito de sesión (la comanda ha sido enviada)
        unset($_SESSION[$carrito]);
        
        // Opcional: Podrías añadir lógica aquí para marcar el pedido como 'enviado' a la cocina
        // por ejemplo, actualizando la tabla 'pedido' a un estado intermedio (estado=1, si 1 es 'enviado')
        
        // 8. Redirigir de vuelta a la página de pedidos
        header("Location: pedidos.php?idped=" . $idped . "&comanda=enviada");
    } else {
        // Si falló, revertir todos los cambios
        mysqli_rollback($conn);
        // Redirigir con un mensaje de error
        header("Location: pedidos.php?idped=" . $idped . "&error=db_fail");
    }

} catch (\Throwable $e) {
    // Manejar cualquier otra excepción y hacer rollback
    mysqli_rollback($conn);
    // Redirigir con un mensaje de error genérico
    header("Location: pedidos.php?idped=" . $idped . "&error=exception");
}

mysqli_close($conn);
exit;
?>