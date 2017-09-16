<?php

class Seccion {
	
	private $codigo_seccion;
	private $codigo_tipo_seccion;
	private $codigo_asignatura;
	private $codigo_aula;
	private $codigo_horario;
	private $codigo_catedratico;
	private $codigo_hi;
	private $cupos_disponibles;

	function __construct($codigo_seccion, $codigo_tipo_seccion, $codigo_asignatura, $codigo_aula, $codigo_horario, $codigo_catedratico, $codigo_hi, $cupos_disponibles){
		$this->codigo_seccion = $codigo_seccion;
		$this->codigo_tipo_seccion = $codigo_tipo_seccion;
		$this->codigo_asignatura = $codigo_asignatura;
		$this->codigo_aula = $codigo_aula;
		$this->codigo_horario = $codigo_horario;
		$this->codigo_catedratico = $codigo_catedratico;
		$this->codigo_hi = $codigo_hi;
		$this->cupos_disponibles = $cupos_disponibles;
	}

	public function getCodigoSeccion(){
	    return $this->codigo_seccion;
	}
	 
	public function setCodigoSeccion($codigo_seccion){
	    $this->codigo_seccion = $codigo_seccion;
	}
	
	public function getCodigoTipoSeccion(){
	    return $this->codigo_tipo_seccion;
	}
	 
	public function setCodigoTipoSeccion($codigo_tipo_seccion){
	    $this->codigo_tipo_seccion = $codigo_tipo_seccion;
	}
	
	public function getCodigoAsignatura(){
	    return $this->codigo_asignatura;
	}
	 
	public function setCodigoAsignatura($codigo_asignatura){
	    $this->codigo_asignatura = $codigo_asignatura;
	}
	
	public function getCodigoAula(){
	    return $this->codigo_aula;
	}
	 
	public function setCodigoAula($codigo_aula){
	    $this->codigo_aula = $codigo_aula;
	}
	
	public function getCodigoHorario(){
	    return $this->codigo_horario;
	}
	 
	public function setCodigoHorario($codigo_horario){
	    $this->codigo_horario = $codigo_horario;
	}
	
	public function getCodigoCatedratico(){
	    return $this->codigo_catedratico;
	}
	 
	public function setCodigoCatedratico($codigo_catedratico){
	    $this->codigo_catedratico = $codigo_catedratico;
	}
	
	public function getCodigoHi(){
	    return $this->codigo_hi;
	}
	 
	public function setCodigoHi($codigo_hi){
	    $this->codigo_hi = $codigo_hi;
	}
	
	public function getCuposDisponibles(){
	    return $this->cupos_disponibles;
	}
	 
	public function setCuposDisponibles($cupos_disponibles){
	    $this->cupos_disponibles = $cupos_disponibles;
	}

	public static function eliminarSeccion($link, $codigo_seccion){
		$sql = sprintf("
			DELETE FROM tbl_secciones_x_usuarios
			WHERE codigo_seccion = '%s'",
			stripslashes($codigo_seccion)
		);

		$link->ejecutarInstruccion($sql);

		$sql = sprintf("
			DELETE FROM tbl_secciones
			WHERE codigo_seccion = '%s'",
			stripslashes($codigo_seccion)
		);

		$link->ejecutarInstruccion($sql);
	}

	public static function verificarIntegridad($link, $codigo_catedratico, $codigo_hi, $codigo_aula){
		$sql = sprintf("
			SELECT codigo_catedratico, codigo_hi, codigo_aula
			FROM tbl_secciones
			WHERE (codigo_catedratico = '%s' AND codigo_hi = '%s')
			OR (codigo_aula = '%s' AND codigo_hi = '%s')",
			stripslashes($codigo_catedratico),
			stripslashes($codigo_hi),
			stripslashes($codigo_aula),
			stripslashes($codigo_hi)
		);

		return($link->cantidadRegistros($link->ejecutarInstruccion($sql)) == 0);
	}

	public static function verificarModificar($link, $codigo_catedratico, $codigo_hi, $codigo_aula, $codigo_seccion){
		$sql = sprintf("
			SELECT codigo_seccion codigo_catedratico, codigo_hi, codigo_aula
			FROM tbl_secciones
			WHERE ((codigo_catedratico = '%s' AND codigo_hi = '%s')
			OR (codigo_aula = '%s' AND codigo_hi = '%s'))
			AND codigo_seccion != '%s'",
			stripslashes($codigo_catedratico),
			stripslashes($codigo_hi),
			stripslashes($codigo_aula),
			stripslashes($codigo_hi),
			stripslashes($codigo_seccion)
		);

		return($link->cantidadRegistros($link->ejecutarInstruccion($sql)) == 0);
	}

