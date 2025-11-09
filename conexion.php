<?php

// conexion.php
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$base_datos = 'restaurante';

$conn = mysqli_connect($host, $usuario, $contrasena, $base_datos);


//caracteres especiales
mysqli_set_charset($conn, 'utf8mb4');

//comprobar errores en la conexion

mysqli_error($conn);