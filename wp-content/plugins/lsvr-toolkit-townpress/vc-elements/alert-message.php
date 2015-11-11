<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Alert Message', 'lsvrtoolkit' ),
	'description' => __( 'Notification box', 'lsvrtoolkit' ),
    'base' => 'lsvr_alert_message',
	'icon' => 'lsvr-vc-ico fa fa-info-circle',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'type',
            'type' => 'dropdown',
            'heading' => __( 'Type', 'lsvrtoolkit' ),
			'value' => array( __( 'Warning', 'lsvrtoolkit' ) => 'warning', __( 'Success', 'lsvrtoolkit' ) => 'success', __( 'Info', 'lsvrtoolkit' ) => 'info', __( 'Notification', 'lsvrtoolkit' ) => 'notification' )
        ),
		array(
			'param_name' => 'content',
            'type' => 'textarea_html',
            'heading' => __( 'Text', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'closable',
            'type' => 'checkbox',
            'heading' => __( 'Closable', 'lsvrtoolkit' ),
			'value' => array( __( 'Yes', 'lsvrtoolkit' ) => 'yes' )
        ),
		array(
			'param_name' => 'wpautop',
            'type' => 'checkbox',
            'heading' => __( 'Automatically add paragraphs', 'lsvrtoolkit' ),
			'value' => array( __( 'Yes', 'lsvrtoolkit' ) => 'yes' ),
			'std' => 'yes'
        ),
        array(
			'param_name' => 'custom_class',
            'type' => 'textfield',
            'heading' => __( 'Extra class name', 'lsvrtoolkit' ),
			'description' => __( 'It can be used for applying custom CSS.', 'lsvrtoolkit' ),
        ),
    ),
));

?>