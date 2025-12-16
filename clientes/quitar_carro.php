<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");


// Comprobamos que nos llega el id por el post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $indice = $_POST['indice_carrito'];
    $idprod = $_POST['idprod_eliminado'];
    $cantidad=$_POST['cantidad_eliminada'];


    // Si existe, borramos esa posición del carrito
    if (isset($_SESSION['carrito'][$indice])) {
        unset($_SESSION['carrito'][$indice]);

        $consulta_sumar_stock = "UPDATE producto SET stock=$cantidad WHERE idprod='$idprod'";
        $result = mysqli_query($conn, $consulta_sumar_stock);

        mysqli_close($conn);
    }
}

// Volvemos a la carta
header('Location: pedidos.php');
exit();
?>