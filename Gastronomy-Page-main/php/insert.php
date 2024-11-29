<?php
include("connect.php");
$words = $_POST['word'];
$idCat = $_POST['category'];
$revisar = getimagesize($_FILES["image"]["tmp_name"]);

if (isset($_FILES['audioI']) && ($_FILES['audioI']['error'] == 0)) {
    $direccion = "../audio/";
    $nombreunico = uniqid()."_". $_FILES['audioI']['name'];
    $rutaArchivo = $direccion.$nombreunico;
    echo "<br>";


    if($revisar !== false){
        $image = $_FILES['image']['tmp_name'];
        $imgContenido = addslashes(file_get_contents($image));
    
        if (move_uploaded_file($_FILES['audioI']['tmp_name'], $rutaArchivo)) {
            if ($varConexion->connect_error) {
                echo "Error en la base de datos";
            } else {
                $tiemnow = date("Y-m-d H:i:s");
                $archivoSonido = addslashes(file_get_contents($rutaArchivo));
                
                $sql = "INSERT INTO vocabulary (imgVocabulary, word, audioVocabulary, idCat) VALUES ('".$imgContenido."','".$words."', '".$archivoSonido."', '".$idCat."')";
                $result = $varConexion->query($sql);
                
                if ($result) {
                    header('location: vocabulary.php');
                } else {
                    echo "¡Ups! Ocurrió un error al subir el archivo de audio.";
                }
            }
        }
    }
}
?>