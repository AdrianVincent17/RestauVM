<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

// vemos si nos llegan los datos o no 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idprod'])) {

    $idprod = $_POST['idprod'];
    $cantidad = (int)$_POST['cantidad'];

    // comprobamos el stock disponible
    $consulta_stock = "SELECT * FROM producto WHERE idprod='$idprod'";

    $result = mysqli_query($conn, $consulta_stock);
    $row = mysqli_fetch_assoc($result);
    $stock_disponible = (int)$row['stock'];

    // 2. Verificación previa
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

        // Descontar automáticamente (Sprint 2)
        $consulta_restar_stock = "UPDATE producto SET stock = stock - $cantidad WHERE idprod = '$idprod'";
        mysqli_query($conn, $consulta_restar_stock);
     
         mysqli_close($conn);
        // volvemos a la seccion pedidos
        header('Location: pedidos.php');
        exit();
    } else {
        mysqli_close($conn);
        // 3. Mostrar advertencia si no hay stock (Sprint 2)
        header('Location: pedidos.php?error=1');
        exit();
    }
}

