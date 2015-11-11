<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Accordion', 'lsvrtoolkit' ),
    'base' => 'lsvr_accordion',
	'icon' => 'lsvr-vc-ico fa fa-bars',
    'as_parent' => array( 'only' => 'lsvr_accordion_item' ),
    'content_element' => true,
    'show_settings_on_create' => true,
	'js_view' => 'VcColumnView',
    'params' => array(
        array(
			'param_name' => 'toggle',
            'type' => 'checkbox',
            'heading' => __( 'Toggle', 'lsvrtoolkit' ),
			'description' => __( 'This accordion will behave as a toggle if enabled.', 'lsvrtoolkit' ),
			'value' => array( __( 'Enable', 'lsvrtoolkit' ) => 'yes' ),
        ),
        array(
			'param_name' => 'custom_class',
            'type' => 'textfield',
            'heading' => __( 'Extra class name', 'lsvrtoolkit' ),
			'description' => __( 'It can be used for applying custom CSS.', 'lsvrtoolkit' ),
        ),
    ),
));
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Lsvr_Accordion extends WPBakeryShortCodesContainer {}
}

// ACCORDION ITEM
vc_map( array(
    'name' => __( 'Accordion Item', 'lsvrtoolkit' ),
    'base' => 'lsvr_accordion_item',
	'icon' => 'lsvr-vc-ico fa fa-angle-right',
    'content_element' => true,
	'as_child' => array( 'only' => 'lsvr_accordion' ),
    'show_settings_on_create' => true,
    'params' => array(
        array(
			'param_name' => 'title',
            'type' => 'textfield',
            'heading' => __( 'Title', 'lsvrtoolkit' ),
			'holder' => 'div'
        ),
        array(
			'param_name' => 'icon',
            'type' => 'textfield',
            'heading' => __( 'Icon', 'lsvrtoolkit' ),
			'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'content',
            'type' => 'textarea_html',
            'heading' => __( 'Text', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'state',
            'type' => 'checkbox',
            'heading' => __( 'Open by default', 'lsvrtoolkit' ),
			'value' => array( __( 'Enable', 'lsvrtoolkit' ) => 'open' ),
        ),
		array(
			'param_name' => 'wpautop',
            'type' => 'checkbox',
            'heading' => __( 'Automatically add paragraphs', 'lsvrtoolkit' ),
			'value' => array( __( 'Yes', 'lsvrtoolkit' ) => 'yes' ),
			'std' => 'yes'
        ),
    ),
));
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Lsvr_Accordion_Item extends WPBakeryShortCode {}
}

?>