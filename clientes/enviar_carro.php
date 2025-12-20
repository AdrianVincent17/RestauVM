<?php
include("../seguridad.php");
proteger(0); // Asegura que solo usuarios autorizados pueden acceder
include("../conexion.php");

// comprobacion del carrito no vacio
if (!empty($_SESSION['carrito'])) {

    // creamos una variable a partir de la sesion del dni 
    $dni = $_SESSION['dni'];

    // Obtenemos el id del pedido
    $consulta_idpedido = "SELECT * FROM pedido WHERE usuario='$dni' AND estado=0";
    $result = mysqli_query($conn, $consulta_idpedido);

    $row = mysqli_fetch_assoc($result);
    $idped = $row['idped'];

    // variable de sesión del idped
    $_SESSION['idped'] = $idped;

    // Recorremos el carrito 
    foreach ($_SESSION['carrito'] as $producto) {

        // productos del carrito tabla pedido_producto
        $idprod = $producto['id'];
        $comentario = $producto['comentario'];
        $cantidad = $producto['cantidad'];
        $consulta_producto = "INSERT INTO pedido_producto (idped, idprod, cant,comentario, servido) 
                                  VALUES ('$idped', '$idprod','$cantidad', '$comentario', 0)";

        mysqli_query($conn, $consulta_producto);
    }
    mysqli_close($conn);

    unset($_SESSION['carrito']);

    header('Location:pedidos.php?idp=' . $idped);
    exit();
    //  header('Location: tickets/generar_ticket.php?idp=' . $idped);
    //  exit();
} else {

    // asegurammos entrada sin sesion o sin productos
    header('Location:pedidos.php');
    exit();
}
