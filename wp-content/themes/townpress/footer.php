	<!-- FOOTER : begin -->
	<footer id="footer"<?php if ( lsvr_get_image_field( 'footer_bg_image' ) ) { echo ' class="m-has-bg"'; } ?>>
		<div class="footer-bg"<?php if ( lsvr_get_image_field( 'footer_bg_image' ) ) : ?> style="background-image: url( '<?php echo esc_url( lsvr_get_image_field( 'footer_bg_image' ) ); ?>' );"<?php endif; ?>>
			<div class="footer-inner">

				<!-- FOOTER TOP : begin -->
				<div class="footer-top">
					<div class="c-container">

						<?php // BOTTOM PANEL
						get_template_part( 'components/sidebar-bottom' ); ?>

					</div>
				</div>
				<!-- FOOTER TOP : end -->

				<!-- FOOTER BOTTOM : begin -->
				<div class="footer-bottom">
					<div class="footer-bottom-inner">
						<div class="c-container">

							<?php if ( lsvr_get_field( 'footer_social_enable', false, true ) ) : ?>

								<?php $social_links = lsvr_get_social_links(); ?>
								<?php if ( $social_links ) : ?>
								<!-- FOOTER SOCIAL : begin -->
								<div class="footer-social">
									<ul class="c-social-icons">
										<?php echo $social_links; ?>
									</ul>
								</div>
								<!-- FOOTER SOCIAL : end -->
								<?php endif; ?>

							<?php endif; ?>

							<?php // FOOTER MENU
							get_template_part( 'components/menu-footer' ); ?>

							<?php if ( lsvr_get_field( 'footer_text', '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' )  ) !== '' ) : ?>
							<!-- FOOTER TEXT : begin -->
							<div class="footer-text">
								<?php echo wpautop( do_shortcode( lsvr_get_field( 'footer_text', '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) ) ) ); ?>
							</div>
							<!-- FOOTER TEXT : end -->
							<?php endif; ?>

						</div>
					</div>
				</div>
				<!-- FOOTER BOTTOM : end -->

			</div>
		</div>
	</footer>
	<!-- FOOTER : end -->

	<var class="js-labels"
		data-mp-tClose="<?php _e( 'Close (Esc)', 'lsvrtheme' )?>"
		data-mp-tLoading="<?php _e( 'Loading...', 'lsvrtheme' )?>"
		data-mp-tPrev="<?php _e( 'Previous (Left arrow key)', 'lsvrtheme' )?>"
		data-mp-tNext="<?php _e( 'Next (Right arrow key)', 'lsvrtheme' )?>"
		data-mp-image-tError="<?php _e( 'The image could not be loaded.', 'lsvrtheme' )?>"
		data-mp-ajax-tError="<?php _e( 'The content could not be loaded.', 'lsvrtheme' )?>"
		data-bbp-forum="<?php _e( 'Forum', 'lsvrtheme' )?>"
		data-bbp-topic="<?php _e( 'Topic', 'lsvrtheme' )?>"
		data-bbp-topics="<?php _e( 'Topics', 'lsvrtheme' )?>"
		data-bbp-posts="<?php _e( 'Posts', 'lsvrtheme' )?>"
		data-bbp-freshness="<?php _e( 'Freshness', 'lsvrtheme' )?>"
		data-bbp-voices="<?php _e( 'Voices', 'lsvrtheme' )?>"
		data-bbp-author="<?php _e( 'Author', 'lsvrtheme' )?>"></var>

	<?php wp_footer(); ?>

</body>
</html>