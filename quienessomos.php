<!DOCTYPE html>
<html lang="es">

<head>
    
    <?php

    include("head.php");
    ?>
    <title>Quiénes Somos - Restaurante La Despensa</title>
    
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
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)),
                url('img/restauLD.jpg') !important;
            background-size: cover !important;
            background-position: center !important;
            background-attachment: fixed !important;
            color: white;
        }

    

        .card,
        .valores-lista li {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            color: #333;
        }
        .img-fluid {
            transition: transform 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .img-fluid:hover {
            transform: scale(1.02);
        }

        .valores-lista li {
            margin-bottom: 0.75rem;
            padding: 1rem;
            border-radius: 0.5rem;
            background-color: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            color: #333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .valores-lista li:hover {
            background-color: rgba(255, 255, 255, 1);
            transform: translateX(5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .valores-lista h2 {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            h1 {
                font-size: 1.8rem;
            }

            .lead {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
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

    <main class="container my-4 main-content">
        <div class="row">
            <div class="col-md-6 mb-4">
                <img src="img/La despensa.jpg" alt="Restaurante La Despensa" class="img-fluid rounded-circle">
            </div>
            <div class="col-md-6">
                <h1 class="mb-4">Nuestra Historia</h1>
                <p class="lead">Desde sus inicios, <strong>Restaurante La Despensa</strong> se ha dedicado a llevar a la mesa los sabores auténticos de la huerta murciana.</p>
                <p>Ubicados en el corazón de la Región de Murcia, seleccionamos cuidadosamente productos locales de temporada, frescos y de proximidad, para ofrecer platos que celebran nuestra tierra y su riqueza gastronómica.</p>
                <p>Nuestro equipo fusiona la tradición culinaria murciana con un toque contemporáneo, respetando siempre la esencia de los ingredientes de la huerta.</p>
                <div class="mt-4 valores-lista">
                    <h2 class="h4">Nuestros Valores</h2>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Compromiso con el producto local</li>
                        <li><i class="fas fa-check text-success me-2"></i>Respeto por la tradición murciana</li>
                        <li><i class="fas fa-check text-success me-2"></i>Calidad y frescura en cada plato</li>
                        <li><i class="fas fa-check text-success me-2"></i>Atención cercana y familiar</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

  <?php
    include("footer.php");
  ?>

   
</body>

</html>