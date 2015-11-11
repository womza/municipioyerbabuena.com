<?php

/* -----------------------------------------------------------------------------

    INIT

----------------------------------------------------------------------------- */

// Flushes rewrite rules on plugin activation to ensure project posts don't 404
// http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
if ( ! function_exists( 'lsvr_event_activation' ) ) {
	function lsvr_event_activation() {
		lsvr_event_init();
		flush_rewrite_rules();
	}
}
if ( ! function_exists( 'lsvr_event_init' ) ) {
	function lsvr_event_init() {

		// Enable custom post type
		// http://codex.wordpress.org/Function_Reference/register_post_type
		$labels = array(
			'name' => __( 'Events', 'lsvrtoolkit' ),
			'singular_name' => __( 'Event', 'lsvrtoolkit' ),
			'add_new' => __( 'Add New Event', 'lsvrtoolkit' ),
			'add_new_item' => __( 'Add New Event', 'lsvrtoolkit' ),
			'edit_item' => __( 'Edit Event', 'lsvrtoolkit' ),
			'new_item' => __( 'Add New Event', 'lsvrtoolkit' ),
			'view_item' => __( 'View Event', 'lsvrtoolkit' ),
			'search_items' => __( 'Search events', 'lsvrtoolkit' ),
			'not_found' => __( 'No events found', 'lsvrtoolkit' ),
			'not_found_in_trash' => __( 'No events found in trash', 'lsvrtoolkit' ),
		);
		$args = array(
			'labels' => $labels,
			'exclude_from_search' => false,
			'public' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions', 'excerpt' ),
			'capability_type' => 'post',
			'rewrite' => array( 'slug' => lsvr_get_field( 'events_slug', 'events' ) ), // Permalinks format
			'menu_position' => 5,
			'has_archive' => true,
			'show_in_nav_menus' => true,
			'menu_icon' => 'dashicons-calendar-alt',
		);
		$args = apply_filters( 'lsvreventposttype_args', $args );
		register_post_type( 'lsvrevent', $args );

		// Register a taxonomy
		// http://codex.wordpress.org/Function_Reference/register_taxonomy
		$taxonomy_lsvreventcat_labels = array(
			'name' => __( 'Event Categories', 'lsvrtoolkit' ),
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
		$taxonomy_lsvreventcat_args = array(
			'labels' => $taxonomy_lsvreventcat_labels,
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_tagcloud' => true,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => lsvr_get_field( 'event_cat_slug', 'event-category' ) ), // Permalinks format
			'query_var' => true

		);
		register_taxonomy( 'lsvreventcat', array( 'lsvrevent' ), $taxonomy_lsvreventcat_args );

	}
}
register_activation_hook( __FILE__, 'lsvr_event_activation' );
add_action( 'init', 'lsvr_event_init' );

// Thumbnail support
add_theme_support( 'post-thumbnails', array( 'lsvrevent' ) );


/* -----------------------------------------------------------------------------

    EDIT COLUMNS
	http://wptheming.com/2010/07/column-edit-pages/

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_event_add_columns' ) ) {
	function lsvr_event_add_columns( $columns ) {
		$column_thumbnail = array( 'thumbnail' => __( 'Thumbnail', 'lsvrtoolkit' ) );
		$column_date = array( 'eventdate' => __( 'Event Date', 'lsvrtoolkit' ) );
		$columns = array_slice( $columns, 0, 2, true ) + $column_thumbnail + $column_date + array_slice( $columns, 1, NULL, true );
		return $columns;
	}
}
if ( ! function_exists( 'lsvr_event_display_columns' ) ) {
	function lsvr_event_display_columns( $column ) {
		global $post;
		global $typenow;
		if ( $typenow == 'lsvrevent' ) {
			switch ( $column ) {
				case 'eventdate':
					echo get_post_meta( $post->ID, 'meta_event_date', true );
					break;
				case 'thumbnail':
					echo get_the_post_thumbnail( $post->ID, array( 35, 35 ) );
					break;
			}
		}
	}
}
add_filter( 'manage_edit-lsvrevent_columns', 'lsvr_event_add_columns', 10, 1 );
add_action( 'manage_posts_custom_column', 'lsvr_event_display_columns', 10, 1 );


/* -----------------------------------------------------------------------------

    ADD TAXONOMY FILTER TO ADMIN
	http://pippinsplugins.com

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_add_eventcat_taxonomy_filters' ) ) {
	function lsvr_add_eventcat_taxonomy_filters() {
		global $typenow;

		// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array( 'lsvreventcat' );

		// must set this to the post type you want the filter(s) displayed on
		if ( $typenow == 'lsvrevent' ) {

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
add_action( 'restrict_manage_posts', 'lsvr_add_eventcat_taxonomy_filters' );

?>