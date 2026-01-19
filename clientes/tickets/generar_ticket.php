<?php

include("../../seguridad.php");
proteger(0);
include("../../conexion.php");

require_once 'vendor/autoload.php';

if (isset($_SESSION['nombre'])) {
    $nombre_cliente = $_SESSION['nombre'];
}
if(isset($_SESSION['apellidos'])) {
    $apellidos_cliente = $_SESSION['apellidos'];
}

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;



    if (isset($_GET['idp'])) {

        // ========================
        // VARIABLES
        // ========================
        $idped   = $_GET['idp'];
        $mesa_id = $_SESSION['idmesa'];

        // ========================
        // CONEXIÓN IMPRESORA
        // ========================
        $ipImpresora     = "192.168.36.170";
        $puertoImpresora = 9100;

        $connector = new NetworkPrintConnector($ipImpresora, $puertoImpresora);
        $printer   = new Printer($connector);

        // ========================
        // CONFIGURACIÓN INICIAL
        // ========================
        $printer->setPrintLeftMargin(0);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);

        // ========================
        // CABECERA
        // ========================
        $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("RESTAURANTE LA DESPENSA\n");
        $printer->selectPrintMode();
        $printer->text("PEDIDO COCINA\n");
        $printer->text(str_repeat("-", 56) . "\n");

        // ========================
        // DATOS PEDIDO
        // ========================
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Pedido Nº: {$idped}\n");
        $printer->text("Mesa: {$mesa_id}\n");
        $printer->text("Cliente: {$nombre_cliente} {$apellidos_cliente}\n");
        $printer->text("Fecha: " . date('d/m/Y H:i') . "\n");
        $printer->text(str_repeat("-", 56) . "\n\n");

        // ========================
        // CABECERA TABLA
        // ========================
        $printer->text(str_repeat("=", 56) . "\n");
        $printer->text(sprintf("%-30s %6s %19s\n", "PRODUCTO", "CANTIDAD", "COMENTARIO"));
        $printer->text(str_repeat("=", 56) . "\n");

        // ========================
        // PRODUCTOS - ULTIMOS AÑADIDOS
        // ========================
        $sql_productos = "
            SELECT p.nombre, pp.comentario, pp.cant
            FROM pedido_producto pp
            INNER JOIN producto p ON pp.idprod = p.idprod
            WHERE pp.idped = $idped AND pp.servido=0
            ORDER BY pp.idline ASC
        ";



        $resultado_productos = mysqli_query($conn, $sql_productos);

        if ($resultado_productos && mysqli_num_rows($resultado_productos) > 0) {
            while ($producto = mysqli_fetch_assoc($resultado_productos)) {

                $nombre     = substr($producto['nombre'], 0, 29);
                $comentario = substr($producto['comentario'], 0, 15);
                $cantidad   = (int)$producto['cant'] ?? 1;

                // Imprimimos una línea por unidad (ideal para cocina)
                $printer->text(sprintf("%-30s %6s %19s\n", $nombre, str_pad($cantidad, 6, ' ', STR_PAD_BOTH), $comentario));
            }

            // // ========================
            // // PRODUCTOS
            // // ========================
            // if (!empty($_SESSION['carrito'])) {

            //     foreach ($_SESSION['carrito'] as $producto) {

            //         $nombre     = substr($producto['nombre'], 0, 15);
            //         $comentario = substr($producto['comentario'], 0, 15) ?? '';
            //         $cantidad   = (int)($producto['cantidad'] ?? 1);


                   // Imprimimos una línea por unidad (ideal para cocina)

            //         $printer->text(sprintf("%-25s %6s %20s\n", $nombre, str_pad($cantidad, 6, ' ', STR_PAD_BOTH), $comentario));
            //     }
        } else {
            $printer->text("NO HAY PRODUCTOS EN EL PEDIDO\n");
        }

        $printer->text(str_repeat("-", 56) . "\n\n");

        // ========================
        // PIE DEL TICKET
        // ========================
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Conservar ticket hasta\n");
        $printer->text("fin de servicio\n\n");

        // ========================
        // CORTE Y CIERRE
        // ========================
        $printer->cut();
        $printer->close();

        // ========================
        // LIMPIAR CARRITO 
        // ========================
        unset($_SESSION['carrito']);

        // Redirigimos al pedido
        header("LOCATION: ../pedidos.php?id='$idped'");
        exit();

        mysqli_close($conn);
    }

