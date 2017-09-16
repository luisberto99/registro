<?php

class TipoUsuario{
	
	private $codigo_tipo_usuario;
	private $tipo_usuario;

	function __construct($codigo_tipo_usuario, $tipo_usuario){
		$this->codigo_tipo_usuario = $codigo_tipo_usuario;
		$this->tipo_usuario = $tipo_usuario;
	}

	public function getCodigoTipoUsuario(){
	    return $this->codigo_tipo_usuario;
	}
	 
	public function setCodigoTipoUsuario($codigo_tipo_usuario){
	    $this->codigo_tipo_usuario = $codigo_tipo_usuario;
	}
	
	public function getTipoUsuario(){
	    return $this->tipo_usuario;
	}
	 
	public function setTipoUsuario($tipo_usuario){
	    $this->tipo_usuario = $tipo_usuario;
	}
	
	public static function generarSelect($link){
		$resultado = $link->ejecutarInstruccion("
			SELECT codigo_tipo_usuario, tipo_usuario 
			FROM tbl_tipos_usuarios
			WHERE tipo_usuario != 'Estudiante'
		");
		echo '<select class="form-control" id="slc-tipo-usuario">';
		while ($fila = $link->obtenerFila($resultado)) {
			echo "<option value='".$fila["codigo_tipo_usuario"]."'>";
			echo $fila["tipo_usuario"];
			echo "</option>";
		}
		echo '</select>';
		
		$link->liberarResultado($resultado);
	}

	public static function obtenerCodigoEstudiante($link){
		$resultado = $link->ejecutarInstruccion("
			SELECT codigo_tipo_usuario, tipo_usuario
			FROM tbl_tipos_usuarios
			WHERE tipo_usuario = 'Estudiante'
		");

		$fila = $link->obtenerFila($resultado); 
		$link->liberarResultado($resultado);
		return $fila["codigo_tipo_usuario"];
	}

}

?>