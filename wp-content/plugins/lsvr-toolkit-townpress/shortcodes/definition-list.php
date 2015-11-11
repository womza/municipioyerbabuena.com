<?php
if ( ! lsvr_shortcode_exists( 'lsvr_definition_list' ) && ! function_exists( 'lsvr_definition_list_shortcode' ) ) {

    function lsvr_definition_list_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_definition_list' => array(
                    'name' => __( 'Definition List', 'lsvrtoolkit' ),
					'description' => __ ( 'Can contain several <strong>Definition Item</strong> shortcodes.', 'lsvrtoolkit' ),
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

        $class = $custom_class;
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<div class="c-definition-list' . $class . '"><div class="c-content-box"><dl>' . do_shortcode( $content ) . '</dl></div></div>';

		return $output;

    }
    add_shortcode( 'lsvr_definition_list', 'lsvr_definition_list_shortcode' );

}

/* -----------------------------------------------------------------------------
    DEFINITION LIST ITEM
----------------------------------------------------------------------------- */

if ( ! lsvr_shortcode_exists( 'lsvr_definition_list_item' ) && ! function_exists( 'lsvr_definition_list_item_shortcode' ) ) {

    function lsvr_definition_list_item_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_definition_list_item' => array(
                    'name' => __( 'Definition List Item', 'lsvrtoolkit' ),
                    'description' => __ ( 'Must be placed inside <strong>Definition List</strong> shortcode.', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
                        'value' => array(
                            'label' => __( 'Value', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
                        'value_link' => array(
                            'label' => __( 'Value Link', 'lsvrtoolkit' ),
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
				'value' => '',
                'value_link' => '',
            ),
            $atts
        );

        $title = esc_attr( $args['title'] );
		$value = esc_attr( $args['value'] );
        $value_link = esc_url( $args['value_link'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$output = '';
		$output .= $title !== '' ? '<dt>' . $title . '</dt>' : '';
        if ( $value_link !== '' ) {
            $output .= '<dd><a href="' . $value_link . '">' . $value . '</a></dd>';
        }
        else {
            $output .= '<dd>' . $value . '</dd>';
        }

		return $output;

    }
    add_shortcode( 'lsvr_definition_list_item', 'lsvr_definition_list_item_shortcode' );

}
?>