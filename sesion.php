<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre']) && !isset($_SESSION['dni'])) {
    header("Location:index.php");
    exit();
}



