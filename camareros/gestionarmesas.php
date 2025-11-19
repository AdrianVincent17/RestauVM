<?php
// Se mantienen las includes originales.
include("../seguridad.php");
proteger(1);
include("../conexion.php");

// 1. Consulta Principal: Mesas y su estado.
// NOTA: La tabla `mesa` en el nuevo esquema no tiene `comensales`, por lo que lo cargaremos por separado
// si la mesa está ocupada (estado=1) consultando la tabla `reserva`.
$consultamesa = "SELECT nmesa, estado FROM mesa ORDER BY nmesa";
$mesas = mysqli_query($conn, $consultamesa);

// =========================================================================
// FUNCIÓN AUXILIAR: Obtiene el número de comensales para una mesa ocupada.
// =========================================================================
function get_comensales($conn, $mesa_id) {
    $mesa_id_segura = mysqli_real_escape_string($conn, $mesa_id);
    
    // Asumimos que la entrada más reciente o la única entrada en `reserva` para esta mesa es la actual ocupación.
    $query_comensales = "
        SELECT comensales 
        FROM reserva 
        WHERE nmesa = '$mesa_id_segura' 
        ORDER BY fecha DESC 
        LIMIT 1
    ";
    
    $result = mysqli_query($conn, $query_comensales);
    
    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row['comensales'];
    }
    return 'N/A';
}

// =========================================================================
// FUNCIÓN PRINCIPAL: Obtener datos de pedidos pendientes de la base de datos (REAL)
// Usa: pedido, pedido_producto y producto.
// =========================================================================
function get_pending_orders_info($conn, $mesa_id) {
    $mesa_id_segura = mysqli_real_escape_string($conn, $mesa_id);
    
    // Consulta JOIN para obtener los ítems pendientes (servido=0)
    $query_pedidos = "
        SELECT
            pp.idline,
            p.nombre,
            pp.cant,
            pp.comentario
        FROM
            pedido AS ped
        JOIN
            pedido_producto AS pp ON ped.idped = pp.idped
        JOIN
            producto AS p ON pp.idprod = p.idprod
        WHERE
            ped.nmesa = '$mesa_id_segura' 
            AND pp.servido = 0
        ORDER BY pp.idline ASC
    ";
    
    $result = mysqli_query($conn, $query_pedidos);
    
    $items = [];
    $count = 0;
    
    if ($result) {
        $count = mysqli_num_rows($result);
        while ($row = mysqli_fetch_assoc($result)) {
            // Almacenamos el ID de línea, nombre, cantidad y comentario
            $items[] = [
                'id' => $row['idline'], 
                'name' => $row['nombre'], 
                'qty' => $row['cant'], 
                'comment' => $row['comentario']
            ];
        }
    }
    
    if (!$result) {
        error_log("Error de consulta de pedidos para mesa $mesa_id: " . mysqli_error($conn));
    }
    
    return ['count' => $count, 'items' => $items];
}

// -------------------------------------------------------------------------
// PASO 2: Pre-cargar TODOS los pedidos pendientes en un array PHP para inyectar en JS
// -------------------------------------------------------------------------
$all_pending_orders = [];

if ($mesas && mysqli_num_rows($mesas) > 0) {
    mysqli_data_seek($mesas, 0); // Aseguramos que el puntero esté al inicio
    while ($temp_mesa = mysqli_fetch_assoc($mesas)) {
        if ($temp_mesa['estado'] == 1) { // Solo si está ocupada
            $pedidos_info = get_pending_orders_info($conn, $temp_mesa['nmesa']);
            // Almacenamos el array de objetos [idline, name, qty, comment]
            $all_pending_orders[$temp_mesa['nmesa']] = $pedidos_info['items'];
        }
    }
    mysqli_data_seek($mesas, 0); // Reiniciamos el puntero para el bucle de renderizado HTML
}

?>
<!doctype html>
<html lang="es">

