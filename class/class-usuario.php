<?php

	class Usuario{

		private $nombre;
		private $apellido;
		private $correElectronico;
		private $sexo;
		private $pais;
		private $gustos;

		public function __construct($nombre,
					$apellido,
					$correElectronico,
					$sexo,
					$pais,
					$gustos){
			$this->nombre = $nombre;
			$this->apellido = $apellido;
			$this->correElectronico = $correElectronico;
			$this->sexo = $sexo;
			$this->pais = $pais;
			$this->gustos = $gustos;
		}
		public function getNombre(){
			return $this->nombre;
		}
		public function setNombre($nombre){
			$this->nombre = $nombre;
		}
		public function getApellido(){
			return $this->apellido;
		}
		public function setApellido($apellido){
			$this->apellido = $apellido;
		}
		public function getCorreElectronico(){
			return $this->correElectronico;
		}
		public function setCorreElectronico($correElectronico){
			$this->correElectronico = $correElectronico;
		}
		public function getSexo(){
			return $this->sexo;
		}
		public function setSexo($sexo){
			$this->sexo = $sexo;
		}
		public function getPais(){
			return $this->pais;
		}
		public function setPais($pais){
			$this->pais = $pais;
		}
		public function getGustos(){
			return $this->gustos;
		}
		public function setGustos($gustos){
			$this->gustos = $gustos;
		}
		public function __toString(){
			$gustos="";
			for ($i=0; $i <sizeof($this->gustos); $i++) { 
				$gustos.=$this->gustos[$i]."|";
			}
			return $this->nombre . ",".
				 $this->apellido . ",".
				 $this->correElectronico . ",".
				 $this->sexo . ",".
				 $this->pais . ",".
				 $gustos;
		}

		public function guardarRegistro(){
			$archivo = fopen("data/usuarios.csv","a+");
			fwrite($archivo, $this->__toString() .PHP_EOL);
			fclose($archivo);
		}
	}
?>