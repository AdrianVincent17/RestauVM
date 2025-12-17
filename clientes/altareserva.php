<?php


include("../seguridad.php");
proteger(0); // Asegura que solo usuarios autorizados pueden acceder
include("../conexion.php");

// Comprueba que los datos llegaron por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idmesa = (int)$_POST['idmesa']; //numero de la mesa de la reserva
    $comensales = (int)$_POST['personas']; //numero de comensales
    $dni_cliente = $_SESSION['dni']; //dni del usuario que hace la reserva
    
    // Buscamos si el cliente (usuario) ya tiene un pedido en estado 0 (Abierto/Pendiente)
    $consulta_verificar_pedido = "SELECT idped FROM pedido WHERE usuario = '$dni_cliente' AND estado = 0 ";
    $resultado_verificar = mysqli_query($conn, $consulta_verificar_pedido);
    
    // Si encontramos alguna fila, el cliente ya tiene un pedido activo (reserva pendiente)
    if (mysqli_num_rows($resultado_verificar) > 0) {
        
        // El cliente ya tiene una reserva/pedido activo redirigimos
        mysqli_close($conn);
        header('Location:pedidos.php'); 
        exit();
    }

     // Cambiamos estado de la mesa a ocupada
    $consulta_mesa = "UPDATE mesa SET estado=1 WHERE nmesa=$idmesa";
    mysqli_query($conn, $consulta_mesa);

    // Realizamos la reserva
    $consulta_reserva = "INSERT INTO reserva (dni, nmesa, comensales) VALUES ('$dni_cliente','$idmesa','$comensales')";
    mysqli_query($conn, $consulta_reserva);

    // Insertamos los datos del pedido
    $insertar_pedido = "INSERT INTO pedido (usuario, nmesa, estado) VALUES ('$dni_cliente','$idmesa',0)";
    $result = mysqli_query($conn, $insertar_pedido);

    // Guardamos el nº de mesa y los comensales en la sesión del cliente
    $_SESSION['idmesa'] = $idmesa;
    $_SESSION['comensales'] = $comensales;

    // obtenemos el idpedido y lo guardamos en la session
    $con_idpedido = "SELECT * FROM pedido WHERE usuario='$dni_cliente' AND estado='0'";
    $result = mysqli_query($conn, $con_idpedido);
    $row = mysqli_fetch_array($result);
    $_SESSION['idped'] = $row['idped'];

    // Cerramos la conexión
    mysqli_close($conn);

    // Redireccionamos a la carta
    header('Location:pedidos.php');
    exit();
} else {

    // Si alguien intenta acceder directamente a la página, lo redirigimos
    header("Location:mesas.php");
    exit();
}

?>
