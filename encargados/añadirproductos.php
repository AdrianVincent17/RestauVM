<?php
include("../seguridad.php");
proteger(2);
include("../conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $estado = 0; //siempre lo meteremos como disponible 
    $categoria = $_POST['cat'];
    $imagen=$_POST['imagen'];

    $consulta = "INSERT INTO producto(nombre,precio,stock,estado,categoria,imagen) VALUES('$nombre','$precio','$stock',$estado,'$categoria','$imagen')";


    mysqli_query($conn, $consulta);
    echo mysqli_error($conn);
    mysqli_close($conn);
    header("Location:productos.php");
    exit();
}
