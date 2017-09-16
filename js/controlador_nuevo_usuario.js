var campos = 
[
    "txt-codigo-usuario",
    "txt-nombre-usuario",
    "txt-apellido-usuario",
    "slc-genero-usuario",
    "txt-identidad-usuario",
    "txt-email-usuario",
    "slc-tipo-usuario",
    "txt-clave-usuario",
    "txt-verificar-clave-usuario",
    "date-nacimiento-usuario"
];

errorDeIntegridad = function()
{
    hasError("#div-txt-identidad-usuario");
    hasError("#div-txt-email-usuario");
};

resetFormulario = function()
{
    $("input[name=rad-usuarios]").attr("checked",false);
    $("#div-alert-mensaje").addClass("hidden");
    $("#btn-nuevo-usuario-actualizar").addClass("hidden");
    $("#btn-nuevo-usuario-guardar").removeClass("hidden");
    $("#btn-nuevo-usuario-guardar").prop("disabled", true);
    $("#txt-verificar-clave-estudiante").val("");
    $("#btn-modal").removeClass("hidden");
    $("#form-fotografia")[0].reset();
};

actualizarTabla = function()
{
    $("#tbl-usuarios").find("tr:gt(0)").remove();
    $.ajax(
    {
        method: "POST",
        url: "../ajax/procesar_nuevo_usuario.php?accion=generarTabla",
        success:function(tabla)
        {
            $("#tbl-usuarios").append(tabla);
        }
    });
};

verificarClave = function()
{
    var verificado = ($("#txt-clave-usuario").val() == $("#txt-verificar-clave-usuario").val());
    if (verificado)
    {
        hasSuccess("#div-txt-clave-usuario");
        hasSuccess("#div-txt-verificar-clave-usuario");
    }
    else
    {
        hasError("#div-txt-clave-usuario");
        hasError("#div-txt-verificar-clave-usuario");
    }
    $("#txt-clave-usuario").val("");
    $("#txt-verificar-clave-usuario").val("");
    return verificado;
};

agregarDatos = function(objeto)
{
    $("#txt-nombre-usuario").val(objeto.nombres);
    $("#txt-codigo-usuario").val(objeto.codigo_usuario);
    $("#txt-apellido-usuario").val(objeto.apellidos);
    $("#slc-genero-usuario").val(objeto.genero);
    $("#date-nacimiento-usuario").val(objeto.fecha_nacimiento);
    $("#txt-identidad-usuario").val(objeto.codigo_identidad);
    $("#txt-email-usuario").val(objeto.email);
    $("#slc-tipo-usuario").val(objeto.codigo_tipo_usuario);
};

guardarUsuario = function(parametros)
{
    $.ajax(
    {
        url: "../ajax/procesar_nuevo_usuario.php?accion=guardarUsuario",
        method: "POST",
        data: parametros,
        dataType: "html",
        success: function(texto)
        {
            limpiarCampos(campos);
            resetFormulario();
            actualizarTabla();
        },
        error: function()
        {
            errorDeIntegridad();
            $("#div-alert-mensaje").html("Error! Ya existe un usuario con ese codigo de identidad / correo electronico.");
            $("#div-alert-mensaje").removeClass("hidden");
        }
    });
};

modificarUsuario = function(parametros)
{
    $.ajax(
    {
        url: "../ajax/procesar_nuevo_usuario.php?accion=modificarUsuario",
        method: "POST",
        data: parametros,
        success: function(texto)
        {
            limpiarCampos(campos);
            resetFormulario();
            actualizarTabla();
        },
        error: function()
        {
            errorDeIntegridad();
            $("#div-alert-mensaje").html("Error! Ya existe un usuario con ese codigo de identidad / correo electronico.");
            $("#div-alert-mensaje").removeClass("hidden");
        }
    });
};

radioChecked = function()
{
    return $("input[name='rad-usuarios']:checked").val();
};

$(document).ready(function()
{
    actualizarTabla();

    $("input[name='input-foto-usuario']").on("change", function()
    {
        var formData = new FormData($("#form-fotografia")[0]);
        $.ajax(
        {
            url: "../ajax/procesar_nuevo_usuario.php?accion=verificarFoto",
            type: "POST",
            dataType: "json",
            data: formData,
            contentType: false,
            processData: false,
            success: function(foto)
            {
                if (foto.esValida)
                {
                    $("#btn-nuevo-usuario-guardar").prop("disabled", false);
                    $("#btn-nuevo-usuario-actualizar").prop("disabled", false);
                }
                else
                {
                    $("#btn-nuevo-usuario-guardar").prop("disabled", true);
                    $("#btn-nuevo-usuario-actualizar").prop("disabled", true);
                }
            }
        });
    });

    $("#btn-nuevo-usuario-guardar").click(function()
    {
        if(verificarCampos(campos) && verificarClave())
        {
            var formData = new FormData($("#form-fotografia")[0]);
            $.ajax(
            {
                url: "../ajax/procesar_nuevo_usuario.php?accion=guardarFoto",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(url_imagen)
                {
                    var parametros = procesarParametros(campos) + "&url_imagen=" + url_imagen;
                    guardarUsuario(parametros);
                }
            });
        }
    });

    $("#btn-nuevo-usuario-cancelar").click(function()
    {
        limpiarCampos(campos);
        resetFormulario();
    });

    $("#btn-nuevo-usuario-eliminar").click(function()
    {
        if(radioChecked())
        {
            var parametros = "codigo_usuario=" + radioChecked();
            $.ajax(
            {
                url: "../ajax/procesar_nuevo_usuario.php?accion=eliminarUsuario",
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

    $("#btn-nuevo-usuario-editar").click(function()
    {
        $("#form-fotografia")[0].reset();
        if(radioChecked())
        {
            var parametros = "codigo_usuario=" + radioChecked();
            $.ajax(
            {
                url: "../ajax/procesar_nuevo_usuario.php?accion=obtenerUsuario",
                method: "POST",
                data: parametros,
                dataType: "json",

                success: function(objeto)
                {
                    $("#btn-nuevo-usuario-actualizar").removeClass("hidden");
                    $("#btn-nuevo-usuario-actualizar").prop("disabled", true);
                    $("#btn-nuevo-usuario-guardar").addClass("hidden");
                    $("#btn-modal").addClass("hidden");
                    $("#div-alert-mensaje").addClass("hidden");
                    agregarDatos(objeto);
                }
            });
        }
    });

    $("#btn-nuevo-usuario-actualizar").click(function()
    {
        if(verificarCampos(campos) && verificarClave())
        {
            var formData = new FormData($("#form-fotografia")[0]);
            $.ajax(
            {
                url: "../ajax/procesar_nuevo_usuario.php?accion=guardarFoto",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(url_imagen)
                {
                    var parametros = procesarParametros(campos) + "&url_imagen=" + url_imagen;
                    modificarUsuario(parametros);
                }
            });
        }
    });
});
