
<?php
include("../seguridad.php");
proteger(2);
include("../conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $id = $_GET['idprod'];

    $consulta= mysqli_query($conn,"SELECT * FROM producto WHERE idprod='$id'");

    $producto=mysqli_fetch_array($consulta);    



    if ($producto['estado'] === '1') {
        $consulta = "UPDATE producto SET estado='0' WHERE idprod='$id'";
        mysqli_query($conn, $consulta);
        echo mysqli_error($conn);
        mysqli_close($conn);
        header("Location:productos.php");
        exit();
    } else if($producto['estado'] === '0') {
        $consulta = "UPDATE producto SET estado='1' WHERE idprod='$id'";
        mysqli_query($conn, $consulta);
        echo mysqli_error($conn);
        mysqli_close($conn);
        header("Location:productos.php");
        exit();
    }
}