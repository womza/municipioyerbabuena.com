<?php
if ( ! lsvr_shortcode_exists( 'lsvr_counter' ) && ! function_exists( 'lsvr_counter_shortcode' ) ) {

    function lsvr_counter_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_counter' => array(
                    'name' => __( 'Counter', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
						'counter_number' => array(
                            'label' => __( 'Counter Value', 'lsvrtoolkit' ),
							'description' => __( 'Numeric value of counter.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
						'number_char' => array(
                            'label' => __( 'Symbol After', 'lsvrtoolkit' ),
                            'description' => __( 'Symbol which will be displayed after numeric value. For example "+".', 'lsvrtoolkit' ),
							'type' => 'text'
                        ),
						'title' => array(
                            'label' => __( 'Title', 'lsvrtoolkit' ),
							'description' => __( 'This text will be displayed under Counter Value.', 'lsvrtoolkit' ),
                            'type' => 'text'
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
				'counter_number' => '',
				'number_char' => '',
				'title' => '',
                'custom_class' => '',
            ),
            $atts
        );

		$counter_number = esc_attr( $args['counter_number'] );
		$number_char = esc_attr( $args['number_char'] );
		$title = $args['title'];
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $class = $custom_class;
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<div class="c-counter' . $class . '"><div class="c-content-box"><div class="c-counter-inner">';
		$output .= '<h3 class="counter-data">';
		$output .= '<span class="counter-value">' . $counter_number . '</span>';
		$output .= $number_char !== '' ? '<span class="counter-symbol">' . $number_char . '</span>' : '';
		$output .= '</h3>';
		$output .= $title !== '' ? '<h4 class="counter-label">' . $title . '</h4>' : '';
		$output .= '</div></div></div>';

		return $output;

    }
    add_shortcode( 'lsvr_counter', 'lsvr_counter_shortcode' );

}
?>