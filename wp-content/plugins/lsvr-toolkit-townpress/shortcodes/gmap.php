<?php
if ( ! lsvr_shortcode_exists( 'lsvr_gmap' ) && ! function_exists( 'lsvr_gmap_shortcode' ) ) {

    function lsvr_gmap_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_gmap' => array(
                    'name' => __( 'Google Map', 'lsvrtoolkit' ),
					'description' => __( 'You can define either just <strong>Address</strong> field or <strong>Latitude</strong> and <strong>Longitude</strong> fields.', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
						'address' => array(
                            'label' => __( 'Address', 'lsvrtoolkit' ),
							'description' => __( 'For example: <em>8833 Sunset Blvd, West Hollywood, CA 90069, USA</em>.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
						'latitude' => array(
                            'label' => __( 'Latitude', 'lsvrtoolkit' ),
							'description' => __( 'Optional, it can be more precise than using just the address. For example: <em>48.634340</em>.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
						'longitude' => array(
                            'label' => __( 'Longitude', 'lsvrtoolkit' ),
							'description' => __( 'Optional, it can be more precise than using just the address. For example: <em>21.929627</em>.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
						'type' => array(
							'label' => __( 'Map Type', 'lsvrtoolkit' ),
							'values' => array( 'roadmap' => __( 'Roadmap', 'lsvrtoolkit' ), 'satellite' => __( 'Satellite', 'lsvrtoolkit' ), 'terrain' => __( 'Terrain', 'lsvrtoolkit' ), 'hybrid' => __( 'Hybrid', 'lsvrtoolkit' ) ),
                            'type' => 'select',
							'default' => 'satellite'
                        ),
						'zoom' => array(
							'label' => __( 'Zoom Level', 'lsvrtoolkit' ),
							'values' => array( '16' => __( 'Far', 'lsvrtoolkit' ), '17' => __( 'Medium', 'lsvrtoolkit' ), '18' => __( 'Default', 'lsvrtoolkit' ), '19' => __( 'Very Close', 'lsvrtoolkit' ) ),
                            'type' => 'select',
							'default' => '18'
                        ),
						'height' => array(
                            'label' => __( 'Height', 'lsvrtoolkit' ),
							'description' => __( 'In pixels.', 'lsvrtoolkit' ),
                            'type' => 'text',
							'default' => '400'
                        ),
                        'custom_class' => array(
                            'label' => __( 'Custom Class', 'lsvrtoolkit' ),
                            'description' => __( 'It can be used for applying custom CSS.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
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
				'address' => '',
				'latitude' => '',
				'longitude' => '',
				'type' => 'satellite',
				'zoom' => '18',
                'height' => '400',
                'custom_class' => '',
            ),
            $atts
        );

		$address = esc_attr( $args['address'] );
		$latitude = esc_attr( $args['latitude'] );
		$longitude = esc_attr( $args['longitude'] );
		$type = esc_attr( $args['type'] );
		$zoom = esc_attr( $args['zoom'] );
        $height = (int) esc_attr( $args['height'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $class = $custom_class;
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<div class="c-gmap' . $class . '"><div class="gmap-canvas"';
		$output .= $height > 0 ? ' style="height: ' . $height . 'px;"' : '';
		$output .= $address !== '' ? ' data-address="' . $address . '"' : '';
		$output .= $latitude !== '' ? ' data-latitude="' . $latitude . '"' : '';
		$output .= $longitude !== '' ? ' data-longitude="' . $longitude . '"' : '';
		$output .= $zoom !== '' ? ' data-zoom="' . $zoom . '"' : '';
		$output .= $type !== '' ? ' data-maptype="' . $type . '"' : '';
		$output .= ' data-enable-mousewheel="false"></div></div>';

		return $output;

    }
    add_shortcode( 'lsvr_gmap', 'lsvr_gmap_shortcode' );

}
?>