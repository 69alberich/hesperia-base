$(document).on('ajaxSetup', function(event, context) {
    // Enable AJAX handling of Flash messages on all AJAX requests
    context.options.flash = true

    // Enable the StripeLoadIndicator on all AJAX requests
    context.options.loading = $.oc.stripeLoadIndicator

    // Handle Error Messages by triggering a flashMsg of type error
    context.options.handleErrorMessage = function(message) {
        $.oc.flashMsg({ text: message, class: 'error' })
    }

    // Handle Flash Messages by triggering a flashMsg of the message type
    context.options.handleFlashMessage = function(message, type) {
        $.oc.flashMsg({ text: message, class: type })
    }
});

$(document).ready(function(){

  $(".slider-default").owlCarousel({

      navigation : false, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
      lazyLoad : true,
      autoHeight : true,
      navigationText : ["<",">"]
      // "singleItem:true" is a shortcut for:
      // items : 1,
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false
  });

  $(".slider-2-items").owlCarousel({

      autoPlay: 3000, //Set AutoPlay to 3 seconds
      items : 2,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3],
      lazyLoad : true,
      navigation : true,
      navigationText : ["<",">"],
      pagination: false
  });

  $(".slider-3-items").owlCarousel({

      autoPlay: false, 
      items : 3,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3]

  });


  $("#restaurant_hotel_slider").owlCarousel({
    navigation : false, // Show next and prev buttons
    slideSpeed : 300,
    paginationSpeed : 400,
    singleItem:true,
    lazyLoad : true

    // "singleItem:true" is a shortcut for:
    // items : 1,
    // itemsDesktop : false,
    // itemsDesktopSmall : false,
    // itemsTablet: false,
    // itemsMobile : false
  });

  $("body").on("click", ".seleccion-toggle", function(e) {
      //alert("sirvo");
    e.preventDefault();
  
    if($(this).attr("id") === "go-bottom"){
        $(this).hide();
    }else{
        $("#go-bottom").show();
    }
    $("#wrapper1").toggleClass("active");
    $("body").toggleClass("not-scrollable");
  });

  //$('body').scrollspy({ target: '#spy', offset:80});
});
