<?php

/* -----------------------------------------------------------------------------

    INIT

----------------------------------------------------------------------------- */

// Flushes rewrite rules on plugin activation to ensure project posts don't 404
// http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
if ( ! function_exists( 'lsvr_notice_activation' ) ) {
	function lsvr_notice_activation() {
		lsvr_notice_init();
		flush_rewrite_rules();
	}
}
if ( ! function_exists( 'lsvr_notice_init' ) ) {
	function lsvr_notice_init() {

		// Enable custom post type
		// http://codex.wordpress.org/Function_Reference/register_post_type
		$labels = array(
			'name' => __( 'Notices', 'lsvrtoolkit' ),
			'singular_name' => __( 'Notice', 'lsvrtoolkit' ),
			'add_new' => __( 'Add New Notice', 'lsvrtoolkit' ),
			'add_new_item' => __( 'Add New Notice', 'lsvrtoolkit' ),
			'edit_item' => __( 'Edit Notice', 'lsvrtoolkit' ),
			'new_item' => __( 'Add New Notice', 'lsvrtoolkit' ),
			'view_item' => __( 'View Notice', 'lsvrtoolkit' ),
			'search_items' => __( 'Search notices', 'lsvrtoolkit' ),
			'not_found' => __( 'No notices found', 'lsvrtoolkit' ),
			'not_found_in_trash' => __( 'No notices found in trash', 'lsvrtoolkit' ),
		);

		$args = array(
			'labels' => $labels,
			'exclude_from_search' => false,
			'public' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions', 'excerpt' ),
			'capability_type' => 'post',
			'rewrite' => array( 'slug' => lsvr_get_field( 'notices_slug', 'notices' ) ), // Permalinks format
			'menu_position' => 5,
			'has_archive' => true,
			'show_in_nav_menus' => true,
			'menu_icon' => 'dashicons-megaphone',
		);

		$args = apply_filters( 'lsvrnoticeposttype_args', $args );

		register_post_type( 'lsvrnotice', $args );

		// Register a taxonomy
		// http://codex.wordpress.org/Function_Reference/register_taxonomy
		$taxonomy_lsvrnoticecat_labels = array(
			'name' => __( 'Notice Categories', 'lsvrtoolkit' ),
			'singular_name' => __( 'Category', 'lsvrtoolkit' ),
			'search_items' => __( 'Search Categories', 'lsvrtoolkit' ),
			'popular_items' => __( 'Popular Categories', 'lsvrtoolkit' ),
			'all_items' => __( 'All Categories', 'lsvrtoolkit' ),
			'parent_item' => __( 'Parent Category', 'lsvrtoolkit' ),
			'parent_item_colon' => __( 'Parent Category:', 'lsvrtoolkit' ),
			'edit_item' => __( 'Edit Category', 'lsvrtoolkit' ),
			'update_item' => __( 'Update Category', 'lsvrtoolkit' ),
			'add_new_item' => __( 'Add New Category', 'lsvrtoolkit' ),
			'new_item_name' => __( 'New Category Name', 'lsvrtoolkit' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'lsvrtoolkit' ),
			'add_or_remove_items' => __( 'Add or remove categories', 'lsvrtoolkit' ),
			'choose_from_most_used' => __( 'Choose from the most used categories', 'lsvrtoolkit' ),
			'menu_name' => __( 'Categories', 'lsvrtoolkit' )
		);
		$taxonomy_lsvrnoticecat_args = array(
			'labels' => $taxonomy_lsvrnoticecat_labels,
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_tagcloud' => true,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => lsvr_get_field( 'notice_cat_slug', 'notice-category' ) ), // Permalinks format
			'query_var' => true

		);
		register_taxonomy( 'lsvrnoticecat', array( 'lsvrnotice' ), $taxonomy_lsvrnoticecat_args );

	}
}
register_activation_hook( __FILE__, 'lsvr_notice_activation' );
add_action( 'init', 'lsvr_notice_init' );

// Thumbnail support
add_theme_support( 'post-thumbnails', array( 'lsvrnotice' ) );


/* -----------------------------------------------------------------------------

    EDIT COLUMNS
	http://wptheming.com/2010/07/column-edit-pages/

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_notice_add_columns' ) ) {
	function lsvr_notice_add_columns( $columns ) {
		$column_thumbnail = array( 'thumbnail' => __( 'Thumbnail', 'lsvrtoolkit' ) );
		$columns = array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, NULL, true );
		return $columns;
	}
}
if ( ! function_exists( 'lsvr_notice_display_columns' ) ) {
	function lsvr_notice_display_columns( $column ) {
		global $post;
		global $typenow;
		if ( $typenow == 'lsvrnotice' ) {
			switch ( $column ) {
				case 'thumbnail':
					echo get_the_post_thumbnail( $post->ID, array( 35, 35 ) );
					break;
			}
		}
	}
}
add_filter( 'manage_edit-lsvrnotice_columns', 'lsvr_notice_add_columns', 10, 1 );
add_action( 'manage_posts_custom_column', 'lsvr_notice_display_columns', 10, 1 );



/* -----------------------------------------------------------------------------

    ADD TAXONOMY FILTER TO ADMIN
	http://pippinsplugins.com

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_add_noticecat_taxonomy_filters' ) ) {
	function lsvr_add_noticecat_taxonomy_filters() {
		global $typenow;

		// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array( 'lsvrnoticecat' );

		// must set this to the post type you want the filter(s) displayed on
		if ( $typenow == 'lsvrnotice' ) {
			foreach ( $taxonomies as $tax_slug ) {
				$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($tax_slug);
				if ( count( $terms ) > 0) {
					echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
					echo "<option value=''>$tax_name</option>";
					foreach ( $terms as $term ) {
						echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}
					echo "</select>";
				}
			}
		}
	}
}
add_action( 'restrict_manage_posts', 'lsvr_add_noticecat_taxonomy_filters' );

?>