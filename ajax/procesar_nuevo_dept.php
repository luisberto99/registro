<?php
include_once("../class/class_conexion.php");
include_once("../class/class_carrera.php");
$link = new Conexion();

switch ($_GET["accion"]) {

	case 'guardarCarrera':
		if(Carrera::verificarIntegridad($link, $_POST["txt-nombre-carrera-dept"], $_POST["txt-alias-carrera-dept"])){

			$carrera = new Carrera(
				null,
				$_POST["slc-jefe"],
				$_POST["txt-nombre-carrera-dept"],
				$_POST["txt-alias-carrera-dept"],
				$_POST["regiones"]
			);

			echo $carrera->agregarCarrera($link);
		} else
			echo header('HTTP', true, 500);
		break;
	
	case 'generarTabla':
		echo Carrera::generarTabla($link);
		break;

	case 'eliminarCarrera':
		Carrera::eliminarCarrera($link, $_POST["codigo_carrera"]);
		break;

	case 'obtenerCarrera':
		echo json_encode(Carrera::obtenerCarrera($link, $_POST["codigo_carrera"]));
		break;

	case 'obtenerChkCarrera':
		echo json_encode(Carrera::obtenerChkCarrera($link, $_POST["codigo_carrera"]));
		break;

	case 'modificarCarrera':
		if(Carrera::verificarModificar($link, $_POST["txt-nombre-carrera-dept"], $_POST["txt-alias-carrera-dept"], $_POST["txt-codigo-carrera-dept"])){

			$carrera = new Carrera(
				$_POST["txt-codigo-carrera-dept"],
				$_POST["slc-jefe"],
				$_POST["txt-nombre-carrera-dept"],
				$_POST["txt-alias-carrera-dept"],
				$_POST["regiones"]
			);
			
			echo $carrera->modificarCarrera($link);
		} else
			echo header('HTTP', true, 500);
		break;

	default:
		echo header('HTTP', true, 500);
		break;
}

$link->cerrarConexion();

?>