<?php
include_once("../class/class_conexion.php");
include_once("../class/class_seccion.php");
include_once("../class/class_aula.php");
include_once("../class/class_edificio.php");
$link = new Conexion();

switch ($_GET["accion"])
{

    case 'guardarEdificio':
        if(Edificio::verificarIntegridad($link, $_POST["txt-nombre-edificio"], $_POST["slc-region"]))
        {
            $edificio = new Edificio(
                "null",
                $_POST["slc-region"],
                $_POST["txt-nombre-edificio"]
            );
            echo $edificio->agregarEdificio($link);
        }
        else
        {
            echo header('HTTP', true, 500);
        }
        break;
    
    case 'generarTabla':
        echo Edificio::generarTabla($link);
        break;

    case 'eliminarEdificio':
        Edificio::eliminarEdificio($link, $_POST["codigo_edificio"]);
        break;

    case 'obtenerEdificio':
        echo json_encode(Edificio::obtenerEdificio($link, $_POST["codigo_edificio"]));
        break;

    case 'modificarEdificio':
        if(Edificio::verificarModificar($link, $_POST["txt-nombre-edificio"], $_POST["slc-region"], $_POST["txt-codigo-edificio"]))
        {
            $edificio = new Edificio(
                $_POST["txt-codigo-edificio"],
                $_POST["slc-region"],
                $_POST["txt-nombre-edificio"]
            );
            echo $edificio->modificarEdificio($link);
        }
        else
        {
            echo header('HTTP', true, 500);
        }
        break;

    default:
        echo header('HTTP', true, 500);
        break;
}

$link->cerrarConexion();

?>
