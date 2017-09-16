<?php

class Carrera {

	private $codigo_carrera;
	private $codigo_jefe_dept;
	private $nombre;
	private $alias;
	private $regiones;

	function __construct($codigo_carrera, $codigo_jefe_dept, $nombre, $alias, $regiones){
		$this->codigo_carrera = $codigo_carrera;
		$this->codigo_jefe_dept = $codigo_jefe_dept;
		$this->nombre = $nombre;
		$this->alias = $alias;
		$this->regiones = $regiones;
	}

	public function getCodigoCarrera(){
	    return $this->codigo_carrera;
	}
	 
	public function setCodigoCarrera($codigo_carrera){
	    $this->codigo_carrera = $codigo_carrera;
	}
	
	public function getCodigoJefeDept(){
	    return $this->codigo_jefe_dept;
	}
	 
	public function setCodigoJefeDept($codigo_jefe_dept){
	    $this->codigo_jefe_dept = $codigo_jefe_dept;
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

	public function getRegiones(){
	    return $this->regiones;
	}
	 
	public function setRegiones($regiones){
	    $this->regiones = $regiones;
	}

	public static function generarCheckbox($link){
		$resultado = $link->ejecutarInstruccion("
			SELECT codigo_carrera, nombre 
			FROM tbl_carreras
		");

		while ($fila = $link->obtenerFila($resultado)) {
			echo "<label>";
			echo "<input type='checkbox' name='chk-carreras[]' id='chk-carreras' value='".$fila["codigo_carrera"]."'> ";
			echo $fila["nombre"];
			echo "</label><br>";
		}

		$link->liberarResultado($resultado);
	}

	public static function generarSelect($link){
		$resultado = $link->ejecutarInstruccion("
			SELECT codigo_carrera, codigo_jefe_dept, nombre, alias 
			FROM tbl_carreras
		");

		echo '<select class="form-control" id="slc-carrera">';

		while ($fila = $link->obtenerFila($resultado)) {
			echo "<option value='".$fila["codigo_carrera"]."'>";
			echo $fila["nombre"];
			echo "</option>";
		}

		echo '</select>';
	}

	public function agregarCarrera($link){
		$sql = sprintf("
			INSERT INTO tbl_carreras VALUES (NULL, '%s', '%s', '%s');",
			stripslashes($this->codigo_jefe_dept),
			stripslashes($this->nombre),
			stripslashes($this->alias)
		);

		if($link->ejecutarInstruccion($sql))
			echo "Departamento agregado con exito!";
		else{
			echo "Error! No se agrego el departamento.";
			exit;
		}

		$resultado = $link->ejecutarInstruccion("SELECT last_insert_id() as id;");
		$fila = $link->obtenerFila($resultado);

		for ($i=0; $i<count($this->regiones); $i++){
			$sql = sprintf(
				"INSERT INTO tbl_regiones_x_carreras (codigo_region, codigo_carrera) 
				VALUES ('%s','%s')",
				stripslashes($this->regiones[$i]),
				stripslashes($fila["id"])
			);

			$link->ejecutarInstruccion($sql);
		}
		$link->liberarResultado($resultado);
	}

	public static function generarTabla($link){
		$sql = "SELECT a.codigo_carrera, a.codigo_jefe_dept, a.nombre, a.alias, b.codigo_usuario, b.nombres, b.apellidos
			FROM tbl_carreras a
			INNER JOIN tbl_usuarios b
			ON (a.codigo_jefe_dept = b.codigo_usuario)";

		if($resultado = $link->ejecutarInstruccion($sql)){
			while ($fila = $link->obtenerFila($resultado)) {
				echo "<tr>";
				echo "<td><input type='radio' name='rad-carreras' value='".$fila["codigo_carrera"]."'></td>";
				echo "<td>".$fila["nombre"]."</td>";
				echo "<td>".$fila["alias"]."</td>";
				echo "<td>".$fila["nombres"]." ".$fila["apellidos"]."</td>";
				echo "<td>";
				
				$sql = sprintf("SELECT a.codigo_carrera, b.codigo_carrera, b.codigo_region, c.codigo_region, c.alias
					FROM tbl_carreras a
					INNER JOIN tbl_regiones_x_carreras b
					ON (a.codigo_carrera = b.codigo_carrera)
					INNER JOIN tbl_regiones c
					ON (b.codigo_region = c.codigo_region)
					WHERE a.codigo_carrera = '%s'",
					stripslashes($fila["codigo_carrera"]));

				if($resultadoRegiones = $link->ejecutarInstruccion($sql)){
					while ($filaRegiones = $link->obtenerFila($resultadoRegiones))
						echo $filaRegiones["alias"].", ";

					$link->liberarResultado($resultadoRegiones);
				}

				echo "</td>";
				echo "</tr>";
			}
			$link->liberarResultado($resultado);
		}
	}

	public static function verificarIntegridad($link, $nombre, $alias){
		$sql = sprintf("
			SELECT codigo_carrera, nombre, alias
			FROM tbl_carreras
			WHERE nombre = '%s'
			OR alias = '%s'",
			stripslashes($nombre),
			stripslashes($alias)
		);

		return($link->cantidadRegistros($link->ejecutarInstruccion($sql)) == 0);
	}

	public static function verificarModificar($link, $nombre, $alias, $codigo_carrera){
		$sql = sprintf("
			SELECT codigo_carrera, nombre, alias
			FROM tbl_carreras
			WHERE (nombre = '%s' OR alias = '%s')
			AND codigo_carrera != '%s'",
			stripslashes($nombre),
			stripslashes($alias),
			stripslashes($codigo_carrera)
		);

		return($link->cantidadRegistros($link->ejecutarInstruccion($sql)) == 0);
	}

	public function modificarAula($link){
		$sql = sprintf("
			UPDATE tbl_carreras 
			SET codigo_jefe_dept = '%s', nombre= '%s', alias= '%s'
			WHERE codigo_carrera = '%s'",
			stripslashes($this->codigo_jefe_dept),
			stripslashes($this->nombre),
			stripslashes($this->alias),
			stripslashes($this->codigo_carrera)
		);

		if($link->ejecutarInstruccion($sql))
			echo "Edificio modificado con exito!";
		else
			echo "Error! No se modifico el edificio.";
	}

	public static function eliminarCarrera($link, $codigo_carrera){
		$sql = sprintf("
			DELETE FROM tbl_regiones_x_carreras
			WHERE codigo_carrera = '%s'",
			stripslashes($codigo_carrera)
		);

		$link->ejecutarInstruccion($sql);

		$sql = sprintf("
			DELETE FROM tbl_carreras_x_asignaturas
			WHERE codigo_carrera = '%s'",
			stripslashes($codigo_carrera)
		);

		$link->ejecutarInstruccion($sql);

		$sql = sprintf("
			UPDATE tbl_usuarios
			SET codigo_carrera = NULL
			WHERE codigo_carrera = '%s'",
			stripslashes($codigo_carrera)
		);

		$link->ejecutarInstruccion($sql);

		$sql = sprintf("
			DELETE FROM tbl_carreras
			WHERE codigo_carrera = '%s'",
			stripslashes($codigo_carrera)
		);

		$link->ejecutarInstruccion($sql);
	}
	
	public static function obtenerCarrera($link, $codigo_carrera){
		$sql = sprintf("
			SELECT codigo_carrera, codigo_jefe_dept, nombre, alias
			FROM tbl_carreras
			WHERE codigo_carrera = '%s'",
			stripslashes($codigo_carrera)
		);

		return $link->obtenerFila($link->ejecutarInstruccion($sql));
	}	

	public static function obtenerChkCarrera($link, $codigo_carrera){
		$sql = sprintf("
			SELECT codigo_carrera, codigo_region
			FROM tbl_regiones_x_carreras
			WHERE codigo_carrera = '%s'",
			stripslashes($codigo_carrera)
		);

		$resultado = $link->ejecutarInstruccion($sql);
		$regiones = array();

		while ($fila = $link->obtenerFila($resultado))
			$regiones[] = $fila["codigo_region"];

		return $regiones;
	}

	public function modificarCarrera($link){
		$sql = sprintf("
			UPDATE tbl_carreras 
			SET codigo_jefe_dept='%s', nombre='%s', alias='%s'
			WHERE codigo_carrera = '%s'",
			stripslashes($this->codigo_jefe_dept),
			stripslashes($this->nombre),
			stripslashes($this->alias),
			stripslashes($this->codigo_carrera)
		);

		if($link->ejecutarInstruccion($sql))
			echo "Departamento modificado con exito!";
		else{
			echo "Error! No se modifico el departamento.";
			exit;
		}

		$sql = sprintf(
			"DELETE FROM tbl_regiones_x_carreras
			WHERE codigo_carrera = '%s'",
			stripslashes($this->codigo_carrera)						
		);

		$link->ejecutarInstruccion($sql);

		for ($i=0; $i<count($this->regiones); $i++){
			$sql = sprintf("
				INSERT INTO tbl_regiones_x_carreras (codigo_region, codigo_carrera)
				VALUES ('%s','%s')",
				stripslashes($this->regiones[$i]),
				stripslashes($this->codigo_carrera)
			);
			
			$link->ejecutarInstruccion($sql);
		}
	}

}

?>