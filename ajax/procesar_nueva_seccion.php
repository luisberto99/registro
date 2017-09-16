<?php
include_once("../class/class_conexion.php");
include_once("../class/class_seccion.php");
$link = new Conexion();

switch ($_GET["accion"]) {

	case 'guardarSeccion':
		if(Seccion::verificarIntegridad($link, $_POST["slc-catedratico"], $_POST["slc-hora-inicio"], $_POST["slc-aula"])){

			$seccion = new Seccion(
				null,
				$_POST["slc-tipo-seccion"],
				$_POST["slc-asignatura"],
				$_POST["slc-aula"],
				$_POST["slc-horario"],
				$_POST["slc-catedratico"],
				$_POST["slc-hora-inicio"],
				$_POST["txt-seccion-cupos"]
			);

			echo $seccion->agregarSeccion($link);
		} else
			echo header('HTTP', true, 500);
		break;
	
	case 'generarTabla':
		echo Seccion::generarTabla($link);
		break;

	case 'eliminarSeccion':
		Seccion::eliminarSeccion($link, $_POST["codigo_seccion"]);
		break;

	case 'obtenerSeccion':
		echo json_encode(Seccion::obtenerSeccion($link, $_POST["codigo_seccion"]));
		break;

	case 'modificarSeccion':
		if(Seccion::verificarModificar($link, $_POST["slc-catedratico"], $_POST["slc-hora-inicio"], $_POST["slc-aula"], $_POST["txt-codigo-seccion"])){

			$seccion = new Seccion(
				$_POST["txt-codigo-seccion"],
				$_POST["slc-tipo-seccion"],
				$_POST["slc-asignatura"],
				$_POST["slc-aula"],
				$_POST["slc-horario"],
				$_POST["slc-catedratico"],
				$_POST["slc-hora-inicio"],
				$_POST["txt-seccion-cupos"]
			);
			
			echo $seccion->modificarSeccion($link);
		} else
			echo header('HTTP', true, 500);
		break;

	default:
		echo header('HTTP', true, 500);
		break;
}

$link->cerrarConexion();

?>