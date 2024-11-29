<?php
include("../php/connect.php"); // Asegúrate de que la ruta sea correcta

// Validar si se recibieron los datos del formulario
if (isset($_POST['nameU'], $_POST['lastU'], $_POST['emailU'], $_POST['passwordU'])) {
    // Escapar los datos para evitar inyección SQL
    $name = mysqli_real_escape_string($varConexion, $_POST['nameU']);
    $lastName = mysqli_real_escape_string($varConexion, $_POST['lastU']);
    $email = mysqli_real_escape_string($varConexion, $_POST['emailU']);
    $password = mysqli_real_escape_string($varConexion, $_POST['passwordU']);

    // Consulta SQL usando consultas preparadas
    $sql = "INSERT INTO users (nameU, lastName, email, passwordU) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($varConexion, $sql);
    
    if ($stmt) {
        // Enlazar parámetros y ejecutar la consulta
        mysqli_stmt_bind_param($stmt, "ssss", $name, $lastName, $email, $password);
        $execute = mysqli_stmt_execute($stmt);
        
        if ($execute) {
            // Redirigir si la inserción fue exitosa
            header('Location: ../html/index.html');
            exit();
        } else {
            // Mostrar error si hubo un problema al insertar los datos
            echo "Error al ejecutar la consulta: " . mysqli_error($varConexion);
        }

        // Cerrar la declaración preparada
        mysqli_stmt_close($stmt);
    } else {
        // Mostrar error si no se pudo preparar la consulta
        echo "Error al preparar la consulta: " . mysqli_error($varConexion);
    }

    // Cerrar la conexión
    mysqli_close($varConexion);
} else {
    // Mostrar un mensaje de error si los datos del formulario no están presentes
    echo "Por favor, complete todos los campos del formulario.";
}
?>
