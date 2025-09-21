$(document).ready(function(){
    $("#selector-media").on("change", function(){
        //alert($(this).val());
        $(".media-section").addClass("hidden");
        $("."+$(this).val()).removeClass("hidden");  
    });
    
    $(".image-media-center").on("click", function(){
       var ruta = $(this).data("src");
       
       $("#img-modal").attr("src", ruta);
       $("#link-descarga").attr("href", ruta);
       
    });
});
