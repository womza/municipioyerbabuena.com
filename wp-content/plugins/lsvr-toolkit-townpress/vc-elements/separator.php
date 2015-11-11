<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Separator', 'lsvrtoolkit' ),
	'description' => __( 'Horizontal separator line', 'lsvrtoolkit' ),
    'base' => 'lsvr_separator',
	'icon' => 'lsvr-vc-ico fa fa-minus',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
        array(
			'param_name' => 'type',
            'type' => 'dropdown',
            'heading' => __( 'Type', 'lsvrtoolkit' ),
			'value' => array( __( 'Default', 'lsvrtoolkit' ) => 'default', __( 'Transparent', 'lsvrtoolkit' ) => 'transparent' ),
        ),
        array(
			'param_name' => 'margin_top',
            'type' => 'dropdown',
            'heading' => __( 'Top Margin', 'lsvrtoolkit' ),
			'value' => array( __( 'None', 'lsvrtoolkit' ) => 'none', __( 'Small', 'lsvrtoolkit' ) => 'small', __( 'Medium', 'lsvrtoolkit' ) => 'medium', __( 'Large', 'lsvrtoolkit' ) => 'large' ),
			'std' => 'medium'
        ),
		array(
			'param_name' => 'margin_bottom',
            'type' => 'dropdown',
            'heading' => __( 'Bottom Margin', 'lsvrtoolkit' ),
			'value' => array( __( 'None', 'lsvrtoolkit' ) => 'none', __( 'Small', 'lsvrtoolkit' ) => 'small', __( 'Medium', 'lsvrtoolkit' ) => 'medium', __( 'Large', 'lsvrtoolkit' ) => 'large' ),
			'std' => 'medium'
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