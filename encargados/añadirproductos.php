<?php
include("../seguridad.php");
proteger(2);
include("../conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $estado = $_POST['estado'];
    $categoria = $_POST['cat'];

    $consulta = "INSERT INTO producto(nombre,precio,stock,estado,categoria) VALUES('$nombre','$precio','$stock','$estado','$categoria')";


    mysqli_query($conn, $consulta);
    echo mysqli_error($conn);
    mysqli_close($conn);
    header("Location:productos.php");
    exit();
}
