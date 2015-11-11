<?php
if ( ! lsvr_shortcode_exists( 'lsvr_team_member' ) && ! function_exists( 'lsvr_team_member_shortcode' ) ) {

    function lsvr_team_member_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_team_member' => array(
                    'name' => __( 'Team Member', 'lsvrtoolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'portrait' => array(
                            'label' => __( 'Portrait', 'lsvrtoolkit' ),
                            'type' => 'file'
                        ),
                        'name' => array(
                            'label' => __( 'Name', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
                        'role' => array(
                            'label' => __( 'Role', 'lsvrtoolkit' ),
							'description' => __( 'Short text which will be shown under name (e.g. "web designer").', 'lsvrtoolkit' ),
                            'type' => 'text'
                        ),
                        'social_icons' => array(
                            'label' => __( 'Social Icons', 'lsvrtoolkit' ),
                            'description' => __( 'Use the following pattern for adding social icons: "<strong>icon_class1,link1|icon_class2,link2</strong>".<br>For example: "<strong>fa fa-twitter,https://twitter.com/MyTwitterProfile|fa fa-facebook,https://www.facebook.com/MyTwitterProfile</strong>".', 'lsvrtoolkit' ),
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
                'portrait' => '',
                'name' => '',
                'role' => '',
                'social_icons' => '',
				'wpautop' => '',
                'custom_class' => ''
            ),
            $atts
        );

        $name = $args['name'];
        $role = $args['role'];
        $social_icons = $args['social_icons'];
		$wpautop = esc_attr( $args['wpautop'] );
		$wpautop = $wpautop === 'yes' ? true : false;
        $custom_class = esc_attr( $args['custom_class'] );

		// PARSE IMAGE
		$portrait = $args['portrait'];
		if ( (int) $portrait > 0 ) {
			$image_data = lsvr_get_image_data( $portrait );
			if ( $image_data ) {
				$portrait = esc_url( $image_data[ 'thumbnail' ] );
			}
			else {
				$portrait = '';
			}
		}
		else if ( $portrait !== '' ) {
			$portrait = esc_url( $portrait );
		}

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $class = $custom_class;
		$class .= $portrait !== '' ? ' m-has-portrait' : '';
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<div class="c-team-member' . $class . '"><div class="c-content-box"><div class="team-member-inner">';
		$output .= $portrait !== '' ? '<div class="member-portrait"><img alt="" src="' . $portrait . '"></div>' : '';
		$output .= $name !== '' ? '<h3 class="member-name">' . $name . '</h3>' : '';
		$output .= $role !== '' ? '<h4 class="member-role">' . $role . '</h4>' : '';
		if ( $content !== '' ) {
		$output .= '<div class="member-description">';
			if ( $wpautop ) {
				$output .= do_shortcode( wpautop( $content ) );
			}
			else {
				$output .= do_shortcode( $content );
			}
			$output .= '</div>';
		}
		if ( $social_icons !== '' ) {
			$output .= '<ul class="member-social">';
			$social_icons_arr = explode( '|', $social_icons );
			if ( is_array( $social_icons_arr ) && count( $social_icons_arr ) > 0 ) {
				foreach( $social_icons_arr as $social_icon ) {
					$social_icon_arr = explode( ',', $social_icon );
					if ( is_array( $social_icon_arr ) && count( $social_icon_arr ) === 2 ) {
						$output .= '<li><a href="' . $social_icon_arr[1] . '" target="_blank"><i class="' . $social_icon_arr[0] . '"></i></a></li>';
					}
				}
			}
			$output .= '</ul>';
		}
		$output .= '</div></div></div>';

		return $output;

    }
    add_shortcode( 'lsvr_team_member', 'lsvr_team_member_shortcode' );

}
?>