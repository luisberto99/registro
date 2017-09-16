<?php session_start();
if (!isset($_SESSION["codigo_usuario"]))
    header("Location: ../login.php");

include_once("../class/class_conexion.php");
include_once("../class/class_edificio.php");
$link = new Conexion();
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
    <title>UNAH | Nueva aula</title>
    <link rel="icon" type="image/png" href="../favicon.ico">
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="../assets/css/style.css" rel="stylesheet" />
     <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <strong>Email: </strong>soporte@unah.hn
                    &nbsp;&nbsp;
                    <strong>Ayuda: </strong>+504 2232 6112
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END-->
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../index.html">
                    <img src="../assets/img/unah-logo-mini.png"/>
                </a>
            </div>
            <div class="left-div">
                <div class="user-settings-wrapper">
                    <ul class="nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <span class="glyphicon glyphicon-user" style="font-size: 25px;"></span>
                            </a>
                            <div class="dropdown-menu dropdown-settings">
                                <div class="media" id="div-user-settings"></div>
                                <hr />
                                <a href="cerrar_sesion.php" class="btn btn-danger btn-sm">Cerrar sesion</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right"></ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- MENU SECTION END-->
    <div class="content-wrapper" id="div-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <b>Nueva aula</b>
                        </div>
                        <div class="panel-body">
                            <div class="form-group" id="div-slc-edificio">
                              <label class="control-label" for="slc-edificio">Seleccione el edificio en donde se encuentra el aula:</label>
                              <?php echo Edificio::generarSelect($link); ?>
                            </div>
                            <div class="form-group" id="div-txt-alias-aula">
                              <label for="txt-alias-aula" class="control-label">Codigo del aula:</label>
                              <input type="text" class="form-control" id="txt-alias-aula">
                              <input type="hidden" id="txt-codigo-aula" value="">
                            </div>
                            <div class="form-group" id="div-txt-capacidad-aula">
                              <label for="txt-capacidad-aula" class="control-label">Numero de estudiantes que soporta:</label>
                              <input type="text" class="form-control" id="txt-capacidad-aula">
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-default" id="btn-nueva-aula-cancelar">Cancelar</button>
                            <button type="button" class="btn btn-success hidden" id="btn-nueva-aula-actualizar">Actualizar</button>
                            <button type="button" class="btn btn-primary" id="btn-nueva-aula-guardar">Guardar</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                           <b>Tabla de aulas</b>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <table class="table table-striped table-hover" id="tbl-aulas">
                                    <th></th>
                                    <th>Aula</th>
                                    <th>Edificio</th>
                                    <th>Region</th>
                                    <th>Soporte</th>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                        <button class="btn btn-primary btn-xs" id="btn-nueva-aula-editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button>
                        <button class="btn btn-danger btn-xs" data-toggle="modal" data-target=".bs-example-modal-sm" id="btn-modal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
                        </div>
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
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-body"><b>¿Esta seguro de que desea eliminar este registro?</b></div>
          <div class="modal-footer">
              <button class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-sm">Cancelar</button>
              <button class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm" id="btn-nueva-aula-eliminar"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Small modal -->

    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/controlador.js"></script>
    <script src="../js/controlador_nueva_aula.js"></script>
</body>
</html>
