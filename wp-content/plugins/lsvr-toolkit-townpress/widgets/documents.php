<?php

/* -----------------------------------------------------------------------------

    DOCUMENTS WIDGET

----------------------------------------------------------------------------- */

if ( ! class_exists( 'Lsvr_Documents_Widget' ) ) {
class Lsvr_Documents_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'lsvr-documents', 'description' => __( 'List documents.', 'lsvrtoolkit' ) );
        parent::__construct( 'lsvr_documents_widget', __( 'LSVR Documents', 'lsvrtoolkit' ), $widget_ops );
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Documents', 'lsvrtoolkit' ), 'category' => 'none',
			'limit' => 5, 'show_icons' => 'on', 'show_filesize' => 'on', 'show_all_btn_label' => __( 'See All Documents', 'lsvrtoolkit' ) ) );

        $title = $instance['title'];
		$category = $instance['category'];
		$limit = $instance['limit'];
		$show_icons = $instance['show_icons'];
		$show_filesize = $instance['show_filesize'];
		$show_all_btn_label = $instance['show_all_btn_label'];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" >
        </p>

		<?php $terms_arr = get_terms( 'lsvrdocumentcat' ); ?>
		<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php echo __( 'Category:', 'lsvrtoolkit' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
			<option value="none"<?php if ( $category === 'none' ) { echo ' selected'; } ?>><?php _e( 'None (list all)', 'lsvrtoolkit' ); ?></option>
			<?php if ( is_array( $terms_arr ) ) : ?>
				<?php foreach ( $terms_arr as $term ) : ?>
					<?php if ( is_object( $term ) && property_exists( $term, 'term_id' ) && property_exists( $term, 'name' ) ) : ?>
						<option value="<?php echo $term->term_id; ?>"<?php if ( $category === $term->term_id ) { echo ' selected'; } ?>><?php echo $term->name; ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</select></p>

		<p><label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php echo __( 'Limit:', 'lsvrtoolkit' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>">
			<?php for ( $i = 1; $i <= 10; $i++ ) : ?>
				<option value="<?php echo $i; ?>"<?php if ( intval( $limit ) === intval( $i ) ) { echo ' selected'; } ?>><?php echo $i; ?></option>
			<?php endfor; ?>
		</select></p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_icons' ); ?>" name="<?php echo $this->get_field_name( 'show_icons' ); ?>" <?php if ( isset( $show_icons ) && $show_icons === 'on' ) { echo ' checked'; } ?>>
            <label for="<?php echo $this->get_field_id( 'show_icons' ); ?>"><?php echo __( 'Show File Icon', 'lsvrtoolkit' ); ?></label>
        </p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_filesize' ); ?>" name="<?php echo $this->get_field_name( 'show_filesize' ); ?>" <?php if ( isset( $show_filesize ) && $show_filesize === 'on' ) { echo ' checked'; } ?>>
            <label for="<?php echo $this->get_field_id( 'show_filesize' ); ?>"><?php echo __( 'Show File Size', 'lsvrtoolkit' ); ?></label>
        </p>

		<p>
            <label for="<?php echo $this->get_field_id( 'show_all_btn_label' ); ?>"><?php echo __( 'More Button Label:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'show_all_btn_label' ); ?>" name="<?php echo $this->get_field_name( 'show_all_btn_label' ); ?>" type="text" value="<?php echo $show_all_btn_label; ?>" >
        </p>
		<p><?php _e( 'Leave blank do disable more button.', 'lsvrtoolkit' ); ?></p>

        <?php

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
		$instance['category'] = $new_instance['category'];
		$instance['limit'] = $new_instance['limit'];
		$instance['show_icons'] = $new_instance['show_icons'];
		$instance['show_filesize'] = $new_instance['show_filesize'];
		$instance['show_all_btn_label'] = $new_instance['show_all_btn_label'];
        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
		$category = $instance['category'];
		$limit = $instance['limit'];
		$show_icons = $instance['show_icons'];
		$show_filesize = $instance['show_filesize'];
		$show_all_btn_label = $instance['show_all_btn_label'];
        if ( empty($title) ) { $title = false; }

        ?>

		<?php echo $before_widget; ?>
            <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
            <div class="widget-content">

				<?php $today = current_time( 'Y-m-d H:i' ); ?>
				<?php // QUERY
				$q_args = array(
					'posts_per_page' => $limit,
					'post_type' => 'lsvrdocument',
					'order' => 'DESC',
					'orderby' => 'post_date',
					'post_status' => array( 'publish' ),
					'suppress_filters' => false,
					'meta_query' => array(
						'relation' => 'OR',
							array( 'key' => 'meta_document_expiration_date',
								'value' => '',
								'compare' => 'NOT EXISTS',
							),
							array( 'key' => 'meta_document_expiration_date',
								'value' => $today,
								'compare' => '>=',
								'type' => 'CHAR'
							)
					)
				);
				if ( $category !== 'none' ) {
					$q_args[ 'tax_query' ] = array( array( 'taxonomy' => 'lsvrdocumentcat', 'field' => 'id', 'terms' => array( intval( $category ) ) ) );
				}
				$loop = new WP_Query( $q_args ); ?>

				<?php if ( is_singular( 'lsvrdocument' ) ) : ?>
					<?php global $wp_query; ?>
					<?php $current_id = $wp_query->queried_object; ?>
					<?php $current_id = $current_id->ID; ?>
				<?php else: ?>
					<?php $current_id = false; ?>
				<?php endif; ?>

				<?php if ( $loop->have_posts() ) : ?>

					<ul class="document-list<?php if ( $show_icons ) { echo ' m-has-icons'; } ?>">
					<?php while ( $loop->have_posts() ) : ?>

						<?php $loop->the_post(); ?>

						<?php $document_file_location = get_post_meta( get_the_id(), 'meta_document_file_location', true ) === '' ? 'local' : get_post_meta( get_the_id(), 'meta_document_file_location', true ); ?>
						<?php if ( $document_file_location === 'external' ) {
							$document_file = get_post_meta( get_the_id(), 'meta_document_external_file_url', true );
						} else {
							$document_file = get_post_meta( get_the_id(), 'meta_document_file', true );
						} ?>

						<?php if ( ( $document_file_location === 'local' && is_array( $document_file ) ) || ( $document_file !== '' ) ) : ?>
						<li <?php post_class( 'document' ); ?>>
						<div class="document-inner">

							<?php $link_target = lsvr_get_field( 'document_new_tab_enable', true, true ) ? ' target="_blank"' : ''; ?>

							<?php if ( $show_icons ) : ?>
								<?php $document_type = get_post_meta( get_the_id(), 'meta_document_type', true ); ?>
								<?php $document_type = $document_type === '' ? 'default' : $document_type; ?>
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

							<?php if ( $show_icons && $document_type_icon !== '' ) : ?>
							<div class="document-icon" title="<?php echo esc_attr( $document_type_label ); ?>"><i class="<?php echo esc_attr( $document_type_icon ); ?>"></i></div>
							<?php endif; ?>

							<h4 class="document-title">

								<?php // EXTERNAL FILE
								if ( $document_file_location === 'external' ) : ?>

									<a href="<?php echo esc_url( $document_file ); ?>"<?php echo $link_target; ?>><?php the_title(); ?></a>
									<?php if ( $show_filesize && lsvr_get_field( 'meta_document_external_file_size' ) !== '' ) : ?>
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
									<?php if ( $show_filesize ) : ?>
										<?php $document_size = (int) filesize( get_attached_file( $document_id ) ); ?>
										<?php $document_size = $document_size > 0 ? lsvr_filesize_convert( $document_size ) : false; ?>
										<span class="document-filesize">(<?php echo $document_size; ?>)</span>
									<?php endif; ?>

								<?php endif; ?>

							</h4>

						</div>
						</li>
						<?php endif; ?>

					<?php endwhile; ?>
					<?php wp_reset_query(); ?>
					</ul>

					<?php if ( $show_all_btn_label !== '' ) : ?>
						<?php $show_all_btn_link = $category !== 'none' ? get_term_link( intval( $category ), 'lsvrdocumentcat' ) : get_post_type_archive_link( 'lsvrdocument' ); ?>
						<p class="show-all-btn">
							<a href="<?php echo $show_all_btn_link; ?>"><?php echo _e( $show_all_btn_label, 'lsvrtoolkit' ); ?></a>
						</p>
					<?php endif; ?>

				<?php else : ?>
					<p><?php _e( 'There are no documents at this time.', 'lsvrtoolkit' ); ?></p>
				<?php endif; ?>

            </div>
		<?php echo $after_widget; ?>

        <?php

    }

}}

?>