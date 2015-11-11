<?php if ( is_active_sidebar( 'bottom-sidebar' ) ) : ?>
<!-- BOTTOM PANEL : begin -->
<div id="bottom-panel" class="m-<?php echo lsvr_get_field( 'bottom_panel_columns', 4 ); ?>-columns">
	<div class="bottom-panel-inner">
		<div class="row">

			<?php dynamic_sidebar( 'bottom-sidebar' ); ?>

		</div>
	</div>
</div>
<!-- BOTTOM PANEL : end -->
<?php endif; ?>