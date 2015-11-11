<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'CTA', 'lsvrtoolkit' ),
	'description' => __( 'Message with call to action button', 'lsvrtoolkit' ),
    'base' => 'lsvr_cta_message',
	'icon' => 'lsvr-vc-ico fa fa-arrow-circle-right',
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
			'param_name' => 'content',
            'type' => 'textarea_html',
            'heading' => __( 'Text', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'button_label',
            'type' => 'textfield',
            'heading' => __( 'Button Label', 'lsvrtoolkit' ),
			'description' => __( 'Leave blank to hide.', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'link',
            'type' => 'textfield',
            'heading' => __( 'Button Link', 'lsvrtoolkit' ),
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