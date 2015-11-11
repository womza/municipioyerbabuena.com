(function($){

/* -----------------------------------------------------------------------------

	WIDGETS

----------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------
        IMAGE WIDGET
    ------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrImageWidget ) {
		$.fn.lsvrImageWidget = function(){
			if ( typeof wp.media !== 'undefined' ) {

				var $button = $(this),
					$parent = $button.parent(),
					$input = $parent.find( '.lsvr-widget-image-id' ).first(),
					$holder = $parent.find( '.lsvr-widget-image-holder' ),
					lsvr_custom_uploader;

				$button.unbind( 'click' );
				$button.click(function(){

					if ( lsvr_custom_uploader ) {
						lsvr_custom_uploader.open();
						return;
					}

					// Extend the wp.media object
					lsvr_custom_uploader = wp.media.frames.file_frame = wp.media({
						multiple: false
					});

					// When a file is selected, grab the URL and set it as the text field's value
					lsvr_custom_uploader.on( 'select', function() {
						attachment = lsvr_custom_uploader.state().get( 'selection' ).first().toJSON();
						$holder.html( '<img src="' + attachment.sizes.thumbnail.url + '" alt="">' );
						$holder.show().css( 'display', 'block' );
						$input.val( attachment.id );
					});

					// Open the uploader dialog
					lsvr_custom_uploader.open();

				});

			}

		};
	}

})(jQuery);