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

    <title>Restaurante - Gestión de Usuarios</title>

    

</head>

<body>
    <div class="d-flex flex-column w-100">

        <?php
        include("../nav.php");
        ?>

        <div class="wrapper">
            <?php
            include("navbar.php");
            ?>

            <div id="content">
                <div class="container-fluid">
                    <h1 class="page-heading">Mi perfil</h1>
                    <p class="subheading">Gestiona tu información.</p>

                    <p>
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
                            Toggle con collapse
                        </button>
                    </p>
                    <div style="min-height: 10px;">
                        <div class="collapse" id="collapseWidthExample">
                            <div class="card card-body">
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

        <?php
        include("../footer.php");
        ?>
    </div>
    <script>
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>

</html>