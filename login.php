<?php session_start();
if (isset($_SESSION["codigo_usuario"]))
    header("Location: menu/home.php");
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>UNAH | Iniciar sesion</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
     <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="left-div">
                <a href="index.html"><img src="assets/img/unah-logo.png"/></a>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
   
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Por favor, verifiquese para entrar </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="alert alert-danger hidden" id="div-error-login">
                    </div>
                    <h4><strong>Iniciar sesi&oacute;n: </strong></h4>
                    <br />
                    <label for="txt-email-login">Correo electronico: </label>
                    <input type="text" class="form-control" id="txt-email-login" />
                    <label for="txt-clave-login">Contraseña:  </label>
                    <input type="password" class="form-control" id="txt-clave-login" />
                    <hr />
                    <button class="btn btn-info" id="btn-login" ><span class="glyphicon glyphicon-user"></span> &nbsp;Acceder</button>&nbsp;
                </div>
                <div class="col-md-6">
                    <div class="alert alert-success">
                         <strong> Instrucciones:</strong>
                        <ul>
                            <li>
                               Utilize su <b>ID</b> para iniciar sesion, <b>NO</b> su correo electronico.
                            </li>
                            <li>
                                Si su clave no funciona, asegurese de no tener CAPS LOCK activado.
                            </li>
                        </ul>
                    </div>
                    <div class="alert alert-info">
                        <strong> Tomar en cuenta :</strong>
                        <ul>
                            <li>
                                Para la mejor experiencia de navegacion utilizar el navegador <b>Google Chrome.</b>
                            </li>
                            <li>
                                Si tiene problemas con el sistema, llamar al +504 2232 6112
                            </li>
                            <li>
                                <b>NO COMPARTA SU CLAVE.</b> Su clave es privada.
                            </li>
                            <li>
                                Si comparte su clave no nos hacemos responsables por cambios no deseados en su cuenta. 
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    IS410 Octubre, 2016  |  Javier Edgardo Cano Deras</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/controlador_login.js"></script>
</body>
</html>
