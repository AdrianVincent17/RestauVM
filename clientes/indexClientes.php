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
    <title>Gestión de Usuarios - Restaurante La Despensa</title>
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
                <h1 class="page-heading">Panel Informativo</h1>
                <p class="subheading">Visión general.</p>

                <?php

                if (isset($_SESSION['idped'])) {
                    $idped = $_SESSION['idped'];

                    // Si existe, ejecutamos la consulta (usando casting a int por seguridad)
                    $idped = (int)$idped;
                    $consulta = "SELECT COUNT(idline) as total 
                 FROM pedido_producto 
                 WHERE idped = $idped AND servido = 0";

                    $res_consulta = mysqli_query($conn, $consulta);

                    if ($res_consulta && $fila = mysqli_fetch_assoc($res_consulta)) {
                        $pedidos_pendientes = (int)$fila['total'];
                    } else {
                        $pedidos_pendientes = 0;
                    }

               

                    $consulta2 = "SELECT COUNT(idline) as total 
                 FROM pedido_producto 
                 WHERE idped = $idped AND servido = 1";

                    $res_consulta2 = mysqli_query($conn, $consulta2);

                    if ($res_consulta2 && $fila2 = mysqli_fetch_assoc($res_consulta2)) {
                        $pedidos_servidos = (int)$fila2['total'];
                    } else {
                        $pedidos_servidos = 0;
                    }
                } else {
                    $pedidos_pendientes = 0;
                    $pedidos_servidos = 0;
                }


                $consultamesas = "SELECT COUNT(nmesa) AS mesas_ocupadas FROM mesa WHERE estado=1";
                $resmesas = mysqli_query($conn, $consultamesas);
                $datosmesas = mysqli_fetch_assoc($resmesas);
                $mesas_ocupadas = $datosmesas['mesas_ocupadas'];


                $mesastot = "SELECT COUNT(nmesa) AS total_mesas FROM mesa";
                $resmesastot = mysqli_query($conn, $mesastot);
                $datosmesas2 = mysqli_fetch_assoc($resmesastot);
                $total_mesas = $datosmesas2['total_mesas'];





                ?>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Mesas Ocupadas</h5>
                                <p class="card-text display-4"><?php echo $mesas_ocupadas; ?> / <?php echo $total_mesas; ?></p>
                                <p class="card-text text-muted">Mesas atendidas actualmente</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-warning">Pedidos Pendientes</h5>
                                <p class="card-text display-4"><?php echo $pedidos_pendientes; ?></p>
                                <p class="card-text text-muted">Enviados a cocina</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-success">Pedidos Servidos</h5>
                                <p class="card-text display-4"><?php echo $pedidos_servidos; ?></p>
                                <p class="card-text text-muted">Pedidos ya servidos</p>
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