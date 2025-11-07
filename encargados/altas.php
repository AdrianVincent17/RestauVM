<?php

include("../conexion.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $rol = $_POST['rol'];
    $estado = 0;

    if ($pass != $pass2) {
        header("Location:modperfil.php");
        exit();
    } else {
        $consulta = "INSERT INTO usuario(dni,nombre,apellidos,rol,email,telefono,direccion,pass,estado) VALUES('$dni','$nombre','$apellidos','$rol','$email','$telefono','$direccion','$pass','$estado')";

        mysqli_query($conn, $consulta);
        echo mysqli_error($conn);
        mysqli_close($conn);
        header("Location:indexEncargados.php");
        exit();
    }
}

?>
