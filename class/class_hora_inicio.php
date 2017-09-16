<?php

class HoraInicio {
	
	private $codigo_hi;
	private $hora_inicio;

	function __construct($codigo_hi, $hora_inicio){
		$this->codigo_hi = codigo_hi;
		$this->hora_inicio = hora_inicio;
	}

	public function getCodigoHi(){
	    return $this->codigo_hi;
	}
	 
	public function setCodigoHi($codigo_hi){
	    $this->codigo_hi = $codigo_hi;
	}
	
	public function getHoraInicio(){
	    return $this->hora_inicio;
	}
	 
	public function setHoraInicio($hora_inicio){
	    $this->hora_inicio = $hora_inicio;
	}

	public static function generarSelect($link){
		$resultado = $link->ejecutarInstruccion("
			SELECT codigo_hi, hora_inicio
			FROM tbl_horas_inicio"
		);

		echo "<select class='form-control' id='slc-hora-inicio'>";

		while ($fila = $link->obtenerFila($resultado)) {
			echo "<option value='".$fila["codigo_hi"]."'>";
			echo $fila["hora_inicio"];
			echo "</option>";
		}
		
		echo "</select>";
	}

}

?>