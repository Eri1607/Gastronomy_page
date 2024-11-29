<?php
    $varConexion=mysqli_connect('localhost','root', '', 'gastronomy');

    // Verificar conexión
    if (!$varConexion) {
        die("Conexión fallida: " . mysqli_connect_error());
}
?>