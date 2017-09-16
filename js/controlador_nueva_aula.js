var campos =
[
    "txt-codigo-aula",
    "txt-alias-aula", 
    "txt-capacidad-aula", 
    "slc-edificio"
];

errorDeIntegridad = function()
{
    hasError("#div-txt-alias-aula");
    hasError("#div-slc-edificio");
};

resetFormulario = function()
{
    $("input[name=rad-aulas]").attr("checked",false);
    $("#div-alert-mensaje").addClass("hidden");
    $("#btn-nueva-aula-actualizar").addClass("hidden");
    $("#btn-nueva-aula-guardar").removeClass("hidden");
    $("#btn-modal").removeClass("hidden");
};

actualizarTabla = function()
{
    $("#tbl-aulas").find("tr:gt(0)").remove();
    $.ajax(
    {
        url: "../ajax/procesar_nueva_aula.php?accion=generarTabla",
        method: "POST",
        success: function(tabla)
        {
            $("#tbl-aulas").append(tabla);
        }
    });
};

agregarDatos = function(objeto)
{
    $("#txt-codigo-aula").val(objeto.codigo_aula);
    $("#txt-alias-aula").val(objeto.alias);
    $("#txt-capacidad-aula").val(objeto.capacidad);
    $("#slc-edificio").val(objeto.codigo_edificio);
};

radioChecked = function()
{
    return $("input[name='rad-aulas']:checked").val();
};

$(document).ready(function()
{
    actualizarTabla();
    $("#btn-nueva-aula-guardar").click(function()
    {
        if(verificarCampos(campos))
        {
            var parametros = procesarParametros(campos);
            $.ajax(
            {
                url: "../ajax/procesar_nueva_aula.php?accion=guardarAula",
                method: "POST",
                data: parametros,
                dataType: "html",
                success: function(texto)
                {
                    actualizarTabla();
                    limpiarCampos(campos);
                    resetFormulario();
                },
                error: function()
                {
                    errorDeIntegridad();
                    $("#div-alert-mensaje").html("Error! Ya existe una aula con ese nombre en el mismo edificio.");
                    $("#div-alert-mensaje").removeClass("hidden");
                }
            });
        }
    });

    $("#btn-nueva-aula-cancelar").click(function()
    {
        limpiarCampos(campos);
        resetFormulario();
    });

    $("#btn-nueva-aula-eliminar").click(function()
    {
        if(radioChecked())
        {
            var parametros = "codigo_aula=" + radioChecked();
            $.ajax(
            {
                url: "../ajax/procesar_nueva_aula.php?accion=eliminarAula",
                method: "POST",
                data: parametros,
                success:function()
                {
                    actualizarTabla();
                    $("#div-alert-mensaje").addClass("hidden");
                }
            });
        }
    });

    $("#btn-nueva-aula-editar").click(function()
    {
        if(radioChecked())
        {
            var parametros = "codigo_aula=" + radioChecked();
            $.ajax(
            {
                url: "../ajax/procesar_nueva_aula.php?accion=obtenerAula",
                method: "POST",
                data: parametros,
                dataType: "json",
                success:function(objeto)
                {
                    $("#btn-nueva-aula-actualizar").removeClass("hidden");
                    $("#btn-nueva-aula-guardar").addClass("hidden");
                    $("#btn-modal").addClass("hidden");
                    $("#div-alert-mensaje").addClass("hidden");
                    agregarDatos(objeto);
                }
            });
        }
    });

    $("#btn-nueva-aula-actualizar").click(function()
    {
        var parametros = procesarParametros(campos);
        $.ajax(
        {
            method: "POST",
            data: parametros,
            url: "../ajax/procesar_nueva_aula.php?accion=modificarAula",
            success: function(texto)
            {
                actualizarTabla();
                limpiarCampos(campos);
                resetFormulario();
            },
            error: function()
            {
                errorDeIntegridad();
                $("#div-alert-mensaje").html("Error! Ya existe una aula con ese nombre en ese mismo edificio.");
                $("#div-alert-mensaje").removeClass("hidden");
            }
        });
    });
});
