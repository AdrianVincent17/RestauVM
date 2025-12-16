<?php
include("../seguridad.php");
proteger(0); // Asegura que solo usuarios autorizados pueden acceder
include("../conexion.php");

// Comprobamos que el carrito no esté vacío
if (!empty($_SESSION['carrito'])) {

    // Guardamos variable del dni del usuario
    $dni = $_SESSION['dni'];

    // Obtenemos el id del pedido
    $consulta_idpedido = "SELECT * FROM pedido WHERE usuario='$dni' AND estado=0";
    $result = mysqli_query($conn, $consulta_idpedido);
    
    $row = mysqli_fetch_assoc($result);
    $idped = $row['idped'];

    // Guardamos variable de sesión del idped para usarlo mas adelante
    $_SESSION['idped'] = $idped;

    // Recorremos el carrito 
    foreach ($_SESSION['carrito'] as $producto) {

        // Guardamos los productos del carrito en la tabla pedido_producto
        $idprod = $producto['id'];
        $comentario = $producto['comentario'];
        $cantidad=$producto['cantidad'];
        $consulta_producto = "INSERT INTO pedido_producto (idped, idprod, cant,comentario, servido) 
                                  VALUES ('$idped', '$idprod','$cantidad', '$comentario', 0)";

        mysqli_query($conn, $consulta_producto);       
        
    }
    mysqli_close($conn);

    unset($_SESSION['carrito']);

     // Si alguien entra a este archivo sin productos o sin sesión
    header('Location:pedidos.php');
    exit();
    // // Redirigimos al ticket de cocina
    // header('Location: tickets/generar_ticket.php?idp=' . $idped);
    // exit();
} else {
    // Si alguien entra a este archivo sin productos o sin sesión
    header('Location:pedidos.php');
    exit();
}