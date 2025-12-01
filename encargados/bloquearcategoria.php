<?php
include("../seguridad.php");
proteger(2);
include("../conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $id = $_GET['idcat'];

    $consulta = mysqli_query($conn, "SELECT * FROM categoria WHERE idcat='$id'");

    $categoria = mysqli_fetch_array($consulta);

    $consultaprod = mysqli_query($conn, "SELECT * FROM producto WHERE categoria='$id'");

    $producto = mysqli_fetch_array($consultaprod);


    if ($categoria['estado'] === '1') {
        mysqli_query($conn, "UPDATE categoria SET estado='0' WHERE idcat='$id'");
        mysqli_query($conn, "UPDATE producto SET estado='0' WHERE categoria='$id'");
        echo mysqli_error($conn);
        mysqli_close($conn);
        header("Location:categorias.php");
        exit();
    } else if ($categoria['estado'] === '0') {
        mysqli_query($conn, "UPDATE categoria SET estado='1' WHERE idcat='$id'");
        mysqli_query($conn, "UPDATE producto SET estado='1' WHERE categoria='$id'");
        echo mysqli_error($conn);
        mysqli_close($conn);
        header("Location:categorias.php");
        exit();
    }
}
