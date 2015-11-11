<?php
if ( ! lsvr_shortcode_exists( 'lsvr_directory' ) && ! function_exists( 'lsvr_directory_shortcode' ) ) {

    function lsvr_directory_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

			$menus_arr = array();
			$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );

			if ( is_array( $menus ) ) {
				foreach ( $menus as $menu ) {
					if ( is_object( $menu ) ) {
						$menus_arr[ $menu->term_id ] = $menu->name;
					}
				}
			}

            return array(
                'lsvr_directory' => array(
                    'name' => __( 'Directory', 'lsvrtoolkit' ),
					'description' => __( 'You will have to navigate to <strong>Appearance / Menus</strong> and create a menu first. Then select this menu below', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvrtoolkit' ),
                            'type' => 'text',
							'default' => __( 'Choose <strong>Your Interest</strong>', 'lsvrtoolkit' )
                        ),
						'icon' => array(
                            'label' => __( 'Icon', 'lsvrtoolkit' ),
							'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvrtoolkit' ),
                            'type' => 'text',
							'default' => 'tp tp-road-sign',
                        ),
						'menu' => array(
                            'label' => __( 'Menu', 'lsvrtoolkit' ),
                            'type' => 'select',
							'values' => $menus_arr,
                        ),
						'columns' => array(
                            'label' => __( 'Columns', 'lsvrtoolkit' ),
							'description' => __( 'Please note, that the number of columns displayed on page is affected by screen size.', 'lsvrtoolkit' ),
                            'type' => 'select',
							'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4 ),
							'default' => '2',
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
                'icon' => 'tp tp-road-sign',
                'menu' => '',
				'columns' => 2,
                'custom_class' => ''
            ),
            $atts
        );

        $title = $args['title'];
        $icon = esc_attr( $args['icon'] );
        $menu = (int) esc_attr( $args['menu'] );
		$columns = (int) esc_attr( $args['columns'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$class = $custom_class;
        $class .= $icon !== '' ? ' m-has-icon' : '';
		$class .= $columns > 0 ? ' m-' . $columns . '-columns' : ' m-2-columns';
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<div class="c-directory' . $class . '"><div class="c-content-box"><div class="directory-inner">';
		$output .= $title !== '' && $icon !== '' ? '<i class="ico-shadow ' . $icon . '"></i>' : '';
		$output .= $title !== '' ? '<h2 class="directory-title">' : '';
		$output .= $title !== '' && $icon !== '' ? '<i class="ico ' . $icon . '"></i>' : '';
		$output .= $title !== '' ? $title . '</h2>' : '';
		$output .= '<div class="directory-content">';
		if ( $menu > -1 ) {
			$output .= wp_nav_menu( array(
				'menu' => $menu,
				'echo' => false,
				'menu_class' => 'directory-menu',
			));
		}
        else {
            $output .= '<p>' . __( 'No menu assigned', 'lsvrtoolkit' ) . '</p>';
        }
		$output .= '</div></div></div></div>';

		return $output;

    }
    add_shortcode( 'lsvr_directory', 'lsvr_directory_shortcode' );

}
?>