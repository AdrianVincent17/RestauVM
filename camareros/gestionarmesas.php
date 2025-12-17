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
    <title>Restaurante La Despensa - Gestión de Mesas Ocupadas</title>
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

        /* ESTADO: OCUPADA */
        .mesa-ocupada {
          
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

          .mesa-ocupada .btn:hover{
            transform: scale(1.05);
            background-color: #dc3545;
            box-shadow: 0px 0px 10px red;
        }

        .mesa-ocupada:hover {
            transform: scale(1.03);
            /* Efecto al pasar el ratón */
             box-shadow: 0px 0px 10px red;
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
            <div class="container-fluid card-container">
                <h1 class=" mb-5 fw-bold text-dark">
                    Gestión de Mesas Ocupadas
                </h1>

                <div class="row g-4 justify-content-center">


                    <?php

                    // Consulta para ver las meses que hay
                    $consulta_mesa = "SELECT * FROM mesa";
                    $result1 = mysqli_query($conn, $consulta_mesa);
                    echo mysqli_error($conn);

                    while ($row1 = mysqli_fetch_array($result1)) {
                        $estado = $row1['estado'];
                        $idmesa = $row1['nmesa'];

                        // Consulta para ver los comensales de cada mesa reservada
                        $consulta_reserva = "SELECT * FROM reserva WHERE nmesa=$idmesa";
                        $result2 = mysqli_query($conn, $consulta_reserva);
                        echo mysqli_error($conn);
                        $row2 = mysqli_fetch_array($result2);
                        if (isset($row2['comensales']))
                            $comensales = $row2['comensales'];

                        switch ($estado) {

                                case 0: // DISPONIBLE
                                    $clase_estado = 'mesa-disponible';
                                    $texto_btn = 'Libre';
                                    $btn_clase = 'btn-success disabled'; // O cualquier clase que te guste para disponible
                                    break;
                                case 1: // OCUPADA
                                    $clase_estado = 'mesa-ocupada';
                                    $texto_btn = 'Servir mesa';
                                    $btn_clase = 'btn-danger'; // O cualquier clase que te guste para ocupada
                                    break;
                            }

                        // INICIO DEL ELEMENTO HTML DE LA MESA (DENTRO DEL WHILE)
                    ?>
                         <div class="col-12 col-sm-6 col-md-4 m-0 d-flex justify-content-center">
                                <div class="card <?php echo $clase_estado; ?>">
                                    <?php
                                    if ($estado == 0) {
                                    ?>
                                        <div class="d-flex flex-column align-items-center">
                                            <h4 class="card-title mb-4">Mesa Nº <?php echo $idmesa;?></h4>
                                            <button type="submit" class="btn btn-md <?php echo $btn_clase; ?>"><?php echo $texto_btn; ?></button>
                                    </div>
                                    <?php
                                    } else {
                                    ?>
                                    <a href="servir_pedido.php?id=' <?php echo $idmesa; ?>'" class="text-decoration-none text-center">
                                        <h4 class="card-title mb-4 text-danger">Mesa Nº <?php echo $idmesa; ?></h4>
                                        <small class="text-muted">Comensales: <?php echo $comensales;?></small><br>
                                        <button class="btn btn-md <?php echo $btn_clase; ?>">
                                            <?php echo $texto_btn; ?>
                                        </button>
                                    </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        
                    <?php

                    }
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