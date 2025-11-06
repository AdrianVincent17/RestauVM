<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Restaurante - Gestión de Usuarios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.css" type="text/css">

</head>

<body>
    <div class="d-flex flex-column w-100">

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
                        <a href="indexClientes.php" class="nav-link">Inicio</a>
                    </li>
                    <li>
                        <a href="mesas.php" class="nav-link active">Reservar Mesa</a>
                    </li>
                    <li>
                        <a href="carta.php" class="nav-link">Carta Restaurante</a>
                    </li>
                    <li>
                        <a href="modperfil.php" class="nav-link active">Mi Perfil</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">Reportes</a>
                    </li>
                </ul>
            </nav>

            <div id="content">
                <div class="container-fluid">
                    <h1 class="page-heading">Mi perfil</h1>
                    <p class="subheading">Gestiona tu información.</p>

                    <p>
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
                            Toggle con collapse
                        </button>
                    </p>
                    <div style="min-height: 120px;">
                        <div class="collapse collapse-horizontal" id="collapseWidthExample">
                            <div class="card card-body" style="width: 300px;">
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

                            </div>
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
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>

</html>