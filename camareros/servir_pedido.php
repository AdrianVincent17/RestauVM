<?php
// Incluir archivos de conexión y seguridad
include("../seguridad.php");
proteger(1); // Asumimos que solo el camarero (rol 1) puede ejecutar esto
include("../conexion.php");

// 1. Verificar que se ha recibido el ID de línea de pedido (idline)
if (!isset($_GET['idline']) || empty($_GET['idline'])) {
    // Si no se recibe el ID, redirigir o mostrar un error
    header("Location: gestion_mesas_camarero.php?error=no_id");
    exit();
}

// 2. Obtener y sanear el idline recibido
$idline = $_GET['idline'];
$idline_segura = mysqli_real_escape_string($conn, $idline);

// 3. Consulta SQL para actualizar el estado del artículo
// Actualizamos el campo 'servido' a 1 (servido) en la tabla 'pedido_producto'
$query_update = "
    UPDATE pedido_producto 
    SET servido = 1 
    WHERE idline = '$idline_segura'
";

if (mysqli_query($conn, $query_update)) {
    // Éxito en la actualización:
    
    // Opcional: Obtener el id de la mesa para poder redirigir correctamente si fuera necesario
    // Para simplificar, solo redirigiremos a la página principal de gestión.
    
    mysqli_close($conn);
    
    // Redirigir de nuevo a la página de gestión o a donde sea necesario
    // Nota: El JS de la respuesta anterior solo simulaba el éxito. Si realmente usas AJAX/Fetch,
    // este script solo necesita responder con un código de éxito (ej: HTTP 200) o un JSON.
    // Para una implementación simple con redirección:
    header("Location: gestion_mesas_camarero.php?success=servido");
    exit();
    
} else {
    // Error en la base de datos
    error_log("Error al marcar pedido como servido (idline: $idline_segura): " . mysqli_error($conn));
    mysqli_close($conn);
    header("Location: gestion_mesas_camarero.php?error=db_fail");
    exit();
}

// Nota: Si usas Fetch en JavaScript, puedes eliminar las redirecciones (header("Location: ..."))
// y simplemente imprimir un JSON de éxito o error.
?>