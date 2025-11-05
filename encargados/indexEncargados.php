<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Restaurante - Panel de Control</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.css" type="text/css">
</head>

<body>

    <?php
    include("nav.php");
    ?>

    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Gestión Restaurante</h3>
            </div>
            <ul class="list-unstyled components sidebar-items">
                <li>
                    <a href="indexEncargados.php" class="nav-link active">Inicio</a>
                </li>
                <li>
                    <a href="modperfil.php" class="nav-link">Gestion de Personal</a>
                </li>
                <li>
                    <a href="carta.php" class="nav-link">Carta</a>
                </li>
                <li>
                    <a href="estadisticas.php" class="nav-link">Estadisticas</a>
                </li>
               
            </ul>
        </nav>

        <div id="content">
            <div class="container-fluid">
                <h1 class="page-heading">Bienvenido al Panel de Control</h1>
                <p class="subheading">Visión general.</p>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Mesas Ocupadas</h5>
                                <p class="card-text display-4">8 / 20</p>
                                <p class="card-text text-muted">Mesas atendidas actualmente</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-success">Pedidos Pendientes</h5>
                                <p class="card-text display-4">5</p>
                                <p class="card-text text-muted">Enviados a cocina</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-warning">Personal Activo</h5>
                                <p class="card-text display-4">3</p>
                                <p class="card-text text-muted">Camareros en servicio</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer class="footer-custom">
        <div class="container">
            <p class="text-muted small mb-0">&copy; 2025 Gestión Restaurante. Todos los derechos estan reservados.</p>
        </div>
    </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <script>
        // JavaScript para colapsar la barra lateral en móvil
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>

</html>