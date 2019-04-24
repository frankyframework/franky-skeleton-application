function EliminarRegistro(funcion,id,status,msg,callback)
{

    var var_query = {
                        function: funcion,
                        vars_ajax:[id,status]
                    };

    if(!callback || callback.length == 0)
    {
        callback = "EliminarRegistroPanel";
    }

    if(status == 1)
    {
        $("#"+id).attr("href","#desactivar").html("<i class='icon  icon-r-eliminar'> </i>").trigger("eliminar-registro")
        pasarelaAjax('GET',var_query,callback,var_query.vars_ajax);
        return true;
    }

    var now = $.now();
    if(!msg || msg.length == 0)
    {

        msg = "¿Realmente quiere eliminar este registro?";
    }


    var confirm = $('<div id="dialog-confirm'+now+'" title="Advertencia">\
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>'+msg+'</p>\
    </div>');


    $(function() {
        $( confirm ).dialog({
            resizable: false,
            height:140,
            modal: true,
            buttons: {
                "Aceptar": function() {
                    $("#"+id).attr("href","#activar").html("<i class='icon  icon-c-encender'> </i>").trigger("eliminar-registro")


                    pasarelaAjax('GET',var_query,callback,var_query.vars_ajax);
                    $( this ).dialog( "close" );

                },
                "Cancelar": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });

}


function EliminarRegistroPanel(response,id, status)
{

    var respuesta = null;
    if(response != "null" && response != null)
    {
        respuesta = JSON.parse(response);

        if(respuesta[0] && respuesta[0]["message"])
        {
            _alert(respuesta[0]["message"],"");
        }
        $("#"+id).attr("href","#"+(status == 0 ? "desactivar" : "activar"))
        $("#"+id).html((status == 0 ? "<i class='icon  icon-r-eliminar'> </i>" : "<i class='icon  icon-c-encender'> </i>"))
    }
    else
    {

        $("#"+id).attr("href","#"+(status == 1 ? "desactivar" : "activar"))
        $("#"+id).html((status == 1 ? "<i class='icon  icon-r-eliminar'> </i>" : "<i class='icon  icon-c-encender'> </i>"))


    }
    $("#"+id).trigger("eliminar-registro")
}

function EliminarRegistorPanelRemove(response,id,status)
{

    var respuesta = null;
    if(response != "null" && response != null)
    {
        respuesta = JSON.parse(response);

        if(respuesta[0] && respuesta[0]["message"])
        {
            _alert(respuesta[0]["message"],"");
        }
    }
    else
    {
        $("#content_row_"+id).remove()
        $("#cat_"+id).remove();
    }
    $("#"+id).trigger("eliminar-registro")

}

function EliminarRegistroPanelReload(response,id,status)
{

    var respuesta = null;
    if(response != "null" && response != null)
    {
        respuesta = JSON.parse(response);

        if(respuesta[0] && respuesta[0]["message"])
        {

            _alert(respuesta[0]["message"],"");
        }
    }
    else
    {
        window.location.reload();
    }
}



function EliminarDevice(funcion,id,status,msg,callback)
{
    if(!callback || callback.length == 0)
    {
        callback = "EliminarRegistroPanel";
    }
    if(!msg || msg.length == 0)
    {
        if(status == 1)
        {
            msg = "¿Realmente quiere desbloquear este dispositivo?";

        }
        else {
            msg = "¿Realmente quiere bloquear este dispositivo?";
        }
    }
    var now = $.now();

    var confirm = $('<div id="dialog-confirm'+now+'" title="Advertencia">\
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>'+msg+'</p>\
    <label><input type="password" name="contrasena'+now+'" placeholder="Introduce tu contraseña" />\
    </div>');



    $(function() {
        $( confirm ).dialog({
            resizable: false,
            height:140,
            modal: true,
            buttons: {
                "Aceptar": function() {

                  var var_query = {
                                      function: funcion,
                                      vars_ajax:[ $('input[name=contrasena'+now+']').val(),id,status]
                          };
                    if(status == 1)
                    {
                      $("#"+id).attr("href","#desactivar").html("<i class='icon  icon-r-eliminar'> </i>").trigger("eliminar-registro")
                    }
                    else{
                      $("#"+id).attr("href","#activar").html("<i class='icon  icon-c-encender'> </i>").trigger("eliminar-registro")
                    }



                    pasarelaAjax('GET',var_query,callback,[id,status]);
                    $( this ).dialog( "close" );

                },
                "Cancelar": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });

}
