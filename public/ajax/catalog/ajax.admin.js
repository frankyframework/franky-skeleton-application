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




/* VITRINAS */



function ajax_products_cargarProductosRelacionadosVitrina(id)
{
     var var_query = {
          "function": "ajax_products_cargarProductosRelacionadosVitrina",
          "vars_ajax":[id]
        };
    
    pasarelaAjax('GET', var_query, "ajax_products_cargarProductosRelacionadosVitrinaHTML", var_query.vars_ajax);
}
function ajax_products_cargarProductosRelacionadosVitrinaHTML(response,id){
    
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
                    ajax_products_agregarProductoRelacionadoVitrina(id,$(this).attr('value'))
                }
                else{
                    ajax_products_quitarProductoRelacionadoVitrina(id,$(this).attr('value'))
                }
      
            });
        }

    }
    
}

function ajax_products_agregarProductoRelacionadoVitrina(id_parent,id)
{
    var var_query = {
          "function": "ajax_products_agregarProductoRelacionadoVitrina",
          "vars_ajax":[id_parent,id]
        };
    
    pasarelaAjax('GET', var_query, "ajax_products_agregarProductoRelacionadoVitrinaHTML", var_query.vars_ajax);
}

function ajax_products_agregarProductoRelacionadoVitrinaHTML(response,id_parent)
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
    ajax_products_cargarProductosRelacionadosVitrina(id_parent);
}



function ajax_products_quitarProductoRelacionadoVitrina(id_parent,id)
{
    var var_query = {
          "function": "ajax_products_quitarProductoRelacionadoVitrina",
          "vars_ajax":[id_parent,id]
        };
    
    pasarelaAjax('GET', var_query, "ajax_products_agregarProductoRelacionadoVitrinaHTML",var_query.vars_ajax );
}



/******* Productos configurables */


function ajax_products_cargarProductosConfigurables(id)
{
     var var_query = {
          "function": "ajax_products_cargarProductosConfigurables",
          "vars_ajax":[id]
        };
    
    pasarelaAjax('GET', var_query, "ajax_products_cargarProductosConfigurablesHTML", var_query.vars_ajax);
}
function ajax_products_cargarProductosConfigurablesHTML(response,id){
    
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
            $('.cont_productos_configurables').html(respuesta.html);
           
            $(".contenedor_columnas_info_configurables").htmlDataDum(respuesta.lista_admin_data_configurables,".no_hay_datos_configurables");
            for(var x = 0; x<respuesta.lista_admin_data_configurables.length;x++)
            {
                $('[value='+respuesta.lista_admin_data_configurables[x].id+']').prop('checked',true);


                $('select[name=attr_configurable]').val(respuesta.lista_admin_data_configurables[x].id_attribute)
                    
            }
            
            $("input[name='configurable[]']").unbind('change').change(function(){

                if($(this).is(':checked'))
                {
                    ajax_products_agregarProductoConfigurable(id,$(this).attr('value'),$('select[name=attr_configurable]').val())
                }
                else{
                    ajax_products_quitarProductoConfigurable(id,$(this).attr('value'),$('select[name=attr_configurable]').val())
                }
      
            });
        }

    }
    
}

function ajax_products_agregarProductoConfigurable(id_parent,id,attr)
{
    
    var var_query = {
          "function": "ajax_products_agregarProductoConfigurable",
          "vars_ajax":[id_parent,id,attr]
        };
    
    pasarelaAjax('GET', var_query, "ajax_products_agregarProductoConfigurableHTML", var_query.vars_ajax);
}

function ajax_products_agregarProductoConfigurableHTML(response,id_parent)
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
    ajax_products_cargarProductosConfigurables(id_parent);
}



function ajax_products_quitarProductoConfigurable(id_parent,id,attr)
{
    var var_query = {
          "function": "ajax_products_quitarProductoConfigurable",
          "vars_ajax":[id_parent,id,attr]
        };
    
    pasarelaAjax('GET', var_query, "ajax_products_agregarProductoConfigurableHTML",var_query.vars_ajax );
}


function ajax_products_setAttrConfigurable(id_parent,attr)
{
    
    var var_query = {
          "function": "ajax_products_setAttrConfigurable",
          "vars_ajax":[id_parent,attr]
        };
    
    pasarelaAjax('GET', var_query, "ajax_products_setAttrConfigurableHTML", var_query.vars_ajax);
}

function ajax_products_setAttrConfigurableHTML(response,id_parent,attr)
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
    ajax_products_cargarProductosConfigurables(id_parent);
    
}




function catalog_setOrdenCategoria(orden)
{
    var var_query = {
          "function": "catalog_setOrdenCategoria",
          "vars_ajax":[orden]
        };
    
    pasarelaAjax('GET', var_query, "catalog_setOrdenCategoriaHTML", '');
}


function catalog_setOrdenCategoriaHTML(response)
{
    var respuesta = null;
    if (response != "null")
    {
        respuesta = JSON.parse(response);
       
    }

    return true;
}




function catalog_setOrdenSubcategoria(orden)
{
    var var_query = {
          "function": "catalog_setOrdenSubcategoria",
          "vars_ajax":[orden]
        };
    
    pasarelaAjax('GET', var_query, "catalog_setOrdenSubcategoriaHTML", '');
}


function catalog_setOrdenSubcategoriaHTML(response)
{
    var respuesta = null;
    if (response != "null")
    {
        respuesta = JSON.parse(response);
       
    }

    return true;
}







function ajax_catalog_importar_producto(sku,id)
{
    
   
    var var_query = {
          "function": "ajax_catalog_importar_producto",
          "vars_ajax":[sku,id]
        };
    
    pasarelaAjax('GET', var_query, "ajax_catalog_importar_productoHTML", [sku]);
}


function ajax_catalog_importar_productoHTML(response,sku)
{
    var respuesta = null;
    if (response != "null")
    {
        respuesta = JSON.parse(response);

        $('.operacion_'+sku).html(respuesta.operacion);
        $('.status_'+sku).html(respuesta.status).removeClass('status_pending').addClass('status_complete');
        
       
        $('html, body').stop().animate({
            scrollTop: $('.status_'+sku).offset().top
        }, 2000);


        $('.play_importacion').click();
       
    }

    return true;
}