<?php
if ( ! lsvr_shortcode_exists( 'lsvr_lead' ) && ! function_exists( 'lsvr_lead_shortcode' ) ) {

    function lsvr_lead_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_lead' => array(
                    'name' => __( 'Lead Paragraph', 'lsvrtoolkit' ),
                    'paired' => true,
                    'inline' => true,
                    'atts' => array(
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
            return true;
        }

        /* ---------------------------------------------------------------------
            Prepare arguments
        --------------------------------------------------------------------- */

        $args = shortcode_atts(
            array(
                'custom_class' => ''
            ),
            $atts
        );

        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$class = $custom_class;
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<p class="lead' . $class . '">' . do_shortcode( $content ) . '</p>';

		return $output;

    }
    add_shortcode( 'lsvr_lead', 'lsvr_lead_shortcode' );

}
?>