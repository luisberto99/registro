<?php

class Aula
{
    
    private $codigo_aula; 
    private $codigo_edificio; 
    private $capacidad; 
    private $alias;  

    function __construct($codigo_aula, $codigo_edificio, $capacidad, $alias)
    {
        $this->codigo_aula = $codigo_aula;
        $this->codigo_edificio = $codigo_edificio;
        $this->capacidad = $capacidad;
        $this->alias = $alias;
    }

    public function getCodigoAula()
    {
        return $this->codigo_aula;
    }
     
    public function setCodigoAula($codigo_aula)
    {
        $this->codigo_aula = $codigo_aula;
    }
    
    public function getCodigoEdificio()
    {
        return $this->codigo_edificio;
    }
     
    public function setCodigoEdificio($codigo_edificio)
    {
        $this->codigo_edificio = $codigo_edificio;
    }
    
    public function getCapacidad()
    {
        return $this->capacidad;
    }
     
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;
    }
    
    public function getAlias()
    {
        return $this->alias;
    }
     
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    public static function generarTabla($link)
    {
        $sql = "SELECT a.codigo_aula, a.codigo_edificio, a.alias AS alias_aula, a.capacidad, b.codigo_edificio, b.codigo_region, b.alias AS alias_edificio, c.codigo_region, c.alias AS alias_region
            FROM tbl_aulas a
            INNER JOIN tbl_edificios b
            ON (a.codigo_edificio = b.codigo_edificio)
            INNER JOIN tbl_regiones c
            ON (b.codigo_region = c.codigo_region)";
        $resultado = $link->ejecutarInstruccion($sql);
        while ($fila = $link->obtenerFila($resultado))
        {
            echo "<tr>";
            echo "<td><input type='radio' name='rad-aulas' value='".$fila["codigo_aula"]."'></td>";
            echo "<td>".$fila["alias_aula"]."</td>";
            echo "<td>".$fila["alias_edificio"]."</td>";
            echo "<td>".$fila["alias_region"]."</td>";
            echo "<td>".$fila["capacidad"]."</td>";
            echo "</tr>";
        }
        $link->liberarResultado($resultado);
    }

    public static function generarSelect($link)
    {
        $sql = "SELECT a.codigo_aula, a.codigo_edificio, a.alias AS alias_aula, b.codigo_edificio, b.codigo_region, b.alias AS alias_edificio, c.codigo_region, c.alias AS alias_region
            FROM tbl_aulas a
            INNER JOIN tbl_edificios b
            ON (a.codigo_edificio = b.codigo_edificio)
            INNER JOIN tbl_regiones c
            ON (b.codigo_region = c.codigo_region)";
        if($resultado = $link->ejecutarInstruccion($sql))
        {
            echo "<select class='form-control' id='slc-aula'>";
            while ($fila = $link->obtenerFila($resultado))
            {
                echo "<option value='".$fila["codigo_aula"]."'>";
                echo $fila["alias_region"]." | ".$fila["alias_edificio"]." | ".$fila["alias_aula"];
                echo "</option>";
            }
            echo "</select>";
            $link->liberarResultado($resultado);
        }
    }

    public function agregarAula($link)
    {
        $sql = sprintf(
            "INSERT INTO tbl_aulas VALUES (NULL, '%s', '%s', '%s');",
            stripslashes($this->codigo_edificio),
            stripslashes($this->capacidad),
            stripslashes($this->alias)
        );
        if($link->ejecutarInstruccion($sql))
        {
            echo "Edificio agregado con exito!";
        }
        else
        {
            echo "Error! No se agrego el edificio.";
        }
    }

    public static function obtenerAula($link, $codigo_aula)
    {
        $sql = sprintf(
            "SELECT a.codigo_aula, a.codigo_edificio, a.capacidad, a.alias, b.codigo_edificio, b.codigo_region
            FROM tbl_aulas a
            INNER JOIN tbl_edificios b
            ON (a.codigo_edificio = b.codigo_edificio)
            WHERE codigo_aula = '%s'",
            stripslashes($codigo_aula)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $fila = $link->obtenerFila($resultado);
        $link->liberarResultado($resultado);
        return $fila;
    }

    public static function eliminarAula($link, $codigo_aula)
    {
        //Eliminar las secciones que usan esta aula
        $sql = sprintf(
            "SELECT codigo_seccion, codigo_aula
            FROM tbl_secciones
            WHERE codigo_aula = '%s'",
            stripslashes($codigo_aula)
        );
        if($resultado = $link->ejecutarInstruccion($sql))
        {
            while ($fila = $link->obtenerFila($resultado))
            {
                Seccion::eliminarSeccion($link, $fila["codigo_seccion"]);
            }
            $link->liberarResultado($resultado);
        }

        //Eliminar el aula
        $sql = sprintf(
            "DELETE FROM tbl_aulas
            WHERE codigo_aula = '%s'",
            stripslashes($codigo_aula)
        );
        $link->ejecutarInstruccion($sql);
    }

    public static function verificarIntegridad($link, $alias, $codigo_edificio)
    {
        $sql = sprintf("
            SELECT alias, codigo_edificio
            FROM tbl_aulas
            WHERE (alias = '%s' AND codigo_edificio = '%s')",
            stripslashes($alias),
            stripslashes($codigo_edificio)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $registros = $link->cantidadRegistros($resultado);
        $link->liberarResultado($resultado);
        return ($registros == 0);
    }

    public static function verificarModificar($link, $alias, $codigo_edificio, $codigo_aula)
    {
        $sql = sprintf(
            "SELECT codigo_aula, codigo_edificio, alias
            FROM tbl_aulas
            WHERE (alias = '%s' AND codigo_edificio = '%s')
            AND codigo_aula != '%s'",
            stripslashes($alias),
            stripslashes($codigo_edificio),
            stripslashes($codigo_aula)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $registros = $link->cantidadRegistros($resultado);
        $link->liberarResultado($resultado);
        return ($registros == 0);
    }

    public function modificarAula($link)
    {
        $sql = sprintf(
            "UPDATE tbl_aulas 
            SET codigo_edificio= '%s', alias= '%s', capacidad = '%s'
            WHERE codigo_aula = '%s'",
            stripslashes($this->codigo_edificio),
            stripslashes($this->alias),
            stripslashes($this->capacidad),
            stripslashes($this->codigo_aula)
        );
        if($link->ejecutarInstruccion($sql))
        {
            echo "Edificio modificado con exito!";
        }
        else
        {
            echo "Error! No se modifico el edificio.";
        }
    }

}

?>
