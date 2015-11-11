<?php
/* -----------------------------------------------------------------------------

    DEFINITION LIST WIDGET

----------------------------------------------------------------------------- */

if ( ! class_exists( 'Lsvr_Definition_List_Widget' ) ) {
class Lsvr_Definition_List_Widget extends WP_Widget {

    public function __construct() {
    	$widget_ops = array( 'classname' => 'lsvr-definition-list', 'description' => __( 'Can be used for phone numbers', 'lsvrtoolkit' ) );
        parent::__construct( 'lsvr_definition_list_widget', __( 'LSVR Definition List', 'lsvrtoolkit' ), $widget_ops );
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'label1' => '', 'value1' => '', 'valuelink1' => '',
			'label2' => '', 'value2' => '', 'valuelink2' => '', 'label3' => '', 'value3' => '', 'valuelink3' => '', 'label4' => '', 'value4' => '', 'valuelink4' => '',
			'label5' => '', 'value5' => '', 'valuelink5' => '',
			'show_more_btn_label' => '', 'show_more_btn_link' => '' ) );

        $title = $instance['title'];
		$label1 = $instance['label1'];
		$value1 = $instance['value1'];
		$valuelink1 = $instance['valuelink1'];
		$label2 = $instance['label2'];
		$value2 = $instance['value2'];
		$valuelink2 = $instance['valuelink2'];
		$label3 = $instance['label3'];
		$value3 = $instance['value3'];
		$valuelink3 = $instance['valuelink3'];
		$label4 = $instance['label4'];
		$value4 = $instance['value4'];
		$valuelink4 = $instance['valuelink4'];
		$label5 = $instance['label5'];
		$value5 = $instance['value5'];
		$valuelink5 = $instance['valuelink5'];
		$show_more_btn_label = $instance['show_more_btn_label'];
		$show_more_btn_link = $instance['show_more_btn_link'];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

		<?php for ( $i = 1; $i <= 5; $i ++ ) : ?>
		<p>
            <label for="<?php echo $this->get_field_id( 'label' . $i ); ?>"><?php echo __( 'Row ' . $i . ' Label:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'label' . $i ); ?>" name="<?php echo $this->get_field_name( 'label' . $i ); ?>" type="text" value="<?php echo ${ 'label' . $i }; ?>" >
        </p>
		<p>
            <label for="<?php echo $this->get_field_id( 'value' . $i ); ?>"><?php echo __( 'Row ' . $i . ' Value:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'value' . $i ); ?>" name="<?php echo $this->get_field_name( 'value' . $i ); ?>" type="text" value="<?php echo ${ 'value' . $i }; ?>" >
        </p>
		<p>
            <label for="<?php echo $this->get_field_id( 'valuelink' . $i ); ?>"><?php echo __( 'Row ' . $i . ' Value Link:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'valuelink' . $i ); ?>" name="<?php echo $this->get_field_name( 'valuelink' . $i ); ?>" type="text" value="<?php echo ${ 'valuelink' . $i }; ?>" >
        </p>
		<?php endfor; ?>

		<p>
            <label for="<?php echo $this->get_field_id( 'show_more_btn_label' ); ?>"><?php echo __( 'More Button Label:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'show_more_btn_label' ); ?>" name="<?php echo $this->get_field_name( 'show_more_btn_label' ); ?>" type="text" value="<?php echo $show_more_btn_label; ?>" >
        </p>
		<p>
            <label for="<?php echo $this->get_field_id( 'show_more_btn_link' ); ?>"><?php echo __( 'More Button Link:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'show_more_btn_link' ); ?>" name="<?php echo $this->get_field_name( 'show_more_btn_link' ); ?>" type="text" value="<?php echo $show_more_btn_link; ?>" >
        </p>

        <?php

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
		$instance['label1'] = $new_instance['label1'];
		$instance['value1'] = $new_instance['value1'];
		$instance['valuelink1'] = $new_instance['valuelink1'];
		$instance['label2'] = $new_instance['label2'];
		$instance['value2'] = $new_instance['value2'];
		$instance['valuelink2'] = $new_instance['valuelink2'];
		$instance['label3'] = $new_instance['label3'];
		$instance['value3'] = $new_instance['value3'];
		$instance['valuelink3'] = $new_instance['valuelink3'];
		$instance['label4'] = $new_instance['label4'];
		$instance['value4'] = $new_instance['value4'];
		$instance['valuelink4'] = $new_instance['valuelink4'];
		$instance['label5'] = $new_instance['label5'];
		$instance['value5'] = $new_instance['value5'];
		$instance['valuelink5'] = $new_instance['valuelink5'];
		$instance['show_more_btn_label'] = $new_instance['show_more_btn_label'];
		$instance['show_more_btn_link'] = $new_instance['show_more_btn_link'];

        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
        if ( empty( $title ) ) { $title = false; }
		$label1 = $instance['label1'];
		$value1 = $instance['value1'];
		$valuelink1 = array_key_exists( 'valuelink1',  $instance ) ? $instance['valuelink1'] : '';
		$label2 = $instance['label2'];
		$value2 = $instance['value2'];
		$valuelink2 = array_key_exists( 'valuelink2',  $instance ) ? $instance['valuelink2'] : '';
		$label3 = $instance['label3'];
		$value3 = $instance['value3'];
		$valuelink3 = array_key_exists( 'valuelink3',  $instance ) ? $instance['valuelink3'] : '';
		$label4 = $instance['label4'];
		$value4 = $instance['value4'];
		$valuelink4 = array_key_exists( 'valuelink4',  $instance ) ? $instance['valuelink4'] : '';
		$label5 = $instance['label5'];
		$value5 = $instance['value5'];
		$valuelink5 = array_key_exists( 'valuelink5',  $instance ) ? $instance['valuelink5'] : '';
		$show_more_btn_label = $instance['show_more_btn_label'];
		$show_more_btn_link = $instance['show_more_btn_link'];

        ?>

		<?php echo $before_widget; ?>
            <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
            <div class="widget-content">

				<dl>
					<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
						<?php if ( ${ 'label' . $i } !== '' ) : ?>
							<dt><?php echo ${ 'label' . $i }; ?></dt>
						<?php endif; ?>
						<?php if ( ${ 'value' . $i } !== '' ) : ?>
							<?php if ( ${ 'valuelink' . $i } !== '' ) : ?>
								<dd><a href="<?php echo esc_url( ${ 'valuelink' . $i } ); ?>"><?php echo ${ 'value' . $i }; ?></a></dd>
							<?php else : ?>
								<dd><?php echo ${ 'value' . $i }; ?></dd>
							<?php endif; ?>
						<?php endif; ?>
					<?php endfor; ?>
				</dl>

				<?php if ( $show_more_btn_label !== '' && $show_more_btn_link !== '' ) : ?>
					<p class="show-all-btn">
						<a href="<?php echo $show_more_btn_link; ?>"><?php echo $show_more_btn_label; ?></a>
					</p>
				<?php endif; ?>

            </div>
		<?php echo $after_widget; ?>

        <?php

    }

}}

?>