<?php
if ( ! lsvr_shortcode_exists( 'lsvr_grid_row' ) && ! function_exists( 'lsvr_grid_row_shortcode' ) ) {

    function lsvr_grid_row_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_grid_row' => array(
                    'name' => __( 'Grid Row', 'lsvrtoolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'nesting' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4 ),
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

        return '<div class="row ' . $custom_class . '">' . do_shortcode( $content ) . '</div>';

    }
    add_shortcode( 'lsvr_grid_row', 'lsvr_grid_row_shortcode' );
    add_shortcode( 'lsvr_grid_row2', 'lsvr_grid_row_shortcode' );
    add_shortcode( 'lsvr_grid_row3', 'lsvr_grid_row_shortcode' );
    add_shortcode( 'lsvr_grid_row4', 'lsvr_grid_row_shortcode' );

}

/* -----------------------------------------------------------------------------

    GRID COLUMN

----------------------------------------------------------------------------- */

if ( ! lsvr_shortcode_exists( 'lsvr_grid_column' ) && ! function_exists( 'lsvr_grid_column_shortcode' ) ) {

    function lsvr_grid_column_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_grid_column' => array(
                    'name' => __( 'Grid Column', 'lsvrtoolkit' ),
                    'description' => __ ( '<strong>Grid Column</strong> must be used inside <strong>Grid Row</strong> shortcode.', 'lsvrtoolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'nesting' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4 ),
                    'atts' => array(
						'size' => array(
                            'label' => __( 'Size', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, '11' => 11, '12' => 12 ),
							'default' => '6'
                        ),
						'breakpoint' => array(
                            'label' => __( 'Breakpoint', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'xs' => __( 'Do not collapse', 'lsvrtoolkit' ), 'sm' => __( 'Collapse under 768px', 'lsvrtoolkit' ), 'md' => __( 'Collapse under 992px', 'lsvrtoolkit' ), 'lg' => __( 'Collapse under 1200px', 'lsvrtoolkit' ) ),
							'default' => 'md'
                        ),
                        'offset' => array(
                            'label' => __( 'Offset', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 )
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
				'breakpoint' => 'md',
                'offset' => 0,
                'size' => 12,
                'custom_class' => ''
            ),
            $atts
        );

		$breakpoint = esc_attr( $args['breakpoint'] );
		$size = (int) $args['size'];
        $offset = (int) $args['offset'];
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$classes = $custom_class;
		$classes .= ' col-' . $breakpoint . '-' . $size;
		$classes .= $offset > 0 ? ' col-' . $breakpoint . '-offset-' . $offset : '';
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

        return '<div class="' . $classes . '">' . do_shortcode( $content ) . '</div>';

    }
    add_shortcode( 'lsvr_grid_column', 'lsvr_grid_column_shortcode' );
    add_shortcode( 'lsvr_grid_column2', 'lsvr_grid_column_shortcode' );
    add_shortcode( 'lsvr_grid_column3', 'lsvr_grid_column_shortcode' );
    add_shortcode( 'lsvr_grid_column4', 'lsvr_grid_column_shortcode' );

}
?>