<head>
    <?php
    include("../head.php"); // Asumimos que aquí se carga Bootstrap 5
    ?>
    <title>Restaurante - Gestión de Mesas Camarero</title>
    
    <!-- Iconos Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* Estilos generales del contenedor */
        body {
            background-color: #f7f9fc;
        }
        .card-container {
            padding: 30px 0;
        }

        /* Estilo base de la tarjeta (Mesa) - Forma Circular */
        .card {
            width: 100%; 
            max-width: 200px;
            padding: 20px 10px;
            aspect-ratio: 1 / 1; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin: auto;
            
            /* Círculo */
            border-radius: 50%; 
            border: 4px solid transparent; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); 
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Icono de la mesa */
        .table-icon {
            font-size: 3.5rem; 
            margin-bottom: 0.5rem;
        }
        
        .card-title {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 0.5rem !important;
        }
        
        .card .btn {
            font-weight: 600;
            margin-top: 10px;
            padding: .5rem 1.25rem;
            border-radius: 50px;
            z-index: 10;
        }
        
        /* ESTADO: DISPONIBLE (Reserva) */
        .mesa-disponible {
            background-color: #e8f5e9;
            border-color: #4CAF50; 
            cursor: pointer; 
        }

        .mesa-disponible .table-icon,
        .mesa-disponible .card-title {
            color: #388E3C;
        }

        .mesa-disponible:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(76, 175, 80, 0.5);
            background-color: #f1f8e9;
        }

        /* ESTADO: OCUPADA (Gestión de Pedido) */
        .mesa-ocupada {
            background-color: #ffebee; 
            border-color: #D32F2F; 
            opacity: 1; 
            cursor: pointer; 
        }

        .mesa-ocupada .table-icon,
        .mesa-ocupada .card-title {
            color: #D32F2F;
        }
        
        .mesa-ocupada:hover {
             transform: scale(1.05);
             box-shadow: 0 10px 25px rgba(211, 47, 47, 0.5);
        }
        
        /* Contador de pedidos pendientes */
        .pending-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            padding: .35em .65em;
            border-radius: 50%;
            font-size: 0.8rem;
            font-weight: bold;
            background-color: #FF9800; /* Naranja para pendiente */
            color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 10;
        }
        
        .comment-text {
            font-size: 0.85rem;
            color: #777;
            font-style: italic;
            display: block;
            margin-top: 5px;
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
                <h1 class="text-center mb-5 fw-bold text-dark">
                    <i class="bi bi-gear-fill me-2"></i> Gestión de Mesas y Pedidos (Camarero)
                </h1>

                <div class="row g-4 justify-content-center">
                    
                    <?php

                    if ($mesas && mysqli_num_rows($mesas) > 0) {
                        while ($datosmesas = mysqli_fetch_assoc($mesas)) {
                            
                            $nummesa = $datosmesas['nmesa'];
                            $estadomesa = $datosmesas['estado'];
                            
                            $clase_estado = '';
                            $icon_mesa = '';
                            $accion_contenido = '';
                            $badge_contenido = '';
                            $modal_target = ''; 
                            $pedidos_pendientes = 0;
                            $comensales = 'N/A'; // Valor por defecto

                            if ($estadomesa == 0) { // DISPONIBLE
                                $clase_estado = 'mesa-disponible';
                                $icon_mesa = 'bi-check-circle-fill';
                                $modal_target = '#modalReserva';
                                $texto_btn = 'Reservar';
                                $btn_clase = 'btn-success';
                            } else { // OCUPADA
                                $clase_estado = 'mesa-ocupada';
                                $icon_mesa = 'bi-person-fill';
                                $modal_target = '#modalPedidos';
                                $texto_btn = 'Gestionar Pedido';
                                $btn_clase = 'btn-warning text-dark'; 
                                
                                // OBTENER COMENSALES (NUEVA LÓGICA)
                                $comensales = get_comensales($conn, $nummesa);

                                // OBTENER DATOS REALES DE PENDIENTES
                                $pedidos_pendientes = count($all_pending_orders[$nummesa] ?? []);
                                
                                // Mostrar el contador si hay pedidos pendientes
                                if ($pedidos_pendientes > 0) {
                                    $badge_contenido = '<span class="pending-badge">' . $pedidos_pendientes . '</span>';
                                }
                            }
                            
                            $accion_contenido = '
                                <button class="btn btn-lg ' . $btn_clase . '" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="' . $modal_target . '" 
                                    data-mesa-id="' . $nummesa . '"
                                    data-comensales="' . $comensales . '">
                                    <i class="bi ' . ($estadomesa == 0 ? 'bi-pencil-square' : 'bi-bell-fill') . ' me-2"></i> ' . $texto_btn . '
                                </button>';
                    ?>

                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 d-flex justify-content-center">
                                <div class="card <?php echo $clase_estado; ?> position-relative">
                                    <?php echo $badge_contenido; /* Muestra el contador de pendientes */ ?>
                                    <i class="bi table-icon <?php echo $icon_mesa; ?>"></i>
                                    <h4 class="card-title mb-2">Mesa Nº <?php echo $nummesa; ?></h4>
                                    
                                    <!-- Muestra el número de comensales si está ocupada -->
                                    <?php if ($estadomesa == 1): ?>
                                        <p class="mb-0 fw-bold text-danger">Comensales: <?php echo $comensales; ?></p>
                                    <?php endif; ?>

                                    <?php echo $accion_contenido; ?>
                                    
                                </div>
                            </div>

                    <?php
                        }
                    } else {
                        echo "<div class='col-12'><div class='alert alert-warning text-center' role='alert'>No se encontraron mesas en la base de datos.</div></div>";
                    }

                    //cierre de la conexion
                    mysqli_close($conn);
                    ?>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL 1: RESERVA (Para la acción de OCUPAR) -->
    <div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="modalReservaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalReservaLabel">Reservar/Ocupar Mesa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="altareserva.php" method="POST">
                    <div class="modal-body">
                        <p class="lead">Confirmar ocupación para la mesa: <strong id="infoMesaSeleccionada" class="text-success"></strong></p>
                        <input type="hidden" id="inputMesaId" name="mesa_id">

                        <hr>
                        <div class="row g-2 mb-3">
                            <div class="col-12">
                                <label for="reservaPersonas" class="form-label fw-medium">Nº de Personas</label>
                                <input type="number" class="form-control form-control-lg" id="reservaPersonas" name="personas" min="1" max="12" value="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Confirmar Ocupación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- MODAL 2: GESTIÓN DE PEDIDO (Para la acción de OCUPADA) -->
    <div class="modal fade" id="modalPedidos" tabindex="-1" aria-labelledby="modalPedidosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalPedidosLabel">
                        <i class="bi bi-clipboard-check-fill me-2"></i> Gestión de Pedido
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <h4 class="mb-3">Mesa <strong id="pedidoMesaId" class="text-warning"></strong> | Comensales: <span id="pedidoComensales" class="badge bg-secondary"></span></h4>
                    <hr>
                    
                    <h5 class="text-danger fw-bold"><i class="bi bi-hourglass-split me-2"></i> Ítems Pendientes: <span id="pedidoCount" class="badge bg-danger">0</span></h5>
                    
                    <!-- Aquí se inyectará la lista de pedidos pendientes por JS -->
                    <ul id="listaPedidosPendientes" class="list-group list-group-flush mb-4 border rounded">
                        <!-- Items inyectados por JS -->
                    </ul>
                    
                    <div class="alert alert-info" role="alert">
                        El botón "Servir" debe ser conectado a un script PHP (ej. `servir_pedido.php`) que ejecute: `UPDATE pedido_producto SET servido = 1 WHERE idline = [ID_LINEA_PEDIDO]`.
                    </div>
                </div>

                <div class="modal-footer bg-light d-flex justify-content-between">
                    <!-- Enlace para Liberar Mesa (Opción Final) -->
                    <a id="btnLiberarMesa" href="#" class="btn btn-lg btn-danger">
                        <i class="bi bi-door-open-fill me-2"></i> Liberar Mesa (Cobrar)
                    </a>
                    
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left me-2"></i> Cerrar Gestión
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include("../footer.php");
    ?>
    <script>
        // =========================================================================
        // PASO 3: Inyectar datos REALES de la base de datos en una variable global de JavaScript
        // Contiene objetos: {id: idline, name: nombre_producto, qty: cantidad, comment: comentario}
        // =========================================================================
        const ALL_PENDING_ORDERS = JSON.parse('<?php echo json_encode($all_pending_orders, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>');
        
        // =========================================================================
        // Script para el modal de RESERVA (Disponible)
        // =========================================================================
        var modalReserva = document.getElementById('modalReserva');

        modalReserva.addEventListener('show.bs.modal', function(event) {
            var boton = event.relatedTarget;
            var mesaId = boton.getAttribute('data-mesa-id');

            var modalTitle = modalReserva.querySelector('.modal-title');
            var modalInfoMesa = modalReserva.querySelector('#infoMesaSeleccionada');
            var inputMesaId = modalReserva.querySelector('#inputMesaId');

            modalTitle.textContent = 'Reservar mesa Nº ' + mesaId;
            modalInfoMesa.textContent = mesaId;
            inputMesaId.value = mesaId;
        });
        
        // =========================================================================
        // Script para el modal de PEDIDOS (Ocupada - con datos reales)
        // =========================================================================
        var modalPedidos = document.getElementById('modalPedidos');

        modalPedidos.addEventListener('show.bs.modal', function(event) {
            var boton = event.relatedTarget;
            var mesaId = boton.getAttribute('data-mesa-id');
            var comensales = boton.getAttribute('data-comensales');
            
            // Referencias del modal
            var pedidoMesaId = modalPedidos.querySelector('#pedidoMesaId');
            var pedidoComensales = modalPedidos.querySelector('#pedidoComensales');
            var listaPedidos = modalPedidos.querySelector('#listaPedidosPendientes');
            var pedidoCount = modalPedidos.querySelector('#pedidoCount');
            var btnLiberarMesa = modalPedidos.querySelector('#btnLiberarMesa');

            // 1. Actualizar títulos
            pedidoMesaId.textContent = mesaId;
            pedidoComensales.textContent = comensales;
            
            // 2. Obtener la lista REAL de pedidos pendientes para esta mesa
            var pedidos = ALL_PENDING_ORDERS[mesaId] || [];
            
            // 3. Inyectar lista de pedidos
            listaPedidos.innerHTML = ''; // Limpiar lista anterior
            if (pedidos.length > 0) {
                pedidos.forEach(function(item) {
                    var li = document.createElement('li');
                    li.className = 'list-group-item d-flex flex-column align-items-start';
                    
                    const itemHtml = `
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-clock-history me-2 text-danger"></i> 
                                <span class="fw-bold">${item.qty}x ${item.name}</span>
                                ${item.comment ? `<span class="comment-text">(${item.comment})</span>` : ''}
                            </div>
                            <button class="btn btn-sm btn-outline-primary ms-auto" 
                                    onclick="marcarServido(this, '${item.id}')">
                                Servir
                            </button>
                        </div>
                    `;
                    li.innerHTML = itemHtml;
                    listaPedidos.appendChild(li);
                });
                
                // Actualizar el contador y el estilo del badge
                pedidoCount.textContent = pedidos.length;
                pedidoCount.classList.remove('bg-secondary');
                pedidoCount.classList.add('bg-danger');

            } else {
                var li = document.createElement('li');
                li.className = 'list-group-item text-center text-muted py-4';
                li.textContent = '¡No hay ítems pendientes de servir!';
                listaPedidos.appendChild(li);
                
                // Actualizar el contador y el estilo del badge
                pedidoCount.textContent = 0;
                pedidoCount.classList.remove('bg-danger');
                pedidoCount.classList.add('bg-secondary');
            }
            
            // 4. Configurar enlace de Liberar Mesa
            btnLiberarMesa.href = 'liberarmesa.php?nmesa=' + mesaId;
            btnLiberarMesa.onclick = function() {
                 return confirm('¿Confirmar cobro y liberar la Mesa Nº ' + mesaId + '?');
            }
        });
        
       // Función de acción de servir un ítem (usando Fetch para llamar al script PHP)
function marcarServido(button, idline) {
    
    // Deshabilitar botón para evitar clics dobles
    button.disabled = true;
    button.textContent = 'Procesando...';
    button.classList.remove('btn-outline-primary');
    button.classList.add('btn-secondary');
    
    // La URL apunta al script PHP con el idline como parámetro
    const url = `servir_pedido.php?idline=${idline}`;

    fetch(url, {
        method: 'GET' // Usamos GET ya que el script PHP espera parámetros GET
    })
    .then(response => {
        // En este caso, el script PHP hace una redirección en éxito.
        // Si no hay errores, el pedido fue marcado en la DB.
        
        // 1. Éxito: Marcar visualmente como Servido (temporalmente)
        button.textContent = 'Servido';
        button.classList.remove('btn-secondary');
        button.classList.add('btn-success');
        
        // 2. Retraso y remoción
        setTimeout(() => {
            var li = button.closest('li');
            if (li) {
                li.remove();
                
                // 3. Actualizar contador visualmente
                var listaPedidos = document.getElementById('listaPedidosPendientes');
                var itemsRestantes = listaPedidos.querySelectorAll('.d-flex.flex-column').length;
                var pedidoCountElement = document.getElementById('pedidoCount');

                pedidoCountElement.textContent = itemsRestantes;

                if (itemsRestantes === 0) {
                    pedidoCountElement.classList.remove('bg-danger');
                    pedidoCountElement.classList.add('bg-secondary');
                    
                    var liEmpty = document.createElement('li');
                    liEmpty.className = 'list-group-item text-center text-muted py-4';
                    liEmpty.textContent = '¡No hay ítems pendientes de servir!';
                    listaPedidos.appendChild(liEmpty);
                }
            }
        }, 500);
        
    })
    .catch(error => {
        console.error('Error al intentar servir el pedido:', error);
        
        // Revertir el estado del botón en caso de fallo
        button.disabled = false;
        button.textContent = 'Servir (Error)';
        button.classList.remove('btn-secondary');
        button.classList.add('btn-outline-danger'); 
    });
}

// **Nota Importante:**

// Si utilizas el script `servir_pedido.php` tal cual, el código PHP **redirigirá** al usuario a `gestion_mesas_camarero.php` al finalizar, lo cual cerrará el modal de gestión.

// Si quieres mantener el modal abierto (como sugiere el JavaScript con `fetch`), deberías:

// 1.  Asegurarte de que el script `servir_pedido.php` no haga ninguna redirección (`header("Location:...")`).
// 2.  En su lugar, que el script `servir_pedido.php` responda con un simple `echo "OK";` o un JSON para que `fetch` reciba una respuesta exitosa.

// He mantenido la versión con redirección en el archivo `servir_pedido.php` para que sea un script PHP autocontenido, pero ten en cuenta este detalle si quieres una experiencia de usuario más fluida con el modal abierto.
    </script>
</body>

</html>