<?php
if ( ! lsvr_shortcode_exists( 'lsvr_content_box' ) && ! function_exists( 'lsvr_content_box_shortcode' ) ) {

    function lsvr_content_box_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_content_box' => array(
                    'name' => __( 'Content Box', 'lsvrtoolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
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
				'wpautop' => '',
                'custom_class' => '',
            ),
            $atts
        );

		$wpautop = esc_attr( $args['wpautop'] );
		$wpautop = $wpautop === 'yes' ? true : false;
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $class = $custom_class;
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<div class="c-content-box m-forced' . $class . '">';
		if ( $wpautop ) {
			$output .= do_shortcode( wpautop( $content ) );
		}
		else {
			$output .= do_shortcode( $content );
		}
		$output .= '</div>';

		return $output;

    }
    add_shortcode( 'lsvr_content_box', 'lsvr_content_box_shortcode' );

}
?>