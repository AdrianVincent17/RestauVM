<?php

// conexion.php
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$base_datos = 'restaurante';

$conn = mysqli_connect($host, $usuario, $contrasena, $base_datos);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

//caracteres especiales
mysqli_set_charset($conn, 'utf8mb4');

//comprobar errores en la conexion

mysqli_error($conn);