<?php

class Horario {
	
	private $codigo_horario;
	private $horario;

	function __construct($codigo_horario, $horario){
		$this->codigo_horario = codigo_horario;
		$this->horario = horario;
	}

	public function getCodigoHorario(){
	    return $this->codigo_horario;
	}
	 
	public function setCodigoHorario($codigo_horario){
	    $this->codigo_horario = $codigo_horario;
	}
	
	public function getHorario(){
	    return $this->horario;
	}
	 
	public function setHorario($horario){
	    $this->horario = $horario;
	}

	public static function generarSelect($link){
		$resultado = $link->ejecutarInstruccion("
			SELECT codigo_horario, horario
			FROM tbl_horarios"
		);

		echo "<select class='form-control' id='slc-horario'>";

		while ($fila = $link->obtenerFila($resultado)) {
			echo "<option value='".$fila["codigo_horario"]."'>";
			echo $fila["horario"];
			echo "</option>";
		}

		echo "</select>";
	}

}

?>