(function($) {
    $(document).ready(function(){

      $('#payment-form').on('submit', function(e){
       
        var request = $(this).payStripe();
        
        request.then(function(response){
        var respuesta = JSON.parse(response.result);
        if(respuesta.status === "succeeded"){
            //abre aqui
            var alerta_stripe = swal({
            title: 'Hemos procesado su pago correctamente, ',
            text: 'Espere mientras registramos su reservación',
            allowEscapeKey:false,
            allowEnterKey: false,
            allowOutsideClick: false,
            showConfirmButton:false,
            onOpen:function(){
                swal.showLoading();
                $.request('onAprobarCompra', {
                    data: {
                    transaccion: respuesta.ref_backend,
                    pasarela: 'stripe',
                    },
                    success: function(response) {
                        swal.close();
                        swal({
                        type: 'success',
                        title: '¡Proceso Completado!',
                        html: 'Gracias por Reservar con nosotros',
                        onClose: function(){
                            location.reload();
                        }
                        });
                    },
                    error: function(response){
                    var respuesta = JSON.parse(response.result);
                    swal.close();
                    swal({
                        type: 'error',
                        title: 'Ha ocurrido un error',
                        html: ''+respuesta.message,
                        onClose: function(){
                        location.reload();
                        }
                    });
                    }
                });

            }
            }).then(function(){
                swal.close();
                swal({
                type: 'error',
                title: 'Ha ocurrido un error',
                html: 'Comuniquese con nosotros por info@hoteleshesperia.com.ve',
                onClose: function(){
                    location.reload();
                }
                });

            },
            function(){
            //
            });
            //termina aqui
            
        }else{
            //console.log(response);
            swal({
            type: 'error',
            title: 'Ha ocurrido un error',
            html: respuesta.message,
            onClose: function(){
                location.reload();
            }
            });
        }
        },
        function(response){
        swal({
            type: 'warning',
            title: 'Disculpe, Ha fallado la pasarela de pagos',
        }).then(function(){
            location.reload()
        });
        });
        e.preventDefault();
    }); //FIN STRIPE
});

})(jQuery);