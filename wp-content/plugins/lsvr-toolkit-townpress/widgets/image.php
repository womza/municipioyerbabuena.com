<?php
/* -----------------------------------------------------------------------------

    IMAGE WIDGET

----------------------------------------------------------------------------- */

if ( ! class_exists( 'Lsvr_Image_Widget' ) ) {
class Lsvr_Image_Widget extends WP_Widget {

    public function __construct() {
		$widget_ops = array( 'classname' => 'lsvr-image', 'description' => __( 'Simple image', 'lsvrtoolkit' ) );
        parent::__construct( 'lsvr_image_widget', __( 'LSVR Image', 'lsvrtoolkit' ), $widget_ops );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

    }
	function enqueue_scripts() {
		wp_enqueue_media();
	}

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'image_id' => '', 'image_size' => '', 'image_link' => '' ) );

        $title = $instance['title'];
        $image_id = $instance['image_id'];
		$image_size = $instance['image_size'];
		$image_link = $instance['image_link'];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'image_id' ); ?>"><?php _e( 'Image:' ); ?></label><br>
			<?php if ( $image_id && $image_id !== '' ) : ?>
			<span class="lsvr-widget-image-holder" style="display: block;">
				<?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
			</span>
			<?php else: ?>
			<span class="lsvr-widget-image-holder" style="display: none;"></span>
			<?php endif; ?>
            <input name="<?php echo $this->get_field_name( 'image_id' ); ?>" id="<?php echo $this->get_field_id( 'image_id' ); ?>" class="lsvr-widget-image-id" type="hidden" value="<?php echo esc_attr( $image_id ); ?>" />
            <input class="lsvr-widget-image-upload-btn button button-primary" type="button" value="<?php _e( 'Upload Image', 'lsvrtoolkit' ); ?>" />
        </p>

		<p><label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php echo __( 'Image Size:', 'lsvrtoolkit' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'image_size' ); ?>" name="<?php echo $this->get_field_name( 'image_size' ); ?>">
			<option value="thumbnail"<?php if ( $image_size === 'thumbnail' ) { echo ' selected'; } ?>><?php _e( 'Thumbnail', 'lsvrtoolkit' ); ?></option>
			<option value="medium"<?php if ( $image_size === 'medium' ) { echo ' selected'; } ?>><?php _e( 'Medium', 'lsvrtoolkit' ); ?></option>
			<option value="large"<?php if ( $image_size === 'large' ) { echo ' selected'; } ?>><?php _e( 'Large', 'lsvrtoolkit' ); ?></option>
			<option value="full"<?php if ( $image_size === 'full' ) { echo ' selected'; } ?>><?php _e( 'Full Size', 'lsvrtoolkit' ); ?></option>
		</select></p>
        <p>
            <label for="<?php echo $this->get_field_id( 'image_link' ); ?>"><?php echo __( 'Link:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'image_link' ); ?>" name="<?php echo $this->get_field_name( 'image_link' ); ?>" type="text" value="<?php echo $image_link; ?>" />
        </p>
		<script type="text/javascript">
		// INIT UPLOAD BUTTON
		(function($){
			$(document).ready(function() {

				if ( $.fn.lsvrImageWidget ) {
					$( '.lsvr-widget-image-upload-btn' ).each(function(){
						$(this).lsvrImageWidget();
					});
				}
			});
		})(jQuery);
		</script>
        <?php

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['image_id'] = $new_instance['image_id'];
		$instance['image_size'] = $new_instance['image_size'];
		$instance['image_link'] = $new_instance['image_link'];
        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
        if ( empty( $title ) ) { $title = false; }
        $image_id = array_key_exists( 'image_id', $instance ) ? $instance['image_id'] : '';
		$image_size = array_key_exists( 'image_size', $instance ) ? $instance['image_size'] : '';
		$image_link = array_key_exists( 'image_link', $instance ) ? $instance['image_link'] : '';

        ?>

		<?php echo $before_widget; ?>
            <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
            <div class="widget-content">

				<?php $image_data = lsvr_get_image_data( $image_id ); ?>
				<?php if ( $image_data ) : ?>

					<?php if ( $image_size == '' ) { $image_size = 'medium'; } ?>

					<?php if ( $image_link !== '' ) : ?>
						<a href="<?php echo esc_url( $image_link ); ?>">
					<?php endif; ?>
					<img src="<?php echo esc_url( $image_data[ $image_size ] ); ?>" alt="<?php echo esc_attr( $image_data[ 'alt' ] ); ?>">
					<?php if ( $image_link !== '' ) : ?>
						</a>
					<?php endif; ?>

				<?php endif; ?>

            </div>
		<?php echo $after_widget; ?>

        <?php

    }

}}

?>