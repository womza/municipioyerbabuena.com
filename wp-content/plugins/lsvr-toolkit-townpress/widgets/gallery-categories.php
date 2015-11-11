<?php

/* -----------------------------------------------------------------------------

    GALLERY CATEGORIES WIDGET

----------------------------------------------------------------------------- */

if ( ! class_exists( 'Lsvr_Gallery_Categories_Widget' ) ) {
class Lsvr_Gallery_Categories_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'lsvr-gallery-categories', 'description' => __( 'List gallery categories.', 'lsvrtoolkit' ) );
        parent::__construct( 'lsvr_gallery_categories_widget', __( 'LSVR Gallery Categories', 'lsvrtoolkit' ), $widget_ops );
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Gallery Categories', 'lsvrtoolkit' ), 'show_count' => 'on' ) );

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

				<ul>
				<?php wp_list_categories( array(
					'taxonomy' => 'lsvrgallerycat',
					'show_count' => $show_count,
					'title_li' => '',
				)); ?>
				</ul>

            </div>
		<?php echo $after_widget; ?>

        <?php

    }

}}

?>