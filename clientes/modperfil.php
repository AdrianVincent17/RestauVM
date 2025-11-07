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
                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
                            Editar perfil
                        </button>
                    </p>
                    <div style="min-height: 10px;">
                        <div class="collapse" id="collapseWidthExample">
                            <div class="card card-body">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <form action="modCliente.php" method="POST">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="dni" class="form-label">DNI/NIF</label>
                                                    <input type="text" class="form-control" name="dni" id="dni" value="<?php echo $_SESSION['dni'];?>" disabled required>
                                                    <input type="hidden" name="dni" value="<?php echo $_SESSION['dni'];?>">
                                                </div>
                                                 <div class="col-md-4 mb-3">
                                                    <label for="nombre" class="form-label">Nombre </label>
                                                    <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $_SESSION['nombre'];?>" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="apellidos" class="form-label">Apellidos</label>
                                                    <input type="text" class="form-control" name="apellidos" id="apellidos" value="<?php echo isset($_SESSION['apellidos']) ? $_SESSION['apellidos'] : ''; ?>">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="email" class="form-label">Correo Electrónico</label>
                                                    <input type="email" class="form-control" name="email" id="email"value="<?php echo $_SESSION['email'];?>" required>
                                                </div>
                                               
                                                <div class="col-md-4 mb-3">
                                                    <label for="inputName" class="form-label">Telefono</label>
                                                    <input type="tel" class="form-control" name="telefono" id="telefono" value="<?php echo isset($_SESSION['telefono']) ? $_SESSION['telefono'] : ''; ?>">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="direccion" class="form-label">Direccion</label>
                                                    <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo isset($_SESSION['direccion']) ? $_SESSION['direccion'] : ''; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="pass" class="form-label">Contraseña</label>
                                                    <input type="password" class="form-control" name="pass" id="pass">

                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="pass2" class="form-label">Repetir Contraseña</label>
                                                    <input type="password" class="form-control" name="pass2" id="pass2">
                                                  
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success">Aceptar cambios</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            Lista de facturas
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nº</th>
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th>Importe</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>1</th>
                                            <td>Ana Garcia</td>
                                            <td>22/02/2025 20:44:30</td>
                                            <td>130,23€</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-success">Descargar</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>2</th>
                                            <td>Ana Garcia</td>
                                            <td>27/03/2025 21:44:30</td>
                                            <td>68,03€</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-success">Descargar</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>3</th>
                                            <td>Ana Garcia</td>
                                            <td>18/05/2025 20:14:10</td>
                                            <td>55,39€</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-success">Descargar</button>
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