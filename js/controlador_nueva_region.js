var arreglo_campos = [
	"txt-codigo-region",
	"txt-nombre-region", 
	"txt-alias-region"
];

errorDeIntegridad = function(){
	$("#div-txt-nombre-region").removeClass("has-success").addClass("has-error");
	$("#div-txt-alias-region").removeClass("has-success").addClass("has-error");
};

actualizarTabla = function(){
	$("#tbl-regiones").find("tr:gt(0)").remove();
	$.ajax({
		method: "POST",
		url: "../ajax/procesar_nueva_region.php?accion=generarTabla",
		success:function(tabla){
			$("#tbl-regiones").append(tabla);
		},
		error:function(error){
			console.log(error);
		}
	});
};

agregarDatos = function(objeto){
	$("#txt-codigo-region").val(objeto.codigo_region);
	$("#txt-nombre-region").val(objeto.nombre);
	$("#txt-alias-region").val(objeto.alias);
};

radioChecked = function(){
	return $("input[name='rad-regiones']:checked").val();
};

$(document).ready(function(){
	actualizarTabla();

	$("#btn-nueva-region-guardar").click(function(){
		if(verificarCampos(arreglo_campos)){

			var parametros = procesarParametros(arreglo_campos);

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nueva_region.php?accion=guardarRegion",
				dataType: "html",

				success:function(texto){
					actualizarTabla();
					limpiarCampos(arreglo_campos);
					$("#div-alert-mensaje").html(texto);
					$("#div-alert-mensaje").removeClass("hidden");
				},

				error:function(){
					errorDeIntegridad();
					$("#div-alert-mensaje").html("Error! Ya existe una region con ese nombre / codigo.");
					$("#div-alert-mensaje").removeClass("hidden");
				}

			});
		}
	});

	$("#btn-nueva-region-cancelar").click(function(){
		limpiarCampos(arreglo_campos);
		$('input[name=rad-regiones]').attr('checked',false);
		$("#div-alert-mensaje").addClass("hidden");
		$("#btn-nueva-region-actualizar").addClass("hidden");
		$("#btn-nueva-region-guardar").removeClass("hidden");
		$("#btn-modal").removeClass("hidden");
	});

	$("#btn-nueva-region-eliminar").click(function(){
		if(radioChecked()){
			var parametros = "codigo_region=" + radioChecked();

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nueva_region.php?accion=eliminarRegion",
				dataType: "html",

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

	$("#btn-nueva-region-editar").click(function(){
		if(radioChecked()){
			var parametros = "codigo_region=" + radioChecked();

			$.ajax({
				method: "POST",
				data: parametros,
				url: "../ajax/procesar_nueva_region.php?accion=obtenerRegion",
				dataType: "json",

				success:function(objeto){
					$("#btn-nueva-region-actualizar").removeClass("hidden");
					$("#btn-nueva-region-guardar").addClass("hidden");
					$("#btn-modal").addClass("hidden");
					$("#div-alert-mensaje").addClass("hidden");
					agregarDatos(objeto);
				},

				error:function(error){
					console.log(error);
				}

			});
		}
	});

	$("#btn-nueva-region-actualizar").click(function(){
		var parametros = procesarParametros(arreglo_campos);

		$.ajax({
			method: "POST",
			data: parametros,
			url: "../ajax/procesar_nueva_region.php?accion=modificarRegion",

			success:function(texto){
				actualizarTabla();
				limpiarCampos(arreglo_campos);
				$("#div-alert-mensaje").html(texto);
				$("#btn-nueva-region-actualizar").addClass("hidden");
				$("#btn-nueva-region-guardar").removeClass("hidden");
				$("#btn-modal").removeClass("hidden");
				$("#div-alert-mensaje").removeClass("hidden");
			},

			error:function(){
				errorDeIntegridad();
				$("#div-alert-mensaje").html("Error! Ya existe una region con ese nombre / codigo.");
				$("#div-alert-mensaje").removeClass("hidden");
			}

		});
	});
});