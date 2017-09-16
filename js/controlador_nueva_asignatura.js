var arreglo_campos = [
	"txt-codigo-asignatura",
	"txt-nombre-asignatura", 
	"txt-alias-asignatura", 
	"slc-uv-asignatura"
];

errorDeIntegridad = function(){
	$("#div-txt-nombre-asignatura").removeClass("has-success").addClass("has-error");
	$("#div-txt-alias-asignatura").removeClass("has-success").addClass("has-error");
};

chkParametros = function(checkbox){
	var seleccionados = "";
	$("input[name='chk-"+checkbox+"[]']:checked").each(function(){
		seleccionados+="&"+checkbox+"[]="+$(this).val();
		$("#div-chk-"+checkbox).addClass('has-success');
	});
	return seleccionados;
};

actualizarTabla = function(){
	$("#tbl-asignaturas").find("tr:gt(0)").remove();

	$.ajax({
		method: "POST",
		url: "../ajax/procesar_nueva_asignatura.php?accion=generarTabla",

		success:function(tabla){
			$("#tbl-asignaturas").append(tabla);
		},

		error:function(error){
			console.log(error);
		}

	});
};

agregarDatos = function(objeto){
	$("#txt-codigo-asignatura").val(objeto.codigo_asignatura);
	$("#txt-nombre-asignatura").val(objeto.nombre);
	$("#txt-alias-asignatura").val(objeto.alias);
	$("#slc-uv-asignatura").val(objeto.UV);
};

agregarChkDatos = function(objeto, checkbox){
	for (var i = 0; i < objeto.length; i++)
		$('input:checkbox[name="chk-'+checkbox+'[]"][value="'+objeto[i]+'"]').prop("checked", true);
};

radioChecked = function(){
	return $("input[name='rad-asignaturas']:checked").val();
};

$(document).ready(function(){
	actualizarTabla();

	$("#btn-nueva-asignatura-guardar").click(function(){
		if(verificarCampos(arreglo_campos) && chkParametros('carreras')){
			var parametros = procesarParametros(arreglo_campos) + chkParametros('carreras');

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nueva_asignatura.php?accion=guardarAsignatura",
				dataType: "html",

				success:function(texto){
					actualizarTabla();
					limpiarCampos(arreglo_campos);
					$("input[name='chk-carreras[]']:checkbox").prop('checked',false);
					$("#div-chk-carreras").removeClass('has-success'); 	
					$("#div-alert-mensaje").html(texto);
					$("#div-alert-mensaje").removeClass("hidden");
				},

				error:function(error){
					console.log(error);
					errorDeIntegridad();
					$("#div-alert-mensaje").html("Error! Ya existe una asignatura con ese nombre & codigo.");
					$("#div-alert-mensaje").removeClass("hidden");
				}

			});
		}
	});

	$("#btn-nueva-asignatura-cancelar").click(function(){
		limpiarCampos(arreglo_campos);
		$("input[name='chk-carreras[]']:checkbox").prop('checked',false);
		$('input[name=rad-asignaturas]').attr('checked',false);
		$("#div-chk-carreras").removeClass('has-success');
		$("#div-alert-mensaje").addClass("hidden");
		$("#btn-nueva-asignatura-actualizar").addClass("hidden");
		$("#btn-nueva-asignatura-guardar").removeClass("hidden");
		$("#btn-modal").removeClass("hidden");
	});

	$("#btn-nueva-asignatura-eliminar").click(function(){
		if(radioChecked()){
			var parametros = "codigo_asignatura=" + radioChecked();

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nueva_asignatura.php?accion=eliminarAsignatura",

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

	$("#btn-nueva-asignatura-editar").click(function(){
		if(radioChecked()){
			var parametros = "codigo_asignatura=" + radioChecked();

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nueva_asignatura.php?accion=obtenerAsignatura",
				dataType: "json",

				success:function(objeto){
					$("#btn-nueva-asignatura-actualizar").removeClass("hidden");
					$("#btn-nueva-asignatura-guardar").addClass("hidden");
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
				url: "../ajax/procesar_nueva_asignatura.php?accion=obtenerChkAsignatura",
				dataType: "json",

				success:function(objeto){
					$("input[name='chk-carreras[]']:checkbox").prop('checked',false);
					agregarChkDatos(objeto, 'carreras');
				},

				error:function(error){
					console.log(error);
				}

			});
		}
	});

	$("#btn-nueva-asignatura-actualizar").click(function(){
		if(verificarCampos(arreglo_campos) && chkParametros('carreras')){
			var parametros = procesarParametros(arreglo_campos) + chkParametros('carreras');

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nueva_asignatura.php?accion=modificarAsignatura",

				success:function(texto){
					console.log(texto);
					actualizarTabla();
					limpiarCampos(arreglo_campos);
					$("input[name='chk-carreras[]']:checkbox").prop('checked',false);
					$('input[name=rad-asignaturas]').attr('checked',false);
					$("#div-alert-mensaje").html(texto);
					$("#div-chk-carreras").removeClass('has-success');
					$("#btn-nueva-asignatura-actualizar").addClass("hidden");
					$("#btn-nueva-asignatura-guardar").removeClass("hidden");
					$("#btn-modal").removeClass("hidden");
					$("#div-alert-mensaje").removeClass("hidden");
				},

				error:function(){
					errorDeIntegridad();
					$("#div-alert-mensaje").html("Error! Ya existe una asignatura con ese nombre & codigo.");
					$("#div-alert-mensaje").removeClass("hidden");
				}

			});
		}
	});
});