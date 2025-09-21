$(document).ready(function(){

  $("#owl-galeria-hotel").owlCarousel({
    items : 3,
    lazyLoad : true,
    navigation : true,
    navigationText : ["<",">"],
    pagination: false
  });
  $("#owl-galeria-hotel-modal").owlCarousel({
      navigation : false, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
      pagination : false,
      lazyLoad : true,
      navigationText : ["<",">"]
  });

  $('.detalle').on('click', function(e){
    e.preventDefault();

    /*$('html, body').animate({
      scrollTop: $("#pagar-btn").offset().top
    }, 500);*/

    $("#hab-detalle-"+$(this).data("index")).owlCarousel({
      navigation : false, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
      lazyLoad : true,
      autoHeight : true,
      // "singleItem:true" is a shortcut for:
      // items : 1,
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false
    });
   });

  var owlGaleriaHotel = $("#owl-galeria-hotel").data('owlCarousel');

  var owlGaleriaHotelModal = $("#owl-galeria-hotel-modal").data('owlCarousel');

  $(".carousel-con-modal .item").on("click", function(){
    var index = $(this).data("index");

    owlGaleriaHotelModal.jumpTo(index-1);
    $("#modal-owl-galeria").modal(function(){
      show:true;
    });
  });
  $(".carousel-control").on("click", function(e){
    e.preventDefault();
    var slide =$(this).data("slide");
    if (slide=="next") {
      owlGaleriaHotelModal.next();
    }else{
      owlGaleriaHotelModal.prev();
    }
  });

  $(".lugar-mapa").on("click", function(e){
    e.preventDefault();
    var mapa = getMapa();
    var hotel = getHotelCoord();
    var latitudPunto = $(this).data("lat");
    var longitudPunto = $(this).data("long");
    console.log(hotel);

    mapa.drawRoute({
      origin: [latitudPunto, longitudPunto],
      destination: [hotel.latitud, hotel.longitud],
      travelMode: 'driving',
      strokeColor: '#131540',
      strokeOpacity: 0.6,
      strokeWeight: 6
    });
    /*dibujarRuta(maps, function(){
      origen.latitud:$(this).data("lat"),
      origen.latitud:$(this).data("long"),
    });*/
  //  alert($(this).data("lat"));
  });

  /*$(".lugar-mapa").click(function(){
    alert("sirvo");
  });*/

  /*function dibujarRuta(maps, origen){
    map.drawRoute({
      origin: [origen.latitud, origen.longitud,
      destination: [10.234158, -68.005102],
      travelMode: 'driving',
      strokeColor: '#131540',
      strokeOpacity: 0.6,
      strokeWeight: 6
    });
  }*/
  $(".slider-testimonials").owlCarousel({

      navigation : false, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
      lazyLoad : true,
      // "singleItem:true" is a shortcut for:
      // items : 1,
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false
  });
});
