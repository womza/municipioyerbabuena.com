<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {

/* -----------------------------------------------------------------------------

    INIT

----------------------------------------------------------------------------- */

	// LOAD CSS
	if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) ) {
		if ( ! function_exists( 'lsvr_load_page_builder_files' ) ) {
			function lsvr_load_page_builder_files() {
				wp_register_style( 'page-builder', plugins_url( 'lsvr-toolkit-townpress' ) . '/library/css/page-builder.css', false );
				wp_enqueue_style( 'page-builder' );
			}
		}
		add_action( 'admin_enqueue_scripts', 'lsvr_load_page_builder_files' );
	}

	// SET AS THEME
	add_action( 'vc_before_init', 'lsvr_vc_init' );
	if ( ! function_exists( 'lsvr_vc_init' ) ) {
		function lsvr_vc_init() {
			vc_set_as_theme();
		}
	}

	// SET DEFAULT POST TYPES FOR VC
	vc_set_default_editor_post_types( array( 'page', 'lsvrservice' ) );


/* -----------------------------------------------------------------------------

    ELEMENTS

----------------------------------------------------------------------------- */

	if ( ! function_exists( 'lsvr_vc_register_shortcodes' ) ) {
		function lsvr_vc_register_shortcodes() {

			// ACCORDION
			require_once( 'vc-elements/accordion.php' );

			// ALERT MESSAGE
			require_once( 'vc-elements/alert-message.php' );

			// ARTICLES
			require_once( 'vc-elements/articles.php' );

			// BUTTON
			require_once( 'vc-elements/button.php' );

			// CONTENT BOX
			require_once( 'vc-elements/content-box.php' );

			// COUNTER
			require_once( 'vc-elements/counter.php' );

			// CTA
			require_once( 'vc-elements/cta.php' );

			// DEFINITION LIST
			require_once( 'vc-elements/definition-list.php' );

			// DIRECTORY
			require_once( 'vc-elements/directory.php' );

			// FEATURE
			require_once( 'vc-elements/feature.php' );

			// GALLERY
			require_once( 'vc-elements/gallery.php' );

			// GALLERY CPT
			require_once( 'vc-elements/gallery-cpt.php' );

			// GOOGLE MAP
			require_once( 'vc-elements/gmap.php' );

			// IMAGE
			require_once( 'vc-elements/image.php' );

			// PROGRESS BAR
			require_once( 'vc-elements/progress-bar.php' );

			// SEPARATOR
			require_once( 'vc-elements/separator.php' );

			// SLIDER
			require_once( 'vc-elements/slider.php' );

			// TABS
			require_once( 'vc-elements/tabs.php' );

			// TEAM MEMBER
			require_once( 'vc-elements/team-member.php' );

			// TEXT BLOCK
			require_once( 'vc-elements/text-block.php' );

		}
	}
	add_action( 'vc_before_init', 'lsvr_vc_register_shortcodes' );

} ?>