<?php get_header(); ?>

<?php global $wp_query;
$total_results = $wp_query->found_posts;
$search_query = get_search_query(); ?>

<!-- CORE : begin -->
<div id="core" <?php post_class(); ?>>
	<div class="c-container">

		<?php // PAGE CONTENT BEFORE
		get_template_part( 'components/page-content-before' ); ?>

		<!-- PAGE CONTENT : begin -->
		<div id="page-content">
			<div class="search-results-page">

				<div class="c-content-box m-no-padding">
					<?php get_search_form() ?>
				</div>



					<?php if ( have_posts() ) : ?>

						<h2><?php echo @sprintf( __( '%d Results for <strong>"%s"</strong>', 'lsvrtheme' ), $total_results, $search_query ); ?></h2>

						<?php while ( have_posts() ) : the_post(); ?>

							<div class="c-content-box">
								<h3 class="item-title"><?php the_title(); ?></h3>
								<p class="item-link"><a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></p>
								<div class="item-text">
									<?php echo wpautop( do_shortcode( get_the_excerpt() ) ); ?>
								</div>
							</div>

						<?php endwhile; ?>

						<?php // PAGINATION
						get_template_part( 'components/pagination' ); ?>

					<?php else : ?>

						<p class="c-alert-message m-info">
							<i class="ico fa fa-info-circle"></i>
							<?php _e( 'No results found.', 'lsvrtheme' ); ?>
						</p>

					<?php endif; ?>


			</div>
		</div>
		<!-- PAGE CONTENT : end -->

		<?php // PAGE CONTENT AFTER
		get_template_part( 'components/page-content-after' ); ?>

	</div>
</div>
<!-- CORE : end -->

<?php get_footer(); ?>


<?php /* get_header();?>

<?php global $wp_query;
$total_results = $wp_query->found_posts;
$search_query = get_search_query(); ?>

<!-- CORE : begin -->
<div id="core" <?php post_class(); ?>>

	<?php // PAGE HEADER
	get_template_part( 'components/page-header' ); ?>

	<div class="container">

		<!-- PAGE CONTENT : begin -->
		<div id="page-content">

			<!-- SEARCH RESULTS : begin -->
			<div class="search-results-page">

				<?php get_search_form() ?>

				<hr class="c-separator m-size-medium">

				<?php if ( have_posts() ) : ?>

					<h2><?php echo @sprintf( __( '%d Results for <strong>"%s"</strong>', 'lsvrtheme' ), $total_results, $search_query ); ?></h2>

					<?php $counter = 0; ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php $counter++; ?>

						<h3 class="item-title"><?php the_title(); ?></h3>
						<p class="item-link"><a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></p>
						<div class="item-text">
							<?php echo wpautop( do_shortcode( get_the_excerpt() ) ); ?>
						</div>

						<?php if ( $counter < count( $posts ) ) : ?>
							<hr class="c-separator">
						<?php endif; ?>

					<?php endwhile; ?>

					<?php // PAGINATION
					get_template_part( 'components/pagination' ); ?>

				<?php else : ?>

					<p class="c-alert-message m-info">
						<i class="ico fa fa-info-circle"></i>
						<?php _e( 'No results found.', 'lsvrtheme' ); ?>
					</p>

				<?php endif; ?>

			</div>
			<!-- SEARCH RESULTS : end -->

		</div>
		<!-- PAGE CONTENT : end -->

	</div>

</div>
<!-- CORE : end -->

<?php get_footer(); */?>