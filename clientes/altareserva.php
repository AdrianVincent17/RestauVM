<?php
include("../seguridad.php");
proteger(0);
include("../conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Tus nombres de campos: mesa_id, dni_cliente, personas, peticiones
    $mesa_id     = $_POST['mesa_id'];
    $dni_cliente = $_SESSION['dni'];
    $comensales  = $_POST['personas'];      // El formulario envía 'personas'
    $comentarios = $_POST['peticiones'];

    // DATE(fecha_reserva) extrae solo la fecha del TIMESTAMP (ej: '2025-11-16')
    
    $comprobacionreserva = "SELECT COUNT(*) as total 
                  FROM reserva
                  WHERE dni = '$dni_cliente' AND DATE(fecha) = DATE(NOW())";

    $resultadoreserva = mysqli_query($conn, $comprobacionreserva);
    
    // Obtenemos la fila de resultado
    $row = mysqli_fetch_assoc($resultadoreserva);
    $total_reservas_hoy = (int)$row['total']; // Vemos cuántas hay (0, 1, etc.)


    if ($total_reservas_hoy > 0) {

        // ERROR: El usuario ya tiene una reserva hoy.
        
        // Simplemente lo devolvemos a la página de mesas.
        mysqli_close($conn);
        header("Location:mesas.php");
        exit();

    } else {
        //El usuario no tiene reservas hoy (total es 0).
        // Procedemos con el INSERT y UPDATE

        // --- INSERTAR LA RESERVA ---
        $consulta = "INSERT INTO reservas (dni, nmesa, comensales, comentarios) 
                     VALUES ('$dni_cliente', $mesa_id, $comensales, '$comentarios')";
        
        mysqli_query($conn, $consulta);

        // --- ACTUALIZAR LA MESA ---
        $estadomesa = "UPDATE mesa SET estado = '1' WHERE nmesa = $mesa_id";

        mysqli_query($conn, $estadomesa);

        mysqli_close($conn);
        header("Location:pedidos.php"); // <-- Le mandamos con éxito
        exit();
    }
}
?>
