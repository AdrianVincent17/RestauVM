<?php
session_start();

function proteger($rolpermitido){
    // Verificar si está logeado Y si el rol es 'usuario'
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != $rolpermitido) {
    header('Location:index.php'); // Redirigir si no cumple el requisito
    exit;
}

}

?>