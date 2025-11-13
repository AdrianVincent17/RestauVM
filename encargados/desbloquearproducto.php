
<?php

include("../conexion.php");


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $id = $_GET['idprod'];

    $consulta = "UPDATE producto SET estado='0' WHERE idprod='$id'";

    mysqli_query($conn, $consulta);
    echo mysqli_error($conn);
    mysqli_close($conn);
    header("Location:productos.php");
    exit();
}