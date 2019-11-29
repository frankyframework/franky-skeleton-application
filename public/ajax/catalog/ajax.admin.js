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
