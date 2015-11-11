<?php
if ( ! lsvr_shortcode_exists( 'lsvr_icon' ) && ! function_exists( 'lsvr_icon_shortcode' ) ) {

    function lsvr_icon_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_icon' => array(
                    'name' => __( 'Icon', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => true,
                    'atts' => array(
                        'icon' => array(
                            'label' => __( 'Icon', 'lsvrtoolkit' ),
                            'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
                        'icon_size' => array(
                            'label' => __( 'Icon Size', 'lsvrtoolkit' ),
                            'description' => __( 'Size of icon in pixels.', 'lsvrtoolkit' ),
                            'type' => 'text',
                            'default' => 18
                        ),
                        'icon_color' => array(
                            'label' => __( 'Icon Color', 'lsvrtoolkit' ),
                            'description' => __( 'For example "#232323".', 'lsvrtoolkit' ),
                            'type' => 'color'
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
                'icon' => '',
                'icon_size' => 18,
                'icon_color' => '',
                'custom_class' => ''
            ),
            $atts
        );

        $icon = esc_attr( $args['icon'] );
        $icon_size = (int) esc_attr( $args['icon_size'] );
        $icon_color = esc_attr( $args['icon_color'] );
		$icon_color = ( strlen( $icon_color ) > 0 ) && ( substr( $icon_color, 0, 1 ) ) !== '#' ? '#' . $icon_color : $icon_color;
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$class = $custom_class;
		$class .= ' ' . $icon;
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<i class="' . $class . '" style="';
		$output .= $icon_color !== '' ? 'color: ' . $icon_color . ';' : '';
		$output .= $icon_size !== '' ? 'font-size: ' . $icon_size . 'px;' : '';
		$output .= '"></i>';

		return $output;

    }
    add_shortcode( 'lsvr_icon', 'lsvr_icon_shortcode' );

}
?>