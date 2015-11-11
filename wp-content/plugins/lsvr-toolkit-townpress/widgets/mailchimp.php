<?php
/* -----------------------------------------------------------------------------

    MAILCHIMP SUBSCRIBE WIDGET

----------------------------------------------------------------------------- */

if ( ! class_exists( 'Lsvr_Mailchimp_Subscribe_Widget' ) ) {
class Lsvr_Mailchimp_Subscribe_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'lsvr-mailchimp-subscribe', 'description' => __( 'Basic Mailchimp subscribe form', 'lsvrtoolkit' ) );
        parent::__construct( 'lsvr_mailchimp_subscribe_widget', __( 'LSVR Mailchimp Subscribe', 'lsvrtoolkit' ), $widget_ops );
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Join Our Newsletter', 'lsvrtoolkit' ), 'description' => '', 'mailchimp_link' => '' ) );

        $title = $instance['title'];
        $description = $instance['description'];
        $mailchimp_link = esc_url( $instance['mailchimp_link'] );

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php echo __( 'Description:', 'lsvrtoolkit' ); ?></label>
            <textarea rows="6" class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo $description; ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'mailchimp_link' ); ?>"><?php echo __( 'Mailchimp Link:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'mailchimp_link' ); ?>" name="<?php echo $this->get_field_name( 'mailchimp_link' ); ?>" type="text" value="<?php echo $mailchimp_link; ?>" />
        </p>
        <p class="description"><?php _e( 'Please refer to the documentation on how to obtain a correct link.', 'lsvrtoolkit' ); ?></p>
        <?php

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['description'] = $new_instance['description'];
        $instance['mailchimp_link'] = esc_url( $new_instance['mailchimp_link'] );
        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
        if ( empty($title) ) { $title = false; }
        $description = array_key_exists( 'description', $instance ) ? $instance['description'] : '';
        $mailchimp_link = esc_url( $instance['mailchimp_link'] );

        ?>

		<?php echo $before_widget; ?>
            <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
            <div class="widget-content">
                <form action="<?php echo esc_url( $mailchimp_link ); ?>" method="get" class="mailchimp-subscribe-form">
                    <div class="subscribe-inner">

                        <?php if ( $description !== '' ) : ?>
                        <div class="description"><?php echo wpautop( $description ); ?></div>
                        <?php endif; ?>

						<!-- VALIDATION ERROR MESSAGE : begin -->
						<p style="display: none;" class="c-alert-message m-warning m-validation-error"><i class="ico fa fa-exclamation-circle"></i>
						<span><?php _e( 'Your email address is required.', 'lsvrtoolkit' ); ?></span></p>
						<!-- VALIDATION ERROR MESSAGE : end -->

						<!-- SENDING REQUEST ERROR MESSAGE : begin -->
						<p style="display: none;" class="c-alert-message m-warning m-request-error"><i class="ico fa fa-exclamation-circle"></i>
						<span><?php _e( 'There was a connection problem. Try again later.', 'lsvrtoolkit' ); ?></span></p>
						<!-- SENDING REQUEST ERROR MESSAGE : end -->

						<!-- SUCCESS MESSAGE : begin -->
						<p style="display: none;" class="c-alert-message m-success"><i class="ico fa fa-check-circle"></i>
						<span><?php _e( '<strong>Form sent successfully!</strong>', 'lsvrtoolkit' ); ?></span></p>
						<!-- SUCCESS MESSAGE : end -->

                        <div class="form-fields">
                            <input class="m-required m-email" type="text" name="EMAIL" placeholder="<?php _e( 'Your Email Address', 'lsvrtoolkit' ); ?>">
                            <button class="submit-btn" type="submit" title="<?php _e( 'Subscribe', 'lsvrtoolkit' ); ?>">
								<i class="fa fa-chevron-right"></i>
								<i class="fa fa-spinner fa-spin"></i>
							</button>
                        </div>

                    </div>
                </form>
            </div>
		<?php echo $after_widget; ?>

        <?php

    }

}}

?>