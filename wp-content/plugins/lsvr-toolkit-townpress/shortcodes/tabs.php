<?php
$lsvr_tabs_sc_temp = array();

if ( ! lsvr_shortcode_exists( 'lsvr_tabs' ) && ! function_exists( 'lsvr_tabs_shortcode' ) ) {

    function lsvr_tabs_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_tabs' => array(
                    'name' => __( 'Tabs', 'lsvrtoolkit' ),
                    'description' => __( '<strong>Tabs</strong> shortcode should contain multiple <strong>Tab Item</strong> shortcodes.', 'lsvrtoolkit' ),
                    'paired' => true,
                    'inline' => false,
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
            return false;
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

        global $lsvr_tabs_sc_temp;

        $class = $custom_class;
		$class = $class !== '' ? ' ' . $class : '';

        $html = '<div class="c-tabs' . $class . '"><div class="c-content-box"><div class="tabs-inner">';
        $html .= '<ul class="tab-list">';

        $tab_contents = do_shortcode( $content );
		$index = 0;
        foreach ( $lsvr_tabs_sc_temp as $tab ) {

			$active = $index === 0 ? ' m-active' : '';
            $title = $tab['title'] != '' ? '<span class="tab-label">' . $tab['title'] . '</span>' : '';
            $html .= '<li class="tab' . $active. '">' . $title . '</li>';
			$index++;

        }
        $lsvr_tabs_sc_temp = array();

        $html .= '</ul><ul class="content-list">' . $tab_contents . '</ul></div></div></div>';

        return $html;

    }
    add_shortcode( 'lsvr_tabs', 'lsvr_tabs_shortcode' );

}


/* -----------------------------------------------------------------------------
    TABS ITEM
----------------------------------------------------------------------------- */

if ( ! lsvr_shortcode_exists( 'lsvr_tab_item' ) && ! function_exists( 'lsvr_tabs_item_shortcode' ) ) {

    function lsvr_tabs_item_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_tab_item' => array(
                    'name' => __( 'Tab Item', 'lsvrtoolkit' ),
                    'description' => __( '<strong>Tab Item</strong> should be put inside <strong>Tabs</strong> shortcode.', 'lsvrtoolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvrtoolkit' ),
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
                'title' => '',
				'wpautop' => '',
            ),
            $atts
        );

        $title = $args['title'];
		$wpautop = esc_attr( $args['wpautop'] );
		$wpautop = $wpautop === 'yes' ? true : false;

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        global $lsvr_tabs_sc_temp;

        $tab = array();
        $tab['title'] = $title;

        array_push( $lsvr_tabs_sc_temp, $tab );

        $style = count( $lsvr_tabs_sc_temp ) > 1 ? ' style="display: none;"' : '';

        $output =  '<li' . $style . '>';
		if ( $wpautop ) {
			$output .= do_shortcode( wpautop( $content ) );
		}
		else {
			$output .= do_shortcode( $content );
		}
		$output .= '</li>';

		return $output;

    }
    add_shortcode( 'lsvr_tab_item', 'lsvr_tabs_item_shortcode' );

}
?>