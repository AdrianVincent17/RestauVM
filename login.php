<?php
session_start();
include("conexion.php"); // tu archivo de conexión (debe definir $conn)

// Si ya hay sesión, redirigir según rol
if (isset($_SESSION['rol'])) {
    if ($_SESSION['rol'] == 0) { header('Location: clientes/indexClientes.php'); exit(); }
    if ($_SESSION['rol'] == 1) { header('Location: camareros/indexCamareros.php'); exit(); }
    if ($_SESSION['rol'] == 2) { header('Location: encargados/indexEncargados.php'); exit(); }
}

// Procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni  = trim($_POST['dni']);
    $pass = trim($_POST['pass']);


    // Consulta simple: buscar usuario con dni y pass (texto plano)
    $consulta = "SELECT dni, rol FROM usuario WHERE dni = '$dni' AND contraseña = '$pass' LIMIT 1";
    $result = mysqli_query($conn, $consulta);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        // Crear sesión
        $_SESSION['dni'] = $row['dni'];
        $_SESSION['rol'] = $row['rol'];

        // Redirigir según rol
        switch ($row['rol']) {
            case '0':
            case 0:
                header('Location: clientes/indexClientes.php');
                exit();
            case '1':
            case 1:
                header('Location: camareros/indexCamareros.php');
                exit();
            case '2':
            case 2:
                header('Location: encargados/indexEncargados.php');
                exit();
            default:
                // Rol desconocido, cerrar sesión por seguridad mínima
                session_unset();
                session_destroy();
                echo "Rol no reconocido.";
                exit();
        }
    } else {
        // Credenciales incorrectas
        $error = "DNI o contraseña incorrectos.";
    }
}
?>


