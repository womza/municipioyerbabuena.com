<?php get_header(); ?>

<?php $page_id = lsvr_get_current_page_id(); ?>

<!-- CORE : begin -->
<div id="core" <?php post_class(); ?>>
	<div class="c-container">

		<?php // PAGE CONTENT BEFORE
		get_template_part( 'components/page-content-before' ); ?>

		<!-- PAGE CONTENT : begin -->
		<div id="page-content">

			<!-- DOCUMENT LIST : begin -->
			<div class="cpt-archive-page document-archive-page document-page">

				<?php if ( is_tax( 'lsvrdocumentcat' ) && term_description( get_queried_object()->term_id, 'lsvrdocumentcat' ) !== '' ) : ?>
				<!-- ARCHIVE DESCRIPTION : begin -->
				<div class="archive-description">
					<div class="c-content-box">
						<?php echo wpautop( term_description( get_queried_object()->term_id, 'lsvrdocumentcat' ) ); ?>
					</div>
				</div>
				<!-- ARCHIVE DESCRIPTION : end -->
				<?php endif; ?>

				<div class="c-content-box">

					<ul class="document-list<?php if ( lsvr_get_field( 'document_list_icon_enable', true, true ) ) { echo ' m-has-icons'; } ?>">

						<?php if ( have_posts() ) : ?>
							<?php while ( have_posts() ) : the_post(); ?>
							<!-- DOCUMENT : begin -->
							<li <?php post_class( 'document' ); ?>>
								<div class="document-inner">

									<?php $document_file_location = get_post_meta( get_the_id(), 'meta_document_file_location', true ) === '' ? 'local' : get_post_meta( get_the_id(), 'meta_document_file_location', true ); ?>
									<?php if ( $document_file_location === 'external' ) {
										$document_file = get_post_meta( get_the_id(), 'meta_document_external_file_url', true );
									} else {
										$document_file = get_post_meta( get_the_id(), 'meta_document_file', true );
									} ?>

									<?php if ( ( $document_file_location === 'local' && is_array( $document_file ) ) || ( $document_file !== '' ) ) : ?>

										<?php $link_target = lsvr_get_field( 'document_new_tab_enable', true, true ) ? ' target="_blank"' : ''; ?>

										<?php if ( lsvr_get_field( 'document_list_icon_enable', true, true ) ) : ?>
											<?php $document_type = lsvr_get_field( 'meta_document_type', 'default' ); ?>
											<?php $document_type_icon = ''; ?>
											<?php $document_type_label = ''; ?>
											<?php if ( $document_type === 'custom' ) : ?>
												<?php $document_type_icon = lsvr_get_field( 'meta_document_custom_icon' ); ?>
												<?php $document_type_label = lsvr_get_field( 'meta_document_custom_label' ); ?>
											<?php else: ?>
												<?php $document_type = lsvr_get_document_type( $document_type ); ?>
												<?php if ( is_array( $document_type ) ) : ?>
													<?php $document_type_icon = $document_type['class']; ?>
													<?php $document_type_label = $document_type['label']; ?>
												<?php endif; ?>
											<?php endif; ?>
										<?php endif; ?>

										<!-- DOCUMENT TITLE : begin -->
										<h4 class="document-title<?php if ( lsvr_get_field( 'document_list_icon_enable', true, true ) && $document_type_icon !== '' ) { echo ' m-has-icon'; } ?>">
											<?php if ( lsvr_get_field( 'document_list_icon_enable', true, true ) && $document_type_icon !== '' ) : ?>
												<span class="document-icon" title="<?php echo esc_attr( $document_type_label ); ?>"><i class="<?php echo esc_attr( $document_type_icon ); ?>"></i></span>
											<?php endif; ?>

											<?php // EXTERNAL FILE
											if ( $document_file_location === 'external' ) : ?>

												<a href="<?php echo esc_url( $document_file ); ?>"<?php echo $link_target; ?>><?php the_title(); ?></a>
												<?php if ( lsvr_get_field( 'document_list_filesize_enable', true, true ) && lsvr_get_field( 'meta_document_external_file_size' ) !== '' ) : ?>
													<span class="document-filesize">(<?php echo lsvr_get_field( 'meta_document_external_file_size' ); ?>)</span>
												<?php endif; ?>

											<?php // LOCAL FILE
											else : ?>

												<?php if ( $document_file_location === 'local' ) {
													reset( $document_file );
													$document_id = key( $document_file );
													$document_link = reset( $document_file );
												} ?>

												<a href="<?php echo esc_url( $document_link ); ?>"<?php echo $link_target; ?>><?php the_title(); ?></a>
												<?php if ( lsvr_get_field( 'document_list_filesize_enable', true, true ) ) : ?>
													<?php $document_size = (int) filesize( get_attached_file( $document_id ) ); ?>
													<?php $document_size = $document_size > 0 ? lsvr_filesize_convert( $document_size ) : false; ?>
													<span class="document-filesize">(<?php echo $document_size; ?>)</span>
												<?php endif; ?>

											<?php endif; ?>

										</h4>
										<!-- DOCUMENT TITLE : end -->

										<?php if ( lsvr_get_field( 'document_list_uploader_enable', false, true )
											|| lsvr_get_field( 'document_list_upload_date_enable', false, true )
											|| ( lsvr_get_field( 'document_list_expiration_date_enable', false, true ) && lsvr_get_field( 'meta_document_expiration_date' ) ) ) : ?>
										<!-- DOCUMENT INFO : begin -->
										<div class="document-info">
											<ul>
												<?php if ( lsvr_get_field( 'document_list_uploader_enable', false, true ) ) : ?>
												<li class="document-uploader"><?php _e( 'Uploaded by:', 'lsvrtheme' ); ?> <span><?php the_author(); ?></span></li>
												<?php endif; ?>
												<?php if ( lsvr_get_field( 'document_list_upload_date_enable', false, true ) ) : ?>
												<li class="document-date"><?php _e( 'Upload date:', 'lsvrtheme' ); ?> <span><?php echo get_the_date(); ?></span></li>
												<?php endif; ?>
												<?php if ( lsvr_get_field( 'document_list_expiration_date_enable', false, true ) && lsvr_get_field( 'meta_document_expiration_date' ) ) : ?>
													<?php $expiration_date = lsvr_parse_datetime_field( lsvr_get_field( 'meta_document_expiration_date', ''  ) ); ?>
													<li class="document-expiration-date"><?php _e( 'Expiration date:', 'lsvrtheme' ); ?> <span><?php echo date_i18n( get_option( 'date_format' ), $expiration_date->getTimestamp() ); ?></span></li>
												<?php endif; ?>

											</ul>
										</div>
										<!-- DOCUMENT INFO : end -->
										<?php endif; ?>

									<?php endif; ?>

								</div>
							</li>
							<!-- DOCUMENT : end -->
							<?php endwhile; ?>
						<?php else: ?>
							<p><?php _e( 'There are currently no documents', 'lsvrtheme' ); ?></p>
						<?php endif; ?>

					</ul>

					<?php if ( lsvr_get_field( 'document_list_expired_link_enable', false, true ) ) : ?>
					<!-- BOTTOM TOOLS : begin -->
					<div class="bottom-tools">
						<ul>
							<?php $is_archive = isset( $_GET[ 'archive' ] ) && preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET[ 'archive' ] ) === 'true' ? true : false; ?>
							<?php if ( $is_archive ) : ?>
								<li><a href="<?php echo get_post_type_archive_link( 'lsvrdocument' ); ?>"><?php _e( 'Show Non-Archived Documents', 'lsvrtheme' ); ?></a></li>
							<?php else : ?>
								<li><a href="<?php echo esc_url( add_query_arg( array( 'archive' => 'true' ), get_post_type_archive_link( 'lsvrdocument' ) ) ); ?>"><?php _e( 'Show Archived Documents', 'lsvrtheme' ); ?></a></li>
							<?php endif; ?>
						</ul>
					</div>
					<!-- BOTTOM TOOLS : end -->
					<?php endif; ?>

				</div>

			</div>
			<!-- DOCUMENT LIST : end -->

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