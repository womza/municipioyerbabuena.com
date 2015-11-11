<?php get_header(); ?>

<?php $page_id = lsvr_get_current_page_id(); ?>

<!-- CORE : begin -->
<div id="core" <?php post_class(); ?>>
	<div class="c-container">

		<?php // PAGE CONTENT BEFORE
		get_template_part( 'components/page-content-before' ); ?>

		<!-- PAGE CONTENT : begin -->
		<div id="page-content">

			<!-- EVENT LIST : begin -->
			<div class="cpt-archive-page event-archive-page event-page">

				<?php if ( is_tax( 'lsvreventcat' ) && term_description( get_queried_object()->term_id, 'lsvreventcat' ) !== '' ) : ?>
				<!-- ARCHIVE DESCRIPTION : begin -->
				<div class="archive-description">
					<div class="c-content-box">
						<?php echo wpautop( term_description( get_queried_object()->term_id, 'lsvreventcat' ) ); ?>
					</div>
				</div>
				<!-- ARCHIVE DESCRIPTION : end -->
				<?php endif; ?>

				<?php $event_date_string = ''; ?>
				<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php $event_date = lsvr_parse_datetime_field( lsvr_get_field( 'meta_event_date', ''  ) ); ?>

					<?php // GROUP BY MONTH
					if ( $event_date && lsvr_get_field( 'event_list_group_by_month', true, true )
						&& date_i18n( 'F Y', $event_date->getTimestamp() ) !== $event_date_string ) : ?>
						<?php $event_date_string = date_i18n( 'F Y', $event_date->getTimestamp() ); ?>
						<h2 class="group-title"><?php echo $event_date_string; ?></h2>
					<?php endif; ?>

					<!-- EVENT : begin -->
					<article <?php post_class( 'event' ); ?>>
						<div class="event-inner c-content-box m-no-padding">

							<?php if ( has_post_thumbnail() && lsvr_get_field( 'event_list_thumb', 'full' ) !== 'disable' ) : ?>
							<!-- EVENT IMAGE : begin -->
							<div class="event-image">
								<a href="<?php the_permalink(); ?>">
								<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id() ); ?>
								<?php if ( lsvr_get_field( 'event_list_thumb', 'full' ) === 'cropped' ) : ?>
									<span class="event-image-inner" style="background-image: url('<?php echo esc_url( $thumb_data['large'] ); ?>');"></span>
								<?php else: ?>
									<img src="<?php echo esc_url( $thumb_data['large'] ); ?>" alt="<?php echo esc_attr( $thumb_data['alt'] ); ?>">
								<?php endif; ?>
								</a>
							</div>
							<!-- EVENT IMAGE : end -->
							<?php endif; ?>

							<!-- EVENT CORE : begin -->
							<div class="event-core">

								<!-- EVENT TITLE : begin -->
								<h2 class="event-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<!-- EVENT TITLE : end -->

								<?php if ( $event_date ) : ?>
								<!-- EVENT INFO : begin -->
								<ul class="event-info">
									<li class="event-date">
										<i class="ico tp tp-calendar-full"></i>
										<?php echo date_i18n( get_option( 'date_format' ), $event_date->getTimestamp() ); ?>
									</li>
									<?php if ( lsvr_get_field( 'event_list_time_enable', true, true ) ) : ?>
									<li class="event-time">
										<i class="ico tp tp-clock2"></i>
										<?php echo date_i18n( get_option( 'time_format' ), $event_date->getTimestamp() ); ?>
									</li>
									<?php endif; ?>
									<?php if ( lsvr_get_field( 'meta_event_location' ) !== '' && lsvr_get_field( 'event_list_location_enable', true, true ) ) : ?>
									<li class="event-location">
										<i class="ico tp tp-map-marker"></i>
										<?php echo lsvr_get_field( 'meta_event_location' ); ?>
									</li>
									<?php endif; ?>
								</ul>
								<!-- EVENT INFO : end -->
								<?php endif; ?>

								<?php if ( lsvr_get_field( 'event_list_excerpt_enable', 'excerpt' ) === 'excerpt' ) : ?>
								<!-- EVENT CONTENT : begin -->
								<div class="event-content"><?php the_excerpt(); ?></div>
								<!-- EVENT CONTENT : end -->
								<?php elseif ( lsvr_get_field( 'event_list_excerpt_enable', 'excerpt' ) === 'content' ) : ?>
								<!-- EVENT CONTENT : begin -->
								<div class="event-content"><?php the_content(); ?></div>
								<!-- EVENT CONTENT : end -->
								<?php endif; ?>

							</div>
							<!-- EVENT CORE : end -->

						</div>
					</article>
					<!-- EVENT : end -->

				<?php endwhile; ?>
				<?php endif; ?>

				<?php if ( lsvr_get_field( 'event_list_archive_link_enable', false, true ) ) : ?>
				<!-- BOTTOM TOOLS : begin -->
				<div class="bottom-tools">
					<ul>
						<?php $is_archive = isset( $_GET[ 'archive' ] ) && preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET[ 'archive' ] ) === 'true' ? true : false; ?>
						<?php if ( $is_archive ) : ?>
							<li><a href="<?php echo get_post_type_archive_link( 'lsvrevent' ); ?>"><?php _e( 'Show Upcoming Events', 'lsvrtheme' ); ?></a></li>
						<?php else : ?>
							<li><a href="<?php echo esc_url( add_query_arg( array( 'archive' => 'true' ), get_post_type_archive_link( 'lsvrevent' ) ) ); ?>"><?php _e( 'Show Past Events', 'lsvrtheme' ); ?></a></li>
						<?php endif; ?>
					</ul>
				</div>
				<!-- BOTTOM TOOLS : end -->
				<?php endif; ?>

			</div>
			<!-- EVENT LIST : end -->

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