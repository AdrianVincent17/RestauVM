<?php

session_start();
include("../../conexion.php");

require_once 'vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

try {

    if (isset($_GET['idp'])) {

        // ========================
        // VARIABLES
        // ========================
        $idped   = $_GET['idp'];
        $mesa_id = $_SESSION['idmesa'] ?? '---';

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
        $printer->text("RESTAURANTE LA DESPENSA\n");
        $printer->selectPrintMode();
        $printer->text("PEDIDO COCINA\n");
        $printer->text(str_repeat("-", 35) . "\n");

        // ========================
        // DATOS PEDIDO
        // ========================
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Pedido Nº: {$idped}\n");
        $printer->text("Mesa: {$mesa_id}\n");
        $printer->text("Fecha: " . date('d/m/Y H:i') . "\n");
        $printer->text(str_repeat("-", 42) . "\n\n");

        // ========================
        // CABECERA TABLA
        // ========================
        $printer->text(str_repeat("=", 42) . "\n");
        $printer->text(sprintf("%-20s %-20s\n", "PRODUCTO", "COMENTARIO"));
        $printer->text(str_repeat("=", 42) . "\n");

         // ========================
        // PRODUCTOS - ULTIMOS AÑADIDOS
        // ========================
        $sql_productos = "
            SELECT p.nombre, pp.comentario, pp.cant
            FROM pedido_producto pp
            INNER JOIN producto p ON pp.idprod = p.idprod
            WHERE pp.idped = $idped
            ORDER BY pp.idline DESC
        ";
        $resultado_productos = mysqli_query($conn, $sql_productos);

        if ($resultado_productos && mysqli_num_rows($resultado_productos) > 0) {
            while ($producto = mysqli_fetch_assoc($resultado_productos)) {
                
                $nombre     = substr($producto['nombre'], 0, 15);
                $comentario = substr($producto['comentario'], 0, 15);
                $cantidad   = (int)$producto['cant'];

                // Cada unidad se imprime individualmente (opcional)
                for ($i = 0; $i < $cantidad; $i++) {
                    $printer->text(sprintf("%-20s %-20s\n", $nombre, $comentario));
                }
            }

        // // ========================
        // // PRODUCTOS
        // // ========================
        // if (!empty($_SESSION['carrito'])) {

        //     foreach ($_SESSION['carrito'] as $producto) {

        //         $nombre     = $producto['nombre'] ?? '';
        //         $comentario = $producto['comentario'] ?? '';
        //         $cantidad   = (int)($producto['cantidad'] ?? 1);

        //         // Imprimimos una línea por unidad (ideal para cocina)
        //         for ($i = 0; $i < $cantidad; $i++) {
        //             $printer->text(sprintf(
        //                 "%-20s %-20s\n",
        //                 $nombre,
        //                 $comentario
        //             ));
        //         }
        //     }

        } else {
            $printer->text("NO HAY PRODUCTOS EN EL PEDIDO\n");
        }

        $printer->text(str_repeat("-", 42) . "\n\n");

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

        mysqli_close($conn);
    }

} catch (Exception $e) {
    echo "Error al imprimir ticket: " . $e->getMessage();
}
