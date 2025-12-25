<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

// ===== Comprobamos si el usuario ya tiene un pedido activo =====
$dni_cliente = $_SESSION['dni'];
$consulta_pedido = "SELECT idped, nmesa FROM pedido WHERE usuario='$dni_cliente' AND estado=0 LIMIT 1";
$result_pedido = mysqli_query($conn, $consulta_pedido);

if ($pedido = mysqli_fetch_assoc($result_pedido)) {
    // Guardamos el idped y la mesa en sesión
    $_SESSION['idped'] = $pedido['idped'];
    $_SESSION['idmesa'] = $pedido['nmesa'];

    // Redirigimos al pedido activo
    mysqli_close($conn);
    header('Location: pedidos.php');
    exit();
}

// ===== Si no hay pedido activo, mostramos las mesas =====
$consultamesa = "SELECT * FROM mesa";
$mesas = mysqli_query($conn, $consultamesa);
?>
<!doctype html>
<html lang="es">

<head>
    <?php include("../head.php"); ?>
    <title>Reserva Mesa - Restaurante La Despensa</title>
    <style>
        .card {
            width: 50%;
            aspect-ratio: 0.5 / 0.5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 25%;
            border: 3px solid transparent;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .mesa-disponible {
            border-color: #198754;
        }

        .mesa-disponible .card-title {
            color: #198754 !important;
        }

        .mesa-disponible .btn {
            background-color: #198754;
            border-color: #198754;
        }

        .mesa-disponible .btn:hover {
            transform: scale(1.03);
            background-color: #24a167ff;
        }

        .mesa-disponible:hover {
            transform: scale(1.03);
            box-shadow: 0 0.5rem 1.5rem rgba(51, 255, 0, 0.15);
        }

        .mesa-ocupada {
            box-shadow: 0px 0px 10px red;
            border-color: #dc3545;
            background-color: #f8f9fa;
            opacity: 0.7;
        }

        .mesa-ocupada .card-title {
            color: #dc3545 !important;
        }

        .mesa-ocupada .btn {
            background-color: #dc3545;
            border-color: #dc3545;
        }
    </style>
</head>

<body>
    <?php include("../nav.php"); ?>
    <div class="wrapper">
        <?php include("navbar.php"); ?>
        <div id="content">
            <div class="container-fluid">
                <div class="row g-4 justify-content-center mt-2">
                    <?php
                    if ($mesas && mysqli_num_rows($mesas) > 0) {
                        while ($datosmesas = mysqli_fetch_assoc($mesas)) {
                            $nummesa = $datosmesas['nmesa'];
                            $estadomesa = $datosmesas['estado'];

                            $clase_estado = '';
                            $texto_btn = '';
                            $btn_clase = 'btn-primary';

                            switch ($estadomesa) {
                                case 0:
                                    $clase_estado = 'mesa-disponible';
                                    $texto_btn = 'Reservar';
                                    $btn_clase = 'btn-success';
                                    break;
                                case 1:
                                    $clase_estado = 'mesa-ocupada';
                                    $texto_btn = 'Ocupada';
                                    $btn_clase = 'btn-danger disabled';
                                    break;
                            }
                    ?>
                            <div class="col-12 col-sm-6 col-md-4 m-0 d-flex justify-content-center">
                                <div class="card <?php echo $clase_estado; ?>">
                                    <?php if ($estadomesa == 0) { ?>
                                        <form action="altareserva.php" method="POST" class="d-flex flex-column align-items-center">
                                            <h4 class="card-title mb-4">Mesa Nº <?php echo $nummesa; ?></h4>
                                            <div class="mb-3 d-flex flex-column align-items-center">
                                                <label for="personas">Nº Comensales</label>
                                                <input type="number" class="form-control" style="width: 80px; text-align: center;" name="personas" min="1" max="12" value="1" required>
                                                <input type="hidden" value="<?php echo $nummesa; ?>" id="idmesa" name="idmesa">
                                            </div>
                                            <button type="submit" class="btn btn-md <?php echo $btn_clase; ?>"><?php echo $texto_btn; ?></button>
                                        </form>
                                    <?php } else { ?>
                                        <h4 class="card-title mb-4 text-danger">Mesa Nº <?php echo $nummesa; ?></h4>
                                        <button class="btn btn-md <?php echo $btn_clase; ?>" disabled><?php echo $texto_btn; ?></button>
                                    <?php } ?>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<div class='alert alert warning' role='alert'>No se encontraron mesas en la base de datos</div>";
                    }
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php include("../footer.php"); ?>
</body>

</html>
