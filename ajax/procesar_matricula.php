<?php session_start();
include_once("../class/class_conexion.php");
include_once("../class/class_seccion.php");
include_once("../class/class_usuario.php");
include_once("../class/class_estudiante.php");
include_once("../class/class_matricula.php");
$link = new Conexion();

switch ($_GET["accion"]) {

	case 'selectAsignatura':
		echo Matricula::generarAsignaturas($link, $_POST["codigo_carrera"]);
		break;

	case 'selectSeccion':
		$region = Estudiante::obtenerRegion($link, $_SESSION["codigo_usuario"]);
		echo Matricula::generarSecciones($link, $_POST["codigo_asignatura"], $region);
		break;

	case 'guardarMatricula':
		if(Matricula::verificarIntegridad($link, $_SESSION["codigo_usuario"], $_POST["codigo_seccion"])){

			$matricula = new Matricula(
				$_POST["codigo_seccion"],
				$_SESSION["codigo_usuario"]
			);

			echo $matricula->agregarMatricula($link);
		} else
			echo header('HTTP', true, 500);
		break;
	
	case 'generarTabla':
		echo Matricula::generarTabla($link, $_SESSION["codigo_usuario"]);
		break;

	case 'eliminarMatricula':
		Matricula::eliminarMatricula($link, $_POST["codigo_seccion"]);
		break;

	default:
		echo header('HTTP', true, 500);
		break;
}

$link->cerrarConexion();

?>