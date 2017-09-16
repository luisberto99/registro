var campos = 
[
    "txt-codigo-edificio",
    "txt-nombre-edificio", 
    "slc-region"
];

errorDeIntegridad = function()
{
    $hasError("#div-txt-nombre-edificio");
};

resetFormulario = function()
{
    $("input[name=rad-edificios]").attr("checked",false);
    $("#div-alert-mensaje").addClass("hidden");
    $("#btn-nuevo-edificio-actualizar").addClass("hidden");
    $("#btn-nuevo-edificio-guardar").removeClass("hidden");
    $("#btn-modal").removeClass("hidden");
};

actualizarTabla = function()
{
    $("#tbl-edificios").find("tr:gt(0)").remove();
    $.ajax(
    {
        url: "../ajax/procesar_nuevo_edificio.php?accion=generarTabla",
        method: "POST",
        success: function(tabla)
        {
            $("#tbl-edificios").append(tabla);
        }
    });
};

agregarDatos = function(objeto)
{
    $("#txt-nombre-edificio").val(objeto.alias);
    $("#txt-codigo-edificio").val(objeto.codigo_edificio);
    $("#slc-region").val(objeto.codigo_region);
};

radioChecked = function()
{
    return $("input[name='rad-edificios']:checked").val();
};

$(document).ready(function()
{
    actualizarTabla();
    $("#btn-nuevo-edificio-guardar").click(function()
    {
        if(verificarCampos(campos))
        {
            var parametros = procesarParametros(campos);
            $.ajax(
            {
                url: "../ajax/procesar_nuevo_edificio.php?accion=guardarEdificio",
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
                    $("#div-alert-mensaje").html("Error! Ya existe un edificio con ese nombre.");
                    $("#div-alert-mensaje").removeClass("hidden");
                }
            });
        }
    });

    $("#btn-nuevo-edificio-cancelar").click(function()
    {
        limpiarCampos(campos);
        resetFormulario();
    });

    $("#btn-nuevo-edificio-eliminar").click(function()
    {
        if(radioChecked())
        {
            var parametros = "codigo_edificio=" + radioChecked();
            $.ajax(
            {
                url: "../ajax/procesar_nuevo_edificio.php?accion=eliminarEdificio",
                method: "POST",
                data: parametros,
                dataType: "html",
                success: function()
                {
                    actualizarTabla();
                    $("#div-alert-mensaje").addClass("hidden");
                }
            });
        }
    });

    $("#btn-nuevo-edificio-editar").click(function()
    {
        if(radioChecked())
        {
            var parametros = "codigo_edificio=" + radioChecked();
            $.ajax(
            {
                url: "../ajax/procesar_nuevo_edificio.php?accion=obtenerEdificio",
                method: "POST",
                data: parametros,
                dataType: "json",
                success: function(objeto)
                {
                    $("#btn-nuevo-edificio-actualizar").removeClass("hidden");
                    $("#btn-nuevo-edificio-guardar").addClass("hidden");
                    $("#btn-modal").addClass("hidden");
                    $("#div-alert-mensaje").addClass("hidden");
                    agregarDatos(objeto);
                }
            });
        }
    });

    $("#btn-nuevo-edificio-actualizar").click(function()
    {
        var parametros = procesarParametros(campos);
        $.ajax(
        {
            url: "../ajax/procesar_nuevo_edificio.php?accion=modificarEdificio",
            method: "POST",
            data: parametros,
            success: function(texto)
            {
                actualizarTabla();
                limpiarCampos(campos);
                resetFormulario();
            },
            error: function()
            {
                errorDeIntegridad();
                $("#div-alert-mensaje").html("Error! Ya existe un edificio con ese nombre.");
                $("#div-alert-mensaje").removeClass("hidden");
            }
        });
    });
});
