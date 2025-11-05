<!doctype html>
<html lang="es" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - Restaurante La Despensa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.css" type="text/css">

    <style>
        /* 1. Configuración de página completa (Sticky Footer) */
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
            color: #212529;
        }

        .main-content {
            flex-grow: 1;
            /* Permite que este área crezca y empuje el footer */
            /* Ajustamos align-items a 'start' para que el formulario se vea bien en móvil */
            /* si crece mucho, y centramos con justify-content */
            display: flex;
            align-items: start;
            justify-content: center;
        }

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

        /* 3. Estilos de Header y Footer */
        header.minimal-header {
            background-color: #ffffffff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, .075);
            padding: 1rem 0;
            /* z-index para estar sobre el contenido */
            position: relative;
            z-index: 10;
        }

        footer.minimal-footer {
            background-color: #ffffffff;
            padding: 1.5rem 0;
            border-top: 1px solid #e9ecef;
        }

        /* 4. Estilo "Botones Elegantes" */
       .btn-elegant {
            border-radius: 50px;
            font-weight: 500;
        }

        /* 5. Icono de logo placeholder */
        .logo-icon {
             height: 90px;
            /* Ajusta este valor al tamaño que desees */
            width: 90px;
            padding: 0;
            margin: 0;
        }

        .logo{
            height: 60px;
            /* Ajusta este valor al tamaño que desees */
            width: auto;
        }

        /* 6. Estilo específico para el logo del navbar */
        .navbar-logo-text {
            color: #212529;
        }

         .fondo {
            background-image: url('img/restauLD.jpg');
            background-repeat: no-repeat;
            background-size: cover;
          

        }
    </style>
</head>

<body class="d-flex flex-column h-100 fondo">
    <header class="minimal-header">
        <!-- CAMBIO CLAVE: container-fluid para full-width y padding responsivo -->
        <div class="container-fluid px-3 px-md-5">

            <!-- Título Centrado en Móvil (SM): Se muestra solo en SM y se oculta en MD y superiores -->
            <!-- Usamos la clase mb-3 para un espacio inferior -->
            <div class="d-md-none text-center mt-2 mb-3">
                <h5 class="fw-bold mb-0">Restaurante La Despensa</h5>
            </div>

            <!-- ESTRUCTURA FLEXBOX para ALINEACIÓN: Por defecto (sm) centramos la nav, 
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

                <!-- DERECHA: Botones de Navegación -->
                <!-- d-flex para poner los botones en línea, sin más clases de visibilidad aquí, 
                     ya que es el único elemento visible en SM. -->
                <nav class="d-flex">
                    <a href="index.php" class="btn btn-sm btn-primary btn-elegant me-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                    </a>
                    <a href="quienessomos.php" class="btn btn-sm btn-outline-secondary btn-elegant me-2">
                        <i class="bi bi-info-circle me-1"></i> Quiénes Somos
                    </a>
                    <a href="ubicacion.php" class="btn btn-sm btn-outline-secondary btn-elegant">
                        <i class="bi bi-geo-alt me-1"></i> Ubicación
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

                        <form action="tu-script-de-registro.php" method="POST">

                            <div class="form-floating mb-3">
                                <input type="tel" class="form-control" id="floatingdni" name="dni" placeholder="600123123">
                                <label for="floatingdni"><i class="bi bi-wallet me-2"></i>DNI/NIF</label>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingNombre" name="nombre" placeholder="Nombre" required>
                                        <label for="floatingNombre"><i class="bi bi-person me-2"></i>Nombre</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingApellidos" name="apellidos" placeholder="Apellidos" required>
                                        <label for="floatingApellidos">Apellidos</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingEmail" name="email" placeholder="nombre@ejemplo.com" required>
                                <label for="floatingEmail"><i class="bi bi-envelope me-2"></i>Email</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="tel" class="form-control" id="floatingTelefono" name="telefono" placeholder="600123123">
                                <label for="floatingTelefono"><i class="bi bi-phone me-2"></i>Teléfono (Opcional)</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Contraseña" required>
                                <label for="floatingPassword"><i class="bi bi-lock me-2"></i>Contraseña</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPasswordConfirm" name="password_confirm" placeholder="Repetir Contraseña" required>
                                <label for="floatingPasswordConfirm"><i class="bi bi-shield-check me-2"></i>Repetir Contraseña</label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="" id="checkTerminos" required>
                                <label class="form-check-label small text-muted" for="checkTerminos">
                                    He leído y acepto los <a href="terminos.php">Términos de Uso</a> y la <a href="privacidad.php">Política de Privacidad</a>.
                                </label>
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

    <footer class="minimal-footer mt-auto">
        <div class="container text-center">
            <p class="text-muted small mb-0">&copy; 2025 Gestión Restaurante. Todos los derechos estan reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>