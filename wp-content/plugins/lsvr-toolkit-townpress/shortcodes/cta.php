<?php
if ( ! lsvr_shortcode_exists( 'lsvr_cta_message' ) && ! function_exists( 'lsvr_cta_message_shortcode' ) ) {

    function lsvr_cta_message_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_cta_message' => array(
                    'name' => __( 'CTA Message', 'lsvrtoolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
                        'button_label' => array(
                            'label' => __( 'Button Label', 'lsvrtoolkit' ),
							'description' => __( 'Leave blank to hide.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
                        'link' => array(
                            'label' => __( 'Button Link', 'lsvrtoolkit' ),
                            'type' => 'text'
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
                'button_label' => '',
                'link' => '',
				'wpautop' => '',
                'custom_class' => ''
            ),
            $atts
        );

        $title = $args['title'];
        $button_label = $args['button_label'];
        $link = esc_url( $args['link'] );
		$wpautop = esc_attr( $args['wpautop'] );
		$wpautop = $wpautop === 'yes' ? true : false;
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$class = $custom_class;
        $class .= $title !== '' ? ' m-has-title ' : '';
        $class .= $button_label !== '' ? ' m-has-btn ' : '';
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<div class="c-cta-message' . $class . '"><div class="c-content-box"><div class="cta-inner">';
		$output .= $title !== '' ? '<h3 class="cta-title"><span>' . $title . '</span></h3>' : '';
		$output .= '<div class="cta-text">';
		if ( $wpautop ) {
			$output .= do_shortcode( wpautop( $content ) );
		}
		else {
			$output .= do_shortcode( $content );
		}
		$output .= '</div>';
		$output .= $button_label !== '' ? '<p class="cta-button"><a href="' . $link . '" class="c-button">' . $button_label . '</a></p>' : '';
		$output .= '</div></div></div>';

		return $output;

    }
    add_shortcode( 'lsvr_cta_message', 'lsvr_cta_message_shortcode' );

}
?>