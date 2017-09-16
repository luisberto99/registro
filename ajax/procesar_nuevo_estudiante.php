<?php 
include_once("../class/class_conexion.php");
include_once("../class/class_carrera.php");
include_once("../class/class_seccion.php");
include_once("../class/class_usuario.php");
include_once("../class/class_estudiante.php");
include_once("../class/class_tipo_usuario.php");
$link = new Conexion();

switch ($_GET["accion"])
{

    case 'verificarFoto':
        if (isset($_FILES["input-foto-estudiante"]))
        {
            $file = $_FILES["input-foto-estudiante"];
            $extension = $file["type"];
            $ruta_provisional = $file["tmp_name"];
            $size = $file["size"];
            $dimensiones = getimagesize($ruta_provisional);
            $width = $dimensiones[0];
            $height = $dimensiones[1];
            $carpeta = "imagenes/";

            if ($extension != 'image/jpg' && $extension != 'image/jpeg' && $extension != 'image/png' && $extension != 'image/gif')
                echo json_encode(array("esValida" => false));
            else if ($size > 1024*1024)
                echo json_encode(array("esValida" => false));
            else if ($width > 480 || $height > 480)
                echo json_encode(array("esValida" => false));
            else if($width < 64 || $height < 64)
                echo json_encode(array("esValida" => false));
            else
                echo json_encode(array( "esValida" => true ));
        }
        else
        {
            echo json_encode(array("esValida" => false));
        }
        break;

    case 'guardarFoto':
        $ruta_provisional = $_FILES["input-foto-estudiante"]["tmp_name"];
        $carpeta = "../imagenes/";
        $nombre = $_FILES["input-foto-estudiante"]["name"];
        echo $src = $carpeta.$nombre;
        move_uploaded_file($ruta_provisional, $src);
        break;

    case 'guardarEstudiante':
        if(Estudiante::verificarIntegridad($link, $_POST["txt-identidad-estudiante"], $_POST["txt-email-estudiante"]))
        {
            $codigoTipoUsuario = TipoUsuario::obtenerCodigoEstudiante($link);
            $estudiante = new Estudiante(
                null,
                $codigoTipoUsuario,
                $_POST["slc-region"],
                $_POST["slc-carrera"],
                $_POST["txt-identidad-estudiante"],
                $_POST["txt-nombre-estudiante"],
                $_POST["txt-apellido-estudiante"],
                $_POST["date-nacimiento-estudiante"],
                $_POST["slc-genero-estudiante"],
                $_POST["txt-email-estudiante"],
                $_POST["txt-clave-estudiante"],
                $_POST["url_imagen"]
            );
            echo $estudiante->agregarEstudiante($link);
        }
        else
        {
            echo header('HTTP', true, 500);
        }
        break;
    
    case 'generarTabla':
        echo Estudiante::generarEstudiantes($link);
        break;

    case 'eliminarEstudiante':
        Estudiante::eliminarUsuario($link, $_POST["codigo_usuario"]);
        break;

    case 'obtenerEstudiante':
        echo json_encode(Estudiante::obtenerEstudiante($link, $_POST["codigo_usuario"]));
        break;

    case 'modificarEstudiante':
        if(Estudiante::verificarModificar($link, $_POST["txt-identidad-estudiante"], $_POST["txt-email-estudiante"], $_POST["txt-codigo-estudiante"]))
        {
            $estudiante = new Estudiante(
                $_POST["txt-codigo-estudiante"],
                null,
                $_POST["slc-region"],
                $_POST["slc-carrera"],
                $_POST["txt-identidad-estudiante"],
                $_POST["txt-nombre-estudiante"],
                $_POST["txt-apellido-estudiante"],
                $_POST["date-nacimiento-estudiante"],
                $_POST["slc-genero-estudiante"],
                $_POST["txt-email-estudiante"],
                $_POST["txt-clave-estudiante"],
                $_POST["url_imagen"]
            );
            echo $estudiante->modificarEstudiante($link);
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
