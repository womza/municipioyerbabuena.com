<?php

/* -------------------------------------------------------------------------
	GET FIELD
	For use with Redux Framework
------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_get_field' ) ) {
	function lsvr_get_field( $field_id, $default = '', $force_bool = false ){

		global $theme_options;
		if ( isset( $theme_options ) && is_array( $theme_options ) && count( $theme_options ) > 0 ) {

			if ( array_key_exists( $field_id, $theme_options ) ) {
				$return = $theme_options[ $field_id ];
			}
			else if ( isset( $default ) ) {
				$return = $default;
			}
			else {
				$return = '';
			}

			// FORCE CAST AS BOOL
			if ( $force_bool ) {
				return (bool) $return;
			}
			else {
				return $return;
			}

		}
		else {
			if ( isset( $default ) ) {
				return $default;
			}
			else {
				return false;
			}
		}

	}
}

/* -----------------------------------------------------------------------------

    SHORTCODE GENERATOR BUTTON

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_sg_add_btn' ) ) {
	function lsvr_sg_add_btn(){
		?>
		<a href="#" class="lsvr-shorcode-generator-button button" data-modal-title="<?php _e( 'Shortcode Generator', 'lsvrtoolkit' ); ?>">
			<i class="fa fa-plus"></i><?php _e( 'Add Shortcode', 'lsvrtoolkit' ); ?>
		</a>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			if ( jQuery.fn.lsvrShortcodeGeneratorBtn ){
				jQuery( ".lsvr-shorcode-generator-button" ).not( '.init' ).each(function(){
					jQuery(this).lsvrShortcodeGeneratorBtn();
				});
			}
		});
		</script>
		<?php
	}
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {

	if ( ! function_exists( 'lsvr_vc_add_sg_button' ) && function_exists( 'lsvr_sg_add_btn' ) ) {
		function lsvr_vc_add_sg_button() {
			add_action( 'media_buttons', 'lsvr_sg_add_btn', 11 );
		}
	}
	add_action( 'vc_before_init', 'lsvr_vc_add_sg_button' );

}
else {
	if ( function_exists( 'lsvr_sg_add_btn' ) ) {
		add_action( 'media_buttons', 'lsvr_sg_add_btn', 11 );
	}
}



/* -----------------------------------------------------------------------------

    SHORTCODE EXISTS
    https://gist.github.com/r-a-y/1887242

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_shortcode_exists' ) ) {
    function lsvr_shortcode_exists( $shortcode = false ) {

        global $shortcode_tags;
        if ( ! $shortcode ) {
            return false;
        }
        if ( array_key_exists( $shortcode, $shortcode_tags ) ) {
            return true;
        }
        return false;

    }
}


/* -----------------------------------------------------------------------------

    GET IMAGE DATA

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_get_image_data' ) ) {
    function lsvr_get_image_data( $image_id ){

        $image_data = array();
        $image_sizes = array( 'thumbnail', 'small', 'medium', 'large', 'full' );

        foreach ( $image_sizes as $size ) {
            $temp = wp_get_attachment_image_src( $image_id, $size );
            $image_data[$size] = $temp[0];
        }

		// GET ALT
        $image_data['alt'] = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

		// GET TITLE
        $image_meta = wp_get_attachment_metadata( $image_id );
        if ( is_array( $image_meta ) && array_key_exists( 'title', $image_meta ) ){
            $image_data['title'] = $image_meta['title'];
        }
        else {
            $image_data['title'] = '';
        }

		// GET CAPTION
		$image_post_data = get_post( $image_id );
		if ( $image_post_data && is_object( $image_post_data ) ) {
			$image_data['caption'] = $image_post_data->post_excerpt;
		}
		else {
			$image_data['caption'] = '';
		}

        if ( count( $image_data ) > 0 ) {
            return $image_data;
        }
        else {
            return false;
        }

    }
}


/* -----------------------------------------------------------------------------

    GET TAXONOMY TERM PARENTS

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_get_term_parents' ) ) {
	function lsvr_get_term_parents( $term_id, $taxonomy, $max_limit = 5 ) {

		$term = get_term( $term_id, $taxonomy );
		if ( $term->parent !== 0 ) {

			$parents_arr = array();
			$counter = 0;
			$parent_id = $term->parent;

			while ( $parent_id !== 0 && $counter < $max_limit ) {
				array_unshift( $parents_arr, $parent_id );
				$parent = get_term( $parent_id, $taxonomy );
				$parent_id = $parent->parent;
				$counter++;
			}
			return $parents_arr;

		}
		else {
			return false;
		}

	}
}


/* -----------------------------------------------------------------------------

    SHORTCODES CONTENT FILTER
    Get rid of redudant P and BR tags when andding a block shortcode

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_shortcodes_content_filter' ) ) {
    function lsvr_shortcodes_content_filter( $content ) {

        global $shortcode_tags;

        if ( is_array( $shortcode_tags ) && count( $shortcode_tags ) > 0 ) {

            // create array of custom shortcodes
            $shortcodes = array();
            foreach ( $shortcode_tags as $key => $val ){

                // include only LSVR block shortcodes
                if ( is_string( $val ) && substr( $val, 0, 5 ) === 'lsvr_' && function_exists( $val ) && ! call_user_func( $val, false, false, false, true ) ) {
                    $shortcodes[] = $key;
                }

            }

        }
		// push some 3rd party shortcodes
        array_push( $shortcodes, 'contact-form-7', 'response', 'template', 'recent_products', 'woocommerce_order_tracking', 'products', 'featured_products', 'product' );

        $block = join( '|', $shortcodes );

    	// opening tag
    	$rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]", $content );

    	// closing tag
    	$rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]", $rep );

    	return $rep;

    }
}
add_filter( 'the_content', 'lsvr_shortcodes_content_filter' );

?>