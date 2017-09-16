<?php

class TipoSeccion {
	
	private $codigo_tipo_seccion;
	private $tipo_seccion;

	function __construct($codigo_tipo_seccion, $tipo_seccion){
		$this->codigo_tipo_seccion = $codigo_tipo_seccion;
		$this->tipo_seccion = $tipo_seccion;
	}

	public function getCodigoTipoSeccion(){
	    return $this->codigo_tipo_seccion;
	}
	 
	public function setCodigoTipoSeccion($codigo_tipo_seccion){
	    $this->codigo_tipo_seccion = $codigo_tipo_seccion;
	}
	
	public function getTipoSeccion(){
	    return $this->tipo_seccion;
	}
	 
	public function setTipoSeccion($tipo_seccion){
	    $this->tipo_seccion = $tipo_seccion;
	}

	public static function generarSelect($link){
		$resultado = $link->ejecutarInstruccion("
			SELECT codigo_tipo_seccion, tipo_seccion
			FROM tbl_tipos_secciones"
		);

		echo "<select class='form-control' id='slc-tipo-seccion'>";

		while ($fila = $link->obtenerFila($resultado)) {
			echo "<option value='".$fila["codigo_tipo_seccion"]."'>";
			echo $fila["tipo_seccion"];
			echo "</option>";
		}
		
		echo "</select>";
	}

}

?>