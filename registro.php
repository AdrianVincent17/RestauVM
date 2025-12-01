<?php

session_start();
include('conexion.php');

$mensaje='';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $rol = 0;
    $estado = 0;

    if ($pass != $pass2) {

        $mensaje="Error, las contraseñas no coinciden";
        
    } else {
        $consulta = "INSERT INTO usuario(dni,nombre,apellidos,rol,email,telefono,direccion,pass,estado) VALUES('$dni','$nombre','$apellidos','$rol','$email','$telefono','$direccion','$pass','$estado')";

        mysqli_query($conn, $consulta);
        echo mysqli_error($conn);
        mysqli_close($conn);
        header("Location:index.php");
        exit();
    }
}

?>
<!doctype html>
<html lang="es" class="h-100">

<head>
    <?php
    include("head.php");
    ?>

    <title>Registro - Restaurante La Despensa</title>
    <link rel="stylesheet" href="styles.css" type="text/css">

    <style>
        /* 2. Estilo de la tarjeta de formulario (renombrada de .login-card) */
        .form-card {
            max-width: 550px;
            /* Un poco más ancha para el form de registro */
            width: 100%;
            padding: 2.5rem;
            background-color: #ffffffff;
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, .07);
        }
    </style>
</head>

<body class="d-flex flex-column h-100 fondo">
    <header class="minimal-header">
        <!-- container-fluid para full-width y padding responsivo -->
        <div class="container-fluid px-3 px-md-5">

            <!-- Usamos la clase mb-3 para un espacio inferior -->
            <div class="d-md-none text-center mt-2 mb-3">
                <h5 class="fw-bold mb-0">Restaurante La Despensa</h5>
            </div>

            <!-- Por defecto (sm) centramos la nav, 
                 en md (y superior) separamos logo y nav a extremos. -->
            <div class="d-flex justify-content-center justify-content-md-between align-items-center">

                <!-- IZQUIERDA: Logo (IMAGEN) y Nombre -->
                <!-- d-none oculta por defecto, d-md-flex lo muestra en MD y superiores y lo pone en línea -->
                <a href="index.php" class="text-decoration-none navbar-logo-text d-none d-md-flex align-items-center">
                    <!-- Placeholder de Imagen: Reemplaza la URL 'src' por tu imagen real. -->
                    <img src="img/LaDespensalogo.png" alt="Logo La Despensa"
                        class="me-2 logo">
                    <h5 class="mb-0 fw-bold">Restaurante La Despensa</h5>
                </a>

                <!-- Botones de Navegación -->
                <!-- d-flex para poner los botones en línea, sin más clases de visibilidad aquí, 
                     ya que es el único elemento visible en SM. -->
                <nav class="d-flex">
                    <a href="index.php" class="btn btn-sm btn-primary btn-elegant me-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                    </a>
                    <a href="quienessomos.php" class="btn btn-sm btn-outline-secondary btn-elegant me-2">
                        <i class="bi bi-info-circle me-1"></i> Quiénes Somos
                    </a>
                    <a href="ubicacion.php" class="btn btn-sm btn-outline-secondary btn-elegant me-2">
                        <i class="bi bi-geo-alt me-1"></i> Ubicación
                    </a>
                    <a href="carta.php" class="btn btn-sm btn-outline-secondary btn-elegant">
                        <i class="bi bi-book me-1"></i> Carta
                    </a>
                </nav>
            </div>


        </div>
    </header>

    <main class="main-content py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <div class="form-card mx-auto">
                        <div class="text-center mb-4">
                            <img class="logo-icon img-fluid" src="img/La despensa.jpg" alt="ladespensa">

                            <h2 class="h3 mt-3 mb-1 fw-semibold">Crea tu Cuenta</h2>
                            <p class="text-muted">Únete para gestionar tus reservas y pedidos.</p>
                        </div>

                        <form action="registro.php" method="POST">
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" maxlength="9" id="dni" name="dni" placeholder="600123123" value="<?php if(isset($_POST['dni'])) echo $dni;?>" required>
                                        <label for="dni"><i class="bi bi-wallet me-2"></i>DNI/NIF</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="telefono" name="telefono" maxlength="12" placeholder="600123123" value="<?php if(isset($_POST['telefono'])) echo $telefono;?>">
                                        <label for="telefono"><i class="bi bi-phone me-2"></i>Teléfono (Opcional)</label>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php if(isset($_POST['nombre'])) echo $nombre;?>" required>
                                        <label for="nombre"><i class="bi bi-person me-2"></i>Nombre</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="<?php if(isset($_POST['apellidos'])) echo $apellidos;?>">
                                        <label for="apellidos"><i class="bi bi-person-add me-2"></i>Apellidos</label>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="nombre@ejemplo.com" value="<?php if(isset($_POST['email'])) echo $email;?>" required>
                                        <label for="email"><i class="bi bi-envelope me-2"></i>Email</label>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="c/huertano,12" value="<?php if(isset($_POST['direccion'])) echo $direccion;?>">
                                        <label for="direccion"><i class="bi bi-house me-2"></i>Direccion</label>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating ">
                                        <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña"  required>
                                        <label for="pass"><i class="bi bi-lock me-2"></i>Contraseña</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Repetir Contraseña" required>
                                        <label for="pass2"><i class="bi bi-shield-check me-2"></i>Repetir Contraseña</label>
                                    </div>
                                </div>

                                <?php

                                if(isset($mensaje)){
                                    
                                echo "<small class='text-danger'>" .$mensaje ."</small>";
                                unset($mensaje);
                                
                                }
                                ?>

                           

                                <div class="col-md-12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="terminos" required>
                                        <label class="form-check-label small text-muted" for="terminos">
                                            He leído y acepto los <a href="terminos.php">Términos de Uso</a> y la <a href="privacidad.php">Política de Privacidad</a>.
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="w-100 btn btn-lg btn-primary" type="submit">
                                <i class="bi bi-person-plus-fill me-2"></i> Crear Cuenta
                            </button>

                            <div class="text-center mt-4">
                                <span class="text-muted small">¿Ya tienes una cuenta? </span>
                                <a href="index.php" class="small text-decoration-none fw-medium">Inicia Sesión</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <?php
    include("footer.php");
    ?>

</body>

</html>