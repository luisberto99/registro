var arreglo_campos = [
	"txt-codigo-carrera-dept",
	"txt-nombre-carrera-dept", 
	"txt-alias-carrera-dept", 
	"slc-jefe"
];

errorDeIntegridad = function(){
	$("#div-txt-nombre-carrera-dept").removeClass("has-success").addClass("has-error");
	$("#div-txt-alias-carrera-dept").removeClass("has-success").addClass("has-error");
};

chkParametros = function(){
	var regionesSeleccionadas = "";
	$("input[name='chk-regiones[]']:checked").each(function(){
		regionesSeleccionadas+="&regiones[]="+$(this).val();
		$("#div-chk-regiones").addClass('has-success');
	});
	return regionesSeleccionadas;
};

actualizarTabla = function(){
	$("#tbl-carreras").find("tr:gt(0)").remove();

	$.ajax({
		method: "POST",
		url: "../ajax/procesar_nuevo_dept.php?accion=generarTabla",

		success:function(tabla){
			$("#tbl-carreras").append(tabla);
		},

		error:function(error){
			console.log(error);
		}

	});
};

agregarDatos = function(objeto){
	$("#txt-codigo-carrera-dept").val(objeto.codigo_carrera);
	$("#txt-nombre-carrera-dept").val(objeto.nombre);
	$("#txt-alias-carrera-dept").val(objeto.alias);
	$("#slc-jefe").val(objeto.codigo_jefe_dept);
};

agregarChkDatos = function(objeto){
	for (var i = 0; i < objeto.length; i++)
		$('input:checkbox[value="'+objeto[i]+'"]').prop("checked", true);
};

radioChecked = function(){
	return $("input[name='rad-carreras']:checked").val();
};

$(document).ready(function(){
	actualizarTabla();

	$("#btn-nuevo-dept-guardar").click(function(){
		if(verificarCampos(arreglo_campos) && chkParametros()){
			var parametros = procesarParametros(arreglo_campos) + chkParametros();

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nuevo_dept.php?accion=guardarCarrera",
				dataType: "html",

				success:function(texto){
					console.log(texto);
					actualizarTabla();
					limpiarCampos(arreglo_campos);
					$("input[name='chk-regiones[]']:checkbox").prop('checked',false);
					$("#div-chk-regiones").removeClass('has-success'); 	
					$("#div-alert-mensaje").html(texto);
					$("#div-alert-mensaje").removeClass("hidden");
				},

				error:function(error){
					console.log(error);
					errorDeIntegridad();
					$("#div-alert-mensaje").html("Error! Ya existe un departamento con ese nombre/codigo.");
					$("#div-alert-mensaje").removeClass("hidden");
				}

			});
		}
	});

	$("#btn-nuevo-dept-cancelar").click(function(){
		limpiarCampos(arreglo_campos);
		$("input[name='chk-regiones[]']:checkbox").prop('checked',false);
		$("#div-chk-regiones").removeClass('has-success');
		$('input[name=rad-carreras]').attr('checked',false);
		$("#div-alert-mensaje").addClass("hidden");
		$("#btn-nuevo-dept-actualizar").addClass("hidden");
		$("#btn-nuevo-dept-guardar").removeClass("hidden");
		$("#btn-modal").removeClass("hidden");
	});

	$("#btn-nuevo-dept-eliminar").click(function(){
		if(radioChecked()){
			var parametros = "codigo_carrera=" + radioChecked();

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nuevo_dept.php?accion=eliminarCarrera",

				success:function(){
					actualizarTabla();
					$("#div-alert-mensaje").addClass("hidden");
				},

				error:function(error){
					console.log(error);
				}

			});
		}
	});

	$("#btn-nuevo-dept-editar").click(function(){
		if(radioChecked()){
			var parametros = "codigo_carrera=" + radioChecked();

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nuevo_dept.php?accion=obtenerCarrera",
				dataType: "json",

				success:function(objeto){
					$("#btn-nuevo-dept-actualizar").removeClass("hidden");
					$("#btn-nuevo-dept-guardar").addClass("hidden");
					$("#btn-modal").addClass("hidden");
					$("#div-alert-mensaje").addClass("hidden");
					agregarDatos(objeto);
				},

				error:function(error){
					console.log(error);
				}

			});

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nuevo_dept.php?accion=obtenerChkCarrera",
				dataType: "json",

				success:function(objeto){
					$("input[name='chk-regiones[]']:checkbox").prop('checked',false);
					agregarChkDatos(objeto);
				},

				error:function(error){
					console.log(error);
				}

			});
		}
	});

	$("#btn-nuevo-dept-actualizar").click(function(){
		if(verificarCampos(arreglo_campos) && chkParametros()){
			var parametros = procesarParametros(arreglo_campos) + chkParametros();

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nuevo_dept.php?accion=modificarCarrera",

				success:function(texto){
					actualizarTabla();
					limpiarCampos(arreglo_campos);
					$("input[name='chk-regiones[]']:checkbox").prop('checked',false);
					$("#div-alert-mensaje").html(texto);
					$("#div-chk-regiones").removeClass('has-success');
					$("#btn-nuevo-dept-actualizar").addClass("hidden");
					$("#btn-nuevo-dept-guardar").removeClass("hidden");
					$("#btn-modal").removeClass("hidden");
					$("#div-alert-mensaje").removeClass("hidden");
				},

				error:function(){
					errorDeIntegridad();
					$("#div-alert-mensaje").html("Error! Ya existe un departamento con ese nombre/codigo.");
					$("#div-alert-mensaje").removeClass("hidden");
				}

			});
		}
	});
});