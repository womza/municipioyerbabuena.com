<?php $page_id = lsvr_get_current_page_id(); ?>

<?php if ( $page_id ) : ?>
	<?php $sidebar_id = get_post_meta( $page_id, 'meta_sidebar_primary', true ); ?>
	<?php $sidebar_id = $sidebar_id === '' ? 'primary-sidebar' : $sidebar_id; ?>
<?php else : ?>
	<?php $sidebar_id = 'primary-sidebar'; ?>
<?php endif; ?>

<?php if ( is_active_sidebar( $sidebar_id ) ) : ?>

	<!-- PRIMARY SIDEBAR : begin -->
	<aside id="primary-sidebar" class="sidebar">
		<div class="widget-list">

			<?php dynamic_sidebar( $sidebar_id ); ?>

		</div>
	</aside>
	<!-- PRIMARY SIDEBAR : end -->

<?php endif; ?>
