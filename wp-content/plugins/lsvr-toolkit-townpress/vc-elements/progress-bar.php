<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Progress Bar', 'lsvrtoolkit' ),
	'description' => __( 'Animated progress bar', 'lsvrtoolkit' ),
    'base' => 'lsvr_progressbar',
	'icon' => 'lsvr-vc-ico fa fa-bar-chart',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'title',
            'type' => 'textfield',
            'heading' => __( 'Title', 'lsvrtoolkit' ),
			'holder' => 'div'
        ),
        array(
			'param_name' => 'percentage',
            'type' => 'dropdown',
            'heading' => __( 'Percentage', 'lsvrtoolkit' ),
			'value' => array( '0' => 0, '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40, '45' => 45, '50' => 50, '55' => 55, '60' => 60, '65' => 65, '70' => 70, '75' => 75, '80' => 80, '85' => 85, '90' => 90, '95' => 95, '100' => 100 ),
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