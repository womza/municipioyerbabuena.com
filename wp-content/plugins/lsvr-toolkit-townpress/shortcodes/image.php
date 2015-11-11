<?php
if ( ! lsvr_shortcode_exists( 'lsvr_image' ) && ! function_exists( 'lsvr_image_shortcode' ) ) {

    function lsvr_image_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        /*if ( $generator === true ) {

            return array(
                'lsvr_image' => array(
                    'name' => __( 'Image', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => true,
                    'atts' => array(
                        'image' => array(
                            'label' => __( 'Upload Image', 'lsvrtoolkit' ),
                            'type' => 'file'
                        ),
                        'max_width' => array(
                            'label' => __( 'Max Width', 'lsvrtoolkit' ),
							'description' => __( 'You can define maximum width (in pixels, e.g. "100") to restrict image dimensions.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
                        'link' => array(
                            'label' => __( 'Link', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
                        'lightbox' => array(
                            'label' => __( 'Open In Lightbox', 'lsvrtoolkit' ),
                            'description' => __( 'URL of the lightbox image must be placed in "Link" field.', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'yes' => __( 'Yes', 'lsvrtoolkit' ), 'no' => __( 'No', 'lsvrtoolkit' ) ),
                            'default' => 'no'
                        ),
                        'custom_class' => array(
                            'label' => __( 'Custom Class', 'lsvrtoolkit' ),
                            'description' => __( 'It can be used for applying custom CSS.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        )
                    )
                )
            );

        }*/

        /* ---------------------------------------------------------------------
            Check if shortcode is inline
        --------------------------------------------------------------------- */

        if ( $check_if_inline === true ) {
            return false;
        }

        /* ---------------------------------------------------------------------
            Prepare arguments
        --------------------------------------------------------------------- */

        $args = shortcode_atts(
            array(
                'image' => '',
				'size' => 'medium',
				'max_width' => '',
				'link' => '',
				'lightbox' => 'no',
                'custom_class' => ''
            ),
            $atts
        );

		$size = esc_attr( $args['size'] );
		$max_width = esc_attr( $args['max_width'] );
		$link = esc_url( $args['link'] );
		$lightbox = esc_attr( $args['lightbox'] );
		$lightbox = $lightbox === 'yes' ? true : false;
        $custom_class = esc_attr( $args['custom_class'] );

		// PARSE IMAGE
		$image_url_full = '';
		$image = $args['image'];
		if ( (int) $image > 0 ) {
			$image_data = lsvr_get_image_data( (int) $image );
			if ( $image_data ) {
				$image_url = esc_url( $image_data[ $size ] );
				$image_url_full = esc_url( $image_data[ 'full' ] );
			}
			else {
				$image_url = '';
			}
		}
		else if ( $image !== '' ) {
			$image_url = esc_url( $image );
		}

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $class = $custom_class;
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$image_style = $max_width !== '' ? ' style="width: ' . (int) $max_width . 'px;"' : '';

		$html = '';
		if ( $lightbox && $image_url_full !== '' ) {
			$html .= '<a href="' . $image_url_full . '" class="no-border lightbox">';
		}
		elseif ( $link !== '' ) {
			$html .= '<a href="' . $link . '">';
		}
		$html .= $image !== '' ? '<img src="' . $image_url . '" class="' . $class . '" ' . $image_style . ' alt="">' : '';
		if ( ( $lightbox && $image_url_full !== '' ) || $link !== '' ) {
			$html .= '</a>';
		}

		return $html;

    }
    add_shortcode( 'lsvr_image', 'lsvr_image_shortcode' );

}
?>