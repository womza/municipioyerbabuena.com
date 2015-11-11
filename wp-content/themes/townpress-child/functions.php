<?php

/* -----------------------------------------------------------------------------

    LOAD PARENT THEME STYLE.CSS

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_enqueue_parent_styles' ) ) {
	function lsvr_enqueue_parent_styles() {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'lsvr_enqueue_parent_styles' );


/* -----------------------------------------------------------------------------

    LOAD CUSTOM SCRIPTS
	You can override all plugins defined in "library.js" file by adding your own definition
	of the plugin in "/library/js/scripts.js" file and uncommenting "add_action"

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_load_child_scripts' ) ) {
	function lsvr_load_child_scripts() {
		$theme = wp_get_theme();
		$theme_version = $theme->Version;
		wp_register_script( 'child-scripts', get_stylesheet_directory_uri() . '/library/js/scripts.js', array('jquery'), $theme_version, true );
		wp_enqueue_script( 'child-scripts' );
	}
}
//add_action( 'wp_enqueue_scripts', 'lsvr_load_child_scripts' );


/* -----------------------------------------------------------------------------

    CUSTOM CODE

----------------------------------------------------------------------------- */

// add your code here


?>