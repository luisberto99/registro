<?php

class Usuario 
{
    
    protected $codigo_usuario;
    protected $codigo_tipo_usuario;
    protected $codigo_identidad;
    protected $nombres;
    protected $apellidos;
    protected $fecha_nacimiento;
    protected $genero;
    protected $email;
    protected $clave;
    protected $url_imagen;

    function __construct($codigo_usuario, $codigo_tipo_usuario, $codigo_identidad, $nombres, $apellidos, $fecha_nacimiento, $genero, $email, $clave, $url_imagen)
    {
        $this->codigo_usuario = $codigo_usuario;
        $this->codigo_tipo_usuario = $codigo_tipo_usuario;
        $this->codigo_identidad = $codigo_identidad;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->genero = $genero;
        $this->email = $email;
        $this->clave = $clave;
        $this->url_imagen = $url_imagen;
    }

    public function getCodigoUsuario()
    {
        return $this->codigo_usuario;
    }
     
    public function setCodigoUsuario($codigo_usuario)
    {
        $this->codigo_usuario = $codigo_usuario;
    }
    
    public function getCodigoTipoUsuario()
    {
        return $this->codigo_tipo_usuario;
    }
     
    public function setCodigoTipoUsuario($codigo_tipo_usuario)
    {
        $this->codigo_tipo_usuario = $codigo_tipo_usuario;
    }
    
    public function getCodigoIdentidad(){
        return $this->codigo_identidad;
    }
     
    public function setCodigoIdentidad($codigo_identidad)
    {
        $this->codigo_identidad = $codigo_identidad;
    }
    
