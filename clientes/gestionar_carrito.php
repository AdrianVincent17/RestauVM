<?php

include("../seguridad.php");
proteger(0);
include("../conexion.php");
// Si no existe la "mochila" (el carrito), la creamos como un array vacío
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Recogemos la acción (añadir, quitar, vaciar)
$accion = $_GET['accion'];

// --- ACCIÓN: AÑADIR ---
if ($accion == 'añadir') {
    $id = $_GET['idprod'];
    $nombre = $_GET['nombre'];
    $cantidad = 1; // Para este ejemplo, añadimos de 1 en 1

    // Comprobamos si el producto (por su ID) ya está en la mochila
    if (isset($_SESSION['carrito'][$id])) {
        // Si ya existe, solo le sumamos 1 a la cantidad
        $_SESSION['carrito'][$id]['cantidad']++;
    } else {
        // Si no existe, "metemos" el producto nuevo en la mochila
        $_SESSION['carrito'][$id] = [
            'nombre' => $nombre,
            'cantidad' => $cantidad
        ];
    }
}

//ACCIÓN: QUITAR (Limpiar un item)
if ($accion == 'quitar') {
    $id = $_GET['idprod'];

    // Comprobamos si ese ID existe en la mochila
    if (isset($_SESSION['carrito'][$id])) {
        // unset() es la función mágica para "limpiar" o borrar
        // un elemento de un array.
        unset($_SESSION['carrito'][$id]);
    }
}

//ACCIÓN: VACIAR (Limpiar TODO el carrito)
if ($accion == 'vaciar') {
    // Simplemente "vaciamos la mochila" (la reemplazamos por un array vacío)
    $_SESSION['carrito'] = [];
}



?>