<?php
include("../php/connect.php");

// Inicializa una variable para el mensaje de error
$error_message = '';

// Verificar si se recibieron los datos del formulario
if (isset($_POST['emailU'], $_POST['passwordU'], $_POST['role'])) {
    $email = mysqli_real_escape_string($varConexion, $_POST['emailU']);
    $password = mysqli_real_escape_string($varConexion, $_POST['passwordU']);
    $role = mysqli_real_escape_string($varConexion, $_POST['role']);
    $admin_id = isset($_POST['admin_id']) ? mysqli_real_escape_string($varConexion, $_POST['admin_id']) : null;

    // Consulta para verificar las credenciales y el rol
    $sql = "SELECT * FROM users WHERE email = ? AND passwordU = ? AND role = ?";
    $stmt = mysqli_prepare($varConexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $email, $password, $role);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Si el rol es "admin", verificar el ID del administrador
            if ($role === 'admin') {
                if ($admin_id !== '1019903049') { // Cambia '123456' por el ID de administrador que deseas
                    $error_message = "ID de administrador incorrecto.";
                } else {
                    session_start();
                    $_SESSION['user'] = $email;
                    $_SESSION['role'] = $role; // Guardar el rol en la sesión
                    header('Location: ../html/index.html'); // Redirigir a la página
                    exit();
                }
            } else {
                // Si es un usuario normal
                session_start();
                $_SESSION['user'] = $email;
                $_SESSION['role'] = $role; // Guardar el rol en la sesión
                header('Location: ../html/index.html'); // Redirigir a la página
                exit();
            }
        } else {
            $error_message = "Email, contraseña o rol incorrectos.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Error al preparar la consulta: " . mysqli_error($varConexion);
    }

    mysqli_close($varConexion);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In</title>
    <link rel="stylesheet" href="../css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    
    
    <div class="formulario">
        <div class="form p-5">

            <!--IMAGE-->
            <div class="formImg d-none d-lg-block mx-0">
                <img src="../img/imgUsers/chefLogin.svg" alt="">
            </div>

            <!--FORM-->
            <form class="formAc ms-xl-5 ms-lg-5 ms-md-0 ms-sm-0" action="login.php" method="POST">
                    <h1>Sign In</h1>
                    
                    <div class="email mt-xl-3 mt-lg-3 mt-md-3 mt-sm-3">
                        <div class="imgEmail ms-3">
                            <img src="../img/imgUsers/gmail.webp">
                            <label class="" for="Email">Email</label>
                        </div>
                        <input class="mt-xl-1" type="email" name="emailU" id="Email" required>
                    </div>
                    
                    <div class="passwords mt-xl-3 mt-lg-3 mt-md-3 mt-sm-3">
                        <div class="imgPassword ms-3">
                            <img src="../img/imgUsers/password.webp">
                            <label class="" for="Password">Password</label>
                        </div>
                        <input class="mt-xl-1 mt-lg-1 mt-md-0 mt-sm-0" type="password" name="passwordU" id="Password">
            
                    </div>

                    <div class="mt-xl-3 mt-lg-3 mt-md-3 mt-sm-3">
                        <label for="role" class="form-label">Select Role</label>
                        <select class="form-select" name="role" id="role" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div id="admin-id" class="mt-xl-3 mt-lg-3 mt-md-3 mt-sm-3" style="display:none;">
                        <div class="imgPassword ms-3">
                            <img src="../img/imgUsers/password.webp">
                            <label class="" for="Id">Admin ID</label>
                        </div>
                        <input class="mt-xl-1 form-control" type="text" name="admin_id">
                    </div>
        
                    <div class="checkbox mt-xl-3 mt-xl-3 mt-lg-3 mt-md-3 mt-sm-3 ms-4 me-4">
                        <div class="check">
                            <input type="checkbox" name="" id="check">
                            <label for="check">Keep Login</label>
                        </div>
                        <div class="linkCheck">
                            <a href="../html/register.html">Don't you have an account?</a>
                        </div>
                    </div>
        
                    <button type="submit" class="btn mt-3">Sign In</button>

                    <!-- Mostrar el mensaje de error -->
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger mt-5" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script>
        document.querySelector('[name="role"]').addEventListener('change', function() {
            if (this.value === 'admin') {
                document.getElementById('admin-id').style.display = 'block';
            } else {
                document.getElementById('admin-id').style.display = 'none';
            }
        });
    </script>
</body>
</html>