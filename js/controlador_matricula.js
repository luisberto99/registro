errorDeIntegridad = function(){
	$("#div-slc-seccion").removeClass("has-success").addClass("has-error");
};

actualizarTabla = function(){
	$("#tbl-matriculas").find("tr:gt(0)").remove();

	$.ajax({
		method: "POST",
		url: "../ajax/procesar_matricula.php?accion=generarTabla",

		success:function(tabla){
			$("#tbl-matriculas").append(tabla);
		},

		error:function(error){
			console.log(error);
		}

	});
};

radioChecked = function(){
	return $("input[name='rad-matriculas']:checked").val();
};

$(document).ready(function(){
	actualizarTabla();

	$('#slc-carrera').on('change', function() {

		$.ajax({
			url: '../ajax/procesar_matricula.php?accion=selectAsignatura',
			method: 'POST',
			dataType: 'html',
			data: "codigo_carrera=" + $(this).val(),

			success:function(texto){
				$("#div-alert-mensaje").addClass("hidden");
				$("#div-slc-seccion").removeClass('has-error');
				$("#div-slc-asignatura").html(texto);
				$("#div-slc-seccion").html('');
			},

		});
	});

	// IMPORTANTE
	$('#div-slc-asignatura').on('change', '#slc-asignatura', function() {

		$.ajax({
			url: '../ajax/procesar_matricula.php?accion=selectSeccion',
			method: 'POST',
			dataType: 'html',
			data: "codigo_asignatura=" + $(this).val(),

			success:function(texto){
				$("#div-alert-mensaje").addClass("hidden");
				$("#div-slc-seccion").removeClass('has-error');
				$("#div-slc-seccion").html(texto);
			},

			error:function(error){
				console.log("FUN");
				console.log(error);
			}

		});
	});

	$("#btn-matricula-guardar").click(function(){
		if($("#slc-secciones").val()){
			var parametros = "codigo_seccion=" + $("#slc-secciones").val();

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_matricula.php?accion=guardarMatricula",
				dataType: "html",

				success:function(texto){
					actualizarTabla();
					$("#div-alert-mensaje").html(texto);
					$("#div-alert-mensaje").removeClass("hidden");
				},

				error:function(error){
					console.log(error);
					errorDeIntegridad();
					$("#div-alert-mensaje").html("Error! Ya existe una seccion a esa hora / el catedratico da clases a esa hora.");
					$("#div-alert-mensaje").removeClass("hidden");
				}

			});
		}
	});

	$("#btn-matricula-cancelar").click(function(){
		$('input[name=rad-matriculas]').attr('checked',false);
		$("#slc-carrera").val('');
		$("#div-slc-asignatura").html('');
		$("#div-slc-seccion").html('');
		$("#div-alert-mensaje").addClass("hidden");
		$("#btn-matricula-guardar").removeClass("hidden");
		$("#btn-modal").removeClass("hidden");
		$("#div-slc-seccion").removeClass('has-error');
	});

	$("#btn-matricula-eliminar").click(function(){
		if(radioChecked()){
			var parametros = "codigo_seccion=" + radioChecked();

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_matricula.php?accion=eliminarMatricula",

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
});