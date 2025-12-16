<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

// Comprobamos que nos llegan datos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idprod'])) {

    $idprod = $_POST['idprod'];
    $cantidad = (int)$_POST['cantidad'];

    // Creamos el carrito en la sesión si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    $idprod = $_POST['idprod'];

    $consulta_stock = "SELECT * FROM producto WHERE idprod='$idprod'";

    $result = mysqli_query($conn, $consulta_stock);
    $row = mysqli_fetch_assoc($result);

        // Guardamos los datos del producto en un array
        $lista = array(
            'id' => $_POST['idprod'],
            'nombre' => $_POST['nombre'],
            'precio' => $_POST['precio'],
            'comentario' => $_POST['comentario'],
            'cantidad'=>$_POST['cantidad']
        );

        // Añadimos el producto al final del array 
        $_SESSION['carrito'][] = $lista;

        // Restamos 1 al stock del producto del stock
        $consulta_restar_stock = "UPDATE producto SET stock=stock-$cantidad WHERE idprod='$idprod'";
        $result = mysqli_query($conn, $consulta_restar_stock);
    }

    // Cerramos conexion
    mysqli_close($conn);


// Devolvemos al usuario a la carta
header('Location: pedidos.php');
exit();