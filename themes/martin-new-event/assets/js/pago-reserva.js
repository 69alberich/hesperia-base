(function($) {
  $(document).ready(function(){

    $(".nav-tabs li:first-child, .tab-content .tab-pane:first-child").addClass("active");

    $('#pagar').on('submit', function(e){
      var request = $(this).pagar();
      $(this).find("button").attr("disabled","disabled");
      request.then(function(response){
        var respuesta = JSON.parse(response.result);
        console.log(respuesta);
        if(respuesta.success === true){
          var alerta_instapago = swal({
            title: 'Hemos procesado su pago correctamente, ',
            text: 'Espere mientras registramos su reservación',
            allowEscapeKey:false,
            allowEnterKey: false,
            allowOutsideClick: false,
            showConfirmButton:false,
            //timer:1000,
            onOpen:function(){
              swal.showLoading();
              $.request('onAprobarReservacion', {
                  data: {
                    transaccion: respuesta.transaccion,
                    pasarela: 'instapago',
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
                    console.log(response);
                    swal.close();
                    swal({
                      type: 'error',
                      title: 'Ha ocurrido un error',
                      html: ''+response,
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


          });
        }else{
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
  });

  var form = $("#form-transferencia").validate();

  $("#localizador").rules("add", {
      required: true,
      messages:{
        required: "Campo Requerido"
      }
  });
  $("#archivo").rules("add", {
      required: true,
      accept: "image/*, pdf",
      messages:{
        required: "Campo Requerido",
        accept:"Archivo inválido, use solo imagenes o PDF de máximo 1MB de peso"
      }
  });

  $("#form-transferencia").on("submit", function(e){

    if (!form.valid()) {
      return false;
    }
  });

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
              $.request('onAprobarReservacion', {
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
  });

});

})(jQuery);
