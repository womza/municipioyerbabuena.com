<?php

/* -----------------------------------------------------------------------------

    DOCUMENT CATEGORIES WIDGET

----------------------------------------------------------------------------- */

if ( ! class_exists( 'Lsvr_Document_Categories_Widget' ) ) {
class Lsvr_Document_Categories_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'lsvr-document-categories', 'description' => __( 'List document categories.', 'lsvrtoolkit' ) );
        parent::__construct( 'lsvr_document_categories_widget', __( 'LSVR Document Categories', 'lsvrtoolkit' ), $widget_ops );
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Document Categories', 'lsvrtoolkit' ), 'show_count' => 'on' ) );

        $title = $instance['title'];
		$show_count = $instance['show_count'];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" >
        </p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" <?php if ( isset( $show_count ) && $show_count === 'on' ) { echo ' checked'; } ?>>
            <label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php echo __( 'Show Count', 'lsvrtoolkit' ); ?></label>
        </p>

        <?php

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
		$instance['show_count'] = $new_instance['show_count'];
        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
        $show_count = $instance['show_count'];

        if ( empty($title) ) { $title = false; }

        ?>

        <?php echo $before_widget; ?>
            <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
            <div class="widget-content">

                <?php $today = current_time( 'Y-m-d H:i' ); ?>
                <?php $is_archive = isset( $_GET[ 'archive' ] ) && preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET[ 'archive' ] ) === 'true' ? true : false; ?>

                <?php $q_args = array(
                    'post_type' => 'lsvrdocument',
                    'posts_per_page' => 1000
                );

                // SHOW AS ARCHIVE
                if ( $is_archive ) {
                    $q_args[ 'meta_query' ] = array(
                        array( 'key' => 'meta_document_expiration_date',
                            'value' => $today,
                            'compare' => '<=',
                            'type' => 'CHAR'
                        )
                    );
                }

                // SHOW WITHOUT EXPIRED (ARCHIVED)
                else {
                    $q_args[ 'meta_query' ] = array(
                        'relation' => 'OR',
                            array( 'key' => 'meta_document_expiration_date',
                                'value' => '',
                                'compare' => 'NOT EXISTS',

                            ),
                            array( 'key' => 'meta_document_expiration_date',
                                'value' => $today,
                                'compare' => '>=',
                                'type' => 'CHAR'
                            )
                    );
                }

                ?>
                <?php $loop = new WP_Query( $q_args ); ?>

                <?php // CREATE ARRAYS WITH REAL NON-EMPTY CATEGORIES
                $categories_arr = array();
                $categories_id_arr = array();
                if ( $loop->have_posts() ) {
                    while ( $loop->have_posts() ) {
                        $loop->the_post();
                        $terms = wp_get_object_terms( get_the_id(), 'lsvrdocumentcat' );
                        foreach ( $terms as $term ) {
                            if ( array_key_exists( $term->term_id, $categories_arr ) ) {
                                $categories_arr[$term->term_id]['count']++;
                            } else {
                                $categories_arr[$term->term_id] = array( 'name' => $term->name, 'count' => 1 );

                                // CORRECT COUNTS
                                if ( function_exists( 'lsvr_get_term_parents' ) ) {
                                    $term_parents = lsvr_get_term_parents( $term->term_id, 'lsvrdocumentcat' );
                                    if ( is_array( $term_parents ) ) {
                                        foreach ( $term_parents as $term_parent ) {
                                            if ( array_key_exists( $term_parent, $categories_arr ) ) {
                                                $categories_arr[$term_parent]['count']++;
                                            }
                                        }
                                    }
                                }

                            }
                            if ( ! in_array( $term->term_id, $categories_id_arr ) ) {
                                array_push( $categories_id_arr, $term->term_id );
                            }
                        }
                    }
                } ?>

                <?php wp_reset_query(); ?>
                <?php $included_categories_id = implode( ',', $categories_id_arr ); ?>

                <ul>
                <?php wp_list_categories( array(
                    'taxonomy' => 'lsvrdocumentcat',
                    'show_count' => $show_count,
                    'title_li' => '',
                    'include' => $included_categories_id,
                    'walker' => new Lsvr_Document_Categories_Walker,
                    'lsvr_counts' => $categories_arr
                )); ?>
                </ul>

            </div>
        <?php echo $after_widget; ?>

        <?php

    }

}}

/* -------------------------------------------------------------------------
    CUSTOM WALKER
------------------------------------------------------------------------- */

if ( ! class_exists( 'Lsvr_Document_Categories_Walker' ) ) {
class Lsvr_Document_Categories_Walker extends Walker_Category {

    var $db_fields = array ( 'parent' => 'parent', 'id' => 'term_id' );

    function start_lvl( &$output, $depth=1, $args=array() ) {
        $output .= '<ul class="children">';
    }

    function end_lvl( &$output, $depth=0, $args=array() ) {
        $output .= '</ul>';
    }

    function start_el( &$output, $item, $depth=0, $args=array(), $current_object_id = 0 ) {

        $is_archive = isset( $_GET[ 'archive' ] ) && preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET[ 'archive' ] ) === 'true' ? true : false;
        $active_html = $item->term_id == $args['current_category'] ? ' class="current-cat"' : '';
        $output .= '<li' . $active_html . '>';
        if ( $is_archive ) {
            $output .= '<a href="' . esc_url( add_query_arg( array( 'archive' => 'true' ), get_term_link( $item, 'lsvrdocumentcat' ) ) ) . '">' . esc_attr( $item->name ) . '</a>';
        }
        else {
            $output .= '<a href="' . esc_url( get_term_link( $item, 'lsvrdocumentcat' ) ) . '">' . esc_attr( $item->name ) . '</a>';
        }

        // SHOW REAL COUNT
        if ( $args['show_count'] === 'on' ) {
            $categories_arr = $args['lsvr_counts'];
            if ( array_key_exists( $item->term_id, $categories_arr ) ) {
                $term_arr = $categories_arr[ $item->term_id ];
                if ( array_key_exists( 'count', $term_arr ) ) {
                    $output .= ' (' . $term_arr['count'] . ')';
                }
            }
        }

    }

    function end_el( &$output, $item, $depth=0, $args=array() ) {
        $output .= '</li>';
    }

}}

?>