<?php
include_once("../class/class_conexion.php");
include_once("../class/class_seccion.php");
include_once("../class/class_aula.php");
$link = new Conexion();

switch ($_GET["accion"])
{

    case 'guardarAula':
        if(Aula::verificarIntegridad($link, $_POST["txt-alias-aula"], $_POST["slc-edificio"]))
        {
            $aula = new Aula(
                null,
                $_POST["slc-edificio"],
                $_POST["txt-capacidad-aula"],
                $_POST["txt-alias-aula"]
            );
            echo $aula->agregarAula($link);
        }
        else
        {
            echo header('HTTP', true, 500);
        }
        break;
    
    case 'generarTabla':
        echo Aula::generarTabla($link);
        break;

    case 'eliminarAula':
        Aula::eliminarAula($link, $_POST["codigo_aula"]);
        break;

    case 'obtenerAula':
        echo json_encode(Aula::obtenerAula($link, $_POST["codigo_aula"]));
        break;

    case 'modificarAula':
        if(Aula::verificarModificar($link, $_POST["txt-alias-aula"], $_POST["slc-edificio"], $_POST["txt-codigo-aula"]))
        {
            $aula = new Aula(
                $_POST["txt-codigo-aula"],
                $_POST["slc-edificio"],
                $_POST["txt-capacidad-aula"],
                $_POST["txt-alias-aula"]
            );
            echo $aula->modificarAula($link);
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
