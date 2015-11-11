<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Counter', 'lsvrtoolkit' ),
	'description' => __( 'Number with label', 'lsvrtoolkit' ),
    'base' => 'lsvr_counter',
	'icon' => 'lsvr-vc-ico fa fa-tachometer',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'counter_number',
            'type' => 'textfield',
            'heading' => __( 'Counter Value', 'lsvrtoolkit' ),
			'description' => __( 'Numeric value of counter.', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'number_char',
            'type' => 'textfield',
            'heading' => __( 'Symbol After', 'lsvrtoolkit' ),
			'description' => __( 'Symbol which will be displayed after numeric value. For example "+".', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'title',
            'type' => 'textfield',
            'heading' => __( 'Title', 'lsvrtoolkit' ),
			'description' => __( 'This text will be displayed under Counter Value.', 'lsvrtoolkit' ),
			'holder' => 'div'
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