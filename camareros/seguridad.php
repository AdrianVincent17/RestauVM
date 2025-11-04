<?php
session_start();
// Verificar si está logeado Y si el rol es 'camarero = 1'
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 1) {
    header('Location:../index.php'); // Redirigir si no cumple el requisito
    exit;
}
?>