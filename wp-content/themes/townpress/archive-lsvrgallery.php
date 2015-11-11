<?php get_header(); ?>

<?php $page_id = lsvr_get_current_page_id(); ?>

<!-- CORE : begin -->
<div id="core" <?php post_class(); ?>>
	<div class="c-container">

		<?php // PAGE CONTENT BEFORE
		get_template_part( 'components/page-content-before' ); ?>

		<!-- PAGE CONTENT : begin -->
		<div id="page-content">

			<!-- GALLERY LIST : begin -->
			<div class="cpt-archive-page gallery-archive-page gallery-page">

				<?php if ( is_tax( 'lsvrgallerycat' ) && term_description( get_queried_object()->term_id, 'lsvrgallerycat' ) !== '' ) : ?>
				<!-- ARCHIVE DESCRIPTION : begin -->
				<div class="archive-description">
					<div class="c-content-box">
						<?php echo wpautop( term_description( get_queried_object()->term_id, 'lsvrgallerycat' ) ); ?>
					</div>
				</div>
				<!-- ARCHIVE DESCRIPTION : end -->
				<?php endif; ?>

				<?php if ( have_posts() ) : ?>
				<div class="c-gallery">
					<ul class="gallery-images m-layout-masonry m-loading m-<?php echo esc_attr( lsvr_get_field( 'gallery_list_images_columns', 4 ) ); ?>-columns">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php $thumb_data = false; ?>
						<?php $gallery_arr = lsvr_get_field( 'meta_gallery_images' ); ?>
						<?php if ( has_post_thumbnail() ) : ?>
							<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id() ); ?>
						<?php elseif ( $gallery_arr !== '' ) : ?>
							<?php $gallery_arr = explode( ',', $gallery_arr ); ?>
							<?php $thumb_data = lsvr_get_image_data( $gallery_arr[0] ); ?>
						<?php endif; ?>

						<li>
							<article>
								<?php if ( $thumb_data ) : ?>
									<?php if ( lsvr_get_field( 'gallery_list_images_columns', 4 ) > 2 ) : ?>
									<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $thumb_data['medium'] ); ?>" alt="<?php echo esc_attr( $thumb_data['alt'] ); ?>"></a>
									<?php else: ?>
									<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $thumb_data['large'] ); ?>" alt="<?php echo esc_attr( $thumb_data['alt'] ); ?>"></a>
									<?php endif; ?>
								<?php endif; ?>
								<?php if ( lsvr_get_field( 'gallery_list_title_enable', true, true ) ) : ?>
								<h2 class="gallery-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<?php endif; ?>
							</article>
						</li>

					<?php endwhile; ?>
					</ul>
				</div>
				<?php else: ?>
					<p><?php _e( 'There are currently no galleries', 'lsvrtheme' ); ?></p>
				<?php endif; ?>

			</div>
			<!-- GALLERY LIST : end -->

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