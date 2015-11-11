<?php
if ( ! lsvr_shortcode_exists( 'lsvr_progressbar' ) && ! function_exists( 'lsvr_progressbar_shortcode' ) ) {

    function lsvr_progressbar_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_progressbar' => array(
                    'name' => __( 'Progress Bar', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
						'percentage' => array(
                            'label' => __( 'Percentage', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( '0' => 0, '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40, '45' => 45,
                                '50' => 50, '55' => 55, '60' => 60, '65' => 65, '70' => 70, '75' => 75, '80' => 80, '85' => 85, '90' => 90, '95' => 95, '100' => 100 ),
                            'default' => '100'
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
				'title' => '',
                'percentage' => 100,
                'custom_class' => ''
            ),
            $atts
        );

		$title = $args['title'];
        $percentage = (int) esc_attr( $args['percentage'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $class = $custom_class;
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<div class="c-progress-bar' . $class . '" data-percentage="' . $percentage . '"><div class="c-content-box"><div class="progress-bar-inner">';
		$output .= $title !== '' ? '<h5 class="progress-bar-title">' . $title . '</h5>' : '';
		$output .= '<div class="bar-indicator"><span class="bar-indicator-inner" style="width: ' . $percentage . '%"></span></div></div></div></div>';

		return $output;

    }
    add_shortcode( 'lsvr_progressbar', 'lsvr_progressbar_shortcode' );

}
?>