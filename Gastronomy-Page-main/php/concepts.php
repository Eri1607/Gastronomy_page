<?php
    session_start(); // Iniciar la sesión

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['user'])) {
        // Si no está autenticado, redirigir al login
        header('Location: ../html/login.php');
        exit();
    }
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include('connect.php');
    $array = array();

    // Verificar si la solicitud es por POST y si 'consultaPalabra' está presente
    $consultaPalabra = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['consultaPalabra'])) {
        $consultaPalabra = $_POST['consultaPalabra'];
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/concepts.css">
        <title>Concepts | Gastronomy Area</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
<body>
    
    <!-- OFFCANVAS -->
    <div class="container-fluid py-2 inicioBar">
        <div class="row align-items-center">
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-3">
                <div class="sideBar">
                    <button class="btn ms-xl-1" id="botoncito" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                        <picture><img src="../img/list-verde.svg" alt="" style="max-width: 40px;"></picture> 
                    </button>

                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header">
                            <h3 class="offcanvas-title ms-3" id="offcanvasExampleLabel">Concepts</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div class="dropdown mt-3">
                                <ul>
                                    <li><a class="dropdown-item" href="../html/index.html">Home</a></li>
                                    <li><a class="dropdown-item" href="../php/vocabulary.php">Vocabulary</a></li>
                                    <li><a class="dropdown-item" href="../php/concepts.php" id="selected">Concepts</a></li>
                                    <li><a class="dropdown-item" href="../php/interactions.php">Interactions</a></li>
                                    <li><a class="dropdown-item" href="../php/playground.php">Playground</a></li>
                                    <li><a class="dropdown-item text-danger" href="../html/logout.php">Logout</a></li> <!-- Botón de cerrar sesión -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-8 col-6 mt-2 barraBuscar">
                <form method="POST" action="" class="d-flex" role="search">
                    <input class="form-control" type="search" name="consultaPalabra" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success ms-2" type="submit">Search</button>
                </form>
            </div>
        
            <div class="col-xl-1 col-lg-1 col-md-2 col-sm-2 col-3 text-end">
                <div class="logoNavBar">
                    <img src="../img/logo_sena_verde.webp" alt="" style="width: 50px;">
                </div>
            </div>
        </div>
    </div>
    
    <!--Categories-->
    <div class="container mt-5">
        <div class="categories">
            <!--DROPDOWN DE CATEGORIAS-->
            <div class="botonesVocabulario">

                <!--Dropdown para elegir la categoria-->
                <div class="dropdown">
                    <button class="btn dropdown-toggle dropi" type="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</button>
                    <ul class="dropdown-menu">
                        <form action="concepts.php" method="post">
                            <button class="dropdown-item"> All concepts</button>
                        </form>
                        <form action="conceptsConsult.php" method="post">
                            <?php
                                if($ejecutar = mysqli_query($varConexion, "SELECT * FROM categoryconcepts") ){
                                    while ($row = $ejecutar -> fetch_array (MYSQLI_NUM)){
                                        $e = array();
                            ?>
                                    <button value=<?php echo $row[0]?> name="consultaV" class="dropdown-item"><?php echo $row[1]?></button>
                            <?php
                                    }    
                                }
                            ?>
                        </form>
                        <!--Necesita ciclo de las categorias--> 
                    </ul>
                </div>
                
                <?php
                if ($_SESSION['role'] === 'admin') {
                    // El botón para añadir conceptos solo se muestra si el rol es admin
                    echo '
                    <!--Boton para añadir conceptos-->
                    <div class="botonInsertar">
                        <button type="button" class="Insertar" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <picture> <img src="../img/agregar.png" alt=""> </picture>
                        </button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Concepts</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="insertConcepts.php" method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                                <label for="imageVocabulary" class=" image form-label">Image</label>
                                                <input type="file" class="form-control" name="imageConcepts" id="imageVocabulary" multiple required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nameWord" class=" name form-label">Word name</label>
                                                <input type="text" class="form-control" name="wordConcepts" id="nameWord" aria-describedby="emailHelp" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nameWord" class=" name form-label">Description</label>
                                                <input type="text" class="form-control" name="descriptionConcepts" id="nameWord" aria-describedby="emailHelp" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="categoriasSelect" class="audio form-label">Category</label>
                                                <select class="form-select" name="category" id="categoriasSelect" required>
                                                    <option value=""></option>';
                                                
                                                    if($ejecutar = mysqli_query($varConexion, "SELECT * FROM categoryconcepts") ){
                                                        while ($row = $ejecutar -> fetch_array (MYSQLI_NUM)){
                                                            echo '<option value=' . $row[0] . '>' . $row[1] . '</option>';
                                                        }
                                                    }
                                                echo '
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="add btn">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="botonInsertarText">
                            <span>Add Concepts</span>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>    

    <!--Cards Concepts-->
    <section>
        <div class="container">
            <?php
            // Verificar si hay una palabra buscada
            $query = "SELECT * FROM concepts"; // Consulta por defecto, si no se introduce ninguna palabra

            if (!empty($consultaPalabra)) {
                // Si se ingresó una palabra, ajustar la consulta para buscar en el título
                $query = "SELECT * FROM concepts WHERE titleConcepts LIKE '%" . mysqli_real_escape_string($varConexion, $consultaPalabra) . "%'";
            }

            // Ejecutar la consulta
            $ejecutar = mysqli_query($varConexion, $query);

            if ($ejecutar) {
                while ($row = $ejecutar->fetch_array(MYSQLI_NUM)) {
            ?>

                <div class="cardConcept">
                    <div class="imgCard">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row[1])?>" alt="">
                    </div>
                    <div class="contentCard">
                        <h2><?php echo $row[2] ?></h2>
                        <p><?php echo $row[3] ?></p>
                    </div>
                </div>
                
            <?php
                    }
                    
                }
            ?>
        </div>
    </section>

    <!--Footer-->

    <footer class="container-fluid">
        <div class="iconos pt-2">
            <a href="https://www.instagram.com/gastro_sena/profilecard/?igsh=MTR3YTNhZjF5ZGZ4ag=="><img src="../img/imgSocial/instagram.webp" width ="30"></a>
            <a href="https://www.facebook.com/share/gFiKvSR1FPK39KhV/"><img src="../img/imgSocial/facebook.webp" width="30"></a>
            <a href="https://x.com/Gastronomy30458?t=yPBNz8doWTZlS7PgTuVuCw&s=08"><img src="../img/imgSocial/twitter.webp" width="30"></a>
            <a href="https://www.youtube.com/@Gastronomy-o7c"><img src="../img/imgSocial/youtube.webp" width="30"></a>
            <a href=""><img src="../img/imgSocial/linkedin.webp" width="30"></a>
        </div>
        <div class="socialSena ">
            <a href=""> <h2>@SENAComunica</h2> </a>
        </div>
        <div class="urlSena pb-2">
            <a href="https://www.sena.edu.co/es-co/Paginas/default.aspx" target="_blank"> <h3>www.sena.edu.co</h3> </a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>