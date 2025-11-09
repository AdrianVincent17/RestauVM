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
                                        <form action="altas.php" method="POST">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="dni" class="form-label">DNI/NIF</label>
                                                    <input type="text" class="form-control" name="dni" id="dni"
                                                        placeholder="Ej: 12346578X" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="nombre" class="form-label">Nombre </label>
                                                    <input type="text" class="form-control" name="nombre" id="nombre"
                                                        placeholder="Ej: Juan Pérez" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="apellidos" class="form-label">Apellidos</label>
                                                    <input type="text" class="form-control" name="apellidos" id="apellidos"
                                                        placeholder="Ej: López Obrador">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="email" class="form-label">Correo Electrónico</label>
                                                    <input type="email" class="form-control" name="email" id="email"
                                                        placeholder="ejemplo@ladespensa.com" required>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="inputName" class="form-label">Telefono</label>
                                                    <input type="tel" class="form-control" name="telefono" id="telefono"
                                                        placeholder="Ej: 658986134">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="direccion" class="form-label">Direccion</label>
                                                    <input type="adress" class="form-control" name="direccion" id="direccion"
                                                        placeholder="Ej: C/Gutierrez Mellado, 12">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="rol" class="form-label">Rol en el Restaurante</label>
                                                    <select class="form-select" id="rol" name="rol" required>
                                                        <option selected disabled>Selecciona un rol</option>
                                                        <option value="2">Encargado</option>
                                                        <option value="1">Camarero</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="pass" class="form-label">Contraseña</label>
                                                    <input type="password" class="form-control" name="pass" id="pass" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="pass2" class="form-label">Repetir Contraseña</label>
                                                    <input type="password" class="form-control" name="pass2" id="pass2" required>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success">Registrar Nuevo Usuario</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-header bg-secondary text-white">
                            Lista de Usuarios Registrados
                        </div>


                        <div>
                            <div class="card-body">
                                <div class="table-responsive me-2">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>dni</th>
                                                <th>Nombre</th>
                                                <th>Apellidos</th>
                                                <th>email</th>
                                                <th>telefono</th>
                                                <th>Rol</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php

                                            $consulta = "SELECT dni, nombre, apellidos, email, telefono, rol, estado FROM usuario";
                                            $resultado = mysqli_query($conn, $consulta);

                                            if (mysqli_num_rows($resultado) > 0) {
                                                while ($fila = mysqli_fetch_assoc($resultado)) {

                                                    switch ($fila['rol']) {
                                                        case 2:
                                                            $rolTexto = "Encargado";
                                                            break;
                                                        case 1:
                                                            $rolTexto = "Camarero";
                                                            break;
                                                        default:
                                                            $rolTexto = "Cliente";
                                                    }

                                                    // Estado 0 = activo, Estado 1 = bloqueado
                                                    if ($fila['estado'] == 0) {
                                                        // Usuario activo → mostrar botón "Bloquear"
                                                        $botonTexto = "Bloquear";
                                                        $botonColor = "danger";
                                                        $relleno = "-outline";
                                                    } else {
                                                        // Usuario bloqueado → mostrar botón "Desbloquear"
                                                        $botonTexto = "Desbloquear";
                                                        $botonColor = "success";
                                                        $relleno = ""; // botón relleno
                                                    }

                                                    echo "<tr>";
                                                    echo "<td>{$fila['dni']}</td>";
                                                    echo "<td>{$fila['nombre']}</td>";
                                                    echo "<td>{$fila['apellidos']}</td>";
                                                    echo "<td>{$fila['email']}</td>";
                                                    echo "<td>{$fila['telefono']}</td>";
                                                    echo "<td>$rolTexto</td>";

                                                    echo "<td>
                                                    <form action='blockuser.php' method='POST' style='display:inline;'>
                                                    <input type='hidden' name='dni' value='{$fila['dni']}'>
                                                    <button type='submit' class='btn-bloqueo btn btn{$relleno}-{$botonColor} btn-md'>{$botonTexto}</button>
                                                    </form>
                                                    </td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7' class='text-center text-muted'>No hay usuarios registrados</td></tr>";
                                            }
                                            ?>
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