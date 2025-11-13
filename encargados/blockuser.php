<?php
include("../seguridad.php");
proteger(2);
include("../conexion.php");

if (isset($_POST['dni'])) {
    
    $dni = $_POST['dni'];

    // Obtener estado actual
    $consulta = "SELECT estado FROM usuario WHERE dni = '$dni'";
    $resultado = mysqli_query($conn, $consulta);
    $fila = mysqli_fetch_assoc($resultado);

    if ($fila) {
        $nuevo_estado = $fila['estado'] == 0 ? 1 : 0;
        $update = "UPDATE usuario SET estado = '$nuevo_estado' WHERE dni = '$dni'";
        mysqli_query($conn, $update);
    }
}

// Redirige de vuelta a la lista
header("Location:modperfil.php");
exit;
?>