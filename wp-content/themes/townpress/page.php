<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<!-- CORE : begin -->
	<div id="core" <?php post_class(); ?>>
		<div class="c-container">

			<?php // PAGE CONTENT BEFORE
			get_template_part( 'components/page-content-before' ); ?>

			<!-- PAGE CONTENT : begin -->
			<div id="page-content"<?php if ( lsvr_get_field( 'meta_content_boxed', 'single' ) === 'disable' ) { echo ' class="m-no-boxes"'; } ?>>

				<?php if ( lsvr_get_field( 'meta_content_boxed', 'single' ) === 'single' ) : ?>

					<div class="c-content-box">
						<div class="page-content-inner">
							<?php the_content(); ?>
						</div>
					</div>

				<?php else: ?>

					<div class="page-content-inner">
						<?php the_content(); ?>
					</div>

				<?php endif; ?>

			</div>
			<!-- PAGE CONTENT : end -->

			<?php // PAGE CONTENT AFTER
			get_template_part( 'components/page-content-after' ); ?>

		</div>
	</div>
	<!-- CORE : end -->

<?php endwhile; ?>

<?php get_footer(); ?>