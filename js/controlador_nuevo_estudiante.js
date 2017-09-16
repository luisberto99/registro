var campos = 
[
    "txt-codigo-estudiante",
    "txt-nombre-estudiante", 
    "txt-apellido-estudiante",
    "slc-genero-estudiante", 
    "txt-identidad-estudiante", 
    "txt-email-estudiante", 
    "slc-region",
    "slc-carrera",
    "txt-clave-estudiante",
    "txt-verificar-clave-estudiante",
    "date-nacimiento-estudiante"
];

errorDeIntegridad = function()
{
    hasError("#div-txt-identidad-estudiante");
    hasError("#div-txt-email-estudiante");
};

resetFormulario = function()
{
    $("#div-alert-mensaje").addClass("hidden");
    $("input[name=rad-estudiantes]").attr("checked",false);
    $("#btn-nuevo-estudiante-actualizar").addClass("hidden");
    $("#btn-nuevo-estudiante-guardar").removeClass("hidden");
    $("#btn-nuevo-estudiante-guardar").prop("disabled", true);
    $("#txt-verificar-clave-estudiante").val("");
    $("#btn-modal").removeClass("hidden");
    $("#form-fotografia")[0].reset();
};

actualizarTabla = function()
{
    $("#tbl-estudiantes").find("tr:gt(0)").remove();
    $.ajax(
    {
        url: "../ajax/procesar_nuevo_estudiante.php?accion=generarTabla",
        method: "POST",
        success: function(tabla)
        {
            $("#tbl-estudiantes").append(tabla);
        }
    });
};

verificarClave = function()
{
    var verificado = ($("#txt-clave-estudiante").val() == $("#txt-verificar-clave-estudiante").val());
    if (verificado)
    {
        hasSuccess("#div-txt-clave-estudiante");
        hasSuccess("#div-txt-verificar-clave-estudiante");
    }
    else
    {
        hasError("#div-txt-clave-estudiante");
        hasError("#div-txt-verificar-clave-estudiante");
    }
    $("#txt-clave-estudiante").val("");
    $("#txt-verificar-clave-estudiante").val("");
    return verificado;
};

agregarDatos = function(objeto)
{
    $("#txt-nombre-estudiante").val(objeto.nombres);
    $("#txt-codigo-estudiante").val(objeto.codigo_usuario);
    $("#txt-apellido-estudiante").val(objeto.apellidos);
    $("#slc-genero-estudiante").val(objeto.genero);
    $("#txt-identidad-estudiante").val(objeto.codigo_identidad);
    $("#txt-email-estudiante").val(objeto.email);
    $("#slc-region").val(objeto.codigo_region);
    $("#slc-carrera").val(objeto.codigo_carrera);
    $("#date-nacimiento-estudiante").val(objeto.fecha_nacimiento);
};

guardarEstudiante = function(parametros)
{
    $.ajax(
    {
        url: "../ajax/procesar_nuevo_estudiante.php?accion=guardarEstudiante",
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
            $("#div-alert-mensaje").html("Error! Ya existe un estudiante con ese codigo de identidad / correo electronico.");
            $("#div-alert-mensaje").removeClass("hidden");
        }
    });
};

modificarEstudiante = function(parametros)
{
    $.ajax(
    {
        url: "../ajax/procesar_nuevo_estudiante.php?accion=modificarEstudiante",
        method: "POST",
        data: parametros,
        dataType: "html",
        success:function(texto)
        {
            actualizarTabla();
            limpiarCampos(campos);
            resetFormulario();
        },
        error:function()
        {
            errorDeIntegridad();
            $("#div-alert-mensaje").html("Error! Ya existe un estudiante con ese codigo de identidad / correo electronico.");
            $("#div-alert-mensaje").removeClass("hidden");
        }
    });
};

radioChecked = function()
{
    return $("input[name='rad-estudiantes']:checked").val();
};

$(document).ready(function()
{
    actualizarTabla();
    $("input[name='input-foto-estudiante']").on("change", function()
    {
        var formData = new FormData($("#form-fotografia")[0]);
        $.ajax(
        {
            url: "../ajax/procesar_nuevo_estudiante.php?accion=verificarFoto",
            type: "POST",
            dataType: "json",
            data: formData,
            contentType: false,
            processData: false,
            success:function(foto)
            {
                if (foto.esValida)
                {
                    $("#btn-nuevo-estudiante-guardar").prop("disabled", false);
                    $("#btn-nuevo-estudiante-actualizar").prop("disabled", false);
                }
                else
                {
                    $("#btn-nuevo-estudiante-guardar").prop("disabled", true);
                    $("#btn-nuevo-estudiante-actualizar").prop("disabled", true);
                }
            }
        });
    });

    $("#btn-nuevo-estudiante-guardar").click(function()
    {
        if(verificarCampos(campos) && verificarClave())
        {
            var formData = new FormData($("#form-fotografia")[0]);
            $.ajax(
            {
                url: "../ajax/procesar_nuevo_estudiante.php?accion=guardarFoto",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success:function(url_imagen)
                {
                    var parametros = procesarParametros(campos) + "&url_imagen=" + url_imagen;
                    guardarEstudiante(parametros);
                }
            });
        }
    });

    $("#btn-nuevo-estudiante-cancelar").click(function()
    {
        limpiarCampos(campos);
        resetFormulario();
    });

    $("#btn-nuevo-estudiante-eliminar").click(function()
    {
        if(radioChecked())
        {
            var parametros = "codigo_usuario=" + radioChecked();
            $.ajax(
            {
                url: "../ajax/procesar_nuevo_estudiante.php?accion=eliminarEstudiante",
                method: "POST",
                data: parametros,
                dataType: "html",
                success:function()
                {
                    actualizarTabla();
                    $("#div-alert-mensaje").addClass("hidden");
                }
            });
        }
    });

    $("#btn-nuevo-estudiante-editar").click(function()
    {
        $("#form-fotografia")[0].reset();
        if(radioChecked())
        {
            var parametros = "codigo_usuario=" + radioChecked();
            $.ajax(
            {
                method: "POST",
                data: parametros,
                url: "../ajax/procesar_nuevo_estudiante.php?accion=obtenerEstudiante",
                dataType: "json",
                success:function(objeto)
                {
                    $("#btn-nuevo-estudiante-actualizar").removeClass("hidden");
                    $("#btn-nuevo-estudiante-actualizar").prop("disabled", true);
                    $("#btn-nuevo-estudiante-guardar").addClass("hidden");
                    $("#btn-modal").addClass("hidden");
                    $("#div-alert-mensaje").addClass("hidden");
                    agregarDatos(objeto);
                }
            });
        }
    });

    $("#btn-nuevo-estudiante-actualizar").click(function()
    {
        if(verificarCampos(campos) && verificarClave())
        {
            var formData = new FormData($("#form-fotografia")[0]);
            $.ajax(
            {
                url: "../ajax/procesar_nuevo_estudiante.php?accion=guardarFoto",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success:function(url_imagen)
                {
                    var parametros = procesarParametros(campos) + "&url_imagen=" + url_imagen;
                    modificarEstudiante(parametros);
                }
            });
        }
    });
});
