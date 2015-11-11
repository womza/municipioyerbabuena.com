<?php
if ( ! lsvr_shortcode_exists( 'lsvr_documents' ) && ! function_exists( 'lsvr_documents_shortcode' ) ) {

    function lsvr_documents_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------

            Output shortcode info for shortcode generator

        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            $shortcode_data = array(
                'lsvr_documents' => array(
                    'name' => __( 'Documents', 'lsvrtoolkit' ),
                    'description' => __( 'Lists documents. You can add documents under <strong>Documents</strong>', 'lsvrtoolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvrtoolkit' ),
                            'type' => 'text',
							'default' => __( 'Town <strong>Documents</strong>', 'lsvrtoolkit' )
                        ),
						'icon' => array(
                            'label' => __( 'Icon', 'lsvrtoolkit' ),
							'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvrtoolkit' ),
                            'type' => 'text',
							'default' => 'tp tp-papers',
                        ),
                        'number_of_items' => array(
                            'label' => __( 'Number of Documents', 'lsvrtoolkit' ),
                            'type' => 'select',
                            'values' => array( '0' => __( 'All', 'lsvrtoolkit' ), '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10 ),
                            'default' => 'all'
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
            $categories_tax = get_categories( 'taxonomy=lsvrdocumentcat&hide_empty=1&hierarchical=0&parent=0' ) ;

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

                $shortcode_atts_arr = $shortcode_data['lsvr_documents']['atts'];
				$shortcode_atts_arr = array( 'category' => $att_data ) + $shortcode_atts_arr;
                $shortcode_data['lsvr_documents']['atts'] = $shortcode_atts_arr;

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
				'number_of_items' => 'all',
				'more_btn_label' => '',
                'custom_class' => ''
            ),
            $atts
        );

		$category = trim( esc_attr( $args['category'] ) );
		$title = $args['title'];
		$icon = esc_attr( $args['icon'] );
        $number_of_items = (int) esc_attr( $args['number_of_items'] );
        $number_of_items = $number_of_items < 1 ? 1000 : $number_of_items;
		$more_btn_label = $args['more_btn_label'];
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Query
        --------------------------------------------------------------------- */

        $q_args = array(
            'posts_per_page' => $number_of_items,
            'post_type' => 'lsvrdocument',
            'order' => 'DESC',
            'orderby' => 'post_date',
            'post_status' => array( 'publish' ),
            'suppress_filters' => false
        );

        if ( $category !== '' && $category !== 'none' ) {

            // GET ITEMS FROM TOP CATEGORY
            $q_args[ 'tax_query' ] = array(
                array(
                    'taxonomy' => 'lsvrdocumentcat',
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
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$more_btn_link = $category !== 'none' ? get_term_link( intval( $category ), 'lsvrdocumentcat' ) : get_post_type_archive_link( 'lsvrdocument' );

		$output = '<div class="c-document-list' . $class . '"><div class="c-content-box"><div class="document-list-inner">';
		$output .= $title !== '' && $icon !== '' ? '<i class="ico-shadow ' . $icon . '"></i>' : '';
		$output .= $title !== '' ? '<h2 class="document-list-title">' : '';
		$output .= $title !== '' && $icon !== '' ? '<i class="ico ' . $icon . '"></i>' : '';
		$output .= $title !== '' ? '<a href="' . $more_btn_link . '">' . $title . '</a></h2>' : '';
		$output .= '<div class="document-list-content">' ;

		if ( $loop->have_posts() ) {

			// LOOP
			while ( $loop->have_posts() ) {

				$loop->the_post();


					$output .= '<article class="brief-article">';
					$output .= '<h3 class="article-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
					$output .= '<div class="article-date">' . get_the_date() . '</div>';
					$output .= '</article>';



			}
			wp_reset_query();

			// MORE BUTTON
			if ( $more_btn_label !== '' ) {
				$output .= '<p class="more-btn-holder"><a href="' . $more_btn_link . '">' . $more_btn_label . '</a></p>';
			}

		}
		else {
			$output .= __( 'No documents', 'lsvrtoolkit' );
		}

		$output .= '</div></div></div></div>';

		return $output;

    }
    add_shortcode( 'lsvr_documents', 'lsvr_documents_shortcode' );

}
?>