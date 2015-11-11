<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Definition List', 'lsvrtoolkit' ),
	'description' => __( 'List of titles and values', 'lsvrtoolkit' ),
    'base' => 'lsvr_definition_list',
	'icon' => 'lsvr-vc-ico fa fa-list-ul',
    'as_parent' => array( 'only' => 'lsvr_definition_list_item' ),
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
	class WPBakeryShortCode_Lsvr_Definition_List extends WPBakeryShortCodesContainer {}
}

// DEFINITION LIST ITEM
vc_map( array(
    'name' => __( 'Definition List Item', 'lsvrtoolkit' ),
    'base' => 'lsvr_definition_list_item',
	'icon' => 'lsvr-vc-ico fa fa-angle-right',
    'content_element' => true,
	'as_child' => array( 'only' => 'lsvr_definition_list' ),
    'show_settings_on_create' => true,
    'params' => array(
        array(
			'param_name' => 'title',
            'type' => 'textfield',
            'heading' => __( 'Title', 'lsvrtoolkit' ),
			'holder' => 'div'
        ),
		array(
			'param_name' => 'value',
            'type' => 'textfield',
            'heading' => __( 'Value', 'lsvrtoolkit' ),
        ),
        array(
            'param_name' => 'value_link',
            'type' => 'textfield',
            'heading' => __( 'Value Link', 'lsvrtoolkit' ),
        ),
    ),
));
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Lsvr_Definition_Item extends WPBakeryShortCode {}
}

?>