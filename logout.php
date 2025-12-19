<?php
session_start();
include("conexion.php");

//hacemos una commprobacion del carrito y si tiene algo lo vaciamos para evitar que se queden cosas en el limbo 

if (!empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $producto) {
        $cantidad=$producto['cantidad'];
        $idprod=$producto['id'];
        $sql = "UPDATE producto SET stock = stock + $cantidad WHERE idprod = $idprod";
        mysqli_query($conn, $sql);
    }
}

unset($_SESSION['carrito']);
session_unset();
session_destroy();

// Redirigir al usuario a la página de inicio
header("Location:index.php");
exit();

?>