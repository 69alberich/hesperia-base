$(document).ready(function(){

  $("#owl-galeria-restaurant").owlCarousel({
    items : 3,
    lazyLoad : true,
    navigation : true
  });
  $("#recomendados-carousel").owlCarousel({
    items : 3,
    lazyLoad : true,
    navigation : true
  });
  $("#owl-galeria-restaurant-modal").owlCarousel({

      navigation : false, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
      pagination : false,
      lazyLoad : true
  });

  var owlGaleriaRestaurant = $("#owl-galeria-restaurant").data('owlCarousel');

  var owlGaleriaRestaurantModal = $("#owl-galeria-restaurant-modal").data('owlCarousel');

  $(".carousel-con-modal .item").on("click", function(){
    var index = $(this).data("index");

    owlGaleriaRestaurantModal.jumpTo(index-1);
    $("#modal-owl-galeria").modal(function(){
      show:true;
    });
  });
  $(".carousel-control").on("click", function(e){
    e.preventDefault();
    var slide =$(this).data("slide");
    if (slide=="next") {
      owlGaleriaRestaurantModal.next();
    }else{
      owlGaleriaRestaurantModal.prev();
    }
  });

});

function dibujarRuta(maps, origen, destino){
  map.drawRoute({
    origin: [origen.latitud, origen.longitud],
    destination: [destino.latitud, destino.longitud],
    travelMode: 'driving',
    strokeColor: '#131540',
    strokeOpacity: 0.6,
    strokeWeight: 6
  });
}
