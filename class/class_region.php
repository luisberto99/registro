<?php

class Region {
	
	private $codigo_region;
	private $nombre;
	private $alias;

	function __construct($codigo_region, $nombre, $alias){
		$this->codigo_region = $codigo_region;
		$this->nombre = $nombre;
		$this->alias = $alias;
	}

	public function getCodigoRegion(){
	    return $this->codigo_region;
	}
	 
	public function setCodigoRegion($codigo_region){
	    $this->codigo_region = $codigo_region;
	}
	
	public function getNombre(){
	    return $this->nombre;
	}
	 
	public function setNombre($nombre){
	    $this->nombre = $nombre;
	}
	
	public function getAlias(){
	    return $this->alias;
	}
	 
	public function setAlias($alias){
	    $this->alias = $alias;
	}

	public static function generarSelect($link){
		$resultado = $link->ejecutarInstruccion("
			SELECT codigo_region, nombre, alias 
			FROM tbl_regiones
		");

		echo '<select class="form-control" id="slc-region">';

		while ($fila = $link->obtenerFila($resultado)) {
			echo "<option value='".$fila["codigo_region"]."'>";
			echo $fila["nombre"];
			echo "</option>";
		}

		echo '</select>';
	}

	public static function generarCheckbox($link){
		$resultado = $link->ejecutarInstruccion("
			SELECT codigo_region, nombre 
			FROM tbl_regiones
		");

		while ($fila = $link->obtenerFila($resultado)) {
			echo "<label>";
			echo "<input type='checkbox' name='chk-regiones[]' id='chk-regiones' value='".$fila["codigo_region"]."'> ";
			echo $fila["nombre"];
			echo "</label><br>";
		}

		$link->liberarResultado($resultado);
	}

	public function agregarRegion($link){
		$sql = sprintf("
			INSERT INTO tbl_regiones VALUES (%s, '%s', '%s');",
			stripslashes($this->codigo_region),
			stripslashes($this->nombre),
			stripslashes($this->alias)
		);

		if($link->ejecutarInstruccion($sql))
			echo "Region agregada con exito!";
		else
			echo "Error! No se agrego la region.";
	}

	public static function verificarIntegridad($link, $nombre, $alias){
		$sql = sprintf("
			SELECT nombre, alias
			FROM tbl_regiones
			WHERE nombre = '%s'
			OR alias = '%s'",
			stripslashes($nombre),
			stripslashes($alias)
		);

		return ($link->cantidadRegistros($link->ejecutarInstruccion($sql)) == 0);
	}

	public static function verificarModificar($link, $nombre, $alias, $codigo_region){
		$sql = sprintf("
			SELECT codigo_region, nombre, alias
			FROM tbl_regiones
			WHERE (nombre = '%s' OR alias = '%s')
			AND codigo_region != '%s'",
			stripslashes($nombre),
			stripslashes($alias),
			stripslashes($codigo_region)
		);

		return ($link->cantidadRegistros($link->ejecutarInstruccion($sql)) == 0);
	}

	public static function generarTabla($link){
		$resultado = $link->ejecutarInstruccion("
			SELECT codigo_region, nombre, alias
			FROM tbl_regiones
		");

		while ($fila = $link->obtenerFila($resultado)) {
			echo "<tr>";
			echo "<td><input type='radio' name='rad-regiones' value='".$fila["codigo_region"]."'></td>";
			echo "<td>".$fila["nombre"]."</td>";
			echo "<td>".$fila["alias"]."</td>";
			echo "</tr>";
		}

		$link->liberarResultado($resultado);
	}

	public static function eliminarRegion($link, $codigo_region){
		$sql = sprintf("
			DELETE FROM tbl_regiones_x_carreras
			WHERE codigo_region = '%s'",
			stripslashes($codigo_region)
		);

		$link->ejecutarInstruccion($sql);

		$sql = sprintf("
			UPDATE tbl_usuarios
			SET codigo_region = NULL
			WHERE codigo_region = '%s'",
			stripslashes($codigo_region)
		);

		$link->ejecutarInstruccion($sql);

		$sql = sprintf("
			SELECT codigo_edificio, codigo_region
			FROM tbl_edificios
			WHERE codigo_region = '%s'",
			stripslashes($codigo_region)
		);

		if($resultado = $link->ejecutarInstruccion($sql)){

			while ($fila = $link->obtenerFila($resultado))
				Edificio::eliminarEdificio($link, $fila["codigo_edificio"]);

			$link->liberarResultado($resultado);
		}

		$sql = sprintf("
			DELETE FROM tbl_regiones
			WHERE codigo_region = '%s'",
			stripslashes($codigo_region)
		);

		$link->ejecutarInstruccion($sql);
	}

	public static function obtenerRegion($link, $codigo_region){
		$sql = sprintf("
			SELECT codigo_region, nombre, alias 
			FROM tbl_regiones
			WHERE codigo_region = '%s'
		",
			stripslashes($codigo_region)
		);

		return $link->obtenerFila($link->ejecutarInstruccion($sql));
	}

	public function modificarRegion($link){
		$sql = sprintf("
			UPDATE tbl_regiones 
			SET nombre= '%s', alias= '%s'
			WHERE codigo_region = '%s'",
			stripslashes($this->nombre),
			stripslashes($this->alias),
			stripslashes($this->codigo_region)
		);

		if($link->ejecutarInstruccion($sql))
			echo "Region modificada con exito!";
		else
			echo "Error! No se modifico la region.";
	}

}

?>