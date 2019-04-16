var conektaSuccessResponseHandler = function(token) {
  var $form = $("#card-form");
  $form.append($("<input name=\"conekta\" type=\"hidden\">").val(token.id));
  $form.get(0).submit();
};

var conektaErrorResponseHandler = function(response) {
   var $form = $("#card-form");
  // console.log(response);
  _alert(response.message_to_purchaser,"Error");
  $form.find("input[type=submit]").prop("disabled", false);

  return false;
};

var openpaySuccessResponseHandler = function(response) {
   var $form = $("#card-form");
   $form.append($("<input name=\"conekta\" type=\"hidden\">").val(response.data.id));
   $form.get(0).submit();
 };

 var openpayErrorResponseHandler = function(response) {
    var desc = response.data.description != undefined ? response.data.description : response.message;
    var $form = $("#card-form");
    console.log(response);
    _alert("ERROR [" + response.status + "] " + desc);
    $form.find("input[type=submit]").prop("disabled", false);
    return false;
 };


var paypalCheckout = function(sandbox,idsb,idlive,gran_total)
{
    paypal.Button.render({
        locale: 'es_ES',
        env: (sandbox == 1 ? 'sandbox' : 'production'),
        client: {
            sandbox:    idsb,
            production: idlive
        },
        commit: true,
        payment: function(data, actions) {

            return actions.payment.create({
                /*
                "payment_definitions": [
                    {
                        "amount": {
                            "currency": 'MXN',
                            "value": gran_total
                        },
                        name: 'Standard Plan',
                       type: 'REGULAR',
                       frequency_interval: '1',
                        frequency: 'MONTH',
                        cycles: '11',
                    }
                ],
                 merchant_preferences: {
    setup_fee: {
      currency: 'USD',
      value: '1'
    },
    cancel_url: 'http://localhost:3000/cancel',
    return_url: 'http://localhost:3000/processagreement',
    max_fail_attempts: '0',
    auto_bill_amount: 'YES',
    initial_fail_amount_action: 'CONTINUE'
  }
             **/
                payment: {
                    transactions: [
                        {
                            amount: {
                                total: gran_total,
                                currency: 'MXN'
                            }
                        }]
                }

            });


        },
        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                console.log('Payment Complete!');
                window.location = "/ecommerce/paypal/confirmacion/?paymentID="+data.paymentID+"&payerID="+data.payerID+"&token="+data.paymentToken
            });
        }
    }, '#paypal-button-container');
};


var changeShippingAddress = function(){

    $("._sisi").removeClass("_sisi");
    $("._active").addClass("._nono").removeClass('_active').next("div").hide();
    $(".direccion_entrega").addClass("_nono").addClass('_active').next("div").show();
    $("#resumen_checkout_envio").empty();
    $("#resumen_checkout_facturacion").empty();

}

var changeBillingAddress = function(){
    $(".direccion_facturacion").addClass("_nono").addClass('_active').removeClass("_sisi").next("div").show();
    $("#resumen_checkout_facturacion").empty();

    $(".paga_ahora").addClass("_nono").removeClass('_active').removeClass("_sisi").next("div").hide();
    $(".metodo_pago").addClass("_nono").removeClass('_active').removeClass("_sisi").next("div").hide();
}

var changePaimentMethod = function(){
    $(".paga_ahora").addClass("_nono").removeClass('_active').removeClass("_sisi").next("div").hide();
    $(".metodo_pago").addClass("_nono").addClass('_active').removeClass("_sisi").next("div").show();
    $("#contenedor_frm_pago").empty();
}



$(document).ready(function()
{
    $("#widget_carrito .cerrar_carrito").click(function(e){
        e.preventDefault()
        $("#widget_carrito .cont_detalle").hide();
        $("#widget_carrito .cont_vacio").hide();
    });
    $("#widget_carrito .abrir_carrito").click(function(e){
        e.preventDefault()

        if(parseInt($("#widget_carrito .abrir_carrito .count_productos").text()) > 0)
        {
            $("#widget_carrito .cont_detalle").show();
        }
        else{

            $("#widget_carrito .cont_vacio").show();
        }

    })


    $("form[name=card-form]").find("input[type=submit]").click(function(){

        $("form[name=card-form]").valid();

    });

    llenaCarrido();

});
