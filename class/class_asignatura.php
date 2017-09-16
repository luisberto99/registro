<?php

class Asignatura {
	
	private $codigo_asignatura;
	private $nombre;
	private $alias;
	private $UV;
	private $carreras;

	function __construct($codigo_asignatura, $nombre, $alias, $UV, $carreras){
		$this->codigo_asignatura = $codigo_asignatura;
		$this->nombre = $nombre;
		$this->alias = $alias;
		$this->UV = $UV;
		$this->carreras = $carreras;
	}

	public function getCodigoAsignatura(){
	    return $this->codigo_asignatura;
	}
	 
	public function setCodigoAsignatura($codigo_asignatura){
	    $this->codigo_asignatura = $codigo_asignatura;
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
	
	public function getUV(){
	    return $this->UV;
	}
	 
	public function setUV($UV){
	    $this->UV = $UV;
	}

	public function getCarreras(){
	    return $this->carreras;
	}
	 
	public function setCarreras($carreras){
	    $this->carreras = $carreras;
	}

	public static function generarSelect($link){
		$sql = "SELECT codigo_asignatura, nombre, alias, UV
			FROM tbl_asignaturas";

		if($resultado = $link->ejecutarInstruccion($sql)){
			echo "<select class='form-control' id='slc-asignatura'>";

			while ($fila = $link->obtenerFila($resultado)) {
				$sql = sprintf("
					SELECT a.codigo_asignatura, a.nombre, b.codigo_asignatura, b.codigo_carrera, c.codigo_carrera, c.alias
					FROM tbl_asignaturas a
					INNER JOIN tbl_carreras_x_asignaturas b
					ON (a.codigo_asignatura = b.codigo_asignatura)
					INNER JOIN tbl_carreras c
					ON (b.codigo_carrera = c.codigo_carrera)
					WHERE a.codigo_asignatura = '%s'",
					stripslashes($fila["codigo_asignatura"])
				);

				echo "<option value='".$fila["codigo_asignatura"]."'>";

				if($resultadoCarreras = $link->ejecutarInstruccion($sql)){

					while ($filaCarreras = $link->obtenerFila($resultadoCarreras))
						echo $filaCarreras["alias"].", ";

					echo "| ";
					$link->liberarResultado($resultadoCarreras);
				}
				echo $fila["nombre"];
				echo "</option>";

			}
			echo "</select>";
			$link->liberarResultado($resultado);
		}

	}

	public static function eliminarAsignatura($link, $codigo_asignatura){
		$sql = sprintf("
			DELETE FROM tbl_carreras_x_asignaturas
			WHERE codigo_asignatura = '%s'",
			stripslashes($codigo_asignatura)
		);

		$link->ejecutarInstruccion($sql);

		$sql = sprintf("
			SELECT codigo_calificacion, codigo_asignatura
			FROM tbl_calificaciones
			WHERE codigo_asignatura = '%s'",
			stripslashes($codigo_asignatura)
		);

		if($resultado = $link->ejecutarInstruccion($sql)){

			while ($fila = $link->obtenerFila($resultado))
				Calificacion::eliminarCalificacion($link, $fila["codigo_calificacion"]);

			$link->liberarResultado($resultado);
		}

		$sql = sprintf("
			SELECT codigo_seccion, codigo_asignatura
			FROM tbl_secciones
			WHERE codigo_asignatura = '%s'",
			stripslashes($codigo_asignatura)
		);

		if ($resultado = $link->ejecutarInstruccion($sql)) {
			
			while ($fila = $link->obtenerFila($resultado))
				Seccion::eliminarSeccion($link, $fila["codigo_seccion"]);

			$link->liberarResultado($resultado);
		}

		$sql = sprintf("
			DELETE FROM tbl_asignaturas
			WHERE codigo_asignatura = '%s'",
			stripslashes($codigo_asignatura)
		);

		$link->ejecutarInstruccion($sql);
	}

	public static function generarTabla($link){
		$sql = "SELECT codigo_asignatura, nombre, alias, UV
			FROM tbl_asignaturas";

		if($resultado = $link->ejecutarInstruccion($sql)){
			while ($fila = $link->obtenerFila($resultado)) {
				echo "<tr>";
				echo "<td><input type='radio' name='rad-asignaturas' value='".$fila["codigo_asignatura"]."'></td>";
				echo "<td>".$fila["alias"]."</td>";
				echo "<td>".$fila["nombre"]."</td>";
				echo "<td>".$fila["UV"]."</td>";

				echo "<td>";
				
				$sql = sprintf("SELECT a.codigo_asignatura, a.codigo_carrera, b.codigo_asignatura, c.codigo_carrera, c.alias
					FROM tbl_carreras_x_asignaturas a
					INNER JOIN tbl_asignaturas b
					ON (a.codigo_asignatura = b.codigo_asignatura)
					INNER JOIN tbl_carreras c
					ON (a.codigo_carrera = c.codigo_carrera)
					WHERE a.codigo_asignatura = '%s'",
					stripslashes($fila["codigo_asignatura"]));

				if($resultadoCarreras = $link->ejecutarInstruccion($sql)){

					while ($filaCarreras = $link->obtenerFila($resultadoCarreras))
						echo $filaCarreras["alias"].", ";
					$link->liberarResultado($resultadoCarreras);
				}

				echo "</td>";
				echo "</tr>";
			}

			$link->liberarResultado($resultado);
		}
	}

	public static function verificarIntegridad($link, $nombre, $alias){
		$sql = sprintf("
			SELECT codigo_asignatura, nombre, alias
			FROM tbl_asignaturas
			WHERE nombre = '%s'
			AND alias = '%s'",
			stripslashes($nombre),
			stripslashes($alias)
		);

		return($link->cantidadRegistros($link->ejecutarInstruccion($sql)) == 0);
	}

	public static function verificarModificar($link, $nombre, $alias, $codigo_asignatura){
		$sql = sprintf("
			SELECT codigo_asignatura, nombre, alias
			FROM tbl_asignaturas
			WHERE (nombre = '%s' AND alias = '%s')
			AND codigo_asignatura != '%s'",
			stripslashes($nombre),
			stripslashes($alias),
			stripslashes($codigo_asignatura)
		);

		return($link->cantidadRegistros($link->ejecutarInstruccion($sql)) == 0);
	}

	public function agregarAsignatura($link){
		$sql = sprintf("
			INSERT INTO tbl_asignaturas
			VALUES (NULL, '%s', '%s', '%s')",
			stripslashes($this->nombre),
			stripslashes($this->alias),
			stripslashes($this->UV)
		);

		if($link->ejecutarInstruccion($sql))
			echo "Asignatura agregada con exito!";
		else{
			echo "Error! No se agrego la asignatura.";
			exit;
		}

		$resultado = $link->ejecutarInstruccion("SELECT last_insert_id() as id;");
		$fila = $link->obtenerFila($resultado);

		for ($i=0; $i<count($this->carreras); $i++){
			$sql = sprintf(
				"INSERT INTO tbl_carreras_x_asignaturas (codigo_asignatura, codigo_carrera) 
				VALUES ('%s','%s')",
				stripslashes($fila["id"]),						
				stripslashes($this->carreras[$i])
			);

			$link->ejecutarInstruccion($sql);
		}
		$link->liberarResultado($resultado);
	}

	public function modificarAsignatura($link){
		$sql = sprintf("
			UPDATE tbl_asignaturas
			SET nombre='%s', alias='%s', UV='%s'
			WHERE codigo_asignatura = '%s'",
			stripslashes($this->nombre),
			stripslashes($this->alias),
			stripslashes($this->UV),
			stripslashes($this->codigo_asignatura)
		);

		if($link->ejecutarInstruccion($sql))
			echo "Asignatura modificada con exito!";
		else{
			echo "Error! No se modifico la asignatura.";
			exit;
		}

		$sql = sprintf(
			"DELETE FROM tbl_carreras_x_asignaturas
			WHERE codigo_asignatura = '%s'",
			stripslashes($this->codigo_asignatura)
		);

		$link->ejecutarInstruccion($sql);

		for ($i=0; $i<count($this->carreras); $i++){
			$sql = sprintf(
				"INSERT INTO tbl_carreras_x_asignaturas (codigo_carrera, codigo_asignatura)
				VALUES ('%s', '%s')",
				stripslashes($this->carreras[$i]),
				stripslashes($this->codigo_asignatura)
			);

			$link->ejecutarInstruccion($sql);
		}
	}

	public static function obtenerAsignatura($link, $codigo_asignatura){
		$sql = sprintf("
			SELECT codigo_asignatura, nombre, alias, UV
			FROM tbl_asignaturas
			WHERE codigo_asignatura = '%s'",
			stripslashes($codigo_asignatura)
		);

		return $link->obtenerFila($link->ejecutarInstruccion($sql));
	}	

	public static function obtenerChkAsignatura($link, $codigo_asignatura){
		$sql = sprintf("
			SELECT codigo_asignatura, codigo_carrera
			FROM tbl_carreras_x_asignaturas
			WHERE codigo_asignatura = '%s'",
			stripslashes($codigo_asignatura)
		);

		if($resultado = $link->ejecutarInstruccion($sql)){
			$regiones = array();

			while ($fila = $link->obtenerFila($resultado))
				$regiones[] = $fila["codigo_carrera"];

			$link->liberarResultado($resultado);
			return $regiones;
		} else {
			echo "Error! No se pudieron obtener las Asignaturas.";
		}
	}
}

?>