<?php
include_once("../class/class_conexion.php");
include_once("../class/class_seccion.php");
include_once("../class/class_asignatura.php");
$link = new Conexion();

switch ($_GET["accion"]) {

	case 'guardarAsignatura':
		if(Asignatura::verificarIntegridad($link, $_POST["txt-nombre-asignatura"], $_POST["txt-alias-asignatura"])){

			$asignatura = new Asignatura(
				null,
				$_POST["txt-nombre-asignatura"],
				$_POST["txt-alias-asignatura"],
				$_POST["slc-uv-asignatura"],
				$_POST["carreras"]
			);

			echo $asignatura->agregarAsignatura($link);
		} else
			echo header('HTTP', true, 500);
		break;
	
	case 'generarTabla':
		echo Asignatura::generarTabla($link);
		break;

	case 'generarCheckbox':
		echo Asignatura::generarCheckbox($link);
		break;

	case 'eliminarAsignatura':
		Asignatura::eliminarAsignatura($link, $_POST["codigo_asignatura"]);
		break;

	case 'obtenerAsignatura':
		echo json_encode(Asignatura::obtenerAsignatura($link, $_POST["codigo_asignatura"]));
		break;

	case 'obtenerChkAsignatura':
		echo json_encode(Asignatura::obtenerChkAsignatura($link, $_POST["codigo_asignatura"]));
		break;

	case 'modificarAsignatura':
		if(Asignatura::verificarModificar($link, $_POST["txt-nombre-asignatura"], $_POST["txt-alias-asignatura"], $_POST["txt-codigo-asignatura"])){

			$asignatura = new Asignatura(
				$_POST["txt-codigo-asignatura"],
				$_POST["txt-nombre-asignatura"],
				$_POST["txt-alias-asignatura"],
				$_POST["slc-uv-asignatura"],
				$_POST["carreras"]
			);
			
			echo $asignatura->modificarAsignatura($link);
		} else
			echo header('HTTP', true, 500);
		break;

	default:
		echo header('HTTP', true, 500);
		break;
}

$link->cerrarConexion();

?>