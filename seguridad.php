<?php
session_start();

function proteger($rolpermitido){

    // Verificar si está logeado Y si el rol es uno de los roles permitidos que seran los del parametro

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != $rolpermitido) {
    session_unset();
    session_destroy();
    header('Location:../index.php'); // Redirigir si no cumple el requisito
    
    exit;
}

}

?>