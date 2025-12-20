<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

if (isset($_SESSION['idped'])) {

    $idped = $_SESSION['idped'];
    $consulta = "SELECT * FROM pedido WHERE idped = '$idped'";

    $result = mysqli_query($conn, $consulta);
    $row = mysqli_fetch_array($result);
    if ($row['estado'] == '1') {
        unset($_SESSION['idmesa']);
        mysqli_close($conn);
        header('Location:mesas.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include("../head.php"); ?>
    <title>Restaurante La Despensa - Resumen Pedido</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <?php include("../nav.php"); ?>
    <div class="wrapper">
        <?php include("navbar.php"); ?>
        <div id="content">
            <div class="container-fluid">
                
            <h1>Resumen del Pedido de la Mesa <?php echo $_SESSION['idmesa']; ?></h1>

            <div class="row justify-content-center mb-5">
                <div class="col-lg-10">
                    <div>

                        <h2 class="mt-5 mb-5">Total Pedido a la Mesa</h2>

                        <div class="table-responsive">
                            <table class="table text-center table-striped table-hover">
                                <thead>
                                    <tr class='text-center'>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Comentario</th>
                                        <th>Estado</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $dni = $_SESSION['dni'];
                                    $idped = $_SESSION['idped'];
                                    $total = 0;

                                    // Realizamos consulta de la tabla pedido_producto
                                    $consulta_pp = "SELECT * FROM pedido_producto WHERE idped=$idped";
                                    $result1 = mysqli_query($conn, $consulta_pp);

                                    if (mysqli_num_rows($result1) > 0) {
                                        while ($row1 = mysqli_fetch_array($result1)) {

                                            // Hacemos consulta para conseguir el nombre del producto
                                            $idprod = $row1['idprod'];
                                            $cantidad = $row1['cant'];
                                            $consulta_productos = "SELECT * FROM producto WHERE idprod='$idprod'";
                                            $result2 = mysqli_query($conn, $consulta_productos);

                                            $row2 = mysqli_fetch_assoc($result2);
                                            $nombre = $row2['nombre'];
                                            $precio = $row2['precio'];
                                            $total += $precio*$cantidad;

                                            // Guardamos la variable del estado de cada producto, poniendole el estado en que se encuentra
                                            if ($row1['servido'] == 0) {
                                                $estado = 'Pendiente';
                                                $color = 'danger';
                                            } else {
                                                $estado = 'Servido';
                                                $color = 'success';
                                            }
                                            echo "<tr class='text-center'>";
                                            echo "<td>" . ($nombre) . "</td>";
                                            echo "<td>" . ($cantidad) . "</td>";
                                            echo "<td>" . ($row1['comentario']) . "</td>";
                                            echo "<td><span class='badge bg-" . $color . "'>" . ($estado) . "</td>";
                                            echo "<td>" . number_format($precio, 2) . " €</td>";
                                            echo "</tr>";
                                        }
                                    }

                                    mysqli_close($conn);
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr class="border-top">
                                        <td colspan="4" class="text-end h5" style="vertical-align: middle;">Total a Pagar:</td>
                                        <td class="h4 text-warning"><?php echo number_format($total, 2) . " €"; ?></td>
                                    </tr>
                                </tfoot>
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

        <script src="../js/bootstrap.bundle.min.js"></script>

</body>

</html>