<?php
session_start();

include("conexion.php");

// Si ya hay sesión, redirigir según rol
if (isset($_SESSION['rol'])) {
    if ($_SESSION['rol'] == 0) {
        header('Location:clientes/indexClientes.php');
        exit();
    }
    if ($_SESSION['rol'] == 1) {
        header('Location:camareros/indexCamareros.php');
        exit();
    }
    if ($_SESSION['rol'] == 2) {
        header('Location:encargados/indexEncargados.php');
        exit();
    }
}

// Procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni  = trim($_POST['dni']);
    $pass = trim($_POST['pass']);


    // Consulta simple: buscar usuario con dni y pass (texto plano)
    $consulta = "SELECT * FROM usuario WHERE dni = '$dni' AND pass = '$pass' LIMIT 1";
    $result = mysqli_query($conn, $consulta);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_array($result);


        //Comprobamos que el usuario este bloqueado
        if ($row['estado'] == 1) {
              $_SESSION['error_login'] = "Tu cuenta está bloqueada. Contacta con un encargado.";
            header("Location:index.php");
            exit();
        }
    
        // Crear sesión
        $_SESSION['dni'] = $row['dni'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['rol'] = $row['rol'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['telefono'] = $row['telefono'];
        $_SESSION['direccion'] = $row['direccion'];
        $_SESSION['apellidos'] = $row['apellidos'];
        $_SESSION['estado'] = $row['estado'];
        $_SESSION['pass'] = $row['pass'];



        // Redirigir según rol
        switch ($row['rol']) {
            case '0':
            case 0:

                header('Location:clientes/indexClientes.php');
                exit();
            case '1':
            case 1:

                header('Location:camareros/indexCamareros.php');
                exit();
            case '2':
            case 2:

                header('Location:encargados/indexEncargados.php');
                exit();
            default:
                // Rol desconocido, cerrar sesión por seguridad mínima
                session_unset();
                session_destroy();
                echo "Rol no reconocido.";
                exit();
        }
    }else {
        $_SESSION['error_login'] = "Usuario o contraseña incorrectos.";
        header("Location: index.php");
        exit();
    }

}
?>
