<?php

include("../seguridad.php");
proteger(1);
include("../conexion.php");

// 1. Consulta Principal: Mesas Ocupadas (estado = 1).
$consultamesa = "SELECT nmesa, estado FROM mesa WHERE estado = 1 ORDER BY nmesa";
$mesas = mysqli_query($conn, $consultamesa);

// =========================================================================
// FUNCIÓN AUXILIAR: Obtiene el número de comensales.
// =========================================================================
function get_comensales($conn, $mesa_id) {
    $mesa_id_segura = mysqli_real_escape_string($conn, $mesa_id);
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
// FUNCIÓN: Obtener datos de pedidos pendientes de la base de datos (servido=0)
// =========================================================================
function get_pending_orders_info($conn, $mesa_id) {
    $mesa_id_segura = mysqli_real_escape_string($conn, $mesa_id);
    
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
            $items[] = [
                'id' => $row['idline'], 
                'name' => $row['nombre'], 
                'qty' => $row['cant'], 
                'comment' => $row['comentario']
            ];
        }
    }
    return ['count' => $count, 'items' => $items];
}

// -------------------------------------------------------------------------
// PASO 2: Pre-cargar TODOS los pedidos pendientes en un array PHP para inyectar en JS
// -------------------------------------------------------------------------
$all_pending_orders = [];
$all_pending_idlines = []; // CSV para el envío masivo

if ($mesas && mysqli_num_rows($mesas) > 0) {
    mysqli_data_seek($mesas, 0); // Aseguramos que el puntero esté al inicio
    while ($temp_mesa = mysqli_fetch_assoc($mesas)) {
        $mesa_id = $temp_mesa['nmesa'];
        
        // Obtener pedidos pendientes solo para la lógica de visualización y el modal de servir
        $pedidos_info = get_pending_orders_info($conn, $mesa_id);
        
        // Almacenamos el array de objetos [idline, name, qty, comment]
        $all_pending_orders[$mesa_id] = $pedidos_info['items'];
        
        // Recopilar todos los ID de línea pendientes para un envío masivo
        $idlines_mesa = array_column($pedidos_info['items'], 'id');
        $all_pending_idlines[$mesa_id] = implode(',', $idlines_mesa); 
    }
    mysqli_data_seek($mesas, 0); // Reiniciamos el puntero para el bucle de renderizado HTML
}

?>
<!doctype html>
<html lang="es">

