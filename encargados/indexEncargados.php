<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Restaurante - Panel de Control</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background-color: #f8f9fa; /* Color de fondo claro como Clean Blog */
        }
        .wrapper {
            display: flex;
            flex-grow: 1;
        }
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #343a40; /* Color oscuro para la barra lateral */
            color: #fff;
            transition: all 0.3s;
            padding-top: 20px;
            height: 100vh; /* Altura completa de la ventana */
            position: sticky; /* Fijo al desplazarse */
            top: 0;
        }
        #sidebar.active {
            margin-left: -250px;
        }
        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        .footer-custom {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
            width: 100%;
            margin-top: auto; /* Empuja el footer hacia abajo */
        }
        /* Estilos Clean Blog */
        .page-heading {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: #212529;
        }
        .subheading {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 3rem;
            color: #6c757d;
        }
        .card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
                position: fixed;
                height: 100%;
                z-index: 1000;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
            }
            #sidebarCollapse {
                display: block !important;
            }
        }
        .sidebar-header {
            padding-bottom: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }
        .sidebar-header h3 {
            color: #fff;
            font-size: 1.5rem;
        }
        .sidebar-items .nav-link {
            padding: 10px 15px;
            color: #adb5bd;
            font-weight: 500;
            display: block;
        }
        .sidebar-items .nav-link:hover {
            background: #495057;
            color: #fff;
            text-decoration: none;
        }
        .sidebar-items .nav-link.active {
            background: #0d6efd; /* Color primario de Bootstrap */
            color: #fff;
        }

        .logo{
            width: 60px;
            padding: auto;
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column w-100">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-info d-md-none me-3">
                    <i class="fas fa-bars"></i> <span>Menu</span>
                </button>
<<<<<<< HEAD
                <div class="col-auto  "><a class="navbar-brand text-dark" href="index.html"><img src="../img/LaDespensalogo.png" alt="LaDespensalogo" class="logo"></a></div>
=======
                <div class="col-auto  "><a class="navbar-brand text-dark" href="index.html"><img src="img/LaDespensalogo.png" alt="LaDespensalogo" class="logo"></a></div>
>>>>>>> origin/HEAD
                <div class="col"><h5>Restaurante La Despensa</h5></div>
                
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
<<<<<<< HEAD
                            <a class="nav-link" href="#">Bienvenido, <span><?php echo $email;?></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-danger ms-2" href="../logout.php">Cerrar Sesión</a>
=======
                            <a class="nav-link" href="#">Bienvenido, Usuario</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-danger ms-2" href="login.html">Cerrar Sesión</a>
>>>>>>> origin/HEAD
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="wrapper">
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>Gestión Restaurante</h3>
                </div>
                <ul class="list-unstyled components sidebar-items">
                    <li>
                        <a href="index.html" class="nav-link active">Dashboard</a>
                    </li>
                    <li>
                        <a href="users.html" class="nav-link">Usuarios (Camareros, Encargados)</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" >Gestión de Mesas</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" >Gestión de Pedidos</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" >Menú del Día</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" >Reportes</a>
                    </li>
                </ul>
            </nav>

            <div id="content">
                <div class="container-fluid">
                    <h1 class="page-heading">Bienvenido al Panel de Control</h1>
                    <p class="subheading">Visión general y acceso rápido a tus herramientas.</p>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Mesas Ocupadas</h5>
                                    <p class="card-text display-4">**8 / 20**</p>
                                    <p class="card-text text-muted">Mesas atendidas actualmente</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title text-success">Pedidos Pendientes</h5>
                                    <p class="card-text display-4">**5**</p>
                                    <p class="card-text text-muted">Enviados a cocina</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title text-warning">Personal Activo</h5>
                                    <p class="card-text display-4">**3**</p>
                                    <p class="card-text text-muted">Camareros en servicio</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    Noticias y Anuncios
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Nueva promoción de postres</h5>
                                    <p class="card-text">Consulta las nuevas adiciones a nuestro menú de postres, disponibles a partir de mañana.</p>
                                    <a href="#" class="btn btn-primary">Ver Detalles</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer-custom">
            <div class="container">
                <p class="mb-0">&copy; 2025 Restaurante La Despensa- Gestión Interna.</p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <script>
        // JavaScript para colapsar la barra lateral en móvil
        document.getElementById('sidebarCollapse').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>