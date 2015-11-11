<?php $page_id = lsvr_get_current_page_id(); ?>

<?php if ( $page_id ) : ?>
	<?php $enable_title = get_post_meta( $page_id, 'meta_content_title_enable', true ) !== '0' ? true : false; ?>
	<?php $enable_breadcrumbs = get_post_meta( $page_id, 'meta_content_breadcrumbs_enable', true ) !== '0' ? true : false; ?>
<?php elseif ( is_404() || is_search() ) : ?>
	<?php $enable_title = true; ?>
	<?php $enable_breadcrumbs = true; ?>
<?php endif; ?>

<?php if ( is_404() || is_search() || ( $page_id && ( $enable_title || $enable_breadcrumbs ) ) ) : ?>

	<?php $page_header_class = $enable_title ? ' m-has-title' : ''; ?>
	<?php $page_header_class .= $enable_breadcrumbs ? ' m-has-breadcrumbs' : ''; ?>
	<?php $page_header_class = trim( $page_header_class ); ?>

	<!-- PAGE HEADER : begin -->
	<div id="page-header"<?php if ( $page_header_class !== '' ) { echo ' class="' . $page_header_class . '"'; } ?>>

		<?php if ( $enable_title ) : ?>
		<!-- PAGE TITLE : begin -->
		<div class="page-title"><h1>
			<?php if ( is_singular( 'post' ) || is_singular( 'lsvrnotice' ) || is_singular( 'lsvrdocument' ) || is_singular( 'lsvrevent' ) || is_singular( 'lsvrgallery' ) ) : ?>
				<?php the_title(); ?>
			<?php elseif ( is_tag() || is_category() || is_tax( 'lsvrnoticecat' ) || is_tax( 'lsvrdocumentcat' ) || is_tax( 'lsvreventcat' ) || is_tax( 'lsvrgallerycat' ) ) : ?>
				<?php global $wp_query; ?>
				<?php $current_term = $wp_query->queried_object; ?>
				<?php echo $current_term->name; ?>
			<?php elseif ( is_404() ) : ?>
				<?php _e( 'Page Not Found', 'lsvrtheme' ); ?>
			<?php elseif ( is_search() ) : ?>
				<?php _e( 'Search Results', 'lsvrtheme' ); ?>
			<?php elseif ( $page_id && get_post_meta( $page_id, 'meta_content_title', true ) !== '' ) : ?>
				<?php echo get_post_meta( $page_id, 'meta_content_title', true ); ?>
			<?php elseif ( ( function_exists( 'is_bbpress' ) && is_bbpress() ) ) : ?>
				<?php the_title(); ?>
			<?php elseif ( $page_id ) : ?>
				<?php echo get_the_title( $page_id ); ?>
			<?php endif; ?>
			</h1>
		</div>
		<!-- PAGE TITLE : end -->
		<?php endif; ?>

		<?php if ( $enable_breadcrumbs ) : ?>
		<?php // BREADCRUMBS
		get_template_part( 'components/breadcrumbs' ); ?>
		<?php endif; ?>

	</div>
	<!-- PAGE HEADER : end -->

<?php endif; ?>