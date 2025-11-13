<?php
include("../seguridad.php");
proteger(2);
include("../conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idprod=$_POST['idprod'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['cat'];

    $consulta = "UPDATE producto SET nombre='$nombre',precio='$precio',stock='$stock',categoria='$categoria' WHERE idprod='$idprod'";
    mysqli_query($conn, $consulta);

    echo mysqli_error($conn);
    mysqli_close($conn);
    header("Location:productos.php");
    exit();
}