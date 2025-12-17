<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

$consultamesa = "SELECT * FROM mesa";

$mesas = mysqli_query($conn, $consultamesa);

?>
<!doctype html>
<html lang="es">

<head>
    <?php
    include("../head.php");
    ?>
    <title>Restaurante La Despensa - Reserva Mesa</title>
    <style>
        .card {
            width: 50%;
            /* Ocupa todo el ancho de su columna */
            aspect-ratio: 0.5 / 0.5;
            /* Mantiene la forma cuadrada de la tarjeta */
            display: flex;
            /* Asegura que los hijos se centren */
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 25%;
            /* Borde más moderno que 80px */
            border: 3px solid transparent;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            /* Quitamos margin-bottom de aquí ya que lo gestionará el 'g-4' del 'row' */
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            /* Añadido cursor para indicar interactividad */
        }

        /* ESTADO: DISPONIBLE */
        .mesa-disponible {
            border-color: #198754;
            /* Verde Bootstrap */

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
            /* Efecto al pasar el ratón */
            box-shadow: 0 0.5rem 1.5rem rgba(51, 255, 0, 0.15);
        }

        /* ESTADO: OCUPADA */
        .mesa-ocupada {
            box-shadow: 0px 0px 10px red;
            border-color: #dc3545;
            /* Rojo Bootstrap */
            background-color: #f8f9fa;
            /* Fondo gris claro */
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
    <?php
    include("../nav.php");
    ?>
    <div class="wrapper">
        <?php
        include("navbar.php");
        ?>
        <div id="content">
            <div class="container-fluid">


                <div class="row g-4 justify-content-center">
                    <?php

                    if ($mesas && mysqli_num_rows($mesas) > 0) {  //si el numero de filas es mayor que 0...
                        while ($datosmesas = mysqli_fetch_assoc($mesas)) {

                            $nummesa = $datosmesas['nmesa'];
                            $estadomesa = $datosmesas['estado'];

                            // Determinamos la clase CSS y el texto según el estado
                            $clase_estado = '';
                            $texto_estado = '';
                            $texto_btn = '';
                            $btn_clase = 'btn-primary'; // Clase base de Bootstrap

                            switch ($estadomesa) {

                                case 0: // DISPONIBLE
                                    $clase_estado = 'mesa-disponible';
                                    $texto_btn = 'Reservar';
                                    $btn_clase = 'btn-success'; // O cualquier clase que te guste para disponible
                                    break;
                                case 1: // OCUPADA
                                    $clase_estado = 'mesa-ocupada';
                                    $texto_btn = 'Ocupada';
                                    $btn_clase = 'btn-danger disabled'; // O cualquier clase que te guste para ocupada
                                    break;
                            }

                            // INICIO DEL ELEMENTO HTML DE LA MESA (DENTRO DEL WHILE)
                    ?>

                            <div class="col-12 col-sm-6 col-md-4 m-0 d-flex justify-content-center">
                                <div class="card <?php echo $clase_estado; ?>">
                                    <?php
                                    if ($estadomesa == 0) {
                                    ?>
                                        <form action="altareserva.php" method="POST" class="d-flex flex-column align-items-center">
                                            <h4 class="card-title mb-4">Mesa Nº <?php echo $nummesa;?></h4>

                                            <div class="mb-3 d-flex flex-column align-items-center">
                                                <label for="personas">Nº Comensales</label>
                                                <input type="number" class="form-control" style="width: 80px; text-align: center;" name="personas" min="1" max="12" value="1" required>
                                                <input type="hidden" value="<?php echo $nummesa;?>" id="idmesa" name="idmesa">
                                            </div>
                                            <button type="submit" class="btn btn-md <?php echo $btn_clase; ?>"><?php echo $texto_btn; ?></button>
                                        </form>
                                    <?php
                                    } else {
                                    ?>
                                        <h4 class="card-title mb-4 text-danger">Mesa Nº <?php echo $nummesa; ?></h4>
                                        <button class="btn btn-md <?php echo $btn_clase; ?>" disabled>
                                            <?php echo $texto_btn; ?>
                                        </button>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                    <?php

                        }
                    } else {
                        echo "<div class='alert alert warning' role='alert'>No se encontraron mesas en la base de datos</div";
                    }
                    //cierre de la conexion
                    mysqli_close($conn);
                    ?>
                </div>

            </div>
        </div>
    </div>

    <?php
    include("../footer.php");
    ?>
</body>

</html>