	public static function generarTabla($link){
		$sql = "SELECT 
			a.codigo_seccion, a.codigo_tipo_seccion, a.codigo_asignatura, a.codigo_aula, a.codigo_horario, a.codigo_catedratico, a.codigo_hi, a.cupos_disponibles, 
			b.codigo_tipo_seccion, b.tipo_seccion, 
			c.codigo_asignatura, c.nombre, 
			d.codigo_aula, d.codigo_edificio, d.alias AS alias_aula, 
			e.codigo_edificio, e.codigo_region, e.alias AS alias_edificio, 
			f.codigo_region, f.alias AS alias_region, 
			g.codigo_horario, g.horario, 
			h.codigo_usuario, h.nombres, h.apellidos, 
			i.codigo_hi, i.hora_inicio 
			FROM tbl_secciones a
			INNER JOIN tbl_tipos_secciones b
			ON (a.codigo_tipo_seccion = b.codigo_tipo_seccion)
			INNER JOIN tbl_asignaturas c
			ON (a.codigo_asignatura = c.codigo_asignatura)
			INNER JOIN tbl_aulas d
			ON (a.codigo_aula = d.codigo_aula)
			INNER JOIN tbl_edificios e
			ON (d.codigo_edificio = e.codigo_edificio)
			INNER JOIN tbl_regiones f
			ON (e.codigo_region = f.codigo_region)
			INNER JOIN tbl_horarios g
			ON (a.codigo_horario = g.codigo_horario)
			INNER JOIN tbl_usuarios h
			ON (a.codigo_catedratico = h.codigo_usuario)
			INNER JOIN tbl_horas_inicio i
			ON (a.codigo_hi = i.codigo_hi)";

		if($resultado = $link->ejecutarInstruccion($sql)){
			while ($fila = $link->obtenerFila($resultado)) {
				echo "<tr>";
				echo "<td><input type='radio' name='rad-secciones' value='".$fila["codigo_seccion"]."'></td>";
				echo "<td>".$fila["tipo_seccion"]."</td>";
				echo "<td>".$fila["nombre"]."</td>";
				echo "<td>".$fila["alias_aula"]."</td>";
				echo "<td>".$fila["alias_edificio"]."</td>";
				echo "<td>".$fila["alias_region"]."</td>";
				echo "<td>".$fila["horario"]."</td>";
				echo "<td>".$fila["hora_inicio"]."</td>";
				echo "<td>".$fila["nombres"]." ".$fila["apellidos"]."</td>";
				echo "<td>".$fila["cupos_disponibles"]."</td>";
				echo "</tr>";
			}

			$link->liberarResultado($resultado);
		}
	}

	public function agregarSeccion($link){
		$sql = sprintf("
			INSERT INTO tbl_secciones 
			(codigo_seccion, codigo_tipo_seccion, codigo_asignatura, codigo_aula, codigo_horario, codigo_catedratico, codigo_hi, cupos_disponibles) 
			VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
			stripslashes($this->codigo_tipo_seccion),
			stripslashes($this->codigo_asignatura),
			stripslashes($this->codigo_aula),
			stripslashes($this->codigo_horario),
			stripslashes($this->codigo_catedratico),
			stripslashes($this->codigo_hi),
			stripslashes($this->cupos_disponibles)
		);
		
		if($link->ejecutarInstruccion($sql))
			echo "Seccion agregada con exito!";
		else
			echo "Error! No se agrego la seccion.";
	}

	public static function obtenerSeccion($link, $codigo_seccion){
		$sql = sprintf("
			SELECT codigo_seccion, codigo_tipo_seccion, codigo_asignatura, codigo_aula, codigo_horario, codigo_catedratico, codigo_hi, cupos_disponibles
			FROM tbl_secciones
			WHERE codigo_seccion = '%s'",
			stripslashes($codigo_seccion)
		);

		return $link->obtenerFila($link->ejecutarInstruccion($sql));
	}

	public function modificarSeccion($link){
		$sql = sprintf("
			UPDATE tbl_secciones 
			SET codigo_tipo_seccion='%s', codigo_asignatura='%s', codigo_aula='%s', codigo_horario='%s', codigo_catedratico='%s', codigo_hi='%s', cupos_disponibles='%s'
			WHERE codigo_seccion = '%s'",
			stripslashes($this->codigo_tipo_seccion),
			stripslashes($this->codigo_asignatura),
			stripslashes($this->codigo_aula),
			stripslashes($this->codigo_horario),
			stripslashes($this->codigo_catedratico),
			stripslashes($this->codigo_hi),
			stripslashes($this->cupos_disponibles),
			stripslashes($this->codigo_seccion)
		);

		if($link->ejecutarInstruccion($sql))
			echo "Seccion modificada con exito!";
		else
			echo "Error! No se modifico la seccion.";
	}

}

?>