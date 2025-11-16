<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");
?>
<!doctype html>
<html lang="es">

<head>
    <?php

    include("../head.php");
    ?>
    <title>Restaurante - Reserva Mesa</title>
   <style>
        .card {
            justify-content: center;
            align-items: center;
            width: 250px;
            height: 250px;
            border-radius: 80px;
            /* NOTA: He cambiado 'border: none;' por un borde sutil 
              para que los colores de estado destaquen más.
            */
            border: 3px solid transparent; 
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            transition: all 0.2s ease-in-out; /* <-- Añadido para un efecto suave */
        }

        /* * =============================================
         * ¡NUEVO! - ESTILOS DE ESTADO DE MESA
         * =============================================
         * Simplemente añade una de estas clases al div 'card' 
         * para cambiar su estado visualmente.
         */

        /* ESTADO: DISPONIBLE */
        .mesa-disponible {
            border-color: #198754; /* Verde Bootstrap */
        }
        .mesa-disponible .card-title {
            color: #198754 !important;
        }
        .mesa-disponible .btn {
            background-color: #198754;
            border-color: #198754;
        }
        .mesa-disponible:hover {
            transform: scale(1.03); /* Efecto al pasar el ratón */
            box-shadow: 0 0.5rem 1.5rem rgba(0,0,0, .15);
        }

        /* ESTADO: OCUPADA */
        .mesa-ocupada {
            box-shadow: 0px 0px 10px red;
            border-color: #dc3545; /* Rojo Bootstrap */
            background-color: #f8f9fa; /* Fondo gris claro */
            opacity: 0.7;
        }
        .mesa-ocupada .card-title {
            color: #dc3545 !important;
        }
        .mesa-ocupada .btn {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* ESTADO: PENDIENTE (Ej. reserva por confirmar) */
        .mesa-pendiente {
            border-color: #ffc107; /* Amarillo Bootstrap */
        }
        .mesa-pendiente .card-title {
            color: #ffc107 !important;
        }
        .mesa-pendiente .btn {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000; /* Texto oscuro para botón amarillo */
        }

    </style>
</head>

<body>
    <?php
    include("../nav.php");
    ?>
    <div class="wrapper">
        <?php
        include("navbar.php");
        ?>
        <div id="content">
            <div class="container-fluid">
                <div class="row ms-5">
                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-title text-primary">Mesa 1</h5>
                            <p class="card-text display-4"><button class="btn btn-primary">Reservar</button></p>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-title text-primary">Mesa 1</h5>
                            <p class="card-text display-4"><button class="btn btn-primary">Reservar</button></p>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-title text-primary">Mesa 1</h5>
                            <p class="card-text display-4"><button class="btn btn-primary">Reservar</button></p>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-title text-primary">Mesa 1</h5>
                            <p class="card-text display-4"><button class="btn btn-primary">Reservar</button></p>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-title text-primary">Mesa 1</h5>
                            <p class="card-text display-4"><button class="btn btn-primary">Reservar</button></p>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-title text-primary">Mesa 1</h5>
                            <p class="card-text display-4"><button class="btn btn-primary">Reservar</button></p>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-title text-primary">Mesa 1</h5>
                            <p class="card-text display-4"><button class="btn btn-primary">Reservar</button></p>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-title text-primary">Mesa 1</h5>
                            <p class="card-text display-4"><button class="btn btn-primary">Reservar</button></p>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-title text-primary">Mesa 1</h5>
                            <p class="card-text display-4"><button class="btn btn-primary">Reservar</button></p>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <?php
    include("../footer.php");
    ?>
    </div>
    <script>
        // JavaScript para colapsar la barra lateral en móvil
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>

</html>

</html>