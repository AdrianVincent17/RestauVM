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
    <title>Restaurante - Reserva Mesa</title>
    <style>
        .card {
            justify-content: center;
            align-items: center;
            width: 250px;
            height: 250px;
            border-radius: 80px;
            /* NOTA: He cambiado 'border: none;' por un borde sutil 
              para que los colores de estado destaquen más.
            */
            border: 3px solid transparent;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            transition: all 0.2s ease-in-out;
            /* <-- Añadido para un efecto suave */
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

        .mesa-disponible .btn:hover{
            transform: scale(1.03);
            background-color:  #24a167ff;
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


                <div class="row ms-5">
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

                            <div class="col-md-4">
                                <div class="card <?php echo $clase_estado; ?>">
                                    <h5 class="card-title text-primary">Mesa Nº <?php echo $nummesa; ?></h5>
                                    <p class="card-text display-4">
                                        <button class="btn <?php echo $btn_clase; ?>" data-bs-toggle="modal" data-bs-target="#modalReserva" data-mesa-id='<?php echo $nummesa; ?>'>
                                            <?php echo $texto_btn; ?>
                                        </button>
                                    </p>
                                </div>
                            </div>

                    <?php

                        }
                    } else {
                        echo "<div class='alert alert warning' role='alert'>No se encontraron mesas en la base de datos</div";
                    }
                    mysqli_close($conn);
                    ?>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="modalReservaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalReservaLabel">Reservar Mesa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="altareserva.php" method="POST">
                    <div class="modal-body">
                        <p>Estás reservando la mesa: <strong id="infoMesaSeleccionada"></strong></p>
                        <input type="hidden" id="inputMesaId" name="mesa_id">

                        <hr>
                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <label for="reservaPersonas" class="form-label fw-medium">Nº de Personas</label>
                                <input type="number" class="form-control" id="reservaPersonas" name="personas" min="1" max="12" value="2" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="reservaPeticiones" class="form-label fw-medium">Peticiones especiales</label>
                            <textarea class="form-control" id="reservaPeticiones" name="peticiones" rows="3" placeholder="Ej: Trona para bebé, alergias..."></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Confirmar Reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    include("../footer.php");
    ?>
    <script>
        // Script para pasar la info de la mesa al modal
        var modalReserva = document.getElementById('modalReserva');

        // Escucha el evento 'show.bs.modal' (cuando el modal está a punto de mostrarse)
        modalReserva.addEventListener('show.bs.modal', function(event) {

            // 'event.relatedTarget' es el botón que activó el modal
            var boton = event.relatedTarget;

            // Obtiene el 'data-mesa-id' que pusimos en el botón
            var mesaId = boton.getAttribute('data-mesa-id');

            // Coge las referencias de los elementos DENTRO del modal
            var modalTitle = modalReserva.querySelector('.modal-title');
            var modalInfoMesa = modalReserva.querySelector('#infoMesaSeleccionada');
            var inputMesaId = modalReserva.querySelector('#inputMesaId');

            // Actualiza el contenido del modal con la info de la mesa
            modalTitle.textContent = 'Reservar mesa Nº ' + mesaId;
            modalInfoMesa.textContent = mesaId;
            inputMesaId.value = mesaId; // Esto se enviará con el formulario
        });
    </script>
</body>

</html>