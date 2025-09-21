$(document).ready(function(){

  $("#owl-galeria-noticia").owlCarousel({
    items : 3,
    lazyLoad : true,
    navigation : true
  });

  $("#owl-galeria-noticia-modal").owlCarousel({
      navigation : false, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
      pagination : false
  });
  var owlGaleriaNoticia = $("#owl-galeria-noticia").data('owlCarousel');

  var owlGaleriaNoticiaModal = $("#owl-galeria-noticia-modal").data('owlCarousel');

  $(".carousel-con-modal .item").on("click", function(){
    var index = $(this).data("index");

    owlGaleriaNoticiaModal.jumpTo(index-1);
    $("#modal-owl-galeria").modal(function(){
      show:true;
    });
  });
  $(".carousel-control").on("click", function(e){
    e.preventDefault();
    var slide =$(this).data("slide");
    if (slide=="next") {
      owlGaleriaNoticiaModal.next();
    }else{
      owlGaleriaNoticiaModal.prev();
    }
  });
  
  $("#share").jsSocials({
    shareIn: "popup",
    shares: ["twitter", "facebook", "googleplus", "linkedin", "pinterest", "whatsapp"]
  });
  
  $("iframe").wrap( "<div class='embed-responsive embed-responsive-16by9'>");
  $("iframe").addClass( "embed-responsive-item");
  
  $("video").addClass("img-responsive");
});
