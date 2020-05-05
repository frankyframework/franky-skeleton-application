function EliminarRegistroEcommerce(funcion,id,status,msg,callback)
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

function eliminarProductoCarrito(id)
{
    EliminarRegistroEcommerce("eliminarProductoCarrito",id,0,'¿Realmente quiere eliminar el producto?',"eliminarProductoCarritoHTML");
}


function eliminarProductoCarritoHTML(response,id)
{
    var respuesta = null;
    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(respuesta["error"])
        {
            _alert(respuesta["message"],"Error");
        }
        else{

            $(".contenedor_producto_"+id).fadeOut('fast',function(){
                $(this).remove();
                setQTYProductoCarridoHTML(response);
                addProductoCarritoHTML(response,0);
            })

        }

    }
    return true;
}

function llenaCarrido()
{
     var var_query = {
          "function": "getInfoCarrito",
          "vars_ajax":[]
    };

    pasarelaAjax('GET',var_query,"addProductoCarritoHTML",[0],null);
}


function addProductoCarrito(id,qty)
{
    var caracteristicas = {};
     var var_query = {
          "function": "addProductoCarrito",
          "vars_ajax":[id,qty,caracteristicas]
    };

    pasarelaAjax('GET',var_query,"addProductoCarritoHTML",[qty]);
}


function addProductoCarritoHTML(response,show)
{
    var respuesta = null;

    $("#widget_carrito .cont_detalle .productos").empty();
    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(!respuesta["error"])
        {
            if(respuesta["productos"])
            {
                for(var i=0; i < respuesta["productos"].length; i++)
                {

                    $("#widget_carrito .cont_detalle .productos")
                    .append("<div class='w-xxxx-12 _minicart_product contenedor_producto_"+respuesta["productos"][i]["id"]+"'>\
                                <div class='w-xxxx-3 _minicart_image'>\
                                    <img src='"+respuesta["productos"][i]["img"]+"'>\
                                    </div>\
                                    <div class='w-xxxx-8 _minicart_prices'><div>"+
                                        respuesta["productos"][i]["nombre"]+
                                        "</div><div> x<span>"+respuesta["productos"][i]["qty"]+
                                        "</span> <span class='_unit_price'>"+respuesta["productos"][i]["precio"]+
                                "</span></div>\
                                <div class='w-xxxx-1 _minicart_delete'>\
                                    <a href=\"javascript:void(0);\" onclick=\"eliminarProductoCarrito('"+respuesta["productos"][i]["id"]+"')\" ><i class=\"icon icon-r-eliminar\"></i></a>\
                                <div>\
                                </div>\
                            </div>");

                }
            }
            $("#widget_carrito .cont_detalle .productos")
            .append("<div class='w-xxxx-12 _minicart_resume'>\
                <div class='_subtotal'>Subtotal: "+respuesta["subtotal"]+"</div>\
                  <div class='_subtotal'>IVA: "+respuesta["iva"]+"</div>\
                <div class='_total'>Total: "+respuesta["total"]+"</div>\
            </div>");
            $("#widget_carrito .abrir_carrito .count_productos").text(respuesta["qty"]);
            if(parseInt(show)== 1)
            {
                $(".cont_detalle").show();
            }

        }
        else
        {
            _alert(respuesta["message"],"Error");
        }

    }

    return true;
}

function setQTYProductoCarrido(id,qty)
{

     var var_query = {
          "function": "setQTYProductoCarrido",
          "vars_ajax":[id,qty]
    };

    var var_function = [id];

    pasarelaAjax('GET',var_query,"setQTYProductoCarridoHTML",var_function);
}


function setQTYProductoCarridoHTML(response,id)
{
    var respuesta = null;
    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(!respuesta["error"])
        {
            if(respuesta["productos"])
            {
                for(var i=0; i < respuesta["productos"].length; i++)
                {
                    $(".contenedor_producto_"+respuesta["productos"][i]["id"]).find('.subtotal_producto').html(respuesta["productos"][i]["subtotal"]);
                    $(".contenedor_producto_"+respuesta["productos"][i]["id"]).find('.precio_producto').html(respuesta["productos"][i]["precio"]);
                }
                $(".resumen_page_carrito .subtotal").html(respuesta.subtotal);
                $(".resumen_page_carrito .iva").html(respuesta.iva);
                $(".resumen_page_carrito .total").html(respuesta.total);

                addProductoCarritoHTML(response,0)
            }
            else
            {
                $(".content_carrito").html("El carrito esta vacio");
            }


        }
        else
        {
            _alert(respuesta["message"],"Error")
        }

    }
    return true;

}

