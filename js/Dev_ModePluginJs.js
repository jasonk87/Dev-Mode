(function($){

	/*
	var sendText = function(){
		// handle form submission
		$( "#JasonsPluginFormBtn" ).click(function(ev) {
		    ev.preventDefault();
		    $( "#JasonsPluginResponse" ).hide();

		    var data = {
				'action': 'my_action',
				'message': $( '#_text_messenger_text-message' ).val(),
				'phone_number': $( '#_text_messenger_phone-number' ).val()
			};
			
			// We can also pass the url value separately from ajaxurl for front end AJAX implementations
			$.post( jasonVars.ajaxurl, data, function(response) {
				$( "#JasonsPluginResponse" ).removeClass();
					
				if( 1 == response.success ){
					$( "#JasonsPluginResponse" ).addClass( "JasonsPluginSuccess");	
					$( "#JasonsPluginResponse" ).addClass( response.class );
					$( "#JasonsPluginReturnMessage" ).html( response.message );
				} else if ( 0 == response.success){
					$( "#JasonsPluginResponse" ).addClass( "JasonsPluginFailure");	
					$( "#JasonsPluginResponse" ).addClass( response.class );
					$( "#JasonsPluginReturnMessage" ).html( response.message );	
				} else{
					$( "#JasonsPluginResponse" ).addClass( "JasonsPluginError");	
					$( "#JasonsPluginResponse" ).addClass( response.class );
					$( "#JasonsPluginReturnMessage" ).html( response.message );	
				}
				$( "#JasonsPluginResponse" ).show();
			}, 'json' );
		});
	}
	*/

	$(document).ready(function(){
		
	});

})(jQuery);