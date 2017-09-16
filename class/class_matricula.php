<?php

class Matricula {
	
	private $codigo_seccion;
	private $codigo_usuario;

	function __construct($codigo_seccion, $codigo_usuario) {
		$this->codigo_seccion = $codigo_seccion;
		$this->codigo_usuario = $codigo_usuario;
	}

	public function getCodigoSeccion(){
	    return $this->codigo_seccion;
	}
	 
	public function setCodigoSeccion($codigo_seccion){
	    $this->codigo_seccion = $codigo_seccion;
	}
	
	public function getCodigoUsuario(){
	    return $this->codigo_usuario;
	}
	 
	public function setCodigoUsuario($codigo_usuario){
	    $this->codigo_usuario = $codigo_usuario;
	}

	public function agregarMatricula($link){
		$sql = sprintf("
			SELECT codigo_seccion, cupos_disponibles
			FROM tbl_secciones
			WHERE codigo_seccion = '%s'
			AND cupos_disponibles > 0",
			stripslashes($this->codigo_seccion)
		);

		if ($link->cantidadRegistros($link->ejecutarInstruccion($sql)) > 0) {
			$sql = sprintf("
				UPDATE tbl_secciones
				SET cupos_disponibles = cupos_disponibles-1
				WHERE codigo_seccion = '%s'",
				stripslashes($this->codigo_seccion)
			);

			if($link->ejecutarInstruccion($sql)){
				$sql = sprintf("
					INSERT INTO tbl_secciones_x_usuarios (codigo_seccion, codigo_usuario)
					VALUES ('%s', '%s')",
					stripslashes($this->codigo_seccion),
					stripslashes($this->codigo_usuario)
				);

				if($link->ejecutarInstruccion($sql))
					echo "Matricula exitosa!";
				else
					echo "Ocurrio un error! Matricula no exitosa.";
			}
		} else
			echo "Ya no hay cupos disponibles en esta seccion!";
	}

	public static function eliminarMatricula($link, $codigo_seccion){
		$sql = sprintf("
			UPDATE tbl_secciones
			SET cupos_disponibles = cupos_disponibles+1
			WHERE codigo_seccion = '%s'",
			stripslashes($codigo_seccion)
		);

		if($link->ejecutarInstruccion($sql)){
			$sql = sprintf("
				DELETE FROM tbl_secciones_x_usuarios
				WHERE codigo_seccion = '%s'",
				stripslashes($codigo_seccion)
			);

			$link->ejecutarInstruccion($sql);
		}
	}

