function catalog_addProductoCarrito(id,qty)
{
    var caracteristicas = {};
     var var_query = {
          "function": "catalog_addProductoCarrito",
          "vars_ajax":[id,qty,JSON.stringify(caracteristicas)]
    };

    pasarelaAjax('GET',var_query,"addProductoCarritoHTML",[qty]);
}

$(window).load(function(){
    if($('[data-idlove]').length > 0)
    {
        wishlist_getWishlist('catalog_products');
    }
    ajax_calificaciones_getPendientesRevisar('administrar_catalog_calificaciones_pendientes','catalog_products','catalog');
});