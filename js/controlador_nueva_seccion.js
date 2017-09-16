var arreglo_campos = [
	"txt-codigo-seccion",
	"slc-asignatura",
	"slc-tipo-seccion",
	"slc-catedratico",
	"slc-hora-inicio",
	"slc-aula",
	"slc-horario",
	"txt-seccion-cupos"
];

errorDeIntegridad = function(){
	$("#div-slc-catedratico").removeClass("has-success").addClass("has-error");
	$("#div-slc-hora-inicio").removeClass("has-success").addClass("has-error");
	$("#div-slc-aula").removeClass("has-success").addClass("has-error");
};

actualizarTabla = function(){
	$("#tbl-secciones").find("tr:gt(0)").remove();

	$.ajax({
		method: "POST",
		url: "../ajax/procesar_nueva_seccion.php?accion=generarTabla",

		success:function(tabla){
			$("#tbl-secciones").append(tabla);
		},

		error:function(error){
			console.log(error);
		}

	});
};

agregarDatos = function(objeto){
	$("#txt-codigo-seccion").val(objeto.codigo_seccion);
	$("#slc-asignatura").val(objeto.codigo_asignatura);
	$("#slc-tipo-seccion").val(objeto.codigo_tipo_seccion);
	$("#slc-catedratico").val(objeto.codigo_catedratico);
	$("#slc-hora-inicio").val(objeto.codigo_hi);
	$("#slc-aula").val(objeto.codigo_aula);
	$("#slc-horario").val(objeto.codigo_horario);
	$("#txt-seccion-cupos").val(objeto.cupos_disponibles);
};

radioChecked = function(){
	return $("input[name='rad-secciones']:checked").val();
};

$(document).ready(function(){
	actualizarTabla();

	$("#btn-nueva-seccion-guardar").click(function(){
		if(verificarCampos(arreglo_campos)){
			var parametros = procesarParametros(arreglo_campos);

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nueva_seccion.php?accion=guardarSeccion",
				dataType: "html",

				success:function(texto){
					actualizarTabla();
					limpiarCampos(arreglo_campos);	
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

	$("#btn-nueva-seccion-cancelar").click(function(){
		limpiarCampos(arreglo_campos);
		$('input[name=rad-secciones]').attr('checked',false);
		$("#div-alert-mensaje").addClass("hidden");
		$("#btn-nueva-seccion-actualizar").addClass("hidden");
		$("#btn-nueva-seccion-guardar").removeClass("hidden");
		$("#btn-modal").removeClass("hidden");
	});

	$("#btn-nueva-seccion-eliminar").click(function(){
		if(radioChecked()){
			var parametros = "codigo_seccion=" + radioChecked();

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nueva_seccion.php?accion=eliminarSeccion",

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

	$("#btn-nueva-seccion-editar").click(function(){
		if(radioChecked()){
			var parametros = "codigo_seccion=" + radioChecked();

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nueva_seccion.php?accion=obtenerSeccion",
				dataType: "json",

				success:function(objeto){
					agregarDatos(objeto);
					$("#btn-nueva-seccion-actualizar").removeClass("hidden");
					$("#btn-nueva-seccion-guardar").addClass("hidden");
					$("#btn-modal").addClass("hidden");
					$("#div-alert-mensaje").addClass("hidden");
				},

				error:function(error){
					console.log(error);
				}

			});
		}
	});

	$("#btn-nueva-seccion-actualizar").click(function(){
		if(verificarCampos(arreglo_campos)){
			var parametros = procesarParametros(arreglo_campos);

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nueva_seccion.php?accion=modificarSeccion",

				success:function(texto){
					actualizarTabla();
					limpiarCampos(arreglo_campos);
					$('input[name=rad-secciones]').attr('checked',false);
					$("#div-alert-mensaje").html(texto);
					$("#btn-nueva-seccion-actualizar").addClass("hidden");
					$("#btn-nueva-seccion-guardar").removeClass("hidden");
					$("#btn-modal").removeClass("hidden");
					$("#div-alert-mensaje").removeClass("hidden");
				},

				error:function(){
					errorDeIntegridad();
					$("#div-alert-mensaje").html("Error! Ya existe una seccion a esa hora / el catedratico da clases a esa hora.");
					$("#div-alert-mensaje").removeClass("hidden");
				}

			});
		}
	});
});