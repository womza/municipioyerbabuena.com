<?php

if ( ! lsvr_shortcode_exists( 'lsvr_slider' ) && ! function_exists( 'lsvr_slider_shortcode' ) ) {

    function lsvr_slider_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        if ( post_type_exists( 'lsvrslide' ) ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            $shortcode_data = array(
                'lsvr_slider' => array(
                    'name' => __( 'Slider', 'lsvrtoolkit' ),
                    'description' => __( 'Basic slider. Slides can be managed under <strong>Slides</strong>.', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
                        'bg_image' => array(
                            'label' => __( 'Background Image', 'lsvrtoolkit' ),
                            'type' => 'file',
							'description' => __( 'If you want to have a separate background image for each slide, leave this blank and set a Featured Image for each Slide post instead.', 'lsvrtoolkit' ),
                        ),
						'height' => array(
                            'label' => __( 'Height', 'lsvrtoolkit' ),
                            'type' => 'text',
                            'default' => 400
                        ),
                        'interval' => array(
                            'label' => __( 'Autoplay Speed', 'lsvrtoolkit' ),
                            'description' => __( 'Duration between transitions in seconds. Leave blank to disable automatic slideshow.', 'lsvrtoolkit' ),
                            'type' => 'text',
                            'default' => 0
                        ),
                        'custom_class' => array(
                            'label' => __( 'Custom Class', 'lsvrtoolkit' ),
                            'description' => __( 'It can be used for applying custom CSS.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        )
                    )
                )
            );

            // check for slider taxonomy terms
            $slides_group_tax = get_terms( 'lsvrslider', 'hide_empty=0&hierarchical=0&parent=0' ) ;
            if ( count( $slides_group_tax ) > 0 ) {

                $values = array( 'none' => __( 'Show all slides', 'lsvrtoolkit' ) );
                foreach ( $slides_group_tax as $value ) {
                    $values[$value->slug] = $value->name;
                }

                $att_data = array(
                    'label' => __( 'Slider', 'lsvrtoolkit' ),
                    'description' => __( 'Which slider will be used. You can manage sliders under <strong>Slides / Sliders</strong>. Choose <strong>None</strong> to load all slides.', 'lsvrtoolkit' ),
                    'type' => 'select',
                    'values' => $values,
                    'default' => 'none'
                );

                $shortcode_data['lsvr_slider']['atts'] = array_merge( array( 'slider' => $att_data ), $shortcode_data['lsvr_slider']['atts'] );

            }

            return $shortcode_data;

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
                'slider' => '',
				'bg_image' => '',
				'height' => 400,
                'interval' => 0,
				'wpautop' => '',
                'custom_class' => ''
            ),
            $atts
        );

        $slider = trim( esc_attr( $args['slider'] ) );
		$height = (int) $args['height'];
        $interval = (int) $args['interval'];
		$wpautop = esc_attr( $args['wpautop'] );
		$wpautop = $wpautop === 'yes' ? true : false;
        $custom_class = esc_attr( $args['custom_class'] );

		// PARSE IMAGE
		$bg_image = $args['bg_image'];
		if ( (int) $bg_image > 0 ) {
			$image_data = lsvr_get_image_data( $bg_image );
			if ( $image_data ) {
				$bg_image = esc_url( $image_data[ 'full' ] );
			}
			else {
				$bg_image = '';
			}
		}
		else {
			$bg_image = esc_url( $bg_image );
		}

        /* ---------------------------------------------------------------------
            Query
        --------------------------------------------------------------------- */

        $q_args = array(
            'posts_per_page' => -1,
            'post_type' => 'lsvrslide',
            'order' => 'DESC',
            'orderby' => 'post_date',
            'post_status' => array( 'publish', 'private' ),
            'suppress_filters' => false
        );

        if ( $slider !== '' && $slider !== 'none' ) {

            $slider = explode( ',', $slider );
            $q_args[ 'tax_query' ] = array(
                array(
                    'taxonomy' => 'lsvrslider',
                    'field' => 'slug',
                    'terms' => $slider
                )
            );

        }

        $loop = new WP_Query( $q_args );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$class = $custom_class;
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		if ( $loop->have_posts() ) {

			$output = '<div class="c-slider' . $class . '"';
			$output .= $interval > 0 ? ' data-autoplay="' . ( $interval * 1000 ) . '"' : '';
			$output .= $bg_image !== '' ? ' style="background-image: url( \'' . $bg_image . '\' );"' : '';
			$output .= '><div class="slide-list">';

			while ( $loop->have_posts() ) {

				$loop->the_post();

				$thumb_url = '';
				if ( has_post_thumbnail( get_the_id() ) ) {
					$image_data = lsvr_get_image_data( get_post_thumbnail_id() );
					if ( $image_data ) {
						$thumb_url = $image_data['full'];
					}
				}

				$output .= '<div class="slide"';
				$output .= $thumb_url !== '' ? ' style="background-image: url( \'' . $thumb_url . '\' );"' : '';
				$output .= '><div class="slide-bg">';
				$output .= '<div class="slide-inner">';
				$output .= '<div class="slide-content valign-' . lsvr_get_field( 'meta_slide_valign', 'middle' ) . '"';
				$output .= $height > 0 ? ' style="height: ' . $height . 'px;"' : '';
				$output .= '>';
				if ( $wpautop ) {
					$output .= do_shortcode( wpautop( get_the_content() ) );
				}
				else {
					$output .= do_shortcode( get_the_content() );
				}
				$output .= '</div></div>';
				$output .= '</div></div>';

			}
			wp_reset_query();

			$output .= '</div></div>';

		}

		return $output;

		}

    }
    add_shortcode( 'lsvr_slider', 'lsvr_slider_shortcode' );

}

?>