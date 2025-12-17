<?php
include("../../seguridad.php");
proteger(0);

// Cargamos la librería mPDF
require_once('vendor/autoload.php');
$mpdf = new \Mpdf\Mpdf([
    'use_image_persistance' => true
]);
$mpdf->SetTitle('Restaurante La Despensa - Factura');

// Conectamos a la base de datos
include("../../conexion.php");

// Verificamos que llegue el ID del pedido
if (isset($_GET['id'])) {
    $idped = $_GET['id'];
}

$dni = $_SESSION['dni'];
$precio_final = 0;

// ===== CONSULTA 1: Fecha del pedido =====
$consulta_fecha = "SELECT * FROM pedido WHERE idped = $idped";
$result1 = mysqli_query($conn, $consulta_fecha);

if (!$result1) {
    die("Error en consulta de pedido: " . mysqli_error($conn));
}

$row1 = mysqli_fetch_array($result1);

if (!$row1) {
    die("No se encontró el pedido con ID: " . $idped);
}

$fecha = $row1['fecha'];

// ===== CONSULTA 2: Datos del cliente =====
$consulta_cliente = "SELECT * FROM usuario WHERE dni = '$dni'";
$result3 = mysqli_query($conn, $consulta_cliente);

if (!$result3) {
    die("Error en consulta de usuario: " . mysqli_error($conn));
}

$row3 = mysqli_fetch_array($result3);

if (!$row3) {
    die("No se encontró el usuario con DNI: " . $dni);
}

$nombre = $row3['nombre'];
$apellidos = $row3['apellidos'];

// URL base para las imágenes
$url_base = 'http://localhost/restauVM/';

// ===== ESTRUCTURA HTML DEL TICKET =====
$html = "

    <style>
        body {
            
            background-image: url('../../img/fondopdf.jpg');
           
            font-family: Arial, sans-serif;
        }
    </style>
    <p align='center'><img src='" . $url_base . "img/logopdf.png' alt='Logo' width='70px'></p>
    <h1 align='center'>RESTAURANTE LA DESPENSA</h1>
    <br>
    <p align='right'><b>Fecha y hora:</b> " . $fecha . "</p>
    <b>DNI:</b> " . $dni . " <br>
    <b>Nombre:</b> " . $nombre . " <br>
    <b>Apellidos:</b> " . $apellidos . " <br><br>
    <hr>
    <table border='none' cellpadding='5' cellspacing='0' width='100%'>
        <thead>
            <tr style='background: RGB(230, 255, 230,);'>
                <th style='padding-bottom: 10px; padding-top: 10px;' align='left'>Producto</th>
                <th style='padding-bottom: 10px; padding-top: 10px'>Cantidad</th>
                <th style='padding-bottom: 10px; padding-top: 10px' align='right'>Precio Unidad</th>
                <th style='padding-bottom: 10px; padding-top: 10px' align='right'>P. Total</th>
            </tr>
        </thead>
        <tbody>
    ";

$consulta_pedido = "SELECT 
                            p.nombre,
                            COUNT(*) AS cantidad,
                            p.precio,
                            COUNT(*) * p.precio AS total
                        FROM pedido_producto pp
                        INNER JOIN producto p ON pp.idprod = p.idprod
                        WHERE pp.idped = $idped
                        GROUP BY p.nombre, p.precio";

$result2 = mysqli_query($conn, $consulta_pedido);

// Si no hay productos
if (mysqli_num_rows($result2) == 0) {
    $html .= "<tr><td colspan='4' align='center'>No hay productos en este pedido</td></tr>";
} else {
    // Recorremos cada producto
    while ($row2 = mysqli_fetch_array($result2)) {
        $html .= "<tr>
                        <td style='padding-top: 10px;'>" . $row2['nombre'] . "</td>
                        <td style='padding-top: 10px;' align='center'>" . $row2['cantidad'] . "</td>
                        <td style='padding-top: 10px;' align='right'>" . number_format($row2['precio'], 2) . " €</td>
                        <td style='padding-top: 10px;' align='right'>" . number_format($row2['total'], 2) . " €</td>
                    </tr>";

        // Sumamos al precio total
        $precio_final += $row2['total'];
    }
}

// Cerramos la conexión
mysqli_close($conn);

// Cerramos la tabla y añadimos el total con el iba y el total
$html .= "
        </tbody>
    </table>
    <hr>
    <p align='right'><b>Total: " . number_format($precio_final, 2) . " €</b></p>
    <p align='right'><b>IVA(21%): " . number_format($precio_final * (0.21), 2) . " €</b></p>
    <p align='right'><b>Total: " . number_format($precio_final * 1.21, 2) . " €</b></p>
    <br>
    <p align='center'><b>¡Gracias por su visita!</b></p>
    ";

// Generamos el PDF
$mpdf->WriteHTML($html);
$mpdf->Output();
