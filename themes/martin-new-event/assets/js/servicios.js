$(document).ready(function(){

  $("#owl-galeria-servicio").owlCarousel({
    items : 3,
    lazyLoad : true,
    navigation : true
  });

  $("#owl-galeria-servicio-modal").owlCarousel({
      navigation : false, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
      pagination : false
  });
  var owlGaleriaServicio = $("#owl-galeria-servicio").data('owlCarousel');

  var owlGaleriaServicioModal = $("#owl-galeria-servicio-modal").data('owlCarousel');

  $(".carousel-con-modal .item").on("click", function(){
    var index = $(this).data("index");

    owlGaleriaServicioModal.jumpTo(index-1);
    $("#modal-owl-galeria").modal(function(){
      show:true;
    });
  });
  $(".carousel-control").on("click", function(e){
    e.preventDefault();
    var slide =$(this).data("slide");
    if (slide=="next") {
      owlGaleriaServicioModal.next();
    }else{
      owlGaleriaServicioModal.prev();
    }
  });
  
  $("iframe").wrap( "<div class='embed-responsive embed-responsive-16by9'>");
  $("iframe").addClass( "embed-responsive-item");
  
  
});
