<?php
include('connect.php');

$titulo = $_POST['titleGame'];
$descript = $_POST['descriptionGame'];
$link = $_POST['linkGame'];
$type = $_POST['type'];

if ($varConexion->connect_error) {
    echo "Error en la base de datos";
} else {
    
    $sql = "INSERT INTO games (linkGames, titleGames, descriptionGames, idGameType) VALUES ('".$link."','".$titulo."', '".$descript."', '".$type."')";
    $result = $varConexion->query($sql);
    
    if ($result) {
        header('location: playground.php');
    } else {
        echo "¡Ups! Ocurrió un error al subir a la Base de Datos.";
    }
}