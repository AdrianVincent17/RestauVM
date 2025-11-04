<?php
// 1. Iniciar la Sesión
// Siempre debe ser la primera línea de cualquier script que use sesiones.
session_start();

// 2. Definir las credenciales simuladas (¡En un proyecto real, usa una base de datos!)
// Usamos un array simple para simular diferentes usuarios y sus roles.
$usuarios_permitidos = [
    'cliente@despensa.com' => ['password' => 'pass123', 'rol' => '0'],
    'juan_c@despensa.com' => ['password' => 'camarero456', 'rol' => '1'],
    'elena_e@despensa.com' => ['password' => 'encargado789', 'rol' => '2']
];

// 3. Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $email = $_POST['email'] ?? '';
    $password_ingresada = $_POST['password'] ?? '';

    // Sanitizar (limpiar) los datos antes de usarlos (básico)
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    $mensaje = "";

    // 4. Validar las credenciales
    if (isset($usuarios_permitidos[$email])) {
        $usuario_info = $usuarios_permitidos[$email];

        // NOTA: ¡En un entorno de producción, las contraseñas DEBEN ser hasheadas 
        // y verificadas con password_verify()!
        if ($password_ingresada === $usuario_info['password']) {
            
            // Credenciales correctas: Almacenar el rol en la sesión
            $_SESSION['rol'] = $usuario_info['rol'];
            $_SESSION['email'] = $email;
            
            // 5. Redirección basada en el Rol
            switch ($_SESSION['rol']) {
                case '0':
                    header('Location:clientes/indexClientes.php');
                    exit;
                case '1':
                    header('Location:camareros/indexCamareros.php');
                    exit;
                case '2':
                    header('Location:encargados/indexEncargados.php');
                    exit;
                default:
                    // Si el rol existe pero no está mapeado, se envía a una página por defecto
                    header('Location: inicio_default.php'); 
                    exit;
            }

        } else {
            // Contraseña incorrecta
            $mensaje = "Error: La contraseña es incorrecta.";
        }
    } else {
        // Usuario no encontrado
        $mensaje = "Error: El correo electrónico no está registrado.";
    }
}

// 6. Formulario HTML para la Interfaz
?>