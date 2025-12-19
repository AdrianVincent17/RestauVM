<?php
include("../seguridad.php");
proteger(2);
include("../conexion.php");

  $consultamesas = "SELECT COUNT(nmesa) AS mesas_ocupadas FROM mesa WHERE estado=1";
                $resmesas = mysqli_query($conn, $consultamesas);
                $datosmesas = mysqli_fetch_assoc($resmesas);
                $mesas_ocupadas = $datosmesas['mesas_ocupadas'];


 $mesastot = "SELECT COUNT(nmesa) AS total_mesas FROM mesa";
                $resmesastot = mysqli_query($conn, $mesastot);
                $datosmesas2 = mysqli_fetch_assoc($resmesastot);
                $total_mesas = $datosmesas2['total_mesas'];

$consulta_pedidos="SELECT count(*) as pedidos_totales FROM pedido WHERE estado=1 AND DATE(fecha)=CURDATE()";
$res_pedidos=mysqli_query($conn,$consulta_pedidos);
$datos_pedidos=mysqli_fetch_assoc($res_pedidos);
if(mysqli_num_rows($res_pedidos)>0){
$transacciones=$datos_pedidos['pedidos_totales'];
}else {
    $transacciones=0;
}


$consulta_dinero = "SELECT SUM(pr.precio * pp.cant) as recaudacion_hoy 
                    FROM pedido p
                    INNER JOIN pedido_producto pp ON p.idped = pp.idped
                    INNER JOIN producto pr ON pr.idprod=pp.idprod
                    WHERE p.estado = 1 AND DATE(p.fecha) = CURDATE()";

$res_dinero = mysqli_query($conn, $consulta_dinero);
$datos_dinero = mysqli_fetch_assoc($res_dinero);

$total_dinero = $datos_dinero['recaudacion_hoy'] ?? 0;
               
?>



<!doctype html>
<html lang="es">

<head>

    <?php
    include("../head.php");
    ?>
    <title>Restaurante - Panel de Control</title>



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

                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Mesas Ocupadas</h5>
                                <p class="card-text display-4"><?php echo $mesas_ocupadas;?> / <?php echo $total_mesas;?> </p>
                                <p class="card-text text-muted">Mesas atendidas actualmente</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-success">Total Transaccioness</h5>
                                <p class="card-text display-4"><?php echo $transacciones;?></p>
                                <p class="card-text text-muted">Pedidos Terminados</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-warning">Total Recaudacion</h5>
                                <p class="card-text display-4"><?php echo number_format($total_dinero, 2) . "€";?></p>
                                <p class="card-text text-muted">Caja Total de hoy</p>
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