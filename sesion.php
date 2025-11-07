<?php
session_start();
include("conexion.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre']) || !isset($_SESSION['dni'])) {
    header("Location:index.php");
    exit();
}

// Obtener datos del usuario actual desde la sesión
$dni = $_SESSION['dni'];

// Consultar el estado del usuario actual
$consulta = "SELECT estado FROM usuario WHERE dni='$dni' LIMIT 1";
$resultado = mysqli_query($conn, $consulta);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);

    // Si el estado es 1, el usuario está bloqueado
    if ($fila['estado'] == 1) {
        // Cerrar sesión y bloquear acceso
        session_unset();
        session_destroy();
        $_SESSION['error_login'] = "Tu cuenta está bloqueada. Contacta con un encargado.";
        exit();
    }
} else {
    // Usuario no encontrado en BD
    session_unset();
    session_destroy();
    header("Location:index.php");
    exit();
}
?>
