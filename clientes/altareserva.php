<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

// Verificamos que los datos lleguen por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1. Recogemos los datos (del modal y la sesión)
    $mesa_id     = (int)$_POST['mesa_id'];
    $comensales  = (int)$_POST['personas'];
    $dni_cliente = $_SESSION['dni']; // Asumimos que el DNI está en la sesión

    // Comprobamos si el cliente ya tiene una reserva activa o futura
    // Consideramos "activa" cualquier reserva con fecha >= hoy
    $contadorreserva = "SELECT COUNT(*) AS cnt FROM reserva WHERE dni = '$dni_cliente' AND DATE(fecha) >= CURDATE()";
    $reservas = mysqli_query($conn, $contadorreserva);
    $already_reserved = false;
    if ($reservas) {
        $cnt = (int)mysqli_fetch_assoc($reservas)['cnt'];
        if ($cnt > 0) $already_reserved = true;
    }

    // También comprobamos si ya tiene un pedido abierto (estado = 0) y obtenemos su id
    $sql_pedido_abierto = "SELECT idped FROM pedido WHERE usuario = '$dni_cliente' AND estado = 0 LIMIT 1";
    $res_pedido_abierto = mysqli_query($conn, $sql_pedido_abierto);
    $already_pedido = false;
    $existing_pedido_id = 0;
    if ($res_pedido_abierto && mysqli_num_rows($res_pedido_abierto) > 0) {
        $rowp = mysqli_fetch_assoc($res_pedido_abierto);
        $existing_pedido_id = (int)$rowp['idped'];
        $already_pedido = true;
    }

    if ($already_reserved || $already_pedido) {
        // No permitimos crear otra reserva; redirigimos al pedido abierto si existe, o a mesas con mensaje
        mysqli_close($conn);
        if ($already_pedido && $existing_pedido_id > 0) {
            header('Location: pedidos.php?idped=' . $existing_pedido_id);
        } else {
            header('Location: mesas.php?error=ya_reservado');
        }
        exit();
    }

    // 2. CREAMOS LA RESERVA
    $sql_reserva = "INSERT INTO reserva (dni, nmesa, comensales) 
                    VALUES ('$dni_cliente', $mesa_id, $comensales)";
    mysqli_query($conn, $sql_reserva);

    // 3. ACTUALIZAMOS LA MESA (la ponemos como ocupada)
    $sql_mesa = "UPDATE mesa SET estado = '1' WHERE nmesa = $mesa_id";
    mysqli_query($conn, $sql_mesa);

    // 4. CREAMOS EL PEDIDO VACÍO ASOCIADO
    // El 'estado = 0' significa 'pendiente'
    $sql_pedido = "INSERT INTO pedido (estado, usuario, nmesa)
                   VALUES (0, '$dni_cliente', $mesa_id)";
    
    // Ejecutamos la consulta para crear el pedido
    if (mysqli_query($conn, $sql_pedido)) {
        
        // 5. OBTENEMOS EL ID DEL PEDIDO QUE ACABAMOS DE CREAR
        $id_nuevo_pedido = mysqli_insert_id($conn);

        // 6. REDIRIGIMOS A LA PÁGINA DE PEDIDOS
        mysqli_close($conn);
        header("Location: pedidos.php?idped=" . $id_nuevo_pedido);
        exit();

    } else {
        // Si falló la creación del pedido (muy raro), volvemos a mesas
        mysqli_close($conn);
        header("Location: mesas.php?error=pedidofallo");
        exit();
    }
    
} else {
    // Si no es POST, redirigimos
    header("Location: mesas.php");
    exit();
}
?>