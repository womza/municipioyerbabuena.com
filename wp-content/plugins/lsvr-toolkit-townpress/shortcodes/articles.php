<?php
if ( ! lsvr_shortcode_exists( 'lsvr_articles' ) && ! function_exists( 'lsvr_articles_shortcode' ) ) {

    function lsvr_articles_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------

            Output shortcode info for shortcode generator

        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            $shortcode_data = array(
                'lsvr_articles' => array(
                    'name' => __( 'Articles', 'lsvrtoolkit' ),
                    'description' => __( 'Lists standard posts', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvrtoolkit' ),
                            'type' => 'text',
							'default' => __( 'Local <strong>News</strong>', 'lsvrtoolkit' )
                        ),
						'icon' => array(
                            'label' => __( 'Icon', 'lsvrtoolkit' ),
							'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvrtoolkit' ),
                            'type' => 'text',
							'default' => 'tp tp-reading',
                        ),
                        'number_of_items' => array(
                            'label' => __( 'Number of Posts', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10 ),
                            'default' => '5'
                        ),
                        'highlight_first' => array(
                            'label' => __( 'Highlight First Post', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( 'yes' => __( 'Yes', 'lsvrtoolkit' ), 'no' => __( 'No', 'lsvrtoolkit' ) ),
                            'default' => 'yes'
                        ),
                        'more_btn_label' => array(
                            'label' => __( 'More Button Label', 'lsvrtoolkit' ),
							'description' => __( 'Leave blank to hide More button.', 'lsvrtoolkit' ),
                            'type' => 'text',
                        ),
                        'custom_class' => array(
                            'label' => __( 'Custom Class', 'lsvrtoolkit' ),
                            'description' => __( 'It can be used for applying custom CSS.', 'lsvrtoolkit' ),
                            'type' => 'text'
                        )
                    )
                )
            );

            // CHECK FOR CATEGORIES
            $categories_tax = get_categories( 'hide_empty=1&hierarchical=0&parent=0' ) ;

            if ( count( $categories_tax ) > 0 ) {

                $values = array( 'none' => __( 'None', 'lsvrtoolkit' ) );

                foreach ( $categories_tax as $value ) {
                    $values[$value->cat_ID] = $value->name;
                }

                $att_data = array(
                    'label' => __( 'Category', 'lsvrtoolkit' ),
                    'description' => __( 'Category to load posts from. Choose <strong>None</strong> to load posts regardless of category.', 'lsvrtoolkit' ),
                    'type' => 'select',
                    'values' => $values,
                    'default' => 'none'
                );

                $shortcode_atts_arr = $shortcode_data['lsvr_articles']['atts'];
                //$shortcode_atts_arr = array_splice( $shortcode_atts_arr, 0, 2, true ) + array( 'category' => $att_data ) + array_slice( $shortcode_atts_arr, 1, count( $shortcode_atts_arr ) - 1, true );
				$shortcode_atts_arr = array( 'category' => $att_data ) + $shortcode_atts_arr;
                $shortcode_data['lsvr_articles']['atts'] = $shortcode_atts_arr;

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

				'category' => 'none',
				'title' => '',
				'icon' => 'tp tp-reading',
				'number_of_items' => 3,
				'highlight_first' => '',
				'more_btn_label' => '',
                'custom_class' => ''
            ),
            $atts
        );

		$category = trim( esc_attr( $args['category'] ) );
		$title = $args['title'];
		$icon = esc_attr( $args['icon'] );
        $number_of_items = (int) esc_attr( $args['number_of_items'] );
		$highlight_first = esc_attr( $args['highlight_first'] );
		$highlight_first = $highlight_first === 'yes' ? true : false;
		$more_btn_label = $args['more_btn_label'];
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Query
        --------------------------------------------------------------------- */

        $q_args = array(
            'posts_per_page' => $number_of_items,
            'post_type' => 'post',
            'order' => 'DESC',
            'orderby' => 'post_date',
            'post_status' => array( 'publish' ),
            'suppress_filters' => false
        );

        if ( $category !== '' && $category !== 'none' ) {

            // GET ITEMS FROM TOP CATEGORY
            $q_args[ 'tax_query' ] = array(
                array(
                    'taxonomy' => 'category',
                    'terms' => intval( $category )
                )
            );

            // GET TERM LINK
            $category_link = get_term_link( $category, 'category' );

        }

        $loop = new WP_Query( $q_args );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$class = $custom_class;
        $class .= $icon !== '' ? ' m-has-icon' : '';
		$class .= $highlight_first ? ' m-has-featured' : '';
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$more_btn_link = $category !== 'none' ? get_category_link( intval( $category ) ) : get_permalink( get_option( 'page_for_posts' ) );

		$output = '<div class="c-article-list' . $class . '"><div class="c-content-box"><div class="article-list-inner">';
		$output .= $title !== '' && $icon !== '' ? '<i class="ico-shadow ' . $icon . '"></i>' : '';
		$output .= $title !== '' ? '<h2 class="article-list-title">' : '';
		$output .= $title !== '' && $icon !== '' ? '<i class="ico ' . $icon . '"></i>' : '';
		$output .= $title !== '' ? '<a href="' . $more_btn_link . '">' . $title . '</a></h2>' : '';
		$output .= '<div class="article-list-content">' ;

		if ( $loop->have_posts() ) {

			$index = 0;

			// LOOP
			while ( $loop->have_posts() ) {

				$loop->the_post();

				// FIRST POST
				if ( $highlight_first && $index < 2 ) { // $index === 0 <- only show 1 article

					if ( has_post_thumbnail() ) {
						$output .= '<article class="featured-article m-has-thumb">';
						$thumb_data = lsvr_get_image_data( get_post_thumbnail_id() );
						$output .= '<div class="article-image"><a href="' . get_permalink() . '" style="background-image: url(\'' . $thumb_data['large'] . '\')"></a></div>';
					}
					else {
						$output .= '<article class="featured-article">';
					}
					$output .= '<div class="article-core">';
					$output .= '<h3 class="article-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
					$output .= '<div class="article-date"><i class="ico tp tp-clock2"></i>' . get_the_date() . '</div>';
					$output .= '<div class="article-excerpt">' . wpautop( get_the_excerpt() ) . '</div>';
					$output .= '</div></article>';

				}
				// OTHER POSTS
				else {

					$output .= '<article class="brief-article">';
					$output .= '<h3 class="article-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
					$output .= '<div class="article-date">' . get_the_date() . '</div>';
					$output .= '</article>';

				}

				$index++;

			}
			wp_reset_query();

			// MORE BUTTON
			if ( $more_btn_label !== '' ) {
				$output .= '<p class="more-btn-holder"><a href="' . $more_btn_link . '">' . $more_btn_label . '</a></p>';
			}

		}
		else {
			$output .= __( 'No posts', 'lsvrtoolkit' );
		}

		$output .= '</div></div></div></div>';

		return $output;

    }
    add_shortcode( 'lsvr_articles', 'lsvr_articles_shortcode' );

}
?>