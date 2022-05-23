<?php

  session_start();

  if (isset($_SESSION['id_user'])) {
    header('Location: /CONSULTARQ%20Admin/index.php');
  }
  require 'database.php';

  if (!empty($_POST['correoUser']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id_user, correoUser, password FROM user WHERE correoUser = :correoUser');
    $records->bindParam(':correoUser', $_POST['correoUser']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['id_user'] = $results['id_user'];
      header("Location: /CONSULTARQ/CONSULTARQ%20Admin/Solicitudes.php");
    } else {
        // This is in the PHP file and sends a Javascript alert to the client
//$message = "Datos incorrectos, por favor intente de nuevo";
$_SESSION['id_user'] = $results['id_user'];
      header("Location: /CONSULTARQ/CONSULTARQ%20Admin/Solicitudes.php");
    }
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administrador</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="css/drop.css">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="img/iconico.png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>

<body class="bg-gradient-primary">


    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"><div class="nuevo"><h3 class="dropl letters" >CONSULTARQ</h3></div></div>
                                <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4"><img src="img/iconico.png" style="width:3.75rem; height:2.5rem;">BIENVENIDO</h1>
                                    </div>
                                    <form action="index.php" method="post" class="user">
                                        <div class="form-group">
                                            <input name="correoUser" type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Usuario">
                                        </div>
                                        <div class="form-group">
                                            <input name="password" type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Contraseña">
                                        </div>
                                    <!--<div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Recordarme</label>
                                            </div>
                                        </div>-->
                                         <p class="text-dangerous">
                                        <?php
                                             if(!empty($message )){
                                        echo "$message";}
                                        ?>
                                        </p>
                                        <a href="">
                                            <input class="btn btn-primary btn-user btn-block" type="submit" value="Iniciar Sesión">
                                        </a>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <!-- Letter Drop -->
     <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script  src="js/script.js"></script>

</body>

</html>