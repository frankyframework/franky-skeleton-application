function registrarEmail()
{
    var email = $("input[name=mailing]").val();

    if(email == "")
    {
        $("#msg_mailing").css("display","").children("span").addClass("error").html("Favor de escribir una direccion de e-mail");
    }
    else
    {
        var var_query = {
          "function": "registrarEmail",
          "vars_ajax":[email]
        };


        pasarelaAjax('GET', var_query, "registrarEmailHTML", "");
    }
}


function registrarEmailHTML(response)
{

    var respuesta = null;
    if (response != "null")
    {
        respuesta = JSON.parse(response);

        if (respuesta["message"] == "success")
        {
             $("#msg_mailing").css("display","").children("span").addClass("success").html("El e-mail se registro correctamente");
             $("input[name=mailing]").val("");
            return true;
        }
        else if (respuesta["message"] == "error")
        {
             $("#msg_mailing").css("display","").children("span").addClass("error").html("Error favor de intentar mas tarde");
                return true;
        }
        else if (respuesta["message"] == "bad")
        {
             $("#msg_mailing").css("display","").children("span").addClass("error").html("La direccion de e-mail no es valida");
                return true;
        }
        else if (respuesta["message"] == "duplicate")
        {
             $("#msg_mailing").css("display","").children("span").addClass("error").html("La direccion de e-mail ya esta registrada");
                return true;
        }

    }
    $("#msg_mailing").css("display","").children("span").addClass("error").html("Error favor de intentar mas tarde");
    return false;
}

function registrarEmailCuerpo()
{
    var email = $("input[name=mailing_cuerpo]").val();

    if(email == "")
    {
        $("#msg_mailing_cuerpo").css("display","").children("span").addClass("error").html("Favor de escribir una direccion de e-mail");
    }
    else
    {
        var var_query = {
          "function": "registrarEmail",
          "vars_ajax":[email]
        };

        pasarelaAjax('GET', var_query, "registrarEmailCuerpoHTML", "");
    }
}


function registrarEmailCuerpoHTML(response)
{

    var respuesta = null;
    if (response != "null")
    {
        respuesta = JSON.parse(response);

        if (respuesta["message"] == "success")
        {
             $("#msg_mailing_cuerpo").css("display","").children("span").addClass("success").html("El e-mail se registro correctamente");
             $("input[name=mailing_cuerpo]").val("");
            return true;
        }
        else if (respuesta["message"] == "error")
        {
             $("#msg_mailing_cuerpo").css("display","").children("span").addClass("error").html("Error favor de intentar mas tarde");
                return true;
        }
        else if (respuesta["message"] == "bad")
        {
             $("#msg_mailing_cuerpo").css("display","").children("span").addClass("error").html("La direccion de e-mail no es valida");
                return true;
        }
        else if (respuesta["message"] == "duplicate")
        {
             $("#msg_mailing_cuerpo").css("display","").children("span").addClass("error").html("La direccion de e-mail ya esta registrada");
                return true;
        }

    }
    $("#msg_mailing_cuerpo").css("display","").children("span").addClass("error").html("Error favor de intentar mas tarde");
    return false;
}

function setExplorador()
{
    var var_query = {
          "function": "setExplorador"
    };

    pasarelaAjax('GET', var_query, "setExploradorHTML", "");
}

function setExploradorHTML(response)
{
    return true;
}



function showResponseHTML(response,id)
{

    var respuesta = null;
    if(response != "null" && response != null)
    {
        respuesta = JSON.parse(response);
        if(respuesta.html)
        {
          //console.log(id);
          $(id).html(respuesta.html);
        }

    }

}
