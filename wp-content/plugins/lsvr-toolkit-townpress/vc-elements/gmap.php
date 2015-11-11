<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Google Map', 'lsvrtoolkit' ),
    'base' => 'lsvr_gmap',
	'icon' => 'lsvr-vc-ico fa fa-map-marker',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'address',
            'type' => 'textfield',
            'heading' => __( 'Address', 'lsvrtoolkit' ),
			'description' => __( 'For example: <em>8833 Sunset Blvd, West Hollywood, CA 90069, USA</em>.', 'lsvrtoolkit' ),
			'holder' => 'div'
        ),
        array(
			'param_name' => 'latitude',
            'type' => 'textfield',
            'heading' => __( 'Latitude', 'lsvrtoolkit' ),
			'description' => __( 'Optional, it can be more precise than using just the address. For example: <em>48.634340</em>.', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'longitude',
            'type' => 'textfield',
            'heading' => __( 'Longitude', 'lsvrtoolkit' ),
			'description' => __( 'Optional, it can be more precise than using just the address. For example: <em>21.929627</em>.', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'type',
            'type' => 'dropdown',
            'heading' => __( 'Map Type', 'lsvrtoolkit' ),
			'value' => array( __( 'Roadmap', 'lsvrtoolkit' ) => 'roadmap', __( 'Satellite', 'lsvrtoolkit' ) => 'satellite' , __( 'Terrain', 'lsvrtoolkit' ) => 'terrain', __( 'Hybrid', 'lsvrtoolkit' ) => 'hybrid' ),
        ),
        array(
			'param_name' => 'zoom',
            'type' => 'dropdown',
            'heading' => __( 'Zoom Level', 'lsvrtoolkit' ),
			'value' => array( __( 'Far', 'lsvrtoolkit' ) => '16', __( 'Medium', 'lsvrtoolkit' ) => '17' , __( 'Close', 'lsvrtoolkit' ) => '18', __( 'Very Close', 'lsvrtoolkit' ) => '19' ),
			'std' => '17'
        ),
        array(
			'param_name' => 'height',
            'type' => 'textfield',
            'heading' => __( 'Height', 'lsvrtoolkit' ),
			'description' => __( 'In pixels.', 'lsvrtoolkit' ),
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