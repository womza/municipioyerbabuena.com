<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Tabs', 'lsvrtoolkit' ),
	'description' => __( 'Tabbed content', 'lsvrtoolkit' ),
    'base' => 'lsvr_tabs',
	'icon' => 'lsvr-vc-ico fa fa-folder-o',
    'as_parent' => array( 'only' => 'lsvr_tab_item' ),
    'content_element' => true,
    'show_settings_on_create' => false,
	'js_view' => 'VcColumnView',
    'params' => array(
        array(
			'param_name' => 'custom_class',
            'type' => 'textfield',
            'heading' => __( 'Extra class name', 'lsvrtoolkit' ),
			'description' => __( 'It can be used for applying custom CSS.', 'lsvrtoolkit' ),
        ),
    ),
));
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Lsvr_Tabs extends WPBakeryShortCodesContainer {}
}

// TAB ITEM
vc_map( array(
    'name' => __( 'Tab Item', 'lsvrtoolkit' ),
    'base' => 'lsvr_tab_item',
	'icon' => 'lsvr-vc-ico fa fa-angle-right',
    'content_element' => true,
	'as_child' => array( 'only' => 'lsvr_tabs' ),
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
			'param_name' => 'wpautop',
            'type' => 'checkbox',
            'heading' => __( 'Automatically add paragraphs', 'lsvrtoolkit' ),
			'value' => array( __( 'Yes', 'lsvrtoolkit' ) => 'yes' ),
			'std' => 'yes'
        ),
    ),
));
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Lsvr_Tab_Item extends WPBakeryShortCode {}
}

?>