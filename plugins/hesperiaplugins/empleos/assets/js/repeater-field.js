$(document).ready(function(){
       var n = 0;
       var button = "";
       var form = getForm(n, button);
       
      $('#dynamic_field').append(form);

      $('#add').click(function(){  
        var n = $( ".content-account" ).length;
        var button = "";
        
        if (n > 0) {
            button = "<button type='button' name='remove' id='"+n+"' class='close btn_remove' aria-label='Close'>"
                            +"<span aria-hidden='true'>&times;</span>"
                        +"</button>"
                        +"<div class='clearfix'></div>";
        }
        var form = getForm(n, button);
        $('#dynamic_field').append(form);
    
      });  

      function getForm(n, b){

        body = "<div id='row-"+n+"' class='content-account'>"
                        +b
                        +"<div class='form-group col-md-6 col-sm-6'>"
                            +"<label>Tipo</label>"
                            +"<select name='contactos["+n+"][red]' class='form-control'>"
                                +"<option value='telefono'>Telefono</option>"
                                +"<option value='behance'>Behance</option>"
                                +"<option value='facebook'>Facebook</option>"
                                +"<option value='instagram'>Instagram</option>"
                                +"<option value='linkedin'>Linkedin</option>"
                                +"<option value='twitter'>Twitter</option>"
                                +"<option value='web'>Sitio Web</option>"
                                +"<option value='otros'>Otros</option>"
                                +"</select>"
                        +"</div>"
                        +"<div class='form-group col-md-6 col-sm-6'>"
                            +"<label>Cuenta / Telefono / URL</label>"
                            +"<input class='form-control' name='contactos["+n+"][cuenta]' type='text' placeholder='Cuenta'/>"
                        +"</div>"
                    +"</div>";

        return body;  
      }

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row-'+button_id+'').remove();  
      });  
});