function eliminarCuponCarrito(cupon)
{

    EliminarRegistro("eliminarCuponCarrito",cupon,0,'¿Realmente quiere eliminar el cupon?',"eliminarCuponCarritoHTML");

}


function eliminarCuponCarritoHTML(response)
{
    var respuesta = null;
    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(!respuesta.error)
        {
            window.location.reload;
        }
        else
        {
            _alert(respuesta["message"],"Error")
        }

    }
    return true;

}




function setFacturacionCheckout()
{
    var id_facturacion= $("input[name=id_facturacion]:checked").val();

    var var_query = {
        function: "setFacturacionCheckout",
        vars_ajax:[id_facturacion]
    };
    var var_function = [];
    pasarelaAjax('GET',var_query,"setFacturacionCheckoutHTML",var_function);
}


function setFacturacionCheckoutHTML(response)
{
    var respuesta = null;
    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(!respuesta.error)
        {
            $(".direccion_facturacion").next("div").hide();
            $(".direccion_facturacion").toggleClass("_nono").toggleClass("_sisi").toggleClass('_active');
            $(".metodo_envio").toggleClass('_active').next("div").show();
            $("#resumen_checkout_facturacion").html(respuesta.resumen_facturacion);
            loadMetodosEnvio();
        }
        else
        {
            _alert(respuesta["message"],"Error")
        }

    }
    return true;
}

function setNuevaFacturacionCheckout()
{
    var var_query = {
        function: "setNuevaFacturacionCheckout",
        vars_ajax:[JSON.stringify($("form[name=frmdirecciones_facturacion]").serializeArray())]
    };
    var var_function = [];
    pasarelaAjax('GET',var_query,"setNuevaFacturacionCheckoutHTML",var_function);
}



function setNuevaFacturacionCheckoutHTML(response)
{
    var respuesta = null;
    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(!respuesta.error)
        {
            $(".direccion_facturacion").next("div").hide();
            $(".direccion_facturacion").toggleClass("_nono").toggleClass("_sisi").toggleClass('_active');
            $(".metodo_envio").toggleClass('_active').next("div").show();
            $("#resumen_checkout_facturacion").html(respuesta.resumen_facturacion);
            loadMetodosEnvio();
        }
        else
        {
            _alert(respuesta["message"],"Error")
        }

    }
    return true;
}

function setNuevaDireccionCheckout()
{
    var var_query = {
        function: "setNuevaDireccionCheckout",
        vars_ajax:[JSON.stringify($("form[name=frmdirecciones]").serializeArray())]
    };
    var var_function = [];
    pasarelaAjax('GET',var_query,"setNuevaDireccionCheckoutHTML",var_function);
}



function setNuevaDireccionCheckoutHTML(response)
{
    var respuesta = null;
    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(!respuesta.error)
        {
            $(".direccion_entrega").next("div").hide();
            $(".direccion_entrega").toggleClass("_nono").toggleClass("_sisi").toggleClass('_active');
            $(".direccion_facturacion").toggleClass('_active').next("div").show();
            $("#resumen_checkout_envio").html(respuesta.resumen_envio);
        }
        else
        {
            _alert(respuesta["message"],"Error")
        }

    }
    return true;
}


function setDireccionCheckout()
{
    var id_envio= $("input[name=id_envio]:checked").val();

    var var_query = {
        function: "setDireccionCheckout",
        vars_ajax:[id_envio]
    };
    var var_function = [];
    pasarelaAjax('GET',var_query,"setDireccionCheckoutHTML",var_function);
}


function setDireccionCheckoutHTML(response)
{
    var respuesta = null;
    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(!respuesta.error)
        {
            $(".direccion_entrega").next("div").hide();
            $(".direccion_entrega").toggleClass("_nono").toggleClass("_sisi").toggleClass('_active');
            $(".direccion_facturacion").toggleClass('_active').next("div").show();
            $("#resumen_checkout_envio").html(respuesta.resumen_envio);
        }
        else
        {
            _alert(respuesta["message"],"Error")
        }

    }
    return true;
}


