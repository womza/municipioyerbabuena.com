<?php

/* -----------------------------------------------------------------------------

    GET FIELD
	For use with Redux Framework

----------------------------------------------------------------------------- */

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

    GET IMAGE FIELD
	For use with Redux Framework

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_get_image_field' ) && function_exists( 'lsvr_get_field' ) ) {
	function lsvr_get_image_field( $field_id, $key = 'url' ){

		$field = lsvr_get_field( $field_id );
		if ( is_array( $field ) && array_key_exists( $key, $field ) ) {
			return $field[$key];
		}
		else {
			return false;
		}

	}
}

/* -----------------------------------------------------------------------------

    GET PAGE ID

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_get_current_page_id' ) ) {
	function lsvr_get_current_page_id(){

		// POSTS
		if ( ( get_option( 'page_for_posts' ) || lsvr_get_field( 'articles_base_page' ) ) && ( is_home() || is_singular( 'post' ) || is_category() || is_tag() || is_day() || is_month() || is_year() || is_author() ) ) {
			if ( get_option( 'page_for_posts' ) ) {
				$return = get_option( 'page_for_posts' );
			}
			else {
				$return = lsvr_get_field( 'articles_base_page', '' );
			}
		}

		// NOTICES
		elseif ( is_post_type_archive( 'lsvrnotice' ) || is_singular( 'lsvrnotice' ) || is_tax( 'lsvrnoticecat' ) ) {
			$return = lsvr_get_field( 'notices_base_page', '' );
		}

		// DOCUMENTS
		elseif ( is_post_type_archive( 'lsvrdocument' ) || is_singular( 'lsvrdocument' ) || is_tax( 'lsvrdocumentcat' ) ) {
			$return = lsvr_get_field( 'documents_base_page', '' );
		}

		// EVENTS
		elseif ( is_post_type_archive( 'lsvrevent' ) || is_singular( 'lsvrevent' ) || is_tax( 'lsvreventcat' ) ) {
			$return = lsvr_get_field( 'events_base_page', '' );
		}

		// GALLERIES
		elseif ( is_post_type_archive( 'lsvrgallery' ) || is_singular( 'lsvrgallery' ) || is_tax( 'lsvrgallerycat' ) ) {
			$return = lsvr_get_field( 'galleries_base_page', '' );
		}

		// BBPRESS
		elseif ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
			$return = lsvr_get_field( 'forums_base_page', '' );
		}

		// BUDDYBPRESS
		elseif ( function_exists( 'is_buddypress' ) && is_buddypress() ) {
			if ( intval( $return ) < 1 ) {
				global $wp_query;
				$return = $wp_query->get_queried_object_id();
			}
		}

		// PAGE
		elseif ( is_page() ) {
			if ( in_the_loop() ) {
				$return = get_the_id();
			}
			else {
				global $wp_query;
				$return = $wp_query->get_queried_object_id();
			}
		}

		else {
			$return = false;
		}

		// IS WPML
		if ( ! ( get_option( 'page_for_posts' ) && ( is_home() || is_singular( 'post' ) || is_category() || is_tag() || is_day() || is_month() || is_year() || is_author() ) )
			&& intval( $return ) > 0 && function_exists( 'icl_object_id' ) ) {
			$return_wpml = icl_object_id( $return, 'page' );
			if ( intval( $return_wpml ) > 0 ) {
				$return = $return_wpml;
			}
		}

		// RETURN
		if ( intval( $return ) > 0 ) {
			return intval( $return );
		}
		else {
			return false;
		}

	}
}


/* -----------------------------------------------------------------------------

    PARSE DATE TIME FIELD

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_parse_datetime_field' ) ) {
	function lsvr_parse_datetime_field( $datetime ){

		if ( $datetime && $datetime !== '' ) {

			$year = intval( substr( $datetime, 0, 4 ) );
			$month = intval( substr( $datetime, 5, 2 ) );
			$day = intval( substr( $datetime, 8, 2 ) );
			$hours = intval( substr( $datetime, 11, 2 ) );
			$minutes = intval( substr( $datetime, 14, 2 ) );

			$date = new DateTime();
			$date->setDate( $year, $month, $day );
			$date->setTime( $hours, $minutes );

			return $date;

		}
		else {
			return false;
		}

	}
}

/* -----------------------------------------------------------------------------

    CONSOLIDATE REPEATER FIELD

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_consolidate_repeater_field' ) ) {
	function lsvr_consolidate_repeater_field( $repeater_arr, $keys ) {

		if ( is_array( $repeater_arr ) && is_array( $keys ) ) {
			$consolidated_arr = '';
			foreach ( $keys as $key ) {
				$temp_arr = array();
				if ( array_key_exists( $key, $repeater_arr ) ) {
					if ( ! is_array( $consolidated_arr ) ) {
						$consolidated_arr = array_fill( 0, sizeof( $repeater_arr[ $key ] ), array() );
					}
					$index = 0;
					foreach ( $repeater_arr[ $key ] as $value ) {
						$consolidated_arr[ $index ] = array_merge( $consolidated_arr[ $index ], array( $key => $value ) );
						$index++;
					}
				}
			}
			return $consolidated_arr;
		}
		else {
			return false;
		}

	}
}


/* -----------------------------------------------------------------------------

    GET DOCUMENT TYPE

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_get_document_type' ) ) {
	function lsvr_get_document_type( $type ) {

		$types_arr = array(
			'default' => array( 'class' => 'fa fa-file-o', 'label' => '' ),
			'zip' => array( 'class' => 'fa fa-file-archive-o', 'label' => __( '.zip Archive', 'lsvrtheme' ) ),
			'audio' => array( 'class' => 'fa fa-file-audio-o', 'label' => __( 'Audio File', 'lsvrtheme' ) ),
			'code' => array( 'class' => 'fa fa-file-code-o', 'label' => __( 'Code File', 'lsvrtheme' ) ),
			'excel' => array( 'class' => 'fa fa-file-excel-o', 'label' => __( 'Excel Document', 'lsvrtheme' ) ),
			'image' => array( 'class' => 'fa fa-file-image-o', 'label' => __( 'Image File', 'lsvrtheme' ) ),
			'video' => array( 'class' => 'fa fa-file-movie-o', 'label' => __( 'Movie File', 'lsvrtheme' ) ),
			'pdf' => array( 'class' => 'fa fa-file-pdf-o', 'label' => __( 'PDF File', 'lsvrtheme' ) ),
			'powerpoint' => array( 'class' => 'fa fa-file-powerpoint-o', 'label' => __( 'PowerPoint Document', 'lsvrtheme' ) ),
			'text' => array( 'class' => 'fa fa-file-text-o', 'label' => __( 'Text File', 'lsvrtheme' ) ),
			'word' => array( 'class' => 'fa fa-file-word-o', 'label' => __( 'Word Document', 'lsvrtheme' ) ),
		);

		if ( array_key_exists( $type, $types_arr ) ) {
			return $types_arr[$type];
		}
		else {
			return false;
		}

	}
}


/* -----------------------------------------------------------------------------

    GET SOCIAL LINKS

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_get_social_links' ) ) {
	function lsvr_get_social_links() {

		$links = lsvr_get_field( 'social_links' );
		if ( is_array( $links ) ) {

			$links = array_filter( $links );
			if ( is_array( $links ) && count ( $links ) > 0 ) {

				// PARSE ARRAY
				$links_parsed = array();
				$html = '';
				$target = lsvr_get_field( 'social_links_target', false, true ) ? 'target="_blank"' : '';
				foreach ( $links as $key => $val ) {

					$class = strtolower( $key );
					$icoclass = '';
					if ( $class === 'googleplus' ) {
						$icoclass = 'google-plus';
					}
					else if ( $class === 'email' ) {
						$icoclass = 'envelope-o';
					}
					else if ( $class === 'vimeo' ) {
						$icoclass = 'vimeo-square';
					}
					else {
						$icoclass = $class;
					}
					$icoclass = 'fa fa-' . $icoclass;
					$html .= '<li class="ico-' . $class . '"><a href="' . esc_url( $val ) . '" ' . $target . '>';
					$html .= '<i class="' . esc_attr( $icoclass ) . '"></i></a></li>';

				}
				return $html;

			}
			else {
				return false;
			}

		}
		else {
			return false;
		}

	}
}


/* -----------------------------------------------------------------------------

    GET IMAGE DATA

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_get_image_data' ) ) {
	function lsvr_get_image_data( $image_id ){

		$image_data = array();
		$image_sizes = array( 'thumbnail', 'medium', 'large', 'full' );

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

    GET THE CONTENT WITH FORMATTING

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_get_the_content' ) ) {
	function lsvr_get_the_content( $more_link_text = '(more...)', $stripteaser = 0, $more_file = '' ) {
		$content = get_the_content( $more_link_text, $stripteaser, $more_file );
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		return $content;
	}
}


/* -----------------------------------------------------------------------------

    EXCERPT BY ID

----------------------------------------------------------------------------- */

