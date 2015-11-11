<?php

/* -----------------------------------------------------------------------------

    GALLERIES WIDGET

----------------------------------------------------------------------------- */

if ( ! class_exists( 'Lsvr_Galleries_Widget' ) ) {
class Lsvr_Galleries_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'lsvr-galleries', 'description' => __( 'List galleries.', 'lsvrtoolkit' ) );
        parent::__construct( 'lsvr_galleries_widget', __( 'LSVR Galleries', 'lsvrtoolkit' ), $widget_ops );
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Galleries', 'lsvrtoolkit' ), 'category' => 'none',
			'limit' => 5, 'show_thumb' => 'on', 'show_date' => 'on', 'show_all_btn_label' => __( 'See All Galleries', 'lsvrtoolkit' ) ) );

        $title = $instance['title'];
		$category = $instance['category'];
		$limit = $instance['limit'];
		$show_thumb = $instance['show_thumb'];
		$show_date = $instance['show_date'];
		$show_all_btn_label = $instance['show_all_btn_label'];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" >
        </p>

		<?php $terms_arr = get_terms( 'lsvrgallerycat' ); ?>
		<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php echo __( 'Category:', 'lsvrtoolkit' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
			<option value="none"<?php if ( $category === 'none' ) { echo ' selected'; } ?>><?php _e( 'None (list all)', 'lsvrtoolkit' ); ?></option>
			<?php if ( is_array( $terms_arr ) ) : ?>
				<?php foreach ( $terms_arr as $term ) : ?>
					<?php if ( is_object( $term ) && property_exists( $term, 'term_id' ) && property_exists( $term, 'name' ) ) : ?>
						<option value="<?php echo $term->term_id; ?>"<?php if ( $category === $term->term_id ) { echo ' selected'; } ?>><?php echo $term->name; ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</select></p>

		<p><label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php echo __( 'Limit:', 'lsvrtoolkit' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>">
			<?php for ( $i = 1; $i <= 10; $i++ ) : ?>
				<option value="<?php echo $i; ?>"<?php if ( intval( $limit ) === intval( $i ) ) { echo ' selected'; } ?>><?php echo $i; ?></option>
			<?php endfor; ?>
		</select></p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_thumb' ); ?>" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" <?php if ( isset( $show_thumb ) && $show_thumb === 'on' ) { echo ' checked'; } ?>>
            <label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>"><?php echo __( 'Show Thumb', 'lsvrtoolkit' ); ?></label>
        </p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" <?php if ( isset( $show_date ) && $show_date === 'on' ) { echo ' checked'; } ?>>
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php echo __( 'Show Date', 'lsvrtoolkit' ); ?></label>
        </p>

		<p>
            <label for="<?php echo $this->get_field_id( 'show_all_btn_label' ); ?>"><?php echo __( 'More Button Label:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'show_all_btn_label' ); ?>" name="<?php echo $this->get_field_name( 'show_all_btn_label' ); ?>" type="text" value="<?php echo $show_all_btn_label; ?>" >
        </p>
		<p><?php _e( 'Leave blank do disable more button.', 'lsvrtoolkit' ); ?></p>

        <?php

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
		$instance['category'] = $new_instance['category'];
		$instance['limit'] = $new_instance['limit'];
		$instance['show_thumb'] = $new_instance['show_thumb'];
		$instance['show_date'] = $new_instance['show_date'];
		$instance['show_all_btn_label'] = $new_instance['show_all_btn_label'];
        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
		$category = $instance['category'];
		$limit = $instance['limit'];
		$show_thumb = $instance['show_thumb'];
		$show_date = $instance['show_date'];
		$show_all_btn_label = $instance['show_all_btn_label'];
        if ( empty($title) ) { $title = false; }

        ?>

		<?php echo $before_widget; ?>
            <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
            <div class="widget-content">

				<?php // QUERY
				$q_args = array(
					'posts_per_page' => $limit,
					'post_type' => 'lsvrgallery',
					'order' => 'DESC',
					'orderby' => 'post_date',
					'post_status' => array( 'publish' ),
					'suppress_filters' => false,
				);
				if ( $category !== 'none' ) {
					$q_args[ 'tax_query' ] = array( array( 'taxonomy' => 'lsvrgallerycat', 'field' => 'id', 'terms' => array( intval( $category ) ) ) );
				}
				$loop = new WP_Query( $q_args ); ?>

				<?php if ( is_singular( 'lsvrgallery' ) ) : ?>
					<?php global $wp_query; ?>
					<?php $current_id = $wp_query->queried_object; ?>
					<?php $current_id = $current_id->ID; ?>
				<?php else: ?>
					<?php $current_id = false; ?>
				<?php endif; ?>

				<?php if ( $loop->have_posts() ) : ?>

					<ul>
					<?php while ( $loop->have_posts() ) : ?>

						<?php $loop->the_post(); ?>

						<?php $thumb_data = false; ?>
						<?php if ( isset( $show_thumb ) && $show_thumb === 'on' ) : ?>
							<?php $gallery_arr = lsvr_get_field( 'meta_gallery_images' ); ?>
							<?php if ( has_post_thumbnail() ) : ?>
								<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id() ); ?>
							<?php elseif ( $gallery_arr !== '' ) : ?>
								<?php $gallery_arr = explode( ',', $gallery_arr ); ?>
								<?php $thumb_data = lsvr_get_image_data( $gallery_arr[0] ); ?>
							<?php endif; ?>
						<?php endif; ?>

						<?php $item_class = $current_id === get_the_id() ? ' m-active' : ''; ?>
						<?php $item_class .= $thumb_data ? ' m-has-thumb' : ''; ?>
						<li class="<?php echo esc_attr( trim( $item_class ) ); ?>">
							<div class="gallery-inner">

								<?php if ( $thumb_data ) : ?>
									<a href="<?php the_permalink(); ?>" class="gallery-image"><img src="<?php echo esc_url( $thumb_data['thumbnail'] ); ?>" alt="<?php echo esc_attr( $thumb_data['alt'] ); ?>"></a>
								<?php endif; ?>

								<h4 class="gallery-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

								<?php if ( isset( $show_date ) && $show_date === 'on' ) : ?>
								<div class="gallery-date"><?php echo get_the_date(); ?></div>
								<?php endif; ?>

							</div>
						</li>

					<?php endwhile; ?>
					<?php wp_reset_query(); ?>
					</ul>

					<?php if ( $show_all_btn_label !== '' ) : ?>
						<?php $show_all_btn_link = $category !== 'none' ? get_term_link( intval( $category ), 'lsvrgallerycat' ) : get_post_type_archive_link( 'lsvrgallery' ); ?>
						<p class="show-all-btn">
							<a href="<?php echo $show_all_btn_link; ?>"><?php echo _e( $show_all_btn_label, 'lsvrtoolkit' ); ?></a>
						</p>
					<?php endif; ?>

				<?php else : ?>
					<p><?php _e( 'There are no galleries at this time.', 'lsvrtoolkit' ); ?></p>
				<?php endif; ?>

            </div>
		<?php echo $after_widget; ?>

        <?php

    }

}}

?>