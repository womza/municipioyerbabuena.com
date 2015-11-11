<?php

/* -----------------------------------------------------------------------------

    EVENTS WIDGET

----------------------------------------------------------------------------- */

if ( ! class_exists( 'Lsvr_Events_Widget' ) ) {
class Lsvr_Events_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'lsvr-events', 'description' => __( 'List events.', 'lsvrtoolkit' ) );
        parent::__construct( 'lsvr_events_widget', __( 'LSVR Events', 'lsvrtoolkit' ), $widget_ops );
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Events', 'lsvrtoolkit' ),
			'limit' => 5, 'show_date' => 'on', 'show_excerpt' => 'on', 'show_all_btn_label' => __( 'See All Events', 'lsvrtoolkit' ) ) );

        $title = $instance['title'];
		$limit = $instance['limit'];
		$show_date = $instance['show_date'];
		$show_excerpt = $instance['show_excerpt'];
		$show_all_btn_label = $instance['show_all_btn_label'];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" >
        </p>

		<p><label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php echo __( 'Limit:', 'lsvrtoolkit' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>">
			<?php for ( $i = 1; $i <= 10; $i++ ) : ?>
				<option value="<?php echo $i; ?>"<?php if ( intval( $limit ) === intval( $i ) ) { echo ' selected'; } ?>><?php echo $i; ?></option>
			<?php endfor; ?>
		</select></p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" <?php if ( isset( $show_date ) && $show_date === 'on' ) { echo ' checked'; } ?>>
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php echo __( 'Show Date', 'lsvrtoolkit' ); ?></label>
        </p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" <?php if ( isset( $show_excerpt ) && $show_excerpt === 'on' ) { echo ' checked'; } ?>>
            <label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php echo __( 'Show Excerpt', 'lsvrtoolkit' ); ?></label>
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
		$instance['limit'] = $new_instance['limit'];
		$instance['show_date'] = $new_instance['show_date'];
		$instance['show_excerpt'] = $new_instance['show_excerpt'];
		$instance['show_all_btn_label'] = $new_instance['show_all_btn_label'];

        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
		$limit = $instance['limit'];
		$show_date = $instance['show_date'];
		$show_excerpt = $instance['show_excerpt'];
		$show_all_btn_label = $instance['show_all_btn_label'];
        if ( empty($title) ) { $title = false; }

        ?>

		<?php echo $before_widget; ?>
            <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
            <div class="widget-content">

				<?php $today = current_time( 'Y-m-d H:i' ); ?>
				<?php // QUERY
				$q_args = array(
					'posts_per_page' => $limit,
					'post_type' => 'lsvrevent',
					'post_status' => array( 'publish' ),
					'suppress_filters' => false,
					'meta_key' => 'meta_event_date',
					'orderby' => 'meta_value meta_value_num',
					'order' => 'ASC',
					'meta_query' => array(
						array(
							'key' => 'meta_event_date',
							'value' => $today,
							'compare' => '>=',
							'type' => 'CHAR'
						)
					)
				);
				$loop = new WP_Query( $q_args ); ?>

				<?php if ( is_singular( 'lsvrevent' ) ) : ?>
					<?php global $wp_query; ?>
					<?php $current_id = $wp_query->queried_object; ?>
					<?php $current_id = $current_id->ID; ?>
				<?php else: ?>
					<?php $current_id = false; ?>
				<?php endif; ?>

				<?php if ( $loop->have_posts() ) : ?>

					<ul class="event-list">
					<?php while ( $loop->have_posts() ) : ?>

						<?php $loop->the_post(); ?>

						<?php $event_date = lsvr_parse_datetime_field( lsvr_get_field( 'meta_event_date', ''  ) ); ?>
						<?php $post_class = 'event'; ?>
						<?php $post_class .= $current_id === get_the_id() ? ' m-active' : ''; ?>
						<?php $post_class .= $show_date && $event_date ? ' m-has-date' : ''; ?>
						<li <?php post_class( $post_class ); ?> data-event-date="<?php echo lsvr_get_field( 'meta_event_date' ); ?>">
							<div class="event-inner">

								<?php if ( $show_date && $event_date ) : ?>
								<div class="event-date" title="<?php echo date( get_option( 'date_format' ), $event_date->getTimestamp() ); ?>">
									<span class="event-month"><?php echo date_i18n( 'M', $event_date->getTimestamp() ); ?></span>
									<span class="event-day"><?php echo date_i18n( 'j', $event_date->getTimestamp() ); ?></span>
								</div>
								<?php endif; ?>

								<h4 class="event-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

								<?php if ( isset( $show_excerpt ) && $show_excerpt === 'on' ) : ?>
									<div class="event-excerpt">
										<?php the_excerpt(); ?>
									</div>
								<?php endif; ?>

							</div>
						</li>

					<?php endwhile; ?>
					<?php wp_reset_query(); ?>
					</ul>

					<?php if ( $show_all_btn_label !== '' ) : ?>
						<?php $show_all_btn_link = get_post_type_archive_link( 'lsvrevent' ); ?>
						<p class="show-all-btn">
							<a href="<?php echo $show_all_btn_link; ?>"><?php echo _e( $show_all_btn_label, 'lsvrtoolkit' ); ?></a>
						</p>
					<?php endif; ?>

				<?php else : ?>
					<p><?php _e( 'There are no events at this time.', 'lsvrtoolkit' ); ?></p>
				<?php endif; ?>

            </div>
		<?php echo $after_widget; ?>

        <?php

    }

}}

?>