/*
* http://pippinsplugins.com/a-better-wordpress-excerpt-by-id-function/
* Gets the excerpt of a specific post ID or object
* @param - $post - object/int - the ID or object of the post to get the excerpt of
* @param - $length - int - the length of the excerpt in words
* @param - $tags - string - the allowed HTML tags. These will not be stripped out
* @param - $extra - string - text to append to the end of the excerpt
*/

if ( ! function_exists( 'lsvr_excerpt_by_id' ) ) {
	function lsvr_excerpt_by_id( $post, $length = 10, $tags = '<a><em><strong>', $extra = ' &hellip;' ) {

		if ( is_int( $post ) ) {
			// get the post object of the passed ID
			$post = get_post($post);
		} elseif ( ! is_object( $post ) ) {
			return false;
		}

		if ( has_excerpt( $post->ID ) && $length < 1 ) {

			$the_excerpt = $post->post_excerpt;
			return apply_filters( 'the_content', $the_excerpt );

		} else {
			$the_excerpt = $post->post_content;
		}

		$the_excerpt = strip_shortcodes( strip_tags( $the_excerpt ), $tags );
		$the_excerpt = preg_split( '/\b/', $the_excerpt, $length * 2+1 );
		$excerpt_waste = array_pop( $the_excerpt );
		$the_excerpt = implode( $the_excerpt );
		$the_excerpt .= $extra;

		return apply_filters( 'the_content', $the_excerpt );

	}
}


/* -----------------------------------------------------------------------------

    FILE SIZE CONVERSION

----------------------------------------------------------------------------- */

/**
* Converts bytes into human readable file size.
*
* @param string $bytes
* @return string human readable file size (2,87 Мб)
* @author Mogilev Arseny
*/

if ( ! function_exists( 'lsvr_filesize_convert' ) ) {
	function lsvr_filesize_convert( $bytes ) {

		$bytes = floatval( $bytes );
			$arBytes = array(
				0 => array(
					'unit' => 'TB',
					'value' => pow(1024, 4)
				),
				1 => array(
					'unit' => 'GB',
					'value' => pow(1024, 3)
				),
				2 => array(
					'unit' => 'MB',
					'value' => pow(1024, 2)
				),
				3 => array(
					'unit' => 'kB',
					'value' => 1024
				),
				4 => array(
					'unit' => 'B',
					'value' => 1
				),
			);

		foreach( $arBytes as $arItem ) {
			if ( $bytes >= $arItem['value'] ) {
				$result = $bytes / $arItem['value'];
				$result = str_replace( '.', ',', strval( round( $result, 0 ) ) ) . ' ' . $arItem['unit'];
				break;
			}
		}
		return $result;

	}
}

?>