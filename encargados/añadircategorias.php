<?php
include("../seguridad.php");
proteger(2);
include("../conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'];
    $stock = $_POST['stock'];
    $estado = 0; //siempre lo meteremos como disponible 

    $consulta = "INSERT INTO categoria(nombre) VALUES('$nombre')";


    mysqli_query($conn, $consulta);
    echo mysqli_error($conn);
    mysqli_close($conn);
    header("Location:categorias.php");
    exit();
}
