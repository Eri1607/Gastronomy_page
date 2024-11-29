<?php
include("connect.php");

    $title = $_POST["titleInteractions"];
    $link = $_POST["linkInteractions"];
    $autor = $_POST["autorInteractions"];
    $description = $_POST["descriptionInteractions"];
    $duration = $_POST["durationInteractions"];


    $revisar = getimagesize($_FILES["imageInteractions"]["tmp_name"]);
    if ($revisar !== false) {
        $image = $_FILES['imageInteractions']['tmp_name'];
        $imgContenido = addslashes(file_get_contents($image));


        $sql = "INSERT INTO social (imgVideo, linkSocial, titleSocial, autorVideo, descriptionSocial, duration) VALUES ('$imgContenido','$link','$title','$autor','$description','$duration')";
        $result = $varConexion->query($sql);

        if ($result) {
            header('location: interactions.php');
        } else {
            echo "¡Ups! Ocurrió un error al subir el archivo de video.";
        }

    } else {
        echo "¡Ups! El archivo de video no es válido.";
    }


?>