<?php session_start();

include_once("../class/class_conexion.php");
include_once("../class/class_usuario.php");
$link = new Conexion();
$respuesta = Usuario::verificarUsuario($link, $_POST["txt-email-login"], $_POST["txt-clave-login"]);
if ($respuesta["existe"])
{
	$_SESSION["codigo_usuario"] = $respuesta["codigo_usuario"];
	$_SESSION["codigo_tipo_usuario"] = $respuesta["codigo_tipo_usuario"];
	$_SESSION["nombres"] = $respuesta["nombres"];
	$_SESSION["apellidos"] = $respuesta["apellidos"];
	$_SESSION["url_imagen"] = $respuesta["url_imagen"];
	echo json_encode($respuesta);
}
else 
{
	echo "Usuario no existe!";
}

?>
