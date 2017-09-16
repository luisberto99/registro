<?php 
include_once("../class/class_conexion.php");
include_once("../class/class_seccion.php");
include_once("../class/class_aula.php");
include_once("../class/class_edificio.php");
include_once("../class/class_region.php");
$link = new Conexion();

switch ($_GET["accion"]) {

	case 'guardarRegion':
		if(Region::verificarIntegridad($link, $_POST["txt-nombre-region"], $_POST["txt-alias-region"])){

			$region = new Region(
				"null",
				$_POST["txt-nombre-region"],
				$_POST["txt-alias-region"]
			);

			echo $region->agregarRegion($link);
		} else
			echo header('HTTP', true, 500);
		break;
	
	case 'generarTabla':
		echo Region::generarTabla($link);
		break;

	case 'eliminarRegion':
		Region::eliminarRegion($link, $_POST["codigo_region"]);
		break;

	case 'obtenerRegion':
		echo json_encode(Region::obtenerRegion($link, $_POST["codigo_region"]));
		break;

	case 'modificarRegion':
		if(Region::verificarModificar($link, $_POST["txt-nombre-region"], $_POST["txt-alias-region"], $_POST["txt-codigo-region"])){

			$region = new Region(
				$_POST["txt-codigo-region"],
				$_POST["txt-nombre-region"],
				$_POST["txt-alias-region"]
			);
			
			echo $region->modificarRegion($link);
		} else
			echo header('HTTP', true, 500);
		break;

	default:
		echo header('HTTP', true, 500);
		break;
}

$link->cerrarConexion();

?>