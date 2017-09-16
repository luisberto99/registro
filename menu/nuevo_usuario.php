﻿<?php session_start();
if (!isset($_SESSION["codigo_usuario"]))
    header("Location: ../login.php");

include_once("../class/class_conexion.php");
include_once("../class/class_tipo_usuario.php");
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
    <title>UNAH | Nuevo usuario</title>
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
            <div class="alert alert-info hidden" id="div-alert-mensaje"></div>
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                       <b>Nuevo usuario</b>
                    </div>
                    <div class="panel-body">
                        <div class="form-group" id="div-txt-nombre-usuario" >
                          <label class="control-label" for="txt-nombre-usuario">Nombres:</label>
                          <input type="text" class="form-control" id="txt-nombre-usuario">
                          <input type="hidden" class="form-control" id="txt-codigo-usuario" value="">
                        </div>
                        <div class="form-group" id="div-txt-apellido-usuario" >
                          <label class="control-label" for="txt-apellido-usuario">Apellidos:</label>
                          <input type="text" class="form-control" id="txt-apellido-usuario">
                        </div>
                         <div class="form-group" id="div-input-foto-usuario" >
                          <label class="control-label" for="input-foto-usuario">Fotografia:</label>
                          <form method="post" id="form-fotografia" enctype="multipart/form-data">
                            <input type="file" name="input-foto-usuario" accept="image/*">
                          </form>
                          <p class="help-block">Formato: gif, png, jpg, jpeg, Max: 480x480px 1Mb, Min: 64x64px.</p>
                        </div>
                        <div class="form-group" id="div-txt-clave-usuario">
                            <label class="control-label" for="txt-clave-usuario">Clave:</label>
                            <input type="password" class="form-control" id="txt-clave-usuario">
                        </div>
                        <div class="form-group" id="div-txt-verificar-clave-usuario">
                            <label class="control-label" for="txt-verificar-clave-usuario">Verificar su clave:</label>
                            <input type="password" class="form-control" id="txt-verificar-clave-usuario">
                        </div>
                        <div class="form-group" id="div-slc-genero-usuario">
                          <label class="control-label" for="slc-genero-usuario">Genero:</label>
                          <select class="form-control" id="slc-genero-usuario">
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                          </select>
                        </div>
                        <div class="form-group" id="div-date-nacimiento-usuario" >
                          <label class="control-label" for="date-nacimiento-usuario">Fecha de nacimiento:</label>
                          <input type="text" class="form-control" id="date-nacimiento-usuario">
                        </div>
                        <div class="form-group" id="div-txt-identidad-usuario" >
                          <label class="control-label" for="txt-identidad-usuario">Codigo de identidad:</label>
                          <input type="text" class="form-control" id="txt-identidad-usuario">
                        </div>
                        <div class="form-group" id="div-txt-email-usuario" >
                          <label class="control-label" for="txt-email-usuario">Correo electronico:</label>
                          <input type="text" class="form-control" id="txt-email-usuario">
                        </div>
                        <div class="form-group" id="div-slc-tipo-usuario" >
                            <label class="control-label" for="slc-tipo-usuario">Tipo de usuario:</label>
                            <?php echo TipoUsuario::generarSelect($link); ?>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-default" id="btn-nuevo-usuario-cancelar">Cancelar</button>
                        <button type="button" class="btn btn-success hidden" disabled id="btn-nuevo-usuario-actualizar">Actualizar</button>
                        <button type="button" class="btn btn-primary" disabled id="btn-nuevo-usuario-guardar">Guardar</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="panel panel-info">
                    <div class="panel-heading">
                       <b>Tabla de usuarios</b>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <table class="table table-striped table-hover" id="tbl-usuarios">
                                <th></th>
                                <th>Fotograf&iacute;a</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Fecha de nacimiento</th>
                                <th>Genero</th>
                                <th>Tipo</th>
                                <th>ID</th>
                                <th>Email</th>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                    <button class="btn btn-primary btn-xs" id="btn-nuevo-usuario-editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button>
                    <button class="btn btn-danger btn-xs" data-toggle="modal" data-target=".bs-example-modal-sm" id="btn-modal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
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
              <button class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm" id="btn-nuevo-usuario-eliminar"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
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
    <script src="../js/controlador_nuevo_usuario.js"></script>
</body>
</html>
