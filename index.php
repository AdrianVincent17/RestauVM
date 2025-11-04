<!doctype html>
<html lang="es" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Título Actualizado -->
    <title>La Despensa - Acceso Personal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* * 1. Configuración de página completa (Sticky Footer) */
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* * 2. Estilo de la tarjeta de login */
        .login-card {
            max-width: 430px;
            width: 100%;
            padding: 2.5rem;
            background-color: #ffffff;
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, .07);
        }

        /* * 3. Estilos de Header y Footer */
        header.minimal-header {
            background-color: #ffffff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, .075);
            padding: 1rem 0;
        }

        footer.minimal-footer {
            background-color: #ffffff;
            padding: 1.5rem 0;
            border-top: 1px solid #e9ecef;
        }

        /* * 4. Estilo "Botones Elegantes" */
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

        /* 6. Estilo específico para el logo del navbar */
        .navbar-logo-text {
            color: #212529;
        }

        /* NUEVA CLASE: Tamaño pequeño para el logo en el header */
        .header-logo-img {
            height: 60px;
            /* Ajusta este valor al tamaño que desees */
            width: auto;
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
                        class="me-2 header-logo-img">

                    <h5 class="mb-0 fw-bold">Restaurante La Despensa</h5>
                </a>

                <!-- DERECHA: Botones de Navegación -->
                <!-- d-flex para poner los botones en línea, sin más clases de visibilidad aquí, 
                     ya que es el único elemento visible en SM. -->
                <nav class="d-flex">
                    <a href="registro.php" class="btn btn-sm btn-primary btn-elegant me-2">
                        <i class="bi bi-person-plus-fill me-1"></i> Registrarse
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-secondary btn-elegant me-2">
                        <i class="bi bi-info-circle me-1"></i> Quiénes Somos
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-secondary btn-elegant">
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

                    <div class="login-card mx-auto">
                        <div class="text-center mb-4">
                            <!-- Icono de la tarjeta de login -->
                            <img class="logo-icon img-fluid" src="img/La despensa.jpg" alt="ladespensa">

                            <h2 class="h3 mt-3 mb-1 fw-semibold">Bienvenido/a</h2>
                            <!-- Nombre del restaurante actualizado -->
                            <p class="text-muted">Accede al panel de gestión de La Despensa</p>
                        </div>

                        <form action="tu-script-de-login.php" method="POST">

                            <div class="form-floating mb-3">
                                <input type:="email" class="form-control" id="floatingInput" name="email"
                                    placeholder="nombre@ejemplo.com" required>
                                <label for="floatingInput"><i class="bi bi-envelope me-2"></i>Email</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" name="password"
                                    placeholder="Contraseña" required>
                                <label for="floatingPassword"><i class="bi bi-lock me-2"></i>Contraseña</label>
                            </div>

                            <button class="w-100 btn btn-lg btn-primary" type="submit">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Acceder
                            </button>

                            <div class="text-center mt-4">
                                <a href="#" class="small text-decoration-none text-muted">¿Olvidaste tu contraseña?</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <footer class="minimal-footer mt-auto">
        <div class="container text-center">
            <!-- Nombre del restaurante actualizado -->
            <p class="text-muted small mb-0">&copy; 2025 Restaurante La Despensa. Algunos derechos nos quedan.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>