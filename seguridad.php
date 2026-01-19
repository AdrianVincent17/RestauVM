<?php
session_start();


function proteger($rolpermitido){

    //hacemos una unica llamada a la conexion
    include_once('conexion.php'); 
    

    // Verificar si está logeado Y si el rol es uno de los roles permitidos que seran los del parametro

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != $rolpermitido) {
    header('Location:../index.php'); // Redirigir si no cumple el requisito
    exit;
}

if (isset($_SESSION['dni'])) {
    $dni = $_SESSION['dni'];

    // Consultamos el estado actual del camarero
    $query = "SELECT estado FROM usuario WHERE dni = '$dni' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    $estado= $user['estado'];   
    // Si el estado es 'bloqueado' o 'inactivo'
    if ($estado == 1) {
        header("Location: ../logout.php");
        exit();
    }
}

}

?>