function loadMetodosEnvio()
{
    var var_query = {
        function: "loadMetodosEnvio",
        vars_ajax:[]
    };
    var var_function = [];
    pasarelaAjax('GET',var_query,"loadMetodosEnvioHTML",var_function);
}


function loadMetodosEnvioHTML(response)
{
    var respuesta = null;
    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(respuesta.envio_requerido == 1)
        {
            $("#content_metodo_envio").html(respuesta.html);
            $( "#frm_metodo_envio" ).validate({
                submitHandler: function(form)
                {
                     setMetodoEnvioCheckout();
                     return false;
                }
            });
        }
        else{
            $(".metodo_envio").next("div").hide();
            $(".metodo_envio").toggleClass("_nono").toggleClass("_sisi").toggleClass('_active');
            $(".metodo_pago").toggleClass('_active').next("div").show();
            loadMetodosPago();
        }
       
    }
    return true;
}


function setMetodoEnvioCheckout()
{
    var id_metodo_envio= $("input[name=id_metodo_envio]:checked").val();

    var var_query = {
        function: "setMetodoEnvioCheckout",
        vars_ajax:[id_metodo_envio]
    };
    var var_function = [];
    pasarelaAjax('GET',var_query,"setMetodoEnvioCheckoutHTML",var_function);
}


function setMetodoEnvioCheckoutHTML(response)
{
    var respuesta = null;
    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(!respuesta.error)
        {
            $(".metodo_envio").next("div").hide();
            $(".metodo_envio").toggleClass("_nono").toggleClass("_sisi").toggleClass('_active');
            $(".metodo_pago").toggleClass('_active').next("div").show();
            $("#resumen_metodo_envio").html(respuesta.resumen_metodo_envio);
            $("._checkout_envio").children('.price').html(respuesta.monto_envio_html);
            $("._checkout_envio").show();
            $("._checkout_total").children('.price').html(respuesta.gran_total_html);
            loadMetodosPago();
        }
        else
        {
            _alert(respuesta["message"],"Error")
        }

    }
    return true;
}


function loadMetodosPago()
{
    var var_query = {
        function: "loadMetodosPago",
        vars_ajax:[]
    };
    var var_function = [];
    pasarelaAjax('GET',var_query,"loadMetodosPagoHTML",var_function);
}


function loadMetodosPagoHTML(response)
{
    var respuesta = null;
    if(response != "null")
    {
        respuesta = JSON.parse(response);

        
        $("#content_metodo_pago").html(respuesta.html);
        $( "#frm_pago" ).validate({
                submitHandler: function(form)
                {
                     setconfigPago();
                     return false;
                }
        });
        $('input[name=id_pago]').each(function(index,val){
          $(this).next('span').addClass($(this).val());
        });
       
    }
    return true;
}


function setconfigPago()
{

    var id_pago = $('input:radio[name=id_pago]:checked').val();

    if(id_pago != "")
    {

        var var_query = {
            "function": "setconfigPago",
            "vars_ajax":[id_pago]
        };

        var var_function = [id_pago];

        pasarelaAjax('GET',var_query,"setconfigPagoHTML",var_function);
    }

}


function setconfigPagoHTML(response,id_pago)
{
    var respuesta = null;
    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(!respuesta.error)
        {
            $(".paga_ahora").next("div").show();
            $(".metodo_pago").toggleClass("_nono").toggleClass("_sisi").toggleClass('_active');
            $(".metodo_pago").next("div").hide();
            $(".paga_ahora").toggleClass('_active');
            getFrmPago(id_pago)
        }
        else
        {
            _alert(respuesta["message"],"Error")
        }

    }
    return true;
}

function getFrmPago(id_pago)
{

        var var_query = {
              "function": id_pago
        };

        var var_function = [];

        pasarelaAjax('GET',var_query,"getFrmPagoHTML",var_function);


}


function getFrmPagoHTML(response)
{
    var respuesta = null;
    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(!respuesta.error)
        {

            $("#contenedor_frm_pago").html(respuesta.html);
            if(respuesta.js)
            {
                eval(respuesta.js)
            }
        }
        else
        {
            _alert(respuesta["message"],"Error")
        }

    }
    return true;
}
