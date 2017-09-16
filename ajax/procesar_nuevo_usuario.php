<?php
include_once("../class/class_conexion.php");
include_once("../class/class_carrera.php");
include_once("../class/class_seccion.php");
include_once("../class/class_usuario.php");
$link = new Conexion();

switch ($_GET["accion"])
{

    case 'verificarFoto':
        if (isset($_FILES["input-foto-usuario"]))
        {
            $file = $_FILES["input-foto-usuario"];
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
                echo json_encode(array("esValida" => true));
        }
        else
        {
            echo json_encode(array("esValida" => false));
        }
        break;

    case 'guardarFoto':
        $ruta_provisional = $_FILES["input-foto-usuario"]["tmp_name"];
        $carpeta = "../imagenes/";
        $nombre = $_FILES["input-foto-usuario"]["name"];
        echo $src = $carpeta.$nombre;
        move_uploaded_file($ruta_provisional, $src);
        break;

    case 'guardarUsuario':
        if( Usuario::verificarIntegridad($link, $_POST["txt-identidad-usuario"], $_POST["txt-email-usuario"]))
        {
            $usuario = new Usuario(
                "null",
                $_POST["slc-tipo-usuario"],
                $_POST["txt-identidad-usuario"],
                $_POST["txt-nombre-usuario"],
                $_POST["txt-apellido-usuario"],
                $_POST["date-nacimiento-usuario"],
                $_POST["slc-genero-usuario"],
                $_POST["txt-email-usuario"],
                $_POST["txt-clave-usuario"],
                $_POST["url_imagen"]
            );
            echo $usuario->agregarUsuario($link);
        }
        else
        {
            echo header('HTTP', true, 500);
        }
        break;
    
    case 'generarTabla':
        echo Usuario::generarUsuarios($link);
        break;

    case 'eliminarUsuario':
        Usuario::eliminarUsuario($link, $_POST["codigo_usuario"]);
        break;

    case 'obtenerUsuario':
        echo json_encode(Usuario::obtenerUsuario($link, $_POST["codigo_usuario"]));
        break;

    case 'modificarUsuario':
        if(Usuario::verificarModificar($link, $_POST["txt-identidad-usuario"], $_POST["txt-email-usuario"], $_POST["txt-codigo-usuario"]))
        {
            $usuario = new Usuario(
                $_POST["txt-codigo-usuario"],
                $_POST["slc-tipo-usuario"],
                $_POST["txt-identidad-usuario"],
                $_POST["txt-nombre-usuario"],
                $_POST["txt-apellido-usuario"],
                $_POST["date-nacimiento-usuario"],
                $_POST["slc-genero-usuario"],
                $_POST["txt-email-usuario"],
                $_POST["txt-clave-usuario"],
                $_POST["url_imagen"]
            );
            echo $usuario->modificarUsuario($link);
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
