hasSuccess = function(campo)
{
    $(campo).removeClass("has-error").addClass("has-success");
};

hasError = function(campo)
{
    $(campo).removeClass("has-success").addClass("has-error");
};

hasNothing = function(campo)
{
    $(campo).removeClass("has-success").removeClass("has-error");
};

verificarCampos = function(campos)
{
    var isComplete = true;
    for (i = 1; i < campos.length; i++)
    {
        if ($.trim( $("#"+campos[i]).val() ).length <= 0 )
        {
            hasError("#div-"+campos[i]);
            isComplete = false;
        } 
        else 
        {
            hasSuccess("#div-"+campos[i]);
        }
    }
    return isComplete;
};

procesarParametros = function(campos)
{
    var parametros = campos[0] + "=" + $.trim($("#"+campos[0]).val());
    for (i = 1; i < campos.length; i++)
    {
        parametros += "&" + campos[i] + "=" +  $.trim($("#"+campos[i]).val());
    }
    return parametros;
};

limpiarCampos = function(campos)
{
    for (i = 0; i < campos.length; i++)
    {
        hasNothing("#div-"+campos[i]);
        $("#"+campos[i]).val("");
    }
};

$(document).ready(function()
{
    var parametros = "pagina=" + $.trim(document.location.pathname.match(/[^\/]+$/)[0]);

    $.ajax(
    {
        url: "../ajax/procesar.php?accion=generarSettings",
        method: "POST",
        dataType: "html",
        success: function(html)
        {
            $("#div-user-settings").html(html);
        }
    });

    $.ajax(
    {
        url: "../ajax/procesar.php?accion=generarMenu",
        method: "POST",
        dataType: "html",
        data: parametros,
        success: function(html)
        {
            $("#menu-top").html(html);
        }
    });

    $.ajax(
    {
        url: "../ajax/procesar.php?accion=verificarAcceso",
        method: "POST",
        dataType: "json",
        data: parametros,
        success: function(respuesta)
        {
            if (!respuesta.acceso)
            {
                $("#div-wrapper").html("<h1><p class='text-center'>Acceso denegado.</p></h1>");
            }
        }
    });
});
