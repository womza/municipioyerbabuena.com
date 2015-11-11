<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Slider', 'lsvrtoolkit' ),
    'base' => 'lsvr_slider',
	'icon' => 'lsvr-vc-ico fa fa-list-alt',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
        array(
			'param_name' => 'slider',
            'type' => 'textfield',
            'heading' => __( 'Slider', 'lsvrtoolkit' ),
			'description' => __( 'Add a slider slug to load projects from. Sliders can be managed under <strong>Slides / Sliders</strong>. Leave blank to load slides regardless of category.', 'lsvrtoolkit' ),
			'holder' => 'div',
        ),
        array(
			'param_name' => 'bg_image',
            'type' => 'attach_image',
			'heading' => __( 'Background image', 'lsvrtoolkit' ),
			'description' => __( 'If you want to have a separate background image for each slide, leave this blank and set a Featured Image for each Slide post instead.', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'height',
            'type' => 'textfield',
			'heading' => __( 'Height', 'lsvrtoolkit' ),
			'value' => '400',
        ),
		array(
			'param_name' => 'interval',
            'type' => 'textfield',
			'heading' => __( 'Autoplay Speed', 'lsvrtoolkit' ),
			'description' => __( 'Duration between transitions in seconds. Leave blank to disable automatic slideshow.', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'wpautop',
            'type' => 'checkbox',
            'heading' => __( 'Automatically create paragraphs in slides', 'lsvrtoolkit' ),
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