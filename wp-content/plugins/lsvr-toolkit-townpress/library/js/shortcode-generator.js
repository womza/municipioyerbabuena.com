(function($){

/* -----------------------------------------------------------------------------

	SHORTCODE GENERATOR BUTTON

----------------------------------------------------------------------------- */

if ( ! $.fn.lsvrShortcodeGeneratorBtn ) {
	$.fn.lsvrShortcodeGeneratorBtn = function(){
		if ( typeof lsvr_sg_shortcodes !== 'undefined' ) {
			if ( ! $(this).hasClass( 'init' ) ) {

				var $this = $(this);
				$this.addClass( 'init' );

				$this.click(function(){
					lsvr_sg_show_modal();
					return false;
				});

			}
		}
		else {
			$(this).hide();
		}
	};
}


/* -----------------------------------------------------------------------------

	FIELD TYPES

----------------------------------------------------------------------------- */

// TEXT INPUT
var lsvr_sg_add_textinput = function( name, atts ){

	var html = '<div class="lsvr-sg-form-row">';

	if ( typeof atts.label !== 'undefined' ) {
		html += '<label>' + atts.label + '</label>';
	}
	if ( typeof atts.description !== 'undefined' ) {
		html += '<p class="lsvr-description">' + atts.description + '</p>';
	}

	html += '<input type="text" class="lsvr-textinput lsvr-sg-att" data-attname="' + name + '"';
	if ( typeof atts.default !== 'undefined' ) {
		html += ' value="' + atts.default + '"';
	}
	html += '></div>';

	return html;

};

// TEXTAREA
var lsvr_sg_add_textarea = function( name, atts ){

	var html = '<div class="lsvr-sg-form-row">';

	if ( typeof atts.label !== 'undefined' ) {
		html += '<label>' + atts.label + '</label>';
	}
	if ( typeof atts.description !== 'undefined' ) {
		html += '<p class="lsvr-description">' + atts.description + '</p>';
	}

	html += '<textarea class="lsvr-textarea lsvr-sg-att" data-attname="' + name + '">';
	if ( typeof atts.default !== 'undefined' ) {
		html += atts.default;
	}
	html += '</textarea></div>';

	return html;

};

// SELECTBOX
var lsvr_sg_add_selectbox = function( name, atts ){

	var html = '<div class="lsvr-sg-form-row">';

	if ( typeof atts.label !== 'undefined' ) {
		html += '<label>' + atts.label + '</label>';
	}
	if ( typeof atts.description !== 'undefined' ) {
		html += '<p class="lsvr-description">' + atts.description + '</p>';
	}

	html += '<select class="lsvr-selectbox lsvr-sg-att" data-attname="' + name + '">';
	$.each( atts.values, function( index, value ) {
		html += '<option value="' + index + '"';
		if ( name !== 'nesting' && typeof atts.default !== 'undefined' && atts.default === index ) {
			html += ' selected="selected"';
		}
		html += '>' + value + '</option>';
	});
	html += '</select></div>';

	return html;

};

// COLOR PICKER
var lsvr_sg_add_colorpicker = function( name, atts ){

	var html = '<div class="lsvr-sg-form-row lsvr-sg-colorpicker">';

	if ( typeof atts.label !== 'undefined' ) {
		html += '<label>' + atts.label + '</label>';
	}
	if ( typeof atts.description !== 'undefined' ) {
		html += '<p class="lsvr-description">' + atts.description + '</p>';
	}

	html += '<input type="text" class="lsvr-textinput lsvr-sg-att" data-attname="' + name + '"';
	if ( typeof atts.default !== 'undefined' ) {
		html += ' value="' + atts.default + '"';
	}
	html += '></div>';

	return html;

};

// IMAGE UPLOAD
var lsvr_sg_add_fileinput = function( name, atts ){

	var html = '<div class="lsvr-sg-form-row lsvr-sg-fileinput">';

	if ( typeof atts.label !== 'undefined' ) {
		html += '<label>' + atts.label + '</label>';
	}
	if ( typeof atts.description !== 'undefined' ) {
		html += '<p class="lsvr-description">' + atts.description + '</p>';
	}

	html += '<input type="text" class="lsvr-textinput lsvr-sg-att" data-attname="' + name + '">';
	html += '<div class="lsvr-btn"><i class="fa fa-upload"></i></div>';
	html += '</div>';

	return html;

};

// GALLERY
var lsvr_sg_add_gallery = function( name, atts ){

	var html = '<div class="lsvr-sg-form-row lsvr-sg-gallery">';

	if ( typeof atts.label !== 'undefined' ) {
		html += '<label>' + atts.label + '</label>';
	}
	if ( typeof atts.description !== 'undefined' ) {
		html += '<p class="lsvr-description">' + atts.description + '</p>';
	}

	html += '<p class="lsvr-sg-gallery-preview" style="display: none;"></p>';
	html += '<input type="hidden" class="lsvr-textinput lsvr-sg-att" data-attname="' + name + '">';
	html += '<button type="button" class="lsvr-btn button button-primary button-large">' + $( 'var#lsvr-var-sg-select-images' ).text() + '</a>';
	html += '</div>';

	return html;

};


/* -----------------------------------------------------------------------------

	GENERATE FORM

----------------------------------------------------------------------------- */

var lsvr_sg_add_shortcode_form = function( pos, shortcode ){

	var sc = lsvr_sg_shortcodes[shortcode],
	html = '';

	// CHECK FOR DESCRIPTION
	if ( typeof sc.description !== 'undefined' ) {
		html += '<div class="lsvr-sg-shortcode-description"><p>' + sc.description + '</p></div>';
	}

	// CHECK FOR NESTING
	if ( typeof sc.nesting !== 'undefined' ) {
		html += lsvr_sg_add_selectbox( 'nesting', { 'label' : 'Nesting level', 'values' : sc.nesting, 'default' : 1 } );
	}

	// ADD ATT INPUTS
	if ( typeof sc.atts !== 'undefined' ) {
		$.each( sc.atts, function( index, value ) {

			// text
			if ( value.type === 'text' ) {
				html += lsvr_sg_add_textinput( index, value );
			}

			// textarea
			else if ( value.type === 'textarea' ) {
				html += lsvr_sg_add_textarea( index, value );
			}

			// select
			else if ( value.type === 'select' ) {
				html += lsvr_sg_add_selectbox( index, value );
			}

			// color
			else if ( value.type === 'color' ) {
				html += lsvr_sg_add_colorpicker( index, value );
			}

			// file
			else if ( value.type === 'file' ) {
				html += lsvr_sg_add_fileinput( index, value );
			}

			// gallery
			else if ( value.type === 'gallery' ) {
				html += lsvr_sg_add_gallery( index, value );
			}

		});
	}

	// OUTPUT FORM
	pos.html( html );

	// INIT FILEINPUT
	// http://www.webmaster-source.com/2013/02/06/using-the-wordpress-3-5-media-uploader-in-your-plugin-or-theme/
	if( typeof wp.media !== 'undefined' ) {

		var lsvr_sg_custom_uploader;

		pos.find( '.lsvr-sg-fileinput .lsvr-btn' ).click(function(){

			var input = $(this).parent().find( '.lsvr-sg-att' );
			if ( lsvr_sg_custom_uploader ) {
				lsvr_sg_custom_uploader.open();
				return;
			}

			// Extend the wp.media object
			lsvr_sg_custom_uploader = wp.media.frames.file_frame = wp.media({
				multiple: false
			});

			// When a file is selected, grab the URL and set it as the text field's value
			lsvr_sg_custom_uploader.on( 'select', function() {
				attachment = lsvr_sg_custom_uploader.state().get( 'selection' ).first().toJSON();
				input.val( attachment.url );
			});

			// Open the uploader dialog
			lsvr_sg_custom_uploader.open();

		});

	}
	else {
		pos.find( '.lsvr-sg-fileinput .lsvr-btn' ).remove();
	}

	// INIT GALLERY
	// http://www.webmaster-source.com/2013/02/06/using-the-wordpress-3-5-media-uploader-in-your-plugin-or-theme/
	if ( typeof wp.media !== 'undefined' ) {

		var lsvr_sg_custom_uploader_gal;

		pos.find( '.lsvr-sg-gallery .lsvr-btn' ).click(function(){

			var input = $(this).parent().find( '.lsvr-sg-att' ),
				preview = $(this).parent().find( '.lsvr-sg-gallery-preview' );

			if ( lsvr_sg_custom_uploader_gal ) {
				lsvr_sg_custom_uploader_gal.open();
				return;
			}

			// Extend the wp.media object
			lsvr_sg_custom_uploader_gal = wp.media.frames.file_frame = wp.media({
				multiple: true
			});

			// When a file is selected, grab the URL and set it as the text field's value
			lsvr_sg_custom_uploader_gal.on( 'select', function() {

				var id_arr = [],
					preview_html = '',
					attachment = lsvr_sg_custom_uploader_gal.state().get( 'selection' ).toJSON();

				// PARSE OBJECT
				if ( attachment.length > 0 ) {
					for ( var i = 0; i < attachment.length; i++ ) {
						id_arr.push( attachment[i].id );
						preview_html += '<img src="' + attachment[i].sizes.thumbnail.url + '" alt="">'
					}
				}

				// SHOW IMAGES
				preview.html( preview_html );
				preview.show();

				// SAVE IDs TO INPUT
				input.val( id_arr.join() );

			});

			// Open the uploader dialog
			lsvr_sg_custom_uploader_gal.open();

		});

	}
	else {
		pos.find( '.lsvr-sg-gallery .lsvr-btn' ).remove();
	}

};


/* -----------------------------------------------------------------------------

	GENERATE SHORTCODE CODE

----------------------------------------------------------------------------- */

var lsvr_sg_create_shortcode_code = function(){

	var sc = lsvr_sg_shortcodes[ $( '#lsvr-sg-shortcode-list' ).val() ];
	var code = $( '#lsvr-sg-shortcode-list' ).val();

	// CHECK FOR NESTING
	var nesting = $( '.lsvr-sg-shortcode-form .lsvr-sg-att[data-attname="nesting"]' ).length > 0 ? $( '.lsvr-sg-shortcode-form .lsvr-sg-att[data-attname="nesting"]' ).val() : false;
	if ( nesting !== false && nesting > 1 ) {
		code += nesting;
	}

	// CHECK FOR END TAG
	var endtag = '';
	if ( sc.paired === true ) {

		if ( typeof lsvr_sg_location !== 'undefined' && lsvr_sg_location === 'page-builder-editor' ) {
			endtag = '';
		}
		else {
			endtag = '<span id="lsvr-sg-cursor-marker">&nbsp;</span>';
		}
		if ( sc.inline === false ) {
			endtag = '<p>' + endtag + '&nbsp;</p>';
		}
		endtag += '[/' + code + ']';

	}

	// ADD ATTRIBUTES
	$( '.lsvr-sg-shortcode-form .lsvr-sg-att' ).not( '.lsvr-sg-shortcode-form .lsvr-sg-att[data-attname="nesting"]' ).each(function(){

		if ( $(this).val() !== '' ){
			var val = $(this).val();
			var valid_hex_color = /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i;
			if ( $(this).parent().hasClass( 'lsvr-sg-colorpicker' ) && valid_hex_color.test( '#' + val ) ) {
				val = '#' + val;
			}
			code += ' ' + $(this).data( 'attname' ) + '="' + val + '"';
		}

	});

	return '[' + code + ']' + endtag;

};


/* -----------------------------------------------------------------------------

	MODAL

----------------------------------------------------------------------------- */

var lsvr_sg_create_modal = function(){

	var html = '<div class="lsvr-modal-overlay"></div><div class="lsvr-modal lsvr-sg-modal"><div class="lsvr-modal-inner">';
	html += '<div class="lsvr-modal-title"><strong>';
	html += $( '#lsvr-var-sg-title' ).text();
	html += '</strong><i class="lsvr-close fa fa-times"></i></div>';
	html += '<div class="lsvr-modal-content">';
	html += '<div class="lsvr-modal-list-container"><label for="lsvr-sg-shortcode-list">' + $( '#lsvr-var-sg-choose-sc' ).text() + '</label>';
	html += '<select id="lsvr-sg-shortcode-list" class="lsvr-selectbox">';

	$.each( lsvr_sg_shortcodes, function( key, value ) {
		html += '<option value="' + key + '">' + value.name + '</option>';
	});

	html += '</select></div><div class="lsvr-sg-shortcode-form"></div>';
	html += '<div class="lsvr-sg-footer"><a href="#" class="lsvr-sg-add-shortcode button button-primary button-large">' + $( '#lsvr-var-sg-add-sc' ).text() + '</a></div>';
	html += '</div></div></div>';
	$( 'body' ).append( html );

	// SELECT SHORTCODE
	$( '#lsvr-sg-shortcode-list' ).change( function(){
		lsvr_sg_add_shortcode_form( $( '.lsvr-sg-shortcode-form' ), $(this).val() );
	});

	// ADD SHORTCODE
	$( '.lsvr-sg-add-shortcode' ).click(function(){

		// if called from page builder editor
		if ( typeof lsvr_sg_location !== 'undefined' && lsvr_sg_location === 'page-builder-editor' ) {

			// send to editor
			if ( typeof lsvr_sg_editor_object !== 'undefined' ) {
				lsvr_sg_editor_object.pasteHTML( lsvr_sg_create_shortcode_code(), false );
				lsvr_sg_hide_modal();
			}

		}
		else {

			// send to editor
			send_to_editor( lsvr_sg_create_shortcode_code() );
			lsvr_sg_hide_modal();

			// set cursor on right position for paired shortcodes
			if ( typeof tinyMCE !== 'undefined' ) {
				var lsvr_sg_cursor_marker = tinyMCE.activeEditor.dom.select( '#lsvr-sg-cursor-marker' )[0];
				if ( typeof lsvr_sg_cursor_marker !== 'undefined' ) {
					tinymce.activeEditor.selection.select( lsvr_sg_cursor_marker );
					lsvr_sg_cursor_marker.remove();
				}
			}

		}

		return false;

	});

	// hide when clicked on overlay or close btn
	$( '.lsvr-modal-overlay, .lsvr-modal-title .lsvr-close' ).click(function(){
		lsvr_sg_hide_modal();
	});

};

// REFRESH OVERLAY FUNCTION
var lsvr_sg_refresh_overlay = function(){
	$( '.lsvr-modal-overlay' ).css({
		'height' : $(document).height()
	});
};

// SHOW MODAL FUNCTION
// Must be global for using in Page Builder
lsvr_sg_show_modal = function ( location, element ){

	if ( typeof location !== 'undefined' ){
		lsvr_sg_location = location;
	}
	if ( typeof element !== 'undefined' ){
		lsvr_sg_editor_object = element;
	}
	if ( $( '.lsvr-modal-overlay' ).length < 1 ) {
		lsvr_sg_create_modal();
	}

	lsvr_sg_add_shortcode_form( $( '.lsvr-sg-shortcode-form' ), $( '#lsvr-sg-shortcode-list' ).val() );
	lsvr_sg_refresh_overlay();
	$( '.lsvr-modal-overlay, .lsvr-sg-modal' ).fadeIn(300);
	$( 'body' ).addClass( 'lsvr-locked-scrolling' );

};

// HIDE MODAL FUNCTION
var lsvr_sg_hide_modal = function(){
	$( '.lsvr-modal-overlay, .lsvr-sg-modal' ).fadeOut(300);
	$( 'body' ).removeClass( 'lsvr-locked-scrolling' );
};

// OPEN THE MODAL
/*
$( '.lsvr-shorcode-generator-button' ).click(function(){
	lsvr_sg_show_modal();
	return false;
});
*/

// REFRESH OVERLAY ON SCREEN RESIZE
$(window).resize(function(){
	lsvr_sg_refresh_overlay();
});

// end
})(jQuery);