	public static function generarCarreras($link){
		if($resultado = $link->ejecutarInstruccion("
			SELECT codigo_carrera, nombre
			FROM tbl_carreras")){

			echo "<select class='form-control' id='slc-carrera' multiple>";

			while ($fila = $link->obtenerFila($resultado)) {
				echo "<option value='".$fila["codigo_carrera"]."'>";
				echo $fila["nombre"];
				echo "</option>";
			}

			echo "</select>";
			$link->liberarResultado($resultado);
		}
	}

	public static function generarAsignaturas($link, $codigo_carrera){
		$sql = sprintf("
			SELECT a.codigo_asignatura, a.nombre, b.codigo_carrera, b.codigo_asignatura
			FROM tbl_asignaturas a
			INNER JOIN tbl_carreras_x_asignaturas b
			ON (a.codigo_asignatura = b.codigo_asignatura)
			WHERE b.codigo_carrera = '%s'",
			stripslashes($codigo_carrera)
		);

		if ($resultado = $link->ejecutarInstruccion($sql)) {

			echo "<select class='form-control' id='slc-asignatura' multiple>";

			while ($fila = $link->obtenerFila($resultado)) {
				echo "<option value='".$fila["codigo_asignatura"]."'>";
				echo $fila["nombre"];
				echo "</option>";
			}

			echo "</select>";
			$link->liberarResultado($resultado);
		}
	}	

	public static function generarSecciones($link, $codigo_asignatura, $codigo_region){
		$sql = sprintf("SELECT 
			a.codigo_seccion, a.codigo_tipo_seccion, a.codigo_asignatura, a.codigo_aula, a.codigo_horario, a.codigo_catedratico, a.codigo_hi, a.cupos_disponibles, 
			b.codigo_tipo_seccion, b.tipo_seccion, 
			c.codigo_asignatura, c.nombre, c.alias AS alias_asignatura,
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
			ON (a.codigo_hi = i.codigo_hi)
			WHERE a.codigo_asignatura = '%s'
			AND f.codigo_region = '%s'",
			stripslashes($codigo_asignatura),
			stripslashes($codigo_region)
		);

		if ($resultado = $link->ejecutarInstruccion($sql)) {
			
			echo "<select class='form-control' id='slc-secciones' multiple>";

			while ($fila = $link->obtenerFila($resultado)) {
				echo "<option value='".$fila["codigo_seccion"]."'>";
				echo $fila["tipo_seccion"]." | ";
				echo $fila["alias_asignatura"]." ". $fila["nombre"]." | ";
				echo $fila["nombres"]." ".$fila["apellidos"]." | ";
				echo $fila["alias_edificio"]." ".$fila["alias_aula"]." | ";
				echo $fila["horario"]." ".$fila["hora_inicio"]." | ";
				echo "Cupos: ".$fila["cupos_disponibles"];
				echo "</option>";
			}

			echo "</select>";
			$link->liberarResultado($resultado);
		}
	}

	public static function generarTabla($link, $codigo_usuario){
		$sql = sprintf("SELECT 
			a.codigo_seccion, a.codigo_tipo_seccion, a.codigo_asignatura, a.codigo_aula, a.codigo_horario, a.codigo_catedratico, a.codigo_hi, a.cupos_disponibles, 
			b.codigo_tipo_seccion, b.tipo_seccion, j.codigo_seccion, j.codigo_usuario,
			c.codigo_asignatura, c.nombre, 
			d.codigo_aula, d.codigo_edificio, d.alias AS alias_aula, 
			e.codigo_edificio, e.alias AS alias_edificio, 
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
			INNER JOIN tbl_horarios g
			ON (a.codigo_horario = g.codigo_horario)
			INNER JOIN tbl_usuarios h
			ON (a.codigo_catedratico = h.codigo_usuario)
			INNER JOIN tbl_horas_inicio i
			ON (a.codigo_hi = i.codigo_hi)
			INNER JOIN tbl_secciones_x_usuarios j
			ON (a.codigo_seccion = j.codigo_seccion)
			WHERE (j.codigo_usuario = '%s')",
			stripslashes($codigo_usuario)
		);

		if($resultado = $link->ejecutarInstruccion($sql)){
			while ($fila = $link->obtenerFila($resultado)) {
				echo "<tr>";
				echo "<td><input type='radio' name='rad-matriculas' value='".$fila["codigo_seccion"]."'></td>";
				echo "<td>".$fila["tipo_seccion"]."</td>";
				echo "<td>".$fila["nombre"]."</td>";
				echo "<td>".$fila["alias_aula"]."</td>";
				echo "<td>".$fila["alias_edificio"]."</td>";
				echo "<td>".$fila["horario"]."</td>";
				echo "<td>".$fila["hora_inicio"]."</td>";
				echo "<td>".$fila["nombres"]." ".$fila["apellidos"]."</td>";
				echo "<td>".$fila["cupos_disponibles"]."</td>";
				echo "</tr>";
			}

			$link->liberarResultado($resultado);
		}
	}

	public static function verificarIntegridad($link, $codigo_usuario, $codigo_seccion){
		$sql = sprintf("
			SELECT codigo_usuario, codigo_seccion
			FROM tbl_secciones_x_usuarios
			WHERE codigo_usuario = '%s'
			AND codigo_seccion = '%s'",
			stripslashes($codigo_usuario),
			stripslashes($codigo_seccion)
		);

		return ($link->cantidadRegistros($link->ejecutarInstruccion($sql)) == 0);
	}

}

?>