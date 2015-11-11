<?php

/* -----------------------------------------------------------------------------

    FEATURED GALLERY WIDGET

----------------------------------------------------------------------------- */

if ( ! class_exists( 'Lsvr_Gallery_Featured_Widget' ) ) {
class Lsvr_Gallery_Featured_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'lsvr-gallery-featured', 'description' => __( 'Display featured gallery.', 'lsvrtoolkit' ) );
        parent::__construct( 'lsvr_gallery_featured_widget', __( 'LSVR Featured Gallery', 'lsvrtoolkit' ), $widget_ops );
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Featured Gallery', 'lsvrtoolkit' ), 'gallery' => 'none',
			'show_all_btn_label' => __( 'See All Galleries', 'lsvrtoolkit' ) ) );

        $title = $instance['title'];
		$gallery = $instance['gallery'];
		$show_all_btn_label = $instance['show_all_btn_label'];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" >
        </p>

		<?php $args = array(
			'posts_per_page'   => 1000,
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'post_type'        => 'lsvrgallery',
			'post_status'      => 'publish',
			'suppress_filters' => true
		);
		$galleries_arr = get_posts( $args ); ?>

		<p><label for="<?php echo $this->get_field_id( 'gallery' ); ?>"><?php echo __( 'Gallery:', 'lsvrtoolkit' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'gallery' ); ?>" name="<?php echo $this->get_field_name( 'gallery' ); ?>">
			<option value="none"<?php if ( $gallery === 'none' ) { echo ' selected'; } ?>><?php _e( 'Most Recent', 'lsvrtoolkit' ); ?></option>
			<?php if ( is_array( $galleries_arr ) ) : ?>
				<?php foreach ( $galleries_arr as $gallery_item ) : ?>
					<?php if ( is_object( $gallery_item ) && property_exists( $gallery_item, 'ID' ) && property_exists( $gallery_item, 'post_title' ) ) : ?>
						<option value="<?php echo $gallery_item->ID; ?>"<?php if ( $gallery == $gallery_item->ID ) { echo ' selected'; } ?>><?php echo $gallery_item->post_title; ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</select></p>

		<p>
            <label for="<?php echo $this->get_field_id( 'show_all_btn_label' ); ?>"><?php echo __( 'More Button Label:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'show_all_btn_label' ); ?>" name="<?php echo $this->get_field_name( 'show_all_btn_label' ); ?>" type="text" value="<?php echo $show_all_btn_label; ?>" >
        </p>
		<p><?php _e( 'Link to all galleries. Leave blank do disable.', 'lsvrtoolkit' ); ?></p>

        <?php

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
		$instance['gallery'] = $new_instance['gallery'];
		$instance['show_all_btn_label'] = $new_instance['show_all_btn_label'];
        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
		$gallery = $instance['gallery'];
		$show_all_btn_label = $instance['show_all_btn_label'];
        if ( empty($title) ) { $title = false; }

        ?>

		<?php echo $before_widget; ?>
            <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
            <div class="widget-content">

				<?php if ( intval( $gallery ) > 0 ) : ?>

					<?php $featured_gallery = get_post( $gallery ); ?>

				<?php else: ?>

					<?php $args = array(
					'posts_per_page'   => 1,
					'orderby'          => 'post_date',
					'order'            => 'DESC',
					'post_type'        => 'lsvrgallery',
					'post_status'      => 'publish',
					'suppress_filters' => true
					);
					$featured_gallery = get_posts( $args );
					if ( is_array( $featured_gallery ) && ! empty( $featured_gallery ) ) {
						$featured_gallery = $featured_gallery[0];
					} ?>

				<?php endif; ?>

				<?php if ( is_object( $featured_gallery ) && property_exists( $featured_gallery, 'ID' ) ) : ?>

					<?php $gallery_id = $featured_gallery->ID; ?>

					<?php $thumb_data = false; ?>
					<?php $gallery_arr = get_post_meta( $gallery_id, 'meta_gallery_images', true ); ?>
					<?php if ( has_post_thumbnail( $gallery_id ) ) : ?>
						<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id( $gallery_id ) ); ?>
					<?php elseif ( $gallery_arr !== '' ) : ?>
						<?php $gallery_arr = explode( ',', $gallery_arr ); ?>
						<?php $thumb_data = lsvr_get_image_data( $gallery_arr[0] ); ?>
					<?php endif; ?>

					<?php if ( $thumb_data ) : ?>
					<div class="gallery-image" title="<?php echo get_the_title( $gallery_id ); ?>">
						<a href="<?php echo get_the_permalink( $gallery_id ); ?>"><img src="<?php echo esc_url( $thumb_data['large'] ); ?>" alt="<?php echo esc_attr( $thumb_data['alt'] ); ?>"></a>
					</div>
					<?php endif; ?>

				<?php endif; ?>

				<?php if ( $show_all_btn_label !== '' ) : ?>
					<?php $show_all_btn_link = get_post_type_archive_link( 'lsvrgallery' ); ?>
					<p class="show-all-btn">
						<a href="<?php echo $show_all_btn_link; ?>"><?php echo $show_all_btn_label; ?></a>
					</p>
				<?php endif; ?>

            </div>
		<?php echo $after_widget; ?>

        <?php

    }

}}

?>