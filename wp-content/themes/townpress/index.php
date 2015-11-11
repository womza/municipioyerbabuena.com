<?php get_header(); ?>

<?php $page_id = lsvr_get_current_page_id(); ?>

<!-- CORE : begin -->
<div id="core" <?php post_class(); ?>>
	<div class="c-container">

		<?php // PAGE CONTENT BEFORE
		get_template_part( 'components/page-content-before' ); ?>

		<!-- PAGE CONTENT : begin -->
		<div id="page-content">
			<?php if ( have_posts() ) : ?>

				<?php if ( is_single() ) : ?>

					<!-- ARTICLE DETAIL : begin -->
					<div class="article-single-page article-page">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'article' ); ?>
					<?php endwhile; ?>
					</div>
					<!-- ARTICLE DETAIL : end -->

				<?php else : ?>

					<!-- ARTICLE LIST : begin -->
					<div class="article-archive-page article-page">

						<?php if ( is_category() && category_description( get_queried_object()->term_id ) !== '' ) : ?>
						<!-- ARCHIVE DESCRIPTION : begin -->
						<div class="archive-description">
							<div class="c-content-box">
								<?php echo wpautop( category_description( get_queried_object()->term_id ) ); ?>
							</div>
						</div>
						<!-- ARCHIVE DESCRIPTION : end -->
						<?php endif; ?>

						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'article' ); ?>
						<?php endwhile; ?>

					</div>
					<!-- ARTICLE LIST : end -->

					<?php // PAGINATION
					get_template_part( 'components/pagination' ); ?>

				<?php endif; ?>

			<?php else : ?>
				<p><?php _e( 'There are currently no posts', 'lsvrtheme' ); ?></p>
			<?php endif; ?>
		</div>
		<!-- PAGE CONTENT : end -->

		<?php // PAGE CONTENT AFTER
		get_template_part( 'components/page-content-after' ); ?>

	</div>
</div>
<!-- CORE : end -->

<?php get_footer(); ?>