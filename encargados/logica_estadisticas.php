<?php
include("../seguridad.php");
proteger(2);
include("../conexion.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Datos que vienen del post

    $fechainicial = $_POST['fechainicial'];
    $fechafinal = $_POST['fechafinal'];
    $comprobar_fecha = 0;

    $estadisticas = [];

    // Consulta pedidos pagados en rango fechas
    $consulta_pedidos = "SELECT idped, fecha
                        FROM pedido 
                        WHERE estado=1 AND fecha BETWEEN '$fechainicial 00:00:00' AND '$fechafinal 23:59:59' ORDER BY fecha";
    $result_pedidos = mysqli_query($conn, $consulta_pedidos);


    if ($result_pedidos && mysqli_num_rows($result_pedidos) > 0) {
        while ($row1 = mysqli_fetch_assoc($result_pedidos)) {
            $idped = $row1['idped'];
            $fecha = substr($row1['fecha'], 0, 10);  //Obtenemos solo el dia 

            if ($comprobar_fecha != $fecha) {  // esta comprobacion hace que no se repitan fechas de un mismo dia
                $comprobar_fecha = $fecha;      // de manera que si es diferente entonces asigna la fecha y asi obtenemos siempre una diferente

                //sacamos el numero total de comensales
                $comensales = "SELECT SUM(comensales) AS totcomen
                            FROM reserva 
                            WHERE DATE(fecha) = '$fecha' AND estado=1";
                $res_comen = mysqli_query($conn, $comensales);
                $fila3 = mysqli_fetch_assoc($res_comen);
                $comensales = $fila3['totcomen'];

                // ingresos 
                $ingresos = "SELECT SUM(p.precio*pp.cant) AS total_ingresos
                                FROM pedido ped, pedido_producto pp, producto p
                                WHERE ped.idped = pp.idped
                                AND pp.idprod = p.idprod
                                AND ped.estado = 1
                                AND DATE(ped.fecha) = '$fecha'";
                $res_ingre = mysqli_query($conn, $ingresos);
                $fila2 = mysqli_fetch_assoc($res_ingre);
                $ingresos = $fila2['total_ingresos'];


                

                // Datos en el array de estadisticas
                $estadisticas[] = [
                    'fecha' => $fecha, //fecha del pedido
                    'ingresos' => $ingresos, //ingreso del pedido
                    'comensales' => $comensales, //comensales de la reserva
                ];
            }
        }
    } else {
        $_SESSION['error'] = true;
        header('Location: estadisticas.php');
        exit();
    }


    // Guardar datos y fechas en sesión para mostrar en pagina estadisticas.php
    $_SESSION['estadisticas'] = $estadisticas;
    $_SESSION['fechainicial'] = $fechainicial;
    $_SESSION['fechafinal'] = $fechafinal;
}


// Redirigir de vuelta a la página de estadisticass
header('Location: estadisticas.php');
exit();