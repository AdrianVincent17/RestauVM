<?php
require_once 'vendor/autoload.php';
include("../../seguridad.php");
proteger(1);
include("../../conexion.php");

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\EscposImage;


try {

    if (isset($_GET['idp'])) {
        
        // Variables
        $idped = $_GET['idp'];
        $mesa_id = $_GET['idm'];
        $precio_final = 0;


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
        $printer->text("Ctra. de la huerta, 27 - Molina de Segura\n");
        $printer->text("Tel: 685974685\n");
        $printer->text("CIF: C25647899\n");
        $printer->text(str_repeat("-", 35) . "\n");

        // Información de la factura
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Factura Nº: " . $idped . "\n");
        $printer->text("Mesa: " . $mesa_id . " \n");
        $printer->text("Fecha: " . date('d/m/Y H:i') . "\n");
        $printer->text(str_repeat("-", 35) . "\n\n");

        // Cabecera de la tabla
        $printer->text(str_repeat("=", 35) . "\n");
        $printer->text(sprintf("%-20s %3s %10s\n", "PRODUCTO", "UDS", "IMPORTE"));
        $printer->text(str_repeat("=", 35) . "\n");

        // Consulta pedido
        $consulta_pedido = "SELECT 
                            p.nombre,
                            SUM(pp.cant) AS cantidad,
                            p.precio,
                            SUM(pp.cant * p.precio) AS total
                        FROM pedido_producto pp, producto p
                        WHERE pp.idprod = p.idprod
                        AND pp.idped = '$idped'
                        GROUP BY p.nombre, p.precio";
        $result = mysqli_query($conn, $consulta_pedido);
        while ($row = mysqli_fetch_array($result)) {

            //asignamos un corte en el nombre del producto para poder tener una buena legibilidad en el ticket
            $nombre=substr($row['nombre'],0,17);
            
            $printer->text(sprintf("%-20s %3s %10s\n", $nombre, $row['cantidad'], number_format($row['total'], 2)));

            $precio_final += $row['total'];
        }

        // Cierro conexión
        mysqli_close($conn);

        // Calculamos iva y precio sin iva
        $sinIVA = $precio_final / 100 * 79;
        $iva = $precio_final - $sinIVA;

        // Totales
        $printer->text(str_repeat("-", 35) . "\n");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text(sprintf("Base Imponible: %10.2f EUR\n", $sinIVA));
        $printer->text(sprintf("IVA (21%%): %15.2f EUR\n", $iva));
        $printer->text(str_repeat("=", 35) . "\n");
        $printer->setEmphasis(true);
        $printer->text(sprintf("TOTAL: %18.2f EUR\n", $precio_final));
        $printer->setEmphasis(false);

        // Pie del ticket
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("\n");
        $printer->text("¡Gracias por su visita!\n");
        $printer->text("www.RestauranteLaDespensa.com\n");
        $printer->text("\n");
        $printer->text("Conserve esta factura\n");
        $printer->text("para cualquier reclamación\n");
        $printer->text("\n\n");

        // Cortar ticket
        $printer->cut();
        $printer->close();

        header("LOCATION: ../gestionarmesas.php");
        exit();
    }
} catch (Exception $e) {
    echo "Error al imprimir ticket: " . $e->getMessage();
}
