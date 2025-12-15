<?php
session_start();
?>
<!doctype html>
<html lang="es" class="h-100">

<head>

    <?php
    include("head.php");
    ?>

    <title>Restaurante La Despensa - Acceso Personal</title>
    
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

        .map-container {
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            width: 100%;
            padding-bottom: 75%;
            /* Ratio 4:3 */
        }

        .map-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
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

    <main class="container">
        <div class="row align-items-center vh-100">
            <div class="col-lg-6">
                <div class="card shadow-lg contact-card">
                    <div class="card-body">
                        
                        <h2 class="card-title">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>Ubicación
                        </h2>

                        <address class="contact-info">
                            <strong>Restaurante La Despensa</strong><br>
                            Calle de la Huerta, 27<br>
                            30500 Molina de Segura<br>
                            Murcia, España
                        </address>

                        <h3 class="h5">
                            <i class="fas fa-clock text-primary me-2"></i>Horario
                        </h3>
                        <p class="contact-info"><b>Martes a Domingo:</b> 13:00 - 16:00 y 20:00 - 23:00<br>
                           <b> Lunes:</b> Cerrado</p>

                        <h3 class="h5">
                            <i class="fas fa-phone text-primary me-2"></i>Contacto
                        </h3>
                        <p class="contact-info"><b>Teléfono:</b> 968 65 81 97<br>
                            <b>Email:</b> info@ladespensa.es<br>
                            <b>Reservas:</b> reservas@ladespensa.es</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6283.5250278593385!2d-1.228804605592398!3d38.05261962370237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd647f4dcbc710c9%3A0xbaf039ec8694b093!2sAv.%20de%20la%20Huerta%2C%2027%2C%2030500%20Molina%20de%20Segura%2C%20Murcia!5e0!3m2!1ses!2ses!4v1764696411151!5m2!1ses!2ses"
                        width="600" height="450" style="border:0;"
                        allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </main>

    <?php
    include('footer.php');
    ?>

</body>

</html>