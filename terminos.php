<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restaurante La Despensa - Términos de Uso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <style>
        h1 {
            margin: 80px auto;
        }

        h2 {
            text-align: justify;
            margin: 25px;
        }

        p {
            text-align: justify;
            margin: 25px;
        }

        ul {
            margin-left: 50px;
        }

        li {
            margin-left: 25px;
        }
    </style>
</head>

<body>
    <header class="minimal-header">
        <div class="container-fluid px-3 px-md-5">
            <div class="d-md-none text-center mt-2 mb-3">
                <h5 class="fw-bold mb-0">Restaurante La Despensa</h5>
            </div>
            <div class="d-flex justify-content-center justify-content-md-between align-items-center">
                <a href="index.php" class="text-decoration-none navbar-logo-text d-none d-md-flex align-items-center">
                    <img src="img/LaDespensalogo.png" alt="Logo La Despensa" class="me-2 logo">
                    <h5 class="mb-0 fw-bold">Restaurante La Despensa</h5>
                </a>
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

    <section>
        <h1 class="text-center">Términos de Uso</h1>
        <h2>1. Introducción</h2>
        <p>
            Bienvenido a <strong>La Despensa</strong>, un restaurante dedicado a ofrecer lo mejor de la huerta murciana. Al acceder a nuestro sitio web o utilizar nuestros servicios, aceptas los siguientes términos y condiciones. Por favor, lee atentamente estos términos antes de continuar.
        </p>

        <h2>2. Aceptación de los Términos</h2>
        <p>
            Al acceder y utilizar el sitio web de <strong>La Despensa</strong> y sus servicios relacionados, aceptas cumplir con estos términos y condiciones. Si no estás de acuerdo con algún término, te solicitamos que no utilices nuestros servicios.
        </p>

        <h2>3. Uso del Sitio Web</h2>
        <p>
            El sitio web de <strong>La Despensa</strong> está destinado a proporcionar información sobre nuestros productos y servicios. Nos reservamos el derecho de modificar, actualizar o interrumpir el sitio web y sus contenidos sin previo aviso. No nos hacemos responsables de posibles interrupciones en el acceso al sitio.
        </p>

        <h2>4. Propiedad Intelectual</h2>
        <p>
            Todos los contenidos del sitio web, incluidos los textos, imágenes, logotipos, gráficos, y demás elementos están protegidos por derechos de autor y son propiedad de <strong>La Despensa</strong> o de los respectivos titulares de los derechos. Queda prohibida su reproducción, distribución, o uso sin el consentimiento previo por escrito de <strong>La Despensa</strong>.
        </p>

        <h2>5. Reservas y Servicios</h2>
        <p>
            Al realizar una reserva en línea o utilizar nuestros servicios, te comprometes a proporcionar información veraz y precisa. En caso de no poder asistir a tu reserva, te pedimos que la canceles con antelación para dar la oportunidad a otros clientes de disfrutar de nuestros servicios.
        </p>

        <h2>6. Comportamiento del Usuario</h2>
        <p>
            Al utilizar nuestros servicios, te comprometes a no realizar conductas que puedan dañar el buen nombre de <strong>La Despensa</strong> o afectar la experiencia de otros usuarios. No está permitido el uso de lenguaje ofensivo, ilegal, o inapropiado en nuestra web o en interacciones con el personal.
        </p>

        <h2>7. Modificaciones de los Términos</h2>
        <p>
            <strong>La Despensa</strong> se reserva el derecho a modificar estos términos y condiciones en cualquier momento. Cualquier cambio será publicado en esta página, y al continuar utilizando nuestros servicios después de dichas modificaciones, aceptas los nuevos términos.
        </p>

        <h2>8. Exoneración de Responsabilidad</h2>
        <p>
            <strong>La Despensa</strong> no será responsable por cualquier daño directo, indirecto, incidental, especial o consecuente que surja del uso del sitio web o de los servicios ofrecidos, incluyendo la interrupción del servicio, la pérdida de datos o cualquier otro perjuicio.
        </p>

        <h2>9. Legislación Aplicable</h2>
        <p>
            Estos términos se regirán e interpretarán de acuerdo con las leyes de España. Cualquier disputa relacionada con estos términos será resuelta en los tribunales de Murcia, España.
        </p>

        <h2>10. Contacto</h2>
        <p>
            Si tienes preguntas sobre estos términos de uso o cualquier otro asunto relacionado con <strong>La Despensa</strong>, puedes ponerte en contacto con nosotros en:
        </p>
        <address class="ms-4">
            Restaurante La Despensa<br>
            Calle de la Huerta, 27 – Molina de Segura, Murcia, España<br>
            Correo electrónico: <a href="mailto:info@ladespensa.com">info@ladespensa.com</a>
        </address>
    </section>

    <?php
    include("footer.php");
    ?>
</body>

</html>
