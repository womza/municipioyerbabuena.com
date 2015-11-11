<?php
if ( ! lsvr_shortcode_exists( 'lsvr_separator' ) && ! function_exists( 'lsvr_separator_shortcode' ) ) {

    function lsvr_separator_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_separator' => array(
                    'name' => __( 'Separator', 'lsvrtoolkit' ),
					'description' => __( 'Horizontal separator line', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
                        'type' => array(
                            'label' => __( 'Type', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'default' => __( 'Default', 'lsvrtoolkit' ), 'transparent' => __( 'Transparent', 'lsvrtoolkit' ) ),
							'default' => 'default'
                        ),
                        'margin_top' => array(
                            'label' => __( 'Top Margin', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'none' => __( 'None', 'lsvrtoolkit' ), 'small' => __( 'Small', 'lsvrtoolkit' ), 'medium' => __( 'Medium', 'lsvrtoolkit' ), 'large' => __( 'Large', 'lsvrtoolkit' ) ),
							'default' => 'medium'
                        ),
						'margin_bottom' => array(
                            'label' => __( 'Bottom Margin', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'none' => __( 'None', 'lsvrtoolkit' ), 'small' => __( 'Small', 'lsvrtoolkit' ), 'medium' => __( 'Medium', 'lsvrtoolkit' ), 'large' => __( 'Large', 'lsvrtoolkit' ) ),
							'default' => 'medium'
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
				'type' => 'default',
				'margin_top' => 'medium',
				'margin_bottom' => 'medium',
                'custom_class' => ''
            ),
            $atts
        );

		$type = esc_attr( $args['type'] );
        $margin_top = esc_attr( $args['margin_top'] );
		$margin_bottom = esc_attr( $args['margin_bottom'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$class = $custom_class;
		$class .= ' m-' . $type;
		$class .= ' m-margin-top-' . $margin_top;
		$class .= ' m-margin-bottom-' . $margin_bottom;
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<hr class="c-separator' . $class . '">';

		return $output;

    }
    add_shortcode( 'lsvr_separator', 'lsvr_separator_shortcode' );

}
?>