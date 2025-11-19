<?php
session_start();
require_once('vendor/autoload.php');
include("../conexion.php");

if (isset($_GET['idped'])) {
    $idped = $_GET['idped'];
    $dni_cliente = $_SESSION['dni'];
    $total_pedido = 0;

    $consultausuario="SELECT * FROM usuario WHERE dni='$dni'";
    $resultadousuario=mysqli_query($conn,$consultausuario);
    $rowuser=mysqli_fetch_assoc($resultadousuario);

    $nombreusuario=$rowuser['nombre'];
    $apellidosusuario=$rowuser['apellidos'];
    
}

$mpdf = new \Mpdf\Mpdf([]);

$html = "
<h4>Titulo principal</h4>
<p align='center'><b>Titulo del documento<b></p>
<hr>
<table border=none>
    <th>
        <tr>
            <td>Encabezado 1</td>
            <td>Encabezado 2</td>
        </tr>
    </th>
    <tbody>
    <tr>
        <td>contenido 1</td>
        <td>contenido 2</td>
    </tr>
    </tbody>
</table>
";
$mpdf->writeHtml($html);
$mpdf->Output();
