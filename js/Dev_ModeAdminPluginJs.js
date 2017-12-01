(function($){

	var activatePopupModal = function(){
		if ( $( '.development_mode_button' ).length && $( '#development_modal' ).length ){
			$('.development_mode_button' ).magnificPopup({
				type: 'inline',
				modal: true
			});

			$(document).on('click', '.development-modal-close', function (e) {
				e.preventDefault();
				sessionStorage.setItem( 'dm_agreed', true );	
				$.magnificPopup.close();
			});

			if ( sessionStorage.getItem( 'dm_agreed' ) != 'true' )
				$( '.development_mode_button' ).click();
		};
	};

	$(document).ready(function(){
		activatePopupModal();
	});

})(jQuery);