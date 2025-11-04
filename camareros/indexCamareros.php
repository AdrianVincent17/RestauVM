<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Restaurante - Gestión de Usuarios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background-color: #f8f9fa;
            /* Color de fondo claro como Clean Blog */
        }

        .wrapper {
            display: flex;
            flex-grow: 1;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #343a40;
            color: #fff;
            transition: all 0.3s;
            padding-top: 20px;
            height: 100vh;
            position: sticky;
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
            margin-top: auto;
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
            background: #0d6efd;
            /* Color primario de Bootstrap */
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
                    <i class="fas fa-bars"></i>
                    <span>Menu</span>
                </button>
                <div class="col-auto"><a class="navbar-brand text-dark" href="index.html"><img
                            src="../img/LaDespensalogo.png" alt="LaDespensalogo" class="logo"></a></div>
                <div class="col">
                    <h5>Restaurante La Despensa</h5>
                </div>
               
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Bienvenido, [Usuario]</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-danger ms-2" href="../logout.php">Cerrar Sesión</a>
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
                        <a href="index.html" class="nav-link">Dashboard</a>
                    </li>
                    <li>
                        <a href="users.html" class="nav-link active">Usuarios (Camareros, Encargados)</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">Gestión de Mesas</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">Gestión de Pedidos</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">Menú del Día</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">Reportes</a>
                    </li>
                </ul>
            </nav>

            <div id="content">
                <div class="container-fluid">
                    <h1 class="page-heading">Gestión de Usuarios</h1>
                    <p class="subheading">Administra los perfiles de tu equipo.</p>

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            Añadir Nuevo Usuario
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="inputName" class="form-label">Nombre Completo</label>
                                        <input type="text" class="form-control" id="inputName"
                                            placeholder="Ej: Juan Pérez" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="inputEmail" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="inputEmail"
                                            placeholder="ejemplo@restaurante.com" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="selectRole" class="form-label">**Rol en el Restaurante**</label>
                                        <select class="form-select" id="selectRole" required>
                                            <option selected disabled>Selecciona un rol</option>
                                            <option value="manager">Encargado/Administrador</option>
                                            <option value="waiter">Camarero</option>
                                            <option value="kitchen">Personal de Cocina</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="inputPassword" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="inputPassword" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Registrar Nuevo Usuario</button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            Lista de Usuarios Registrados
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Correo</th>
                                            <th scope="col">Rol</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Ana García</td>
                                            <td>ana.g@restaurante.com</td>
                                            <td>Encargado</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary me-1">Editar</button>
                                                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Carlos Ruíz</td>
                                            <td>carlos.r@restaurante.com</td>
                                            <td>Camarero</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary me-1">Editar</button>
                                                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>Marta Soto</td>
                                            <td>marta.s@restaurante.com</td>
                                            <td>Camarero</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary me-1">Editar</button>
                                                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer-custom">
            <div class="container">
                <p class="mb-0">&copy; 2025 Mi Restaurante - Gestión Interna.</p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <script>
        document.getElementById('sidebarCollapse').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>

</html>