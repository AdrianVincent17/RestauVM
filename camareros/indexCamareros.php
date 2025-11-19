<?php
include("../seguridad.php");
proteger(1);
include("../conexion.php");
?>
<!doctype html>
<html lang="es">
<?php
include("../head.php");
?>
<title>Restaurante - Gestion Camareros</title>

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
                    <h1 class="page-heading">Gestión Camareros</h1>
                    <p class="subheading">Administra mesas y pedidos</p>

                    

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

                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            Lista de mesas usuarios
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