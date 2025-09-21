
		/*$('#pagar').on('submit', function(e){
			//alert('Hola');
			var res = $(this).pagar();
			res.then(function(res){
		      console.log(res);
		      alert(res.nombre_tarjeta);
		    },
		    function(res){
		      alert("algo ha fallado");
		    });

			e.preventDefault();
		}); */


	$.fn.pagar = function() {
		var dataN = 'error';
		var dfd = jQuery.Deferred();

	    $(this).request('onPay', {

			success: function(data) {
	    		//alert('success'+data+"esto");
			   	//this.dataN = data;
			   	dataN = data;
			   	dfd.resolve( data );
			},
			error: function(error){
				console.log(error);
			   	//dataN = data;
			   	dfd.reject( error );
			},
			complete: function(){
				//console.log(data);
				//alert('completado');
			}


		});

		return dfd.promise();
	};
