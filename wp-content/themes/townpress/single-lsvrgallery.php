<?php get_header(); ?>

<?php $page_id = lsvr_get_current_page_id(); ?>

<!-- CORE : begin -->
<div id="core" <?php post_class(); ?>>
	<div class="c-container">

		<?php // PAGE CONTENT BEFORE
		get_template_part( 'components/page-content-before' ); ?>

		<!-- PAGE CONTENT : begin -->
		<div id="page-content">

			<!-- GALLERY DETAIL : begin -->
			<div class="gallery-single-page gallery-page">

				<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>


					<!-- GALLERY : begin -->
					<article <?php post_class( 'gallery' ); ?>>
						<div class="gallery-inner">

							<?php $gallery_arr = lsvr_get_field( 'meta_gallery_images' ); ?>
							<?php if ( $gallery_arr !== '' ) : ?>
								<?php $gallery_arr = explode( ',', $gallery_arr ); ?>
								<!-- GALLERY : begin -->
								<div class="c-gallery">
									<ul class="gallery-images<?php if ( lsvr_get_field( 'gallery_detail_layout', 'masonry' ) === 'masonry' ) { echo ' m-layout-masonry m-loading'; } ?> m-<?php echo esc_attr( lsvr_get_field( 'gallery_detail_images_columns', 4 ) ); ?>-columns">
									<?php foreach ( $gallery_arr as $gallery_id ) : ?>

										<?php $thumb_data = lsvr_get_image_data( $gallery_id ); ?>
										<li><a href="<?php echo esc_url( $thumb_data[ 'full' ] ); ?>" class="lightbox" title="<?php echo esc_attr( $thumb_data[ 'caption' ] ); ?>">
											<?php if ( lsvr_get_field( 'gallery_detail_images_columns', 4 ) > 2 ) : ?>
											<img src="<?php echo esc_url( $thumb_data[ 'medium' ] ); ?>" alt="<?php echo esc_attr( $thumb_data[ 'alt' ] ); ?>">
											<?php else: ?>
											<img src="<?php echo esc_url( $thumb_data[ 'large' ] ); ?>" alt="<?php echo esc_attr( $thumb_data[ 'alt' ] ); ?>">
											<?php endif; ?>
										</a></li>

									<?php endforeach; ?>
									</ul>
								</div>
							<!-- GALLERY : end -->
							<?php endif; ?>

							<div class="c-content-box m-no-padding">

								<?php if ( get_the_content() !== '' ) : ?>
								<!-- GALLERY CORE : begin -->
								<div class="gallery-core">

									<!-- GALLERY CONTENT : begin -->
									<div class="gallery-content"><?php the_content(); ?></div>
									<!-- GALLERY CONTENT : end -->

								</div>
								<!-- GALLERY CORE : end -->
								<?php endif; ?>

								<!-- GALLERY FOOTER : begin -->
								<div class="gallery-footer">
									<div class="gallery-footer-inner">

										<!-- GALLERY DATE : begin -->
										<div class="gallery-date">
											<i class="ico tp tp-clock2"></i>
											<?php if ( lsvr_get_field( 'gallery_detail_categories_enable', true, true ) ) : ?>
												<?php $categories_html = ''; ?>
												<?php $terms = wp_get_post_terms( get_the_id(), 'lsvrgallerycat' ); ?>
												<?php foreach ( $terms as $term ) : ?>
													<?php $categories_html .= '<a href="' . get_term_link( $term ) . '">' . $term->name . '</a>, '; ?>
												<?php endforeach; ?>
												<?php if ( $categories_html !== '' ) : ?>
													<?php $categories_html = rtrim( $categories_html, ', ' ); ?>
													<?php echo sprintf( '%s en %s', get_the_date(), $categories_html ); ?>
												<?php else: ?>
													<?php echo get_the_date(); ?>
												<?php endif; ?>
											<?php else: ?>
												<?php echo get_the_date(); ?>
											<?php endif; ?>
										</div>
										<!-- GALLERY DATE : end -->

									</div>
								</div>
								<!-- GALLERY FOOTER : end -->

							</div>

						</div>
					</article>
					<!-- GALLERY : end -->

					<?php $post_count = wp_count_posts( 'lsvrgallery' ); ?>
					<?php $post_count = (int) $post_count->publish; ?>
					<?php if ( lsvr_get_field( 'gallery_detail_navigation_enable', true, true ) && $post_count > 1 ) : ?>
					<!-- ARTICLE NAVIGATION : begin -->
					<div class="c-content-box">
						<ul class="article-navigation">

							<?php $prev_post = get_adjacent_post( false, '', false ); ?>
							<?php if ( ! empty( $prev_post ) ): ?>
								<!-- PREV ARTICLE : begin -->
								<li class="prev<?php if ( has_post_thumbnail( $prev_post->ID ) ) { echo ' m-has-thumb'; } ?>">
									<div class="prev-inner">
										<?php if ( has_post_thumbnail( $prev_post->ID ) ) : ?>
											<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id( $prev_post->ID ) ); ?>
											<div class="nav-thumb"><a href="<?php echo get_permalink( $prev_post->ID ); ?>"><img src="<?php echo $thumb_data['thumbnail']; ?>" alt=""></a></div>
										<?php endif; ?>
										<h5><?php _e( 'Nueva Gallery', 'lsvrtheme' ); ?></h5>
										<a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo $prev_post->post_title; ?></a>
									</div>
								</li>
								<!-- PREV ARTICLE : end -->
							<?php endif; ?>

							<?php $next_post = get_adjacent_post( false, '', true ); ?>
							<?php if ( ! empty( $next_post ) ): ?>
								<!-- NEXT ARTICLE : begin -->
								<li class="next<?php if ( has_post_thumbnail( $next_post->ID ) ) { echo ' m-has-thumb'; } ?>">
									<div class="next-inner">
										<?php if ( has_post_thumbnail( $next_post->ID ) ) : ?>
											<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id( $next_post->ID ) ); ?>
											<div class="nav-thumb"><a href="<?php echo get_permalink( $next_post->ID ); ?>"><img src="<?php echo $thumb_data['thumbnail']; ?>" alt=""></a></div>
										<?php endif; ?>
										<h5><?php _e( 'Antigua Gallery', 'lsvrtheme' ); ?></h5>
										<a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo $next_post->post_title; ?></a>
									</div>
								</li>
								<!-- NEXT ARTICLE : end -->
							<?php endif; ?>

						</ul>
					</div>
					<!-- ARTICLE NAVIGATION : end -->
					<?php endif; ?>

				<?php endwhile; ?>
				<?php endif; ?>

			</div>
			<!-- GALLERY DETAIL : end -->

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