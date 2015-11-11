<?php
if ( ! lsvr_shortcode_exists( 'lsvr_accordion' ) && ! function_exists( 'lsvr_accordion_shortcode' ) ) {

    function lsvr_accordion_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_accordion' => array(
                    'name' => __( 'Accordion', 'lsvrtoolkit' ),
					'description' => __ ( 'Can contain several <strong>Accordion Item</strong> shortcodes.', 'lsvrtoolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'toggle' => array(
                            'label' => __( 'Toggle', 'lsvrtoolkit' ),
							'description' => __( 'This accordion will behave as a toggle if enabled.', 'lsvrtoolkit' ),
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
                'toggle' => 'no',
                'custom_class' => ''
            ),
            $atts
        );

        $toggle = esc_attr( $args['toggle'] );
		$toggle = $toggle === 'yes' ? true : false;
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$class = $custom_class;
		$class .= $toggle ? ' m-toggle' : '';
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<div class="c-accordion' . $class . '"><div class="c-content-box"><ul class="accordion-items">';
		$output .= do_shortcode( $content );
		$output .= '</ul></div></div>';

		return $output;

    }
    add_shortcode( 'lsvr_accordion', 'lsvr_accordion_shortcode' );

}

/* -----------------------------------------------------------------------------
    ACCORDION ITEM
----------------------------------------------------------------------------- */

if ( ! lsvr_shortcode_exists( 'lsvr_accordion_item' ) && ! function_exists( 'lsvr_accordion_item_shortcode' ) ) {

    function lsvr_accordion_item_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_accordion_item' => array(
                    'name' => __( 'Accordion Item', 'lsvrtoolkit' ),
                    'description' => __ ( 'Must be placed inside <strong>Accordion</strong> shortcode.', 'lsvrtoolkit' ),
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
                        'state' => array(
                            'label' => __( 'State', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'closed' => __( 'Closed', 'lsvrtoolkit' ), 'open' => __( 'Open', 'lsvrtoolkit' ) ),
                            'default' => 'closed'
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
                'title' => '',
				'icon' => '',
                'state' => 'closed',
				'wpautop' => '',
            ),
            $atts
        );

        $title = esc_attr( $args['title'] );
		$icon = esc_attr( $args['icon'] );
        $state = esc_attr( $args['state'] );
		$state = $state === 'open' ? true : false;
		$wpautop = esc_attr( $args['wpautop'] );
		$wpautop = $wpautop === 'yes' ? true : false;

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$class = $state ? ' m-active' : '';
		$class .= $icon !== '' ? ' m-has-icon' : '';

		$output = '<li class="' . trim( $class ) . '">';
		$output .= '<h4 class="accordion-title">';
		$output .= $icon !== '' ? '<i class="ico ' . $icon . '"></i>' : '';
		$output .= $title . '</h4>';
		$output .= '<div class="accordion-content">';
		if ( $wpautop ) {
			$output .= do_shortcode( wpautop( $content ) );
		}
		else {
			$output .= do_shortcode( $content );
		}
		$output .= '</div>';
		$output .= '</li>';

		return $output;

    }
    add_shortcode( 'lsvr_accordion_item', 'lsvr_accordion_item_shortcode' );

}
?>