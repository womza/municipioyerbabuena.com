<?php
if ( ! lsvr_shortcode_exists( 'lsvr_alert_message' ) && ! function_exists( 'lsvr_alert_message_shortcode' ) ) {

    function lsvr_alert_message_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_alert_message' => array(
                    'name' => __( 'Alert Message', 'lsvrtoolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'type' => array(
                            'label' => __( 'Type', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'warning' => __( 'Warning', 'lsvrtoolkit' ) , 'success' => __( 'Success', 'lsvrtoolkit' ), 'info' => __( 'Info', 'lsvrtoolkit' ), 'notification' => __( 'Notification', 'lsvrtoolkit' ) )
                        ),
                        'closable' => array(
                            'label' => __( 'Closable', 'lsvrtoolkit' ),
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
                'type' => 'warning',
                'closable' => 'no',
				'wpautop' => '',
                'custom_class' => ''
            ),
            $atts
        );

        $type = esc_attr( $args['type'] );
        $closable = esc_attr( $args['closable'] );
		$closable = $closable === 'yes' ? true : false;
		$wpautop = esc_attr( $args['wpautop'] );
		$wpautop = $wpautop === 'yes' ? true : false;
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$class = $custom_class;
        if ( $type === 'success' ) {
            $class .= ' m-success';
        }
        elseif ( $type === 'info' ) {
			$class .= ' m-info';
        }
        elseif ( $type === 'notification' ) {
			$class .= ' m-notification';
        }
        else {
            $class .= ' m-warning';
        }
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<div class="c-alert-message' . $class . '">';
		if ( $type === 'success' ) {
			$output .= '<i class="ico fa fa-check-circle"></i>';
		}
		elseif ( $type === 'info' ) {
			$output .= '<i class="ico fa fa-info-circle"></i>';
		}
		elseif ( $type === 'notification' ) {
			$output .= '<i class="ico fa fa-question-circle"></i>';
		}
		elseif ( $type === 'warning' ) {
			$output .= '<i class="ico fa fa-exclamation-circle"></i>';
		}

		$output .= '<div class="alert-inner">';
		if ( $wpautop ) {
			$output .= do_shortcode( wpautop( $content ) );
		}
		else {
			$output .= do_shortcode( $content );
		}
		$output .= $closable ? '<button class="alert-close" type="button"><i class="fa fa-times"></i></button>' : '';
		$output .= '</div></div>';

		return $output;

    }
    add_shortcode( 'lsvr_alert_message', 'lsvr_alert_message_shortcode' );

}
?>