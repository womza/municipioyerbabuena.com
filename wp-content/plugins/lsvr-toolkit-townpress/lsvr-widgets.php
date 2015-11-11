<?php

/* -----------------------------------------------------------------------------

    REGISTER WIDGETS

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_custom_widgets' ) ) {
    function lsvr_custom_widgets() {

		// CUSTOM CODE
		require_once( 'widgets/custom-code.php' );
		if ( class_exists( 'Lsvr_Custom_Code_Widget' ) ) {
			register_widget( 'Lsvr_Custom_Code_Widget' );
		}

		// DEFINITION LIST
		require_once( 'widgets/definition-list.php' );
		if ( class_exists( 'Lsvr_Definition_List_Widget' ) ) {
			register_widget( 'Lsvr_Definition_List_Widget' );
		}

		// DOCUMENTS
		require_once( 'widgets/documents.php' );
		if ( class_exists( 'Lsvr_Documents_Widget' ) ) {
			register_widget( 'Lsvr_Documents_Widget' );
		}

		// DOCUMENT CATEGORIES
		require_once( 'widgets/document-categories.php' );
		if ( class_exists( 'Lsvr_Document_Categories_Widget' ) ) {
			register_widget( 'Lsvr_Document_Categories_Widget' );
		}

		// EVENTS
		require_once( 'widgets/events.php' );
		if ( class_exists( 'Lsvr_Events_Widget' ) ) {
			register_widget( 'Lsvr_Events_Widget' );
		}

		// EVENT CATEGORIES
		require_once( 'widgets/event-categories.php' );
		if ( class_exists( 'Lsvr_Event_Categories_Widget' ) ) {
			register_widget( 'Lsvr_Event_Categories_Widget' );
		}

		// GALLERIES
		require_once( 'widgets/galleries.php' );
		if ( class_exists( 'Lsvr_Galleries_Widget' ) ) {
			register_widget( 'Lsvr_Galleries_Widget' );
		}

		// GALLERY CATEGORIES
		require_once( 'widgets/gallery-categories.php' );
		if ( class_exists( 'Lsvr_Gallery_Categories_Widget' ) ) {
			register_widget( 'Lsvr_Gallery_Categories_Widget' );
		}

		// FEATURED GALLERY
		require_once( 'widgets/gallery-featured.php' );
		if ( class_exists( 'Lsvr_Gallery_Featured_Widget' ) ) {
			register_widget( 'Lsvr_Gallery_Featured_Widget' );
		}

		// IMAGE
		require_once( 'widgets/image.php' );
		if ( class_exists( 'Lsvr_Image_Widget' ) ) {
			register_widget( 'Lsvr_Image_Widget' );
		}

		// LOCALE INFO
		require_once( 'widgets/locale.php' );
		if ( class_exists( 'Lsvr_Locale_Info_Widget' ) ) {
			register_widget( 'Lsvr_Locale_Info_Widget' );
		}

		// MAILCHIMP
		require_once( 'widgets/mailchimp.php' );
		if ( class_exists( 'Lsvr_Mailchimp_Subscribe_Widget' ) ) {
			register_widget( 'Lsvr_Mailchimp_Subscribe_Widget' );
		}

		// NOTICES
		require_once( 'widgets/notices.php' );
		if ( class_exists( 'Lsvr_Notices_Widget' ) ) {
			register_widget( 'Lsvr_Notices_Widget' );
		}

		// NOTICE CATEGORIES
		require_once( 'widgets/notice-categories.php' );
		if ( class_exists( 'Lsvr_Notice_Categories_Widget' ) ) {
			register_widget( 'Lsvr_Notice_Categories_Widget' );
		}

    }

}
add_action( 'widgets_init', 'lsvr_custom_widgets' );

?>