<?php
include("../seguridad.php");
proteger(2);
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
                    <h1 class="page-heading">Gestión de Usuarios</h1>
                    <p class="subheading">Administra diferentes perfiles.</p>

                    <div class="mb-2">
                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#usuario" aria-expanded="false" aria-controls="usuario">
                            Añadir nuevo usuario
                        </button>
                    </div>

                    <div style="min-height: 10px;">
                        <div class="collapse" id="usuario">
                            <div class="card card-body">
                                <div class="card mb-4">
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
                    <div class="mb-2">
                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#añadeusuario" aria-expanded="false" aria-controls="añadeusuario">
                            listado de usuarios registrados
                        </button>
                    </div>

                    <div style="min-height: 10px;">
                        <div class="collapse" id="añadeusuario">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">dni</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">email</th>
                                                <th scope="col">telefono</th>
                                                <th scope="col">Rol</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Ana García</td>
                                                <td>ana.g@restaurante.com</td>
                                                <td>65487321</td>
                                                <td>Encargado</td>
                                                <td>
                                                    <input type="checkbox" class="btn-check" id="bl1" autocomplete="off">
                                                    <label class="btn btn-outline-warning" for="bl1">bloquear</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Carlos Ruíz</td>
                                                <td>carlos.r@restaurante.com</td>
                                                <td>65487321</td>
                                                <td>Camarero</td>
                                                <td>
                                                    <input type="checkbox" class="btn-check" id="bl2" autocomplete="off">
                                                    <label class="btn btn-outline-warning" for="bl2">bloquear</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Marta Soto</td>
                                                <td>marta.s@restaurante.com</td>
                                                <td>65487321</td>
                                                <td>Camarero</td>
                                                <td>
                                                    <input type="checkbox" class="btn-check" id="bl3" autocomplete="off">
                                                    <label class="btn btn-outline-warning" for="bl3">bloquear</label>
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