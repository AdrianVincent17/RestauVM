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

    <?php
    include("../nav.php");
    ?>

    <div class="wrapper">
        <?php
        include("navbar.php");
        ?>

        <div id="content">
            <div class="container-fluid">
                <h1 class="page-heading">Bienvenido al Panel de Control</h1>
                <p class="subheading">Visión general.</p>

                <?php
                    $consultamesas="SELECT COUNT(*) AS total_mesas,
                                            SUM(CASE WHEN estado = 1 THEN 1 ELSE 0 END) AS mesas_ocupadas
                                     FROM mesa";
                    $resmesas=mysqli_query($conn,$consultamesas);
                    $datosmesas=mysqli_fetch_assoc($resmesas);
                    $total_mesas=$datosmesas['total_mesas'];
                    $mesas_ocupadas=$datosmesas['mesas_ocupadas'];

                ?>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Mesas Ocupadas</h5>
                                <p class="card-text display-4"><?php echo $mesas_ocupadas;?> / <?php echo $total_mesas;?></p>
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

    <?php
    include("../footer.php");
    ?>
    </div>
</body>

</html>

</html>