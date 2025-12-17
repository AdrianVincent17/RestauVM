<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

// vemos si nos llegan los datos o no 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idprod'])) {

    $idprod = $_POST['idprod'];
    $cantidad = (int)$_POST['cantidad'];

    // creamos el carrito con una variable de sesion
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    $idprod = $_POST['idprod'];

    $consulta_stock = "SELECT * FROM producto WHERE idprod='$idprod'";

    $result = mysqli_query($conn, $consulta_stock);
    $row = mysqli_fetch_assoc($result);

        // guardaremos los productos en un array
        $lista = array(
            'id' => $_POST['idprod'],
            'nombre' => $_POST['nombre'],
            'precio' => $_POST['precio'],
            'comentario' => $_POST['comentario'],
            'cantidad'=>$_POST['cantidad']
        );

        // vamos añadiendo los productos al array
        $_SESSION['carrito'][] = $lista;

        // vamos restando la cantidad que pongamos al stock
        $consulta_restar_stock = "UPDATE producto SET stock=stock-$cantidad WHERE idprod='$idprod'";
        $result = mysqli_query($conn, $consulta_restar_stock);
    }

  
    mysqli_close($conn);


// volvemos a la seccion pedidos
header('Location: pedidos.php');
exit();