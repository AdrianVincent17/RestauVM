<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

// vemos si nos llegan los datos o no 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idprod = $_POST['idprod'];
    $cantidad = (int)$_POST['cantidad'];

    // --- Validamos el estado del pedido antes de añadir nada al carrito y evitar restar nada al stock ---
    if (isset($_SESSION['idped'])) {
        $idped = $_SESSION['idped'];
        $chequeo_pedido = mysqli_query($conn, "SELECT estado FROM pedido WHERE idped = '$idped'");
        $row_pedido = mysqli_fetch_assoc($chequeo_pedido);

        if ($row_pedido && $row_pedido['estado'] == '1') {

            // Si el pedido está cerrado, limpiamos sesión y volvemos a mesas
            unset($_SESSION['idped']);
            mysqli_close($conn);
            header('Location: mesas.php'); 
            exit();
        }
    }

    // comprobamos el stock disponible
    $consulta_stock = "SELECT * FROM producto WHERE idprod='$idprod'";

    $result = mysqli_query($conn, $consulta_stock);
    $row = mysqli_fetch_assoc($result);
    $stock_disponible = (int)$row['stock'];

    // Verificación previa
    if ($stock_disponible >= $cantidad) {

        // Inicializar carrito
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }
        
        // Guardar producto
        $lista = array(
            'id' => $idprod,
            'nombre' => $_POST['nombre'],
            'precio' => $_POST['precio'],
            'comentario' => $_POST['comentario'],
            'cantidad' => $cantidad
        );

        $_SESSION['carrito'][] = $lista;

        // Descontar automáticamente
        $consulta_restar_stock = "UPDATE producto SET stock = stock - $cantidad WHERE idprod = '$idprod'";
        mysqli_query($conn, $consulta_restar_stock);
     
         mysqli_close($conn);
        // volvemos a la seccion pedidos
        header('Location: pedidos.php');
        exit();
    } else {
        mysqli_close($conn);
        // Mostrar advertencia si no hay stock
        header('Location: pedidos.php?error=1');
        exit();
    }
}

