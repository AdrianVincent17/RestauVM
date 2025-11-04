<?php
session_start();
// Verificar si está logeado Y si el rol es 'usuario'
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 0) {
    header('Location:../index.php'); // Redirigir si no cumple el requisito
    exit;
}
?>