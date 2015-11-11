<?php
if ( ! lsvr_shortcode_exists( 'lsvr_gallery' ) && ! function_exists( 'lsvr_gallery_shortcode' ) ) {

    function lsvr_gallery_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_gallery' => array(
                    'name' => __( 'Gallery', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
                        'images' => array(
                            'label' => __( 'Images', 'lsvrtoolkit' ),
							'description' => __( 'Hold CTRL/CMD key to select multiple images.', 'lsvrtoolkit' ),
                            'type' => 'gallery'
                        ),
						'items_per_row' => array(
                            'label' => __( 'Images Per Row', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5 ),
                            'default' => '4'
                        ),
						'size' => array(
                            'label' => __( 'Size of Images', 'lsvrtoolkit' ),
							'description' => __( 'You can specify an image size which will be used, e.g. "large" or "full". Sizes can be defined under <strong>Settings / Media</strong>. Leave blank to use a "medium" size.', 'lsvrtoolkit' ),
                            'type' => 'text',
                            'default' => ''
                        ),
						'masonry' => array(
                            'label' => __( 'Masonry Layout', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'yes' => __( 'Yes', 'lsvrtoolkit' ), 'no' => __( 'No', 'lsvrtoolkit' ), ),
                            'default' => 'yes'
                        ),
						'click_action' => array(
                            'label' => __( 'Click Action', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'lightbox' => __( 'Open in Lightbox', 'lsvrtoolkit' ), 'tab' => __( 'Open in new tab', 'lsvrtoolkit' ), 'disable' => __( 'No click action', 'lsvrtoolkit' ) ),
                            'default' => 'lightbox'
                        ),
                        'custom_class' => array(
                            'label' => __( 'Custom Class', 'lsvrtoolkit' ),
                            'description' => __( 'It can be used for applying custom CSS.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        )
                    )
                )
            );

        }

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
                'images' => '',
                'items_per_row' => '4',
                'size' => 'medium',
                'masonry' => 'yes',
				'click_action' => 'lightbox',
                'custom_class' => ''
            ),
            $atts
        );

		$images = esc_attr( $args['images'] );
        $items_per_row = (int) esc_attr( $args['items_per_row'] );
        $size = esc_attr( $args['size'] );
		$masonry = esc_attr( $args['masonry'] );
		$masonry = $masonry === 'yes' ? true : false;
		$click_action = esc_attr( $args['click_action'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $custom_class = $custom_class !== '' ? ' ' . $custom_class : '';
		$class = $masonry !== '' ? ' m-layout-masonry' : '';
		$class .= ' m-' . $items_per_row . '-columns';
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<div class="c-gallery' . $custom_class . '"><ul class="gallery-images' . $class . '">';
		if ( $images !== '' ) {
			$images_arr = explode( ',', $images );
			foreach( $images_arr as $id ) {

				$image_data = lsvr_get_image_data( $id );
				$image_url = '';
				$image_url_full = '';
				$image_alt = '';
				$image_caption = '';
				if ( $image_data ) {
					if ( array_key_exists( $size, $image_data ) ) {
						$image_url = esc_url( $image_data[ $size ] );
					}
					else {
						$image_url = esc_url( $image_data[ 'medium' ] );
					}
					$image_url_full = esc_url( $image_data[ 'full' ] );
					$image_alt = $image_data[ 'alt' ];
					$image_caption = $image_data[ 'caption' ];

				}
				if ( $image_url !== '' ) {

					$output .= '<li>';
					if ( $click_action === 'lightbox' || $click_action === 'tab' ) {
						$output .= '<a title="' . $image_caption . '" href="' . $image_url_full . '"';
						$output .= $click_action === 'lightbox' ? ' class="lightbox">' : '';
						$output .= $click_action === 'tab' ? ' target="_blank">' : '';
					}
					$output .= '<img src="' . $image_url . '" alt="' . $image_alt . '">';
					$output .= $click_action === 'lightbox' || $click_action === 'tab' ? '</a>' : '';
					$output .= '</li>';

				}

			}
		}

		$output .= '</ul></div>';

		return $output;

    }
    add_shortcode( 'lsvr_gallery', 'lsvr_gallery_shortcode' );

}
?>