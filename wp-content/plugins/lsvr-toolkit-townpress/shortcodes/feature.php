<?php
if ( ! lsvr_shortcode_exists( 'lsvr_feature' ) && ! function_exists( 'lsvr_feature_shortcode' ) ) {

    function lsvr_feature_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_feature' => array(
                    'name' => __( 'Feature', 'lsvrtoolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
                        'icon' => array(
                            'label' => __( 'Icon', 'lsvrtoolkit' ),
                            'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvrtoolkit' ),
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
				'icon' => '',
				'wpautop' => '',
                'custom_class' => ''
            ),
            $atts
        );

		$title = esc_attr( $args['title'] );
		$icon = esc_attr( $args['icon'] );
		$wpautop = esc_attr( $args['wpautop'] );
		$wpautop = $wpautop === 'yes' ? true : false;
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $class = $custom_class;
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<div class="c-feature' . $class . '"><div class="c-content-box"><div class="feature-inner">';
		$output .= $icon !== '' ? '<i class="feature-icon ' . $icon . '"></i>' : '';
		$output .= $title !== '' ? '<h3 class="feature-title">' . $title . '</h3>' : '';
		$output .= '<div class="feature-content">';
		if ( $wpautop ) {
			$output .= do_shortcode( wpautop( $content ) );
		}
		else {
			$output .= do_shortcode( $content );
		}
		$output .= '</div></div></div></div>';

		return $output;

    }
    add_shortcode( 'lsvr_feature', 'lsvr_feature_shortcode' );

}
?>