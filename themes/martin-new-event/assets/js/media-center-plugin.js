$(document).ready(function(){
    
    $("#result").on("click", ".modal-img-mini", function(){
       var ruta = $(this).data("src");
       
       $("#img-modal").attr("src", ruta);
       $("#link-descarga").attr("href", ruta);
       
    });

   $("#result").on("click", ".paginadores", function(e){
   		var next = $(this).attr("value");

		$("#form-buscar").request('onFiltrar',{
			data:{
				pagina: next,
			},
			update: {
				mediacenter_result: '#result'
			},
			success: function(data) {
			this.success(data);
			}
		});
		e.preventDefault();
    });
});
