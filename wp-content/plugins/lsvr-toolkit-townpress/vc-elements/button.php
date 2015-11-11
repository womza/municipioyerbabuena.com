<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Button', 'lsvrtoolkit' ),
    'base' => 'lsvr_button',
	'icon' => 'lsvr-vc-ico fa fa-hand-o-up',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'text',
            'type' => 'textfield',
            'heading' => __( 'Text', 'lsvrtoolkit' ),
			'holder' => 'div'
        ),
        array(
			'param_name' => 'link',
            'type' => 'textfield',
            'heading' => __( 'Link', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'target',
            'type' => 'dropdown',
            'heading' => __( 'Link target', 'lsvrtoolkit' ),
			'value' => array( __( 'Default', 'lsvrtoolkit' ) => 'default', __( 'New Tab', 'lsvrtoolkit'  ) => 'blank' ),
        ),
        array(
			'param_name' => 'icon',
            'type' => 'textfield',
            'heading' => __( 'Icon', 'lsvrtoolkit' ),
			'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'style',
            'type' => 'dropdown',
            'heading' => __( 'Style', 'lsvrtoolkit' ),
			'value' => array( __( 'Solid', 'lsvrtoolkit' ) => 'default', __( 'Outline', 'lsvrtoolkit' ) => 'outline', ),
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