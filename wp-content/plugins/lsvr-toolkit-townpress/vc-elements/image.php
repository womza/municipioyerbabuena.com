<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Image', 'lsvrtoolkit' ),
	'description' => __( 'Single image', 'lsvrtoolkit' ),
    'base' => 'lsvr_image',
	'icon' => 'lsvr-vc-ico fa fa-file-image-o',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'image',
            'type' => 'attach_image',
            'heading' => __( 'Image', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'size',
            'type' => 'textfield',
            'heading' => __( 'Size of image', 'lsvrtoolkit' ),
			'description' => __( 'You can specify an image size which will be used, e.g. "large" or "full". Sizes can be defined under <strong>Settings / Media</strong>. Leave blank to use a "medium" size.', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'max_width',
            'type' => 'textfield',
            'heading' => __( 'Max width', 'lsvrtoolkit' ),
			'description' => __( 'You can define maximum width (in pixels, e.g. "100") to restrict image dimensions.', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'link',
            'type' => 'textfield',
            'heading' => __( 'Link', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'lightbox',
            'type' => 'checkbox',
			'heading' => __( 'Open in lightbox', 'lsvrtoolkit' ),
			'description' => __( 'Open the full size of the image in lightbox.', 'lsvrtoolkit' ),
			'value' => array( __( 'Open', 'lsvrtoolkit' ) => 'yes' ),
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