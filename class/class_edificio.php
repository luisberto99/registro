<?php

class Edificio
{
    
    private $codigo_edificio;
    private $codigo_region;
    private $alias;

    function __construct($codigo_edificio, $codigo_region, $alias)
    {
        $this->codigo_edificio = $codigo_edificio;
        $this->codigo_region = $codigo_region;
        $this->alias = $alias;
    }

    public function getCodigoEdificio()
    {
        return $this->codigo_edificio;
    }
     
    public function setCodigoEdificio($codigo_edificio)
    {
        $this->codigo_edificio = $codigo_edificio;
    }
    
    public function getCodigoRegion()
    {
        return $this->codigo_region;
    }
     
    public function setCodigoRegion($codigo_region)
    {
        $this->codigo_region = $codigo_region;
    }
    
    public function getAlias()
    {
        return $this->alias;
    }
     
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    public static function generarSelect($link)
    {
        $sql = "SELECT a.codigo_edificio, a.codigo_region, a.alias, b.codigo_region, b.nombre
            FROM tbl_edificios a
            INNER JOIN tbl_regiones b
            ON (a.codigo_region = b.codigo_region)";

        $resultado = $link->ejecutarInstruccion($sql);
        echo '<select class="form-control" id="slc-edificio">';
        while ($fila = $link->obtenerFila($resultado))
        {
            echo "<option value='".$fila["codigo_edificio"]."'>";
            echo $fila["nombre"]." | ".$fila["alias"];
            echo "</option>";
        }
        echo '</select>';
        $link->liberarResultado($resultado);
    }

    public function agregarEdificio($link)
    {
        $sql = sprintf(
            "INSERT INTO tbl_edificios VALUES (%s, '%s', '%s');",
            stripslashes($this->codigo_edificio),
            stripslashes($this->codigo_region),
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

    public static function verificarIntegridad($link, $alias, $codigo_region)
    {
        $sql = sprintf(
            "SELECT codigo_region, alias
            FROM tbl_edificios
            WHERE (alias = '%s' AND codigo_region = '%s')",
            stripslashes($alias),
            stripslashes($codigo_region)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $registros  = $link->cantidadRegistros();
        $link->liberarResultado($resultado);
        return ($registros == 0);
    }

    public static function verificarModificar($link, $alias, $codigo_region, $codigo_edificio)
    {
        $sql = sprintf(
            "SELECT codigo_edificio, codigo_region, alias
            FROM tbl_edificios
            WHERE (alias = '%s' AND codigo_edificio = '%s')
            AND codigo_edificio != '%s'",
            stripslashes($alias),
            stripslashes($codigo_region),
            stripslashes($codigo_edificio)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $registros  = $link->cantidadRegistros();
        $link->liberarResultado($resultado);
        return ($registros == 0);
    }

    public static function generarTabla($link)
    {
        $sql = "SELECT a.codigo_edificio, a.codigo_region, a.alias, b.codigo_region, b.nombre
            FROM tbl_edificios a
            INNER JOIN tbl_regiones b
            ON (a.codigo_region = b.codigo_region)";
        $resultado = $link->ejecutarInstruccion($sql);
        while ($fila = $link->obtenerFila($resultado))
        {
            echo "<tr>";
            echo "<td><input type='radio' name='rad-edificios' value='".$fila["codigo_edificio"]."'></td>";
            echo "<td>".$fila["alias"]."</td>";
            echo "<td>".$fila["nombre"]."</td>";
            echo "</tr>";
        }
        $link->liberarResultado($resultado);
    }

    public static function eliminarEdificio($link, $codigo_edificio)
    {
        //Eliminar todas las aulas que estan en el edificio
        $sql = sprintf(
            "SELECT codigo_aula, codigo_edificio 
            FROM tbl_aulas
            WHERE codigo_edificio = '%s'",
            stripslashes($codigo_edificio)
        );
        if($resultado = $link->ejecutarInstruccion($sql))
        {
            while ($fila = $link->obtenerFila($resultado))
            {
                Aula::eliminarAula($link, $fila["codigo_aula"]);
            }
            $link->liberarResultado($resultado);
        }

        //Eliminar el edificio
        $sql = sprintf(
            "DELETE FROM tbl_edificios
            WHERE codigo_edificio = '%s'",
            stripslashes($codigo_edificio)
        );
        $link->ejecutarInstruccion($sql);
    }

    public static function obtenerEdificio($link, $codigo_edificio)
    {
        $sql = sprintf(
            "SELECT codigo_edificio, codigo_region, alias 
            FROM tbl_edificios
            WHERE codigo_edificio = '%s'",
            stripslashes($codigo_edificio)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $fila = $link->obtenerFila($resultado);
        $link->liberarResultado($resultado);
        return $fila;
    }

    public function modificarEdificio($link)
    {
        $sql = sprintf(
            "UPDATE tbl_edificios 
            SET codigo_region= '%s', alias= '%s'
            WHERE codigo_edificio = '%s'",
            stripslashes($this->codigo_region),
            stripslashes($this->alias),
            stripslashes($this->codigo_edificio)
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
