$(function () {
    $('#checkin-time').datetimepicker({
        format: 'LT',
        allowInputToggle: true,
    });

});

$(document).ready(function(){
  
  $('.dropify').dropify({
      messages: {
          'default': 'arrastra o clickea para subir tu pasaporte o cédula',
          'replace': 'arrastra o clickea para reemplazar tu pasaporte o cédula',
          'remove':  'remover',
          'error':   'Algo ha salido mal',
      },
      error:{
        'fileExtension': 'Este formato no está permitido. Sólo ({{ value }}).',
        'fileSize': 'El archivo es muy pesado. ({{ value }} es el máximo permitido).',
      }
  });

  $("#pre-checkin-form").on("submit", function(e){
    var nombre = "";
    var documento ="";
    var hora ="";

    e.preventDefault();
    var form = $(this).serializeArray();
    var data = convertToObject(form);

    //console.log(data);
    
    
    $(".nombre").each(function (item) {
      if($(this).val() === "" || $(this).val().length < 4){
        if(nombre == ""){
          nombre = "Completa todos los nombres <br>";
        }
      } 
    });

    $(".documento").each(function (item) {
      
      if (!$(this).hasClass("kid")) {
        if($(this).val() === "" || $(this).val().length < 4){
          documento = "Completa todos los campos de documentos obligatorios <br>";
        } 
      }

    });

    if(data["info_adicional[hora_checkin]"] ==""){
      hora = "Completa la hora estimada de check-in <br>";
    }
    
    if (documento !="" || nombre !="" || hora !="" ) {
      
      swal("Espera", nombre+documento+hora, "error");
  
    }else{

      var loaderModal = swal({
        title: "¡Estamos procesando tu información!",
        text: "Espera unos momentos mientras realizamos tu pre-checkin",
        imageUrl: "https://hoteleshesperia.com.ve/storage/app/media/icons/dae67631234507.564a1d230a290.gif",
        allowEscapeKey: false,
        allowOutsideClick: false,
        showConfirmButton: false
      });

      $(this).request('PrechekinHandler::onSave', {
        success: (response =>{
          location.reload();
          //console.log(this);
            //alert("hola vale");
        })
      });
    }
  });
});

function convertToObject(array){
  var obj = {};
  array.forEach(element => {
      obj[element.name]= element.value;
      
  });
  return obj;
}