<?php

// MENU ARRAY
$menus_arr = array();
$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );

if ( is_array( $menus ) ) {
	foreach ( $menus as $menu ) {
		if ( is_object( $menu ) ) {
			$menus_arr[ $menu->name ] = $menu->term_id;
		}
	}
}

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Directory', 'lsvrtoolkit' ),
	'description' => __( 'Displays menu', 'lsvrtoolkit' ),
    'base' => 'lsvr_directory',
	'icon' => 'lsvr-vc-ico fa fa-folder-open-o',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
        array(
			'param_name' => 'title',
            'type' => 'textfield',
            'heading' => __( 'Title', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'icon',
            'type' => 'textfield',
            'heading' => __( 'Icon', 'lsvrtoolkit' ),
			'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvrtoolkit' ),
			'value' => 'tp tp-road-sign',
        ),
		array(
			'param_name' => 'menu',
			'type' => 'dropdown',
			'heading' => __( 'Menu', 'lsvrtoolkit' ),
			'description' => __( 'Create a menu under <strong>Appearance / Menus</strong> first. Then select this menu here', 'lsvrtoolkit' ),
			'value' => $menus_arr,
		),
        array(
			'param_name' => 'columns',
            'type' => 'dropdown',
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4 ),
            'heading' => __( 'Columns', 'lsvrtoolkit' ),
			'description' => __( 'Please note, that the number of columns displayed on page is affected by screen size.', 'lsvrtoolkit' ),
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