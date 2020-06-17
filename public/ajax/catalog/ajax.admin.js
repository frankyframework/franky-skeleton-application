function setOrdenImagesProducts(album,orden)
{
    var var_query = {
          "function": "setOrdenImagesProducts",
          "vars_ajax":[album,orden]
        };
    
    pasarelaAjax('GET', var_query, "setOrdenImagesProductsHTML", '');
}



function setOrdenImagesProductsHTML(response)
{
    var respuesta = null;
    if (response != "null")
    {
        respuesta = JSON.parse(response);
       
    }

    return true;
}


function eliminarFotoCatalogProduct(image)
{
    EliminarRegistro("eliminarFotoCatalogProduct",image,0,'¿Realmente quiere eliminar esta foto?',"eliminarFotoCatalogProductHTML");
}

function eliminarFotoCatalogProductHTML(response)
{
    var respuesta = null;

    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(respuesta[0]["message"] == "success")
        {

            $(".foto_"+respuesta[0]["id"]).fadeOut(500,function(){
                $(".foto_"+respuesta[0]["id"]).remove();
            });
        }
        else
        {
             _alert(respuesta[0]["message"],"Error")
        }

    }
}
function ajax_products_cargarProductosRelacionados(id)
{
     var var_query = {
          "function": "ajax_products_cargarProductosRelacionados",
          "vars_ajax":[id]
        };
    
    pasarelaAjax('GET', var_query, "ajax_products_cargarProductosRelacionadosHTML", var_query.vars_ajax);
}
function ajax_products_cargarProductosRelacionadosHTML(response,id){
    
    var respuesta = null;

    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(respuesta["error"])
        {

            if(respuesta["message"]){
                 _alert(respuesta["message"],"Error")
            }
        }
        else{
             $("input[type=checkbox]").prop('checked',false);
            $('.cont_productos_relacionados').html(respuesta.html);
           
            $(".contenedor_columnas_info_relacionados").htmlDataDum(respuesta.lista_admin_data_relacionados,".no_hay_datos_relacionados");
            for(var x = 0; x<respuesta.lista_admin_data_relacionados.length;x++)
            {
                $('[value='+respuesta.lista_admin_data_relacionados[x].id+']').prop('checked',true);
                    
            }
            
            $("input[name='relacionado[]']").unbind('change').change(function(){

                if($(this).is(':checked'))
                {
                    ajax_products_agregarProductoRelacionado(id,$(this).attr('value'))
                }
                else{
                    ajax_products_quitarProductoRelacionado(id,$(this).attr('value'))
                }
      
            });
        }

    }
    
}

function ajax_products_agregarProductoRelacionado(id_parent,id)
{
    var var_query = {
          "function": "ajax_products_agregarProductoRelacionado",
          "vars_ajax":[id_parent,id]
        };
    
    pasarelaAjax('GET', var_query, "ajax_products_agregarProductoRelacionadoHTML", var_query.vars_ajax);
}

function ajax_products_agregarProductoRelacionadoHTML(response,id_parent)
{
    var respuesta = null;

    if(response != "null")
    {
        respuesta = JSON.parse(response);

        if(respuesta["error"])
        {

            if(respuesta["message"]){
                 _alert(respuesta["message"],"Error")
            }
        }

    }
    ajax_products_cargarProductosRelacionados(id_parent);
}



function ajax_products_quitarProductoRelacionado(id_parent,id)
{
    var var_query = {
          "function": "ajax_products_quitarProductoRelacionado",
          "vars_ajax":[id_parent,id]
        };
    
    pasarelaAjax('GET', var_query, "ajax_products_agregarProductoRelacionadoHTML",var_query.vars_ajax );
}