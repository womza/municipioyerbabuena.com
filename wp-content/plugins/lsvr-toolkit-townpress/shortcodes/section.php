<?php
if ( ! lsvr_shortcode_exists( 'lsvr_section' ) && ! function_exists( 'lsvr_section_shortcode' ) ) {

    function lsvr_section_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_section' => array(
                    'name' => __( 'Section', 'lsvrtoolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
						'disable_top_margin' => array(
							'label' => __( 'Disable Top Margin', 'lsvrtoolkit' ),
							'description' => __( 'Recommended for the first section on the page.', 'lsvrtoolkit' ),
							'values' => array( 'yes' => __( 'Yes', 'lsvrtoolkit' ), 'no' => __( 'No', 'lsvrtoolkit' ) ),
                            'type' => 'select',
							'default' => 'no'
                        ),
						'wrap_in_container' => array(
							'label' => __( 'Wrap Content in Container', 'lsvrtoolkit' ),
							'description' => __( 'Useful if you are using this element in full width template.', 'lsvrtoolkit' ),
							'values' => array( 'yes' => __( 'Yes', 'lsvrtoolkit' ), 'no' => __( 'No', 'lsvrtoolkit' ) ),
                            'type' => 'select',
							'default' => 'no'
                        ),
                        'custom_class' => array(
                            'label' => __( 'Custom Class', 'lsvrtoolkit' ),
                            'description' => __( 'It can be used for applying custom CSS.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
                        'custom_id' => array(
                            'label' => __( 'Custom ID', 'lsvrtoolkit' ),
                            'description' => __( 'It can be used for one page navigation.', 'lsvrtoolkit' ),
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
				'disable_top_margin' => 'no',
				'wrap_in_container' => 'no',
                'custom_class' => '',
				'custom_id' => ''
            ),
            $atts
        );

		$title = $args['title'];
		$disable_top_margin = esc_attr( $args['disable_top_margin'] );
		$disable_top_margin = $disable_top_margin === 'yes'  ? true : false;
		$wrap_in_container = esc_attr( $args['wrap_in_container'] );
		$wrap_in_container = $wrap_in_container === 'yes'  ? true : false;
        $custom_class = esc_attr( $args['custom_class'] );
		$custom_id = esc_attr( $args['custom_id'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $class = $custom_class;
		$class .= $disable_top_margin ? ' m-no-top-margin' : '';
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<section class="c-section' . $class . '"';
		$output .= $custom_id !== '' ? ' id="' . $custom_id . '"' : '';
		$output .= '><div class="section-inner">';
		$output .= $wrap_in_container ? '<div class="container">' : '';
		$output .= $title !== '' ? '<h2 class="section-title">' . $title . '</h2>' : '';
		$output .= do_shortcode( $content );
		$output .= $wrap_in_container ? '</div>' : '';
		$output .= '</div></section>';

		return $output;

    }
    add_shortcode( 'lsvr_section', 'lsvr_section_shortcode' );

}
?>