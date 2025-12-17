<?php

session_start();
include("../../conexion.php");



require_once 'vendor/autoload.php';


use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\EscposImage;


try {

    if (isset($_GET['idp'])) {
        // Variables
        $idped = $_GET['idp'];
        $mesa_id = $_SESSION['idmesa'];
        
     
        // Configurar impresora - Usar conexión de red
        $ipImpresora = "192.168.36.170";  // Cambiar a la IP de tu impresora
        $puertoImpresora = 9100;         // Puerto por defecto para impresoras ESC/POS
        $connector = new NetworkPrintConnector($ipImpresora, $puertoImpresora);
        $printer = new Printer($connector);

        // Configuración inicial de la impresora
        $printer->setPrintLeftMargin(0);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);

        // Generar número de factura (año + mes + día + hora + minutos)
        //$num_factura = date('YmdHi');

        // Cabecera del ticket
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer->text("RESTAURANTE LA DESPENSA\n");
        $printer->selectPrintMode();
        $printer->text("PEDIDO COCINA\n");
        $printer->text(str_repeat("-", 35) . "\n");

        // Información de la factura
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Pedido Nº: " . $idped . "\n");
        $printer->text("Mesa: " . $mesa_id . " \n");
        $printer->text("Fecha: " . date('d/m/Y H:i') . "\n");
        $printer->text(str_repeat("-", 42) . "\n\n");

        // Cabecera de la tabla
        $printer->text(str_repeat("=", 42) . "\n");
        $printer->text(sprintf("%-20s %-20s\n", "PRODUCTO", "COMENTARIO"));
        $printer->text(str_repeat("=", 42) . "\n");

        // Recorremos carrito
        foreach ($_SESSION['carrito'] as $producto) {
            $printer->text(sprintf("%-20s %-20s\n", $producto['nombre'], $producto['comentario']));
        }
        $printer->text(str_repeat("-", 42) . "\n\n");

        // Cierro conexión
        mysqli_close($conn);

        // Pie del ticket
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("\n");
        $printer->text("\n");
        $printer->text("Conservar ticket hasta\n");
        $printer->text("fin de servicio\n");
        $printer->text("\n\n");

        // Cortar ticket
        $printer->cut();
        $printer->close();

        // Limpiamos el carrito
        unset($_SESSION['carrito']);

        // Redirigimos al pedido
        // header("LOCATION: ../pedidos.php?id='$idped'");
        // exit();
    }
} catch (Exception $e) {
    echo "Error al imprimir ticket: " . $e->getMessage();
}