    public function getNombres()
    {
        return $this->nombres;
    }
     
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }
    
    public function getApellidos()
    {
        return $this->apellidos;
    }
     
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }
    
    public function getFechaNacimiento()
    {
        return $this->fecha_nacimiento;
    }
     
    public function setFechaNacimiento($fecha_nacimiento)
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }
    
    public function getGenero()
    {
        return $this->genero;
    }
     
    public function setGenero($genero)
    {
        $this->genero = $genero;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
     
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getClave()
    {
        return $this->clave;
    }
     
    public function setClave($clave)
    {
        $this->clave = $clave;
    }

    public function getFotografia()
    {
        return $this->url_imagen;
    }
     
    public function setFotografia($url_imagen)
    {
        $this->url_imagen = $url_imagen;
    }
    
    public function agregarUsuario($link)
    {
        $sql = sprintf(
            "INSERT INTO tbl_usuarios VALUES (NULL, '%s', NULL, NULL, '%s', '%s', '%s', '%s', '%s', '%s', sha1('%s'), '%s');",
            stripslashes($this->codigo_tipo_usuario),
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
            echo "Usuario agregado con exito!";
        }
        else
        {
            echo "Error! No se agrego el usuario.";
        }
    }

    public static function verificarIntegridad($link, $codigo_identidad, $email)
    {
        $sql = sprintf(
            "SELECT codigo_identidad, email
            FROM tbl_usuarios
            WHERE codigo_identidad = '%s'
            OR email = '%s'",
            stripslashes($codigo_identidad),
            stripslashes($email)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $registros = $link->cantidadRegistros($resultado);
        $link->liberarResultado($resultado);
        return ($registros == 0);
    }

    public static function verificarModificar($link, $codigo_identidad, $email, $codigo_usuario)
    {
        $sql = sprintf(
            "SELECT codigo_usuario, codigo_identidad, email
            FROM tbl_usuarios
            WHERE (codigo_identidad = '%s' OR email = '%s')
            AND codigo_usuario != '%s'",
            stripslashes($codigo_identidad),
            stripslashes($email),
            stripslashes($codigo_usuario)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $registros = $link->cantidadRegistros($resultado);
        $link->liberarResultado($resultado);
        return ($registros == 0);
    }

    public static function verificarUsuario($link, $email, $clave)
    {
        $sql = sprintf(
            "SELECT codigo_usuario, codigo_tipo_usuario, nombres, apellidos, email, clave, url_imagen
            FROM tbl_usuarios
            WHERE email = '%s'
            AND clave = sha1('%s')",
            stripslashes($email),
            stripslashes($clave)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        if ($link->cantidadRegistros($resultado) > 0)
        {
            $fila = $link->obtenerFila($resultado);
            $respuesta = array(
                "existe" => true,
                "codigo_usuario" => $fila["codigo_usuario"],
                "codigo_tipo_usuario" => $fila["codigo_tipo_usuario"],
                "nombres" => $fila["nombres"],
                "apellidos" => $fila["apellidos"],
                "url_imagen" => $fila["url_imagen"]
            );
        }
        else
        {
            $respuesta = array( "existe" => false );
        }
        $link->liberarResultado($resultado);
        return $respuesta;
    }

    public static function generarUsuarios($link)
    {
        $resultado = $link->ejecutarInstruccion("
            SELECT a.codigo_usuario, a.codigo_tipo_usuario, a.codigo_identidad, a.nombres, a.apellidos, a.fecha_nacimiento, a.genero, a.email, a.url_imagen, b.codigo_tipo_usuario, b.tipo_usuario
            FROM tbl_usuarios a
            INNER JOIN tbl_tipos_usuarios b
            ON a.codigo_tipo_usuario = b.codigo_tipo_usuario
            WHERE b.tipo_usuario != 'Estudiante'
        ");
        while ($fila = $link->obtenerFila($resultado))
        {
            echo "<tr>";
            echo "<td><input type='radio' name='rad-usuarios' value='".$fila["codigo_usuario"]."'></td>";
            echo "<td><img src='".$fila["url_imagen"]."' height='32' width='32'></td>";
            echo "<td>".$fila["nombres"]."</td>";
            echo "<td>".$fila["apellidos"]."</td>";
            echo "<td>".$fila["fecha_nacimiento"]."</td>";
            echo "<td>".$fila["genero"]."</td>";
            echo "<td>".$fila["tipo_usuario"]."</td>";
            echo "<td>".$fila["codigo_identidad"]."</td>";
            echo "<td>".$fila["email"]."</td>";
            echo "</tr>";
        }
        $link->liberarResultado($resultado);
    }

    public static function selectJefes($link)
    {
        $sql = "SELECT a.codigo_usuario, a.codigo_tipo_usuario, a.nombres, a.apellidos, b.codigo_tipo_usuario, b.tipo_usuario
            FROM tbl_usuarios a
            INNER JOIN tbl_tipos_usuarios b
            ON (a.codigo_tipo_usuario = b.codigo_tipo_usuario)
            WHERE b.tipo_usuario = 'Jefe de departamento'";
        if($resultado = $link->ejecutarInstruccion($sql))
        {
            echo "<select class='form-control' id='slc-jefe'>";
            while ($fila = $link->obtenerFila($resultado))
            {
                echo "<option value='".$fila["codigo_usuario"]."'>";
                echo $fila["nombres"]." ".$fila["apellidos"];
                echo "</option>";
            }
            echo '</select>';
            $link->liberarResultado($resultado);
        }
    }

    public static function selectCatedraticos($link)
    {
        $sql = "SELECT a.codigo_usuario, a.codigo_tipo_usuario, a.nombres, a.apellidos, b.codigo_tipo_usuario, b.tipo_usuario
            FROM tbl_usuarios a
            INNER JOIN tbl_tipos_usuarios b
            ON (a.codigo_tipo_usuario = b.codigo_tipo_usuario)
            WHERE b.tipo_usuario = 'Catedratico'";
        if($resultado = $link->ejecutarInstruccion($sql))
        {
            echo "<select class='form-control' id='slc-catedratico'>";
            while ($fila = $link->obtenerFila($resultado))
            {
                echo "<option value='".$fila["codigo_usuario"]."'>";
                echo $fila["nombres"]." ".$fila["apellidos"];
                echo "</option>";
            }
            echo '</select>';
            $link->liberarResultado($resultado);
        }
    }

    public static function eliminarUsuario($link, $codigo_usuario)
    {
        //Eliminar los cupos que tiene el usuario
        $sql = sprintf(
            "DELETE FROM tbl_secciones_x_usuarios
            WHERE codigo_usuario = '%s'",
            stripslashes($codigo_usuario)
        );
        $link->ejecutarInstruccion($sql);

        //Eliminar los departamentos que involucran al usuario
        $sql = sprintf(
            "SELECT codigo_carrera, codigo_jefe_dept
            FROM tbl_carreras
            WHERE codigo_jefe_dept = '%s'",
            stripslashes($codigo_usuario)
        );
        if($resultado = $link->ejecutarInstruccion($sql))
        {
            while ($fila = $link->obtenerFila($resultado))
            {
                Carrera::eliminarCarrera($link, $fila["codigo_carrera"]);
            }
            $link->liberarResultado($resultado);
        }

        //Eliminar las secciones donde el usuario es catedratico
        $sql = sprintf(
            "SELECT codigo_seccion, codigo_catedratico
            FROM tbl_secciones
            WHERE codigo_catedratico = '%s'",
            stripslashes($codigo_usuario)
        );
        if($resultado = $link->ejecutarInstruccion($sql))
        {
            while ($fila = $link->obtenerFila($resultado))
            {
                Seccion::eliminarSeccion($link, $fila["codigo_seccion"]);
            }
            $link->liberarResultado($resultado);
        }

        //Eliminar el usuario
        $sql = sprintf(
            "DELETE FROM tbl_usuarios
            WHERE codigo_usuario = '%s'",
            stripslashes($codigo_usuario)
        );
        $link->ejecutarInstruccion($sql);
    }

    public static function obtenerUsuario($link, $codigo_usuario)
    {
        $sql = sprintf(
            "SELECT codigo_usuario, codigo_tipo_usuario, codigo_identidad, nombres, apellidos, fecha_nacimiento, genero, email 
            FROM tbl_usuarios
            WHERE codigo_usuario = '%s'",
            stripslashes($codigo_usuario)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $fila = $link->obtenerFila($resultado);
        $link->liberarResultado($resultado);
        return $fila;
    }

    public function modificarUsuario($link)
    {
        $sql = sprintf(
            "UPDATE tbl_usuarios 
            SET codigo_tipo_usuario= '%s', codigo_identidad= '%s', nombres= '%s', apellidos= '%s', fecha_nacimiento= '%s', genero= '%s', email= '%s', url_imagen= '%s', clave= sha1('%s') 
            WHERE codigo_usuario = '%s'",
            stripslashes($this->codigo_tipo_usuario),
            stripslashes($this->codigo_identidad),
            stripslashes($this->nombres),
            stripslashes($this->apellidos),
            stripslashes($this->fecha_nacimiento),
            stripslashes($this->genero),
            stripslashes($this->email),
            stripslashes($this->url_imagen),
            stripslashes($this->clave),
            stripslashes($this->codigo_usuario)
        );
        if($link->ejecutarInstruccion($sql))
        {
            echo "Usuario modificado con exito!";
        }
        else
        {
            echo "Error! No se modifico el usuario.";
        }
    }

}

?>
