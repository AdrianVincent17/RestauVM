<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $dni=$_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];

    $passold= "SELECT pass FROM usuario WHERE dni='$dni'";
    if ($pass != $pass2) {
        header("Location:modperfil.php");
        exit();
    } 
    if(empty($pass)) {
        $consulta = "UPDATE usuario SET nombre='$nombre',apellidos='$apellidos',email='$email',telefono='$telefono',direccion='$direccion' WHERE dni='$dni'";

    }else{
        $consulta = "UPDATE usuario SET nombre='$nombre',apellidos='$apellidos',email='$email',telefono='$telefono',direccion='$direccion',pass='$pass' WHERE dni='$dni'";
    }
    
    mysqli_query($conn, $consulta);

    // Actualizamos los datos en la sesión
    
    $resultado = mysqli_query($conn, "SELECT * FROM usuario WHERE dni='$dni'");
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);

        // Actualizamos las variables de sesión
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['apellidos'] = $row['apellidos'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['telefono'] = $row['telefono'];
        $_SESSION['direccion'] = $row['direccion'];
        // No se guarda la contraseña en sesión por seguridad
    }
     mysqli_close($conn);
     header("Location:modperfil.php");
     exit();

}
?>
