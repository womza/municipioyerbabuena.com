<?php if ( class_exists( 'bbPress' ) && function_exists( 'is_bbpress' ) && is_bbpress() && bbp_allow_search() ) : ?>

	<!-- bbPRESS SEARCH FORM : begin -->
	<form class="c-search-form" action="<?php bbp_search_url(); ?>" method="get">
		<div class="form-fields">
			<input type="text" name="bbp_search" placeholder="<?php _e( 'Search forums...', 'lsvrtheme' ); ?>">
			<button class="submit-btn" type="submit"><i class="tp tp-magnifier"></i></button>
		</div>
	</form>
	<!-- bbPRESS SEARCH FORM : end -->

<?php else: ?>

	<!-- STANDARD SEARCH FORM : begin -->
	<form class="c-search-form" action="<?php echo home_url( '/' ) ?>" method="get">
		<div class="form-fields">
			<input type="text" name="s" placeholder="<?php _e( 'Search this site...', 'lsvrtheme' ); ?>" value="<?php echo get_search_query(); ?>">
			<button class="submit-btn" type="submit"><i class="tp tp-magnifier"></i></button>
		</div>
	</form>
	<!-- STANDARD SEARCH FORM : end -->

<?php endif; ?>




