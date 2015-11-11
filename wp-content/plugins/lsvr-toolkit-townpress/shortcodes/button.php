<?php
if ( ! lsvr_shortcode_exists( 'lsvr_button' ) && ! function_exists( 'lsvr_button_shortcode' ) ) {

    function lsvr_button_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_button' => array(
                    'name' => __( 'Button', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => true,
                    'atts' => array(
                        'text' => array(
                            'label' => __( 'Text', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
                        'link' => array(
                            'label' => __( 'Link', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
						'target' => array(
                            'label' => __( 'Target', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'default' => __( 'Default', 'lsvrtoolkit' ), 'blank' => __( 'New Tab', 'lsvrtoolkit' ) ),
							'default' => 'default'
                        ),
                        'icon' => array(
                            'label' => __( 'Icon', 'lsvrtoolkit' ),
                            'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
                        'style' => array(
                            'label' => __( 'Style', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'default' => __( 'Solid', 'lsvrtoolkit' ), 'outline' => __( 'Outline', 'lsvrtoolkit' ),  ),
							'default' => 'default'
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
            return true;
        }

        /* ---------------------------------------------------------------------
            Prepare arguments
        --------------------------------------------------------------------- */

        $args = shortcode_atts(
            array(
				'text' => '',
                'link' => '',
				'target' => 'default',
                'icon' => '',
				'style' => 'default',
                'custom_class' => ''
            ),
            $atts
        );

		$text = esc_attr( $args['text'] );
        $link = esc_url( $args['link'] );
		$target = esc_attr( $args['target'] );
        $icon = esc_attr( $args['icon'] );
		$style = esc_attr( $args['style'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $class = $custom_class;
		$class .= $icon !== '' ?' m-has-icon' : '';
		$class .= $style !== 'default' ? ' m-' . $style : '';
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<a href="' . $link . '" class="c-button' . $class . '"';
		$output .= $target === 'blank' ? ' target="_blank"' : '';
		$output .= '>';
		$output .= $icon !== '' ? '<i class="ico ' . $icon . '"></i>' : '';
		$output .= $text . '</a>';

		return wpautop( $output );

    }
    add_shortcode( 'lsvr_button', 'lsvr_button_shortcode' );

}
?>