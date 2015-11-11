<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Gallery', 'lsvrtoolkit' ),
	'description' => __( 'Simple image gallery', 'lsvrtoolkit' ),
    'base' => 'lsvr_gallery',
	'icon' => 'lsvr-vc-ico fa fa-th',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
        array(
			'param_name' => 'images',
            'type' => 'attach_images',
            'heading' => __( 'Images', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'items_per_row',
            'type' => 'dropdown',
			'heading' => __( 'Images per row', 'lsvrtoolkit' ),
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4 ),
        ),
		array(
			'param_name' => 'size',
            'type' => 'textfield',
            'heading' => __( 'Size of images', 'lsvrtoolkit' ),
			'description' => __( 'You can specify an image size which will be used, e.g. "large" or "full". Sizes can be defined under <strong>Settings / Media</strong>. Leave blank to use a "medium" size.', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'masonry',
            'type' => 'checkbox',
			'heading' => __( 'Masonry Layout', 'lsvrtoolkit' ),
			'value' => array( __( 'Enable', 'lsvrtoolkit' ) => 'yes' ),
			'std' => 'yes'
        ),
		array(
			'param_name' => 'click_action',
            'type' => 'dropdown',
			'heading' => __( 'Click action', 'lsvrtoolkit' ),
			'value' => array( __( 'Open in Lightbox', 'lsvrtoolkit' ) => 'lightbox', __( 'Open in new tab', 'lsvrtoolkit' ) => 'tab', __( 'No click action', 'lsvrtoolkit' ) => 'disable' ),
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