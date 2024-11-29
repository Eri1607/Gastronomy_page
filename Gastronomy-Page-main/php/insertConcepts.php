<?php
include("connect.php");

$words = $_POST['wordConcepts'];
$des = $_POST['descriptionConcepts'];

// Verificar si se seleccionó una categoría
if (isset($_POST['category']) && !empty($_POST['category'])) {
    $idCategoryCon = $_POST['category'];  // Asignar correctamente la categoría

    $revisar = getimagesize($_FILES["imageConcepts"]["tmp_name"]);

    if ($revisar !== false) {
        $image = $_FILES['imageConcepts']['tmp_name'];
        $imgContenido = addslashes(file_get_contents($image));

        $sql = "INSERT INTO concepts (imgConcepts, titleConcepts, descriptionConcepts, idCategoryCon) 
                VALUES ('" . $imgContenido . "', '" . $words . "', '" . $des . "', '" . $idCategoryCon . "')";
        $result = $varConexion->query($sql);

        if ($result) {
            header('Location: concepts.php');
        } else {
            echo "¡Ups! Ocurrió un error al subir el archivo.";
        }
    }
} else {
    echo "¡Error! No se seleccionó una categoría.";
}
?>


