<?php
include("../seguridad.php");
proteger(1);
include("../conexion.php");
?>

<!doctype html>
<html lang="es">

<head>
    <?php

    include("../head.php");
    ?>
    <title>Gestión Camareros - Restaurante La Despensa</title>
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

                $pedidos_pendientes_hoy = 0;
                $pedidos_servidos_hoy = 0;

                $consulta_hoy = "SELECT COUNT(pp.idline) as total_pendientes 
                 FROM pedido p
                 INNER JOIN pedido_producto pp ON p.idped = pp.idped
                 WHERE DATE(p.fecha) = CURDATE() 
                 AND pp.servido = 0";

                $resultado = mysqli_query($conn, $consulta_hoy);

                // Contamos cuántos hay en total para mostrar un aviso
                $fila = mysqli_fetch_assoc($resultado);

                $pedidos_pendientes_hoy=$fila['total_pendientes']??0;


                $consulta_hoy2 = "SELECT COUNT(pp.idline) as total_servidos 
                 FROM pedido p
                 INNER JOIN pedido_producto pp ON p.idped = pp.idped
                 WHERE DATE(p.fecha) = CURDATE() 
                 AND pp.servido = 1";

                $resultado2 = mysqli_query($conn, $consulta_hoy2);

                // Contamos cuántos hay en total para mostrar un aviso
                $fila2 = mysqli_fetch_assoc($resultado2);

                $pedidos_servidos_hoy=$fila2['total_servidos']??0;




                $consultamesas = "SELECT COUNT(*) AS total_mesas,
                                            SUM(CASE WHEN estado = 1 THEN 1 ELSE 0 END) AS mesas_ocupadas
                                     FROM mesa";
                $resmesas = mysqli_query($conn, $consultamesas);
                $datosmesas = mysqli_fetch_assoc($resmesas);
                $total_mesas = $datosmesas['total_mesas'];
                $mesas_ocupadas = $datosmesas['mesas_ocupadas'];





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
                                <p class="card-text display-4"><?php echo $pedidos_pendientes_hoy; ?></p>
                                <p class="card-text text-muted">Enviados a cocina</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-success">Pedidos Servidos</h5>
                                <p class="card-text display-4"><?php echo $pedidos_servidos_hoy; ?></p>
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