<head>
    <?php
    include("../head.php");
    ?>
    <title>Restaurante - Gestión de Mesas Ocupadas</title>

    
    <style>
       
        .card-container {
            padding: 20px;
        }
        .card {
            width: 100%; max-width: 350; padding: 20px; border-width: 3px; border-radius: 25%;
            text-align: center; transition: transform 0.3s, box-shadow 0.3s;
        }
        .table-icon {
            font-size: 4rem; margin-bottom: 15px;
        }
        .card-title {
            font-size: 1.5rem; margin-bottom: 10px;
        }
        .card button {
            margin-top: 15px; width: 100%;
        }
        /* ESTADO: Ocupada - Sin Pedidos Pendientes (Cobro directo) */
        .mesa-lista-cobro {
            background-color: #ffebee; 
            border-color: #0d6efd; /* Azul: Listo para irse/Cobrar */
        }
        .mesa-lista-cobro .table-icon, .mesa-lista-cobro .card-title { color: #0d6efd; }
        .mesa-lista-cobro:hover { transform: scale(1.05); box-shadow: 0 10px 25px rgba(13, 110, 253, 0.5); }

        /* ESTADO: Ocupada - CON Pedidos Pendientes (Servir) */
        .mesa-pendiente-servir {
            background-color: #fff3e0; /* Naranja Claro */
            border-color: #dc3545; /* Rojo: Urgente */
        }
        .mesa-pendiente-servir .table-icon, .mesa-pendiente-servir .card-title { color: #dc3545; }
        .mesa-pendiente-servir:hover { transform: scale(1.05); box-shadow: 0 10px 25px rgba(220, 53, 69, 0.5); }
        
        /* Contador de pedidos pendientes */
        .pending-badge {
            position: absolute; top: 5px; right: 5px; padding: .35em .65em; border-radius: 50%;
            font-size: 0.8rem; font-weight: bold; background-color: #dc3545; color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10;
        }
        
        .comment-text { font-size: 0.85rem; color: #777; font-style: italic; display: block; margin-top: 5px; }
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
                    <i class="bi bi-gear-fill me-2"></i> Gestión de Mesas Ocupadas
                </h1>
                
                <div class="alert alert-info text-center" role="alert">
                    Mesas con pedidos pendientes tienen botón **Servir**. Mesas sin pendientes tienen botón **Cobrar**.
                </div>

                <div class="row g-4 justify-content-center">
                    
                    <?php
                    if ($mesas && mysqli_num_rows($mesas) > 0) {
                        mysqli_data_seek($mesas, 0); // Aseguramos el puntero al inicio
                        while ($datosmesas = mysqli_fetch_assoc($mesas)) {
                            
                            $nummesa = $datosmesas['nmesa'];
                            $comensales = get_comensales($conn, $nummesa);
                            $pedidos_pendientes = count($all_pending_orders[$nummesa] ?? []);

                            $clase_estado = '';
                            $icon_mesa = '';
                            $texto_btn = '';
                            $btn_clase = '';
                            $modal_target = '';
                            $badge_contenido = '';
                            
                            if ($pedidos_pendientes > 0) {
                                // ----------------------------------------------------
                                // OPCIÓN A: HAY PEDIDOS PENDIENTES DE SERVIR
                                // ----------------------------------------------------
                                $clase_estado = 'mesa-pendiente-servir';
                                $icon_mesa = 'bi-exclamation-triangle-fill';
                                $modal_target = '#modalServir';
                                $texto_btn = 'Servir Pedidos';
                                $btn_clase = 'btn-danger';
                                $badge_contenido = '<span class="pending-badge">' . $pedidos_pendientes . '</span>';
                                
                                $accion_contenido = '
                                    <button class="btn btn-lg ' . $btn_clase . '" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="' . $modal_target . '" 
                                        data-mesa-id="' . $nummesa . '"
                                        data-comensales="' . $comensales . '"
                                        data-idlines="' . ($all_pending_idlines[$nummesa] ?? '') . '">
                                        <i class="bi bi-bell-fill me-2"></i> ' . $texto_btn . '
                                    </button>';
                                
                            } else {
                                // ----------------------------------------------------
                                // OPCIÓN B: NO HAY PEDIDOS PENDIENTES (Listo para Cobrar)
                                // ----------------------------------------------------
                                $clase_estado = 'mesa-lista-cobro';
                                $icon_mesa = 'bi-cash-coin';
                                $modal_target = '#modalLiberarCobrar';
                                $texto_btn = 'Cobrar y Liberar';
                                $btn_clase = 'btn-primary';
                                
                                $accion_contenido = '
                                    <button class="btn btn-md ' . $btn_clase . '" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="' . $modal_target . '" 
                                        data-mesa-id="' . $nummesa . '"
                                        data-comensales="' . $comensales . '">
                                        <i class="bi bi-wallet-fill me-2"></i> ' . $texto_btn . '
                                    </button>';
                            }
                    ?>

                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 d-flex justify-content-center">
                                <div class="card <?php echo $clase_estado; ?> position-relative">
                                    <?php echo $badge_contenido; ?>
                                    <i class="bi table-icon <?php echo $icon_mesa; ?>"></i>
                                    <h4 class="card-title mb-2">Mesa Nº <?php echo $nummesa; ?></h4>
                                    
                                    <p class="mb-0 fw-bold text-dark">Comensales: <?php echo $comensales; ?></p>

                                    <?php echo $accion_contenido; ?>
                                </div>
                            </div>

                    <?php
                        }
                    } else {
                        echo "<div class='col-12'><div class='alert alert-success text-center' role='alert'>🥳 **¡Genial!** No hay mesas ocupadas.</div></div>";
                    }

                    mysqli_close($conn);
                    ?>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalServir" tabindex="-1" aria-labelledby="modalServirLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalServirLabel">
                        <i class="bi bi-box-seam-fill me-2"></i> Confirmar Servicio de Pedidos
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form id="formServirTodo" action="servir_todo.php" method="POST">
                    <input type="hidden" id="inputServirMesaId" name="mesa_id">
                    <input type="hidden" id="inputServirIdLines" name="id_lines_csv">

                    <div class="modal-body">
                        <h4 class="mb-3">
                            Mesa <strong id="servirMesaId" class="text-danger"></strong> | 
                            Comensales: <span id="servirComensales" class="badge bg-secondary"></span>
                        </h4>
                        <hr>
                        
                        <h5 class="fw-bold"><i class="bi bi-list-ol me-2"></i> Ítems Pendientes a Servir: <span id="servirCount" class="badge bg-danger">0</span></h5>
                        
                        <ul id="listaPedidosServir" class="list-group list-group-flush mb-4 border rounded">
                            </ul>
                    </div>

                    <div class="modal-footer bg-light d-flex justify-content-between">
                        <button type="submit" class="btn btn-lg btn-danger">
                            <i class="bi bi-check2-all me-2"></i> Servir todo
                        </button>
                        
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-arrow-left me-2"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLiberarCobrar" tabindex="-1" aria-labelledby="modalLiberarCobrarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalLiberarCobrarLabel">
                        <i class="bi bi-cash-coin me-2"></i> Cobrar Mesa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="lead text-dark">¿Deseas confirmar el **cobro** y liberar la Mesa: <strong id="liberarMesaId" class="text-primary"></strong>?</p>
                    <p class="text-muted">Comensales: <span id="liberarComensales" class="badge bg-secondary"></span></p>
                    
                    <div class="alert alert-warning mt-3" role="alert">
                        Asegúrate de que todos los pedidos han sido entregados y cobrados antes de liberar la mesa.
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Cancelar
                    </button>
                    <a id="btnConfirmarLiberacion" href="#" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle me-2"></i>Confirmar Cobro y Liberar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php
    include("../footer.php");
    ?>
    <script>
        // =========================================================================
        // PASO 3: Inyectar datos REALES de la base de datos en variables globales de JavaScript
        // =========================================================================
        const ALL_PENDING_ORDERS = JSON.parse('<?php echo json_encode($all_pending_orders, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>');
        const ALL_PENDING_IDLINES = JSON.parse('<?php echo json_encode($all_pending_idlines, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>');
        
        // =========================================================================
        // Script para el modal de SERVIR PEDIDOS (Envío masivo)
        // =========================================================================
        var modalServir = document.getElementById('modalServir');

        modalServir.addEventListener('show.bs.modal', function(event) {
            var boton = event.relatedTarget;
            var mesaId = boton.getAttribute('data-mesa-id');
            var comensales = boton.getAttribute('data-comensales');
            var idlines = boton.getAttribute('data-idlines'); // CSV de idline

            // Referencias del modal
            var servirMesaId = modalServir.querySelector('#servirMesaId');
            var servirComensales = modalServir.querySelector('#servirComensales');
            var listaPedidos = modalServir.querySelector('#listaPedidosServir');
            var servirCount = modalServir.querySelector('#servirCount');
            var inputMesaId = modalServir.querySelector('#inputServirMesaId');
            var inputIdLines = modalServir.querySelector('#inputServirIdLines');

            // 1. Actualizar títulos e inputs ocultos para el formulario
            servirMesaId.textContent = mesaId;
            servirComensales.textContent = comensales;
            inputMesaId.value = mesaId;
            inputIdLines.value = idlines; 
            
            // 2. Obtener la lista REAL de pedidos pendientes para esta mesa
            var pedidos = ALL_PENDING_ORDERS[mesaId] || [];
            
            // 3. Inyectar lista de pedidos (solo visualización)
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
                            <span class="badge bg-danger">Pendiente</span>
                        </div>
                    `;
                    li.innerHTML = itemHtml;
                    listaPedidos.appendChild(li);
                });
                
                // Actualizar el contador visual
                servirCount.textContent = pedidos.length;
            } else {
                var li = document.createElement('li');
                li.className = 'list-group-item text-center text-muted py-4';
                li.textContent = '¡No hay ítems pendientes de servir!';
                listaPedidos.appendChild(li);
                servirCount.textContent = 0;
            }
        });
        
        // =========================================================================
        // Script para el modal de LIBERAR MESA Y COBRAR
        // =========================================================================
        var modalLiberarCobrar = document.getElementById('modalLiberarCobrar');

        modalLiberarCobrar.addEventListener('show.bs.modal', function(event) {
            var boton = event.relatedTarget;
            var mesaId = boton.getAttribute('data-mesa-id');
            var comensales = boton.getAttribute('data-comensales');
            
            // Referencias del modal
            var liberarMesaId = modalLiberarCobrar.querySelector('#liberarMesaId');
            var liberarComensales = modalLiberarCobrar.querySelector('#liberarComensales');
            var btnConfirmarLiberacion = modalLiberarCobrar.querySelector('#btnConfirmarLiberacion');

            // 1. Actualizar títulos
            liberarMesaId.textContent = mesaId;
            liberarComensales.textContent = comensales;
            
            // 2. Configurar enlace de Liberar Mesa
            btnConfirmarLiberacion.href = 'liberarmesa.php?nmesa=' + mesaId;
            btnConfirmarLiberacion.onclick = function() {
                // Aquí podrías añadir una comprobación de que no queden pendientes
                return confirm('¿Seguro que deseas COBRAR y LIBERAR la Mesa Nº ' + mesaId + '?');
            }
        });
        
    </script>
</body>

</html>