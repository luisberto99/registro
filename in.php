
<?php
	include_once("class/class-usuario.php");
	include_once("class/class-pais.php");
	$nombre = "";
	$apellido = "";
	$correo = "";
	$sexo = "";
	$pais = "";
	$gustos = array();

	if (isset($_GET["txt-nombre"])) {
		$nombre = $_GET["txt-nombre"];
	}
	if (isset($_GET["txt-apellido"])) {
		$apellido = $_GET["txt-apellido"];
	}
	if (isset($_GET["txt-correo"])) {
		$correo = $_GET["txt-correo"];
	}
	if (isset($_GET["radio-sexo"])) {
		$sexo = $_GET["radio-sexo"];
	}
	if (isset($_GET["cmb-pais"])) {
		$pais = $_GET["cmb-pais"];
	}
	if (isset($_GET["check-gustos"])) {
		$gustos = $_GET["gustos"];
	}

if (isset($_GET["btn-registrar"])) {
	$u = new usuario($nombre,
					$apellido,
					$correo,
					$sexo,
					$pais,
					$gustos);
	$u->guardarRegistro();
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
<h1>Formulario Prueba</h1>
<div>
	<form action="index.php" method="GET" >
		<table style="margin: 10px">
			<tr>
				<td<?php
					if ($nombre="") {
						echo "class = 'has-error'";
					}
				?>
				>
					<input type="text" name="txt-nombre" class="form-control" placeholder="Nombre">
				</td>
				<td><input type="text" name="txt-apellido" class="
				form-control" placeholder="Apellido"></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="txt" name="txt-correo" class="form-control" placeholder="Correo Electronico">
				</td>
			</tr>

			<tr>
				<td><label>
					<input type="radio" name="radio-sexo" value="masculino">
					Masculino</label>
				</td>
				<td>
					<label>
					<input type="radio" name="radio-sexo" value="femenino">
					Femenino</label>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<select class="form-control" name="cmb-pais">
						<option value="1">Honduras</option>
						<option value="2">Hon</option>}
						<option value="3">as</option>
						<option value="4">duras</option>
						<option value="5">Hoffs</option>			
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<input type="date" name="medina" class="form-control">
				</td>
			</tr>
			<tr>
				<td>
					<label><strong>Gustos:</strong> </label>
					<label><input type="checkbox" name="check-gustos" value="1">Arroz</label>
					<label><input type="checkbox" name="check-gustos" value="2">Papas</label>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" name="btn-registrar" value="crear cuenta"	class="btn btn-primary">
				</td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>