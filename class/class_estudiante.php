<?php

class Estudiante extends Usuario
{
    
    private $codigo_region;
    private $codigo_carrera;

    function __construct($codigo_usuario, $codigo_tipo_usuario, $codigo_region, $codigo_carrera, $codigo_identidad, $nombres, $apellidos, $fecha_nacimiento, $genero, $email, $clave, $url_imagen)
    {
        parent::__construct($codigo_usuario, $codigo_tipo_usuario, $codigo_identidad, $nombres, $apellidos, $fecha_nacimiento, $genero, $email, $clave, $url_imagen);
        $this->codigo_region = $codigo_region;
        $this->codigo_carrera = $codigo_carrera;
    }

    public function getCodigoRegion()
    {
        return $this->codigo_region;
    }
     
    public function setCodigoRegion($codigo_region)
    {
        $this->codigo_region = $codigo_region;
    }
    
    public function getCodigoCarrera()
    {
        return $this->codigo_carrera;
    }
     
    public function setCodigoCarrera($codigo_carrera)
    {
        $this->codigo_carrera = $codigo_carrera;
    }

    public function agregarEstudiante($link)
    {
        $sql = sprintf("
            INSERT INTO tbl_usuarios VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', sha1('%s'), '%s');",
            stripslashes($this->codigo_tipo_usuario),
            stripslashes($this->codigo_region),
            stripslashes($this->codigo_carrera),
            stripslashes($this->codigo_identidad),
            stripslashes($this->nombres),
            stripslashes($this->apellidos),
            stripslashes($this->fecha_nacimiento),
            stripslashes($this->genero),
            stripslashes($this->email),
            stripslashes($this->clave),
            stripslashes($this->url_imagen)
        );
        if($link->ejecutarInstruccion($sql))
        {
            echo "Estudiante agregado con exito!";
        }
        else
        {
            echo "Error! No se agrego el estudiante.";
        }
    }

    public static function generarEstudiantes($link)
    {
        $sql = "SELECT a.codigo_usuario, a.codigo_tipo_usuario, a.codigo_region, a.codigo_carrera, a.codigo_identidad, a.nombres, a.apellidos, a.fecha_nacimiento, a.genero, a.email, a.url_imagen, d.codigo_tipo_usuario, d.tipo_usuario
            FROM tbl_usuarios a
            INNER JOIN tbl_tipos_usuarios d
            ON a.codigo_tipo_usuario = d.codigo_tipo_usuario
            WHERE d.tipo_usuario = 'Estudiante'";
        if($resultado = $link->ejecutarInstruccion($sql))
        {
            while ($fila = $link->obtenerFila($resultado))
            {
                echo "<tr>";
                echo "<td><input type='radio' name='rad-estudiantes' value='".$fila["codigo_usuario"]."'></td>";
                echo "<td><img src='".$fila["url_imagen"]."' height='32' width='32'></td>";
                echo "<td>".$fila["nombres"]."</td>";
                echo "<td>".$fila["apellidos"]."</td>";
                echo "<td>".$fila["fecha_nacimiento"]."</td>";
                echo "<td>".$fila["genero"]."</td>";

                //Obtener el nombre de la region
                $sql = sprintf(
                    "SELECT a.codigo_usuario, a.codigo_region, b.codigo_region, b.alias
                    FROM tbl_usuarios a
                    INNER JOIN tbl_regiones b
                    ON a.codigo_region = b.codigo_region
                    WHERE a.codigo_usuario = '%s'",
                    stripslashes($fila["codigo_usuario"])
                );
                if($resultadoRegion = $link->ejecutarInstruccion($sql))
                {
                    $filaRegion = $link->obtenerFila($resultadoRegion);
                    echo "<td>".$filaRegion["alias"]."</td>";
                    $link->liberarResultado($resultadoRegion);
                }

                //Obtener el nombre de la carrera
                $sql = sprintf(
                    "SELECT a.codigo_usuario, a.codigo_carrera, c.codigo_carrera, c.nombre
                    FROM tbl_usuarios a
                    INNER JOIN tbl_carreras c
                    ON a.codigo_carrera = c.codigo_carrera
                    WHERE a.codigo_usuario = '%s'",
                    stripslashes($fila["codigo_usuario"])
                );
                if($resultadoCarrera = $link->ejecutarInstruccion($sql))
                {
                    $filaCarrera = $link->obtenerFila($resultadoCarrera);
                    echo "<td>".$filaCarrera["nombre"]."</td>";
                    $link->liberarResultado($resultadoCarrera);
                }

                echo "<td>".$fila["codigo_identidad"]."</td>";
                echo "<td>".$fila["email"]."</td>";
                echo "</tr>";
            }
            $link->liberarResultado($resultado);
        }
    }

    public static function obtenerRegion($link, $codigo_usuario)
    {
        $sql = sprintf("
            SELECT codigo_usuario, codigo_region
            FROM tbl_usuarios
            WHERE codigo_usuario = '%s'",
            stripslashes($codigo_usuario)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $fila = $link->obtenerFila($resultado);
        $region = $fila["codigo_region"];
        $link->liberarResultado($resultado);
        return $region;
    }

    public static function obtenerEstudiante($link, $codigo_usuario)
    {
        $sql = sprintf("
            SELECT codigo_usuario, codigo_region, codigo_carrera, codigo_identidad, nombres, apellidos, fecha_nacimiento, genero, email
            FROM tbl_usuarios
            WHERE codigo_usuario = '%s'",
            stripslashes($codigo_usuario)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $fila = $link->obtenerFila($resultado);
        $link->liberarResultado($resultado);
        return $fila;
    }

    public function modificarEstudiante($link)
    {
        $sql = sprintf("
            UPDATE tbl_usuarios 
            SET codigo_region= '%s', codigo_carrera= '%s', codigo_identidad= '%s', nombres= '%s', apellidos= '%s', fecha_nacimiento= '%s', genero= '%s', email= '%s', clave= sha1('%s'), url_imagen='%s'
            WHERE codigo_usuario = '%s'",
            stripslashes($this->codigo_region),
            stripslashes($this->codigo_carrera),
            stripslashes($this->codigo_identidad),
            stripslashes($this->nombres),
            stripslashes($this->apellidos),
            stripslashes($this->fecha_nacimiento),
            stripslashes($this->genero),
            stripslashes($this->email),
            stripslashes($this->clave),
            stripslashes($this->url_imagen),
            stripslashes($this->codigo_usuario)
        );
        if($link->ejecutarInstruccion($sql))
        {
            echo "Estudiante modificado con exito!";
        }
        else
        {
            echo "Error! No se modifico el estudiante.";
        }
    }
    
}

?>
