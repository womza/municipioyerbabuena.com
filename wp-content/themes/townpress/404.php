<?php get_header(); ?>

<!-- CORE : begin -->
<div id="core" <?php post_class(); ?>>
	<div class="c-container">

		<?php // PAGE CONTENT BEFORE
		get_template_part( 'components/page-content-before' ); ?>

		<!-- PAGE CONTENT : begin -->
		<div id="page-content">
			<div class="error-404-page">
				<?php echo wpautop( do_shortcode( lsvr_get_field( 'page404_content', __( 'La p&aacute;gina que est&aacute;s buscando ya no está disponible o se ha movido', 'lsvrtheme' ) ) ) ); ?>
			</div>
		</div>
		<!-- PAGE CONTENT : end -->

		<?php // PAGE CONTENT AFTER
		get_template_part( 'components/page-content-after' ); ?>

	</div>
</div>
<!-- CORE : end -->

<?php get_footer(); ?>