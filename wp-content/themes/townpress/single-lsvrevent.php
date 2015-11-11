<?php get_header(); ?>

<?php $page_id = lsvr_get_current_page_id(); ?>

<!-- CORE : begin -->
<div id="core" <?php post_class(); ?>>
	<div class="c-container">

		<?php // PAGE CONTENT BEFORE
		get_template_part( 'components/page-content-before' ); ?>

		<!-- PAGE CONTENT : begin -->
		<div id="page-content">

			<!-- EVENT DETAIL : begin -->
			<div class="event-single-page event-page">

				<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php $event_date = lsvr_parse_datetime_field( lsvr_get_field( 'meta_event_date', ''  ) ); ?>

					<!-- EVENT : begin -->
					<article <?php post_class( 'event' ); ?> itemscope itemtype="http://schema.org/Event">
						<div class="event-inner c-content-box m-no-padding">

							<meta itemprop="name" content="<?php the_title(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id() ); ?>
								<meta itemprop="image" content="<?php echo esc_url( $thumb_data['medium'] ); ?>">
							<?php endif; ?>
							<meta itemprop="startDate" content="<?php echo date( 'c', $event_date->getTimestamp() ); ?>">
							<span class="meta-event-location" itemprop="location" itemscope itemtype="http://schema.org/Place">
    							<meta itemprop="name" content="<?php echo lsvr_get_field( 'meta_event_location' ); ?>">
    							<?php if ( lsvr_get_field( 'meta_event_gmap_address' ) !== '' ) : ?>
    							<meta itemprop="address" content="<?php echo esc_attr( lsvr_get_field( 'meta_event_gmap_address' ) ); ?>">
    							<?php endif; ?>
  							</span>

							<?php if ( has_post_thumbnail() && lsvr_get_field( 'event_detail_thumb', 'header' ) === 'top' ) : ?>
							<!-- EVENT IMAGE : begin -->
							<div class="event-image">
								<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id() ); ?>
								<?php if ( lsvr_get_field( 'event_detail_thumb_crop', true, true ) ) : ?>
									<span class="event-image-inner" style="background-image: url('<?php echo esc_url( $thumb_data['large'] ); ?>');"></span>
								<?php else: ?>
									<img src="<?php echo esc_url( $thumb_data['large'] ); ?>" alt="<?php echo esc_attr( $thumb_data['alt'] ); ?>">
								<?php endif; ?>
							</div>
							<!-- EVENT IMAGE : end -->
							<?php endif; ?>

							<!-- EVENT CORE : begin -->
							<div class="event-core">

								<?php if ( $event_date ) : ?>
								<!-- EVENT INFO : begin -->
								<ul class="event-info">
									<li class="event-date">
										<i class="ico tp tp-calendar-full"></i>
										<span><?php echo date_i18n( get_option( 'date_format' ), $event_date->getTimestamp() ); ?></span>
									</li>
									<?php if ( lsvr_get_field( 'document_list_time_enable', true, true ) ) : ?>
									<li class="event-time">
										<i class="ico tp tp-clock2"></i>
										<?php echo date_i18n( get_option( 'time_format' ), $event_date->getTimestamp() ); ?>
									</li>
									<?php endif; ?>
									<?php if ( lsvr_get_field( 'meta_event_location' ) !== '' && lsvr_get_field( 'document_list_location_enable', true, true ) ) : ?>
									<li class="event-location">
										<i class="ico tp tp-map-marker"></i>
										<span><?php echo lsvr_get_field( 'meta_event_location' ); ?></span>
									</li>
									<?php endif; ?>
								</ul>
								<!-- EVENT INFO : end -->
								<?php endif; ?>

								<!-- EVENT CONTENT : begin -->
								<div class="event-content"><?php the_content(); ?></div>
								<!-- EVENT CONTENT : end -->

							</div>
							<!-- EVENT CORE : end -->

							<?php if ( lsvr_get_field( 'meta_event_gmap_enable', false, true )
								&& ( lsvr_get_field( 'meta_event_gmap_address' ) !== ''
									|| ( lsvr_get_field( 'meta_event_gmap_latitude' ) !== '' && lsvr_get_field( 'meta_event_gmap_longitude' ) !== '' ) ) ) : ?>
							<!-- EVENT LOCATION : begin -->
							<div class="event-location">

								<div class="gmap-canvas" data-address="<?php echo esc_attr( lsvr_get_field( 'meta_event_gmap_address' ) ); ?>"
									data-latitude="<?php echo esc_attr( lsvr_get_field( 'meta_event_gmap_latitude' ) ); ?>"
									data-longitude="<?php echo esc_attr( lsvr_get_field( 'meta_event_gmap_longitude' ) ); ?>"
									data-zoom="<?php echo (int) esc_attr( lsvr_get_field( 'meta_event_gmap_zoom' ) ); ?>"
									data-maptype="<?php echo esc_attr( lsvr_get_field( 'meta_event_gmap_type' ) ); ?>"
									data-enable-mousewheel="<?php if ( lsvr_get_field( 'meta_event_gmap_mouse_scroll_enable', true, true ) ) { echo 'true'; } else { echo 'false'; } ?>"></div>

							</div>
							<!-- EVENT LOCATION : end -->
							<?php endif; ?>

						</div>
					</article>
					<!-- EVENT : end -->

				<?php endwhile; ?>
				<?php endif; ?>

			</div>
			<!-- EVENT DETAIL : end -->

			<?php // PAGINATION
			get_template_part( 'components/pagination' ); ?>

		</div>
		<!-- PAGE CONTENT : end -->

		<?php // PAGE CONTENT AFTER
		get_template_part( 'components/page-content-after' ); ?>

	</div>
</div>
<!-- CORE : end -->

<?php get_footer(); ?>