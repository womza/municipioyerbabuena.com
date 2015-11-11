<?php

/* -----------------------------------------------------------------------------

    INIT

----------------------------------------------------------------------------- */

// Flushes rewrite rules on plugin activation to ensure slider posts don't 404
// http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
if ( ! function_exists( 'lsvr_slide_activation' ) ) {
	function lsvr_slide_activation() {
		lsvr_slide_init();
		flush_rewrite_rules();
	}
}
if ( ! function_exists( 'lsvr_slide_init' ) ) {
	function lsvr_slide_init() {

		// Enable the Slider custom post type
		// http://codex.wordpress.org/Function_Reference/register_post_type
		$labels = array(
			'name' => __( 'Slides', 'lsvrtoolkit' ),
			'singular_name' => __( 'Slide', 'lsvrtoolkit' ),
			'add_new' => __( 'Add New Slide', 'lsvrtoolkit' ),
			'add_new_item' => __( 'Add New Slide', 'lsvrtoolkit' ),
			'edit_item' => __( 'Edit Slide', 'lsvrtoolkit' ),
			'new_item' => __( 'Add New Slide', 'lsvrtoolkit' ),
			'view_item' => __( 'View Slide', 'lsvrtoolkit' ),
			'search_items' => __( 'Search slides', 'lsvrtoolkit' ),
			'not_found' => __( 'No slides found', 'lsvrtoolkit' ),
			'not_found_in_trash' => __( 'No slides found in trash', 'lsvrtoolkit' ),
		);

		$args = array(
			'labels' => $labels,
			'exclude_from_search' => true,
			'public' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions' ),
			'capability_type' => 'post',
			'rewrite' => array( 'slug' => 'lsvr-slide' ), // Permalinks format
			'menu_position' => 5,
			'has_archive' => false,
			'show_in_nav_menus' => false,
			'menu_icon'=>'dashicons-slides',
		);

		$args = apply_filters( 'lsvrslideposttype_args', $args );

		register_post_type( 'lsvrslide', $args );

		// Register a taxonomy for Slider Groups
		// http://codex.wordpress.org/Function_Reference/register_taxonomy
		$taxonomy_lsvrslider_labels = array(
			'name' => __( 'Sliders', 'lsvrtoolkit' ),
			'singular_name' => __( 'Slider', 'lsvrtoolkit' ),
			'search_items' => __( 'Search Sliders', 'lsvrtoolkit' ),
			'popular_items' => __( 'Popular Sliders', 'lsvrtoolkit' ),
			'all_items' => __( 'All Sliders', 'lsvrtoolkit' ),
			'parent_item' => __( 'Parent Slider', 'lsvrtoolkit' ),
			'parent_item_colon' => __( 'Parent Slider:', 'lsvrtoolkit' ),
			'edit_item' => __( 'Edit Slider', 'lsvrtoolkit' ),
			'update_item' => __( 'Update Slider', 'lsvrtoolkit' ),
			'add_new_item' => __( 'Add New Slider', 'lsvrtoolkit' ),
			'new_item_name' => __( 'New Slider Name', 'lsvrtoolkit' ),
			'separate_items_with_commas' => __( 'Separate sliders with commas', 'lsvrtoolkit' ),
			'add_or_remove_items' => __( 'Add or remove sliders', 'lsvrtoolkit' ),
			'choose_from_most_used' => __( 'Choose from the most used sliders', 'lsvrtoolkit' ),
			'menu_name' => __( 'Sliders', 'lsvrtoolkit' )
		);
		$taxonomy_lsvrslider_args = array(
			'labels' => $taxonomy_lsvrslider_labels,
			'public' => true,
			'show_in_nav_menus' => false,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_tagcloud' => true,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => 'lsvr-slider' ),
			'query_var' => true

		);
		register_taxonomy( 'lsvrslider', array( 'lsvrslide' ), $taxonomy_lsvrslider_args );

	}
}
register_activation_hook( __FILE__, 'lsvr_slide_activation' );
add_action( 'init', 'lsvr_slide_init' );

// Thumbnail support
add_theme_support( 'post-thumbnails', array( 'lsvrslide' ) );


/* -----------------------------------------------------------------------------

    EDIT COLUMNS
	http://wptheming.com/2010/07/column-edit-pages/

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_slide_add_columns' ) ) {
	function lsvr_slide_add_columns( $columns ) {
		$column_thumbnail = array( 'thumbnail' => __( 'Thumbnail', 'lsvrtoolkit' ) );
		$columns = array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, NULL, true );
		return $columns;
	}
}
if ( ! function_exists( 'lsvr_slide_display_columns' ) ) {
	function lsvr_slide_display_columns( $column ) {
		global $post;
		global $typenow;
		if ( $typenow == 'lsvrslide' ) {
			switch ( $column ) {
				case 'thumbnail':
					echo get_the_post_thumbnail( $post->ID, array( 35, 35 ) );
					break;
			}
		}
	}
}
add_filter( 'manage_edit-lsvrslide_columns', 'lsvr_slide_add_columns', 10, 1 );
add_action( 'manage_posts_custom_column', 'lsvr_slide_display_columns', 10, 1 );

?>