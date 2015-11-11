<?php

$redux_opt_name = 'theme_options';

if ( ! function_exists( 'lsvr_redux_add_metaboxes' ) ) {

	function lsvr_redux_add_metaboxes( $metaboxes ) {

/* -----------------------------------------------------------------------------

    PAGE SETTINGS

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		HEADER
	------------------------------------------------------------------------- */

	$page_settings[] = array(
		'title' => __( 'Header', 'lsvrtheme' ),
		'desc' => __( 'Global settings are defined in <strong>Theme Options / Header Settings</strong>.', 'lsvrtheme' ),
		'icon' => 'el-icon-cog',
		'fields' => array(

            // LOGO SIZE
            array(
                'id' => 'meta_header_logo_size',
				'type' => 'button_set',
				'title' => __( 'Header Logo Size', 'lsvrtheme' ),
				'subtitle' => __( 'Both widths can be set under <strong>Theme Options / Header Settings</strong>', 'lsvrtheme' ),
				'options'  => array(
					'global' => __( 'Global', 'lsvrtheme' ),
					'small' => __( 'Small', 'lsvrtheme' ),
					'large' => __( 'Large', 'lsvrtheme' ),
				),
				'default' => 'global',
			),

            // ENABLE HEADER MENU
            array(
                'id' => 'meta_header_menu_enable',
				'type' => 'button_set',
				'title' => __( 'Header Menu', 'lsvrtheme' ),
				'subtitle' => __( 'Display Main Menu in header', 'lsvrtheme' ),
				'options'  => array(
					'global' => __( 'Global', 'lsvrtheme' ),
					'enable' => __( 'Enable', 'lsvrtheme' ),
					'disable' => __( 'Disable', 'lsvrtheme' ),
				),
				'default' => 'global',
			),

			// ENABLE SLIDESHOW
            array(
                'id' => 'meta_header_slideshow_enable',
				'type' => 'button_set',
				'title' => __( 'Enable Header Slideshow', 'lsvrtheme' ),
				'subtitle' => __( 'Slideshow images can be defined under <strong>Theme Options / Header Settings</strong> with <strong>Slideshow Images</strong> option', 'lsvrtheme' ),
				'options'  => array(
					'global' => __( 'Global', 'lsvrtheme' ),
					'enable' => __( 'Enable', 'lsvrtheme' ),
					'disable' => __( 'Disable', 'lsvrtheme' ),
				),
				'default' => 'global'
			),

			// GOOGLE MAP ENABLE
            array(
                'id' => 'meta_header_gmap_enable',
				'type' => 'button_set',
				'title' => __( 'Enable Header Google Map', 'lsvrtheme' ),
				'subtitle' => __( 'Map settings can be set under <strong>Theme Options / Header Settings</strong>', 'lsvrtheme' ),
				'options'  => array(
					'global' => __( 'Global', 'lsvrtheme' ),
					'enable' => __( 'Enable', 'lsvrtheme' ),
					'disable' => __( 'Disable', 'lsvrtheme' ),
				),
				'default' => 'global'
			),

		)
	);

	/* -------------------------------------------------------------------------
		CONTENT
	------------------------------------------------------------------------- */

	$page_settings[] = array(
		'title' => __( 'Content', 'lsvrtheme' ),
		'icon' => 'el-icon-website',
		'fields' => array(

			// PAGE TITLE ENABLE
            array(
                'id' => 'meta_content_title_enable',
				'type' => 'switch',
				'title' => __( 'Page Title', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1
			),

			// PAGE TITLE OVERRIDE
            array(
                'id' => 'meta_content_title',
				'type' => 'text',
				'title' => __( 'Override Page Title', 'lsvrtheme' ),
				'subtitle' => __( 'Leave blank to use default page title. You can use HTML tags here, for example: &lt;em&gt;<em>italic text</em>&lt;/em&gt;', 'lsvrtheme' ),
				'required'  => array( 'meta_content_title_enable', "=", 1 ),
			),

			// BREADCRUMBS
            array(
                'id' => 'meta_content_breadcrumbs_enable',
				'type' => 'switch',
				'title' => __( 'Breadcrumbs', 'lsvrtheme' ),
				'subtitle' => __( 'Will be show under Page Title', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 1
			),

			// BOXED CONTENT
            array(
                'id' => 'meta_content_boxed',
				'type' => 'button_set',
				'title' => __( 'Boxed Content', 'lsvrtheme' ),
				'subtitle' => __( '<strong>Single Box</strong> - whole content will be wrapped in one single box<br><strong>Separate Boxes</strong> - each element will have its own box<br><br>This option has no effect if you are using this page as a base page for Standard Posts, Notices, Documents, Events, Galleries or Forum pages.', 'lsvrtheme' ),
				'options'  => array(
					'single' => __( 'Single Box', 'lsvrtheme' ),
					'separate' => __( 'Separate Boxes', 'lsvrtheme' ),
					'disable' => __( 'No Box', 'lsvrtheme' ),
				),
				'default' => 'single'
			),

		)
	);

	/* -------------------------------------------------------------------------
		SIDEBARS
	------------------------------------------------------------------------- */

	$sidebars_arr = array();
	$sidebars_arr[ 'disable' ] = __( 'Disable', 'lsvrtheme' );
	if ( is_active_sidebar( 'primary-sidebar' ) ) {
		$sidebars_arr[ 'primary-sidebar' ] = __( 'Default Left Sidebar', 'lsvrtheme' );
	}
	if ( is_active_sidebar( 'secondary-sidebar' ) ) {
		$sidebars_arr[ 'secondary-sidebar' ] = __( 'Default Right Sidebar', 'lsvrtheme' );
	}

	// GET CUSTOM SIDEBARS
	$custom_sidebars = get_option( 'theme_options' );
	if ( is_array( $custom_sidebars ) && array_key_exists( 'custom_sidebars', $custom_sidebars ) ) {
		$custom_sidebars = $custom_sidebars[ 'custom_sidebars' ];
		if ( is_array( $custom_sidebars ) ) {

			$custom_sidebars_arr = lsvr_consolidate_repeater_field( $custom_sidebars, array( 'sidebar_id', 'sidebar_title' ) );
			if ( is_array( $custom_sidebars_arr ) ) {
				$index = 0;
				foreach ( $custom_sidebars_arr as $sidebar ) {
					if ( is_array( $sidebar ) ) {

						$index++;
						$sidebar_id = array_key_exists( 'sidebar_id', $sidebar ) ? sanitize_title( $sidebar['sidebar_id'] ) : false;
						$sidebar_id = ! $sidebar_id ? 'custom-sidebar-' . esc_attr( $index ) : $sidebar_id;
						$sidebar_title = array_key_exists( 'sidebar_title', $sidebar ) ? $sidebar['sidebar_title'] : sprintf( __( 'Custom Sidebar %s', 'lsvrtheme' ), $index );

						if ( is_active_sidebar( $sidebar_id ) ) {
							$sidebars_arr[ $sidebar_id ] = $sidebar_title;
						}

					}
				}
			}

		}
	}

	$page_settings[] = array(
		'title' => __( 'Sidebars', 'lsvrtheme' ),
		'desc' => __( 'Sidebars are managed under <strong>Appearance / Widgets</strong>. You can assign primary and secondary sidebar to this page. Custom sidebars can be added under <strong>"Theme Options / Sidebars"</strong>. Sidebar must contain <strong>at least one widget</strong> to be listed here.', 'lsvrtheme'),
		'icon' => 'el-icon-puzzle',
		'fields' => array(

			// ENABLE SIDE MENU
            array(
                'id' => 'meta_sidebar_menu_position',
				'type' => 'button_set',
				'title' => __( 'Side Menu Position ', 'lsvrtheme' ),
				'subtitle' => __( 'Global setting for this option can be changed under <strong>Theme Options / Sidebar Settings</strong>', 'lsvrtheme' ),
                'options'  => array(
                	'global' => __( 'Global', 'lsvrtheme' ),
                    'left' => __( 'Left', 'lsvrtheme' ),
                    'right' => __( 'Right', 'lsvrtheme' ),
                    'disable' => __( 'Disable', 'lsvrtheme' ),
                ),
                'default' => 'global',
			),

			// PRIMARY SIDEBAR
			array(
				'id' => 'meta_sidebar_primary',
				'type' => 'select',
				'title' => __( 'Left Sidebar', 'lsvrtheme' ),
				'subtitle' => __( 'Choose sidebar for left sidebar area', 'lsvrtheme' ),
				'options' => $sidebars_arr,
				'default' => 'primary-sidebar',
			),

			// SECONDARY SIDEBAR
			array(
				'id' => 'meta_sidebar_secondary',
				'type' => 'select',
				'title' => __( 'Right Sidebar', 'lsvrtheme' ),
				'subtitle' => __( 'Choose sidebar for right sidebar area', 'lsvrtheme' ),
				'options' => $sidebars_arr,
				'default' => 'secondary-sidebar',
			),

		)
	);

	$metaboxes[] = array(
		'id' => 'page_settings',
		'title' => __( 'Page Settings', 'lsvrtheme' ),
		'post_types' => array( 'page' ),
		'position' => 'normal',
		'priority' => 'high',
		'sidebar' => false,
		'sections' => $page_settings
	);


/* -----------------------------------------------------------------------------

    DOCUMENT SETTINGS

----------------------------------------------------------------------------- */

	$document_settings[] = array(
		'title' => __( 'General', 'lsvrtheme' ),
		'icon' => 'el-icon-wrench',
		'fields' => array(

			// FILE TYPE
            array(
                'id' => 'meta_document_file_location',
				'type' => 'button_set',
				'title' => __( 'File Location', 'lsvrtheme' ),
				'options'  => array(
					'local' => __( 'Local (Upload)', 'lsvrtheme' ),
					'external' => __( 'External (URL)', 'lsvrtheme' ),
				),
				'default' => 'local',
			),

			// UPLOAD FILE
			array(
				'id' => 'meta_document_file',
				'type' => 'multi_media',
				'title' => __( 'Upload File', 'lsvrtheme' ),
				'max_file_upload' => 1,
				'required'  => array( 'meta_document_file_location', "=", 'local' ),
			),

			// EXTERNAL FILE URL
			array(
				'id' => 'meta_document_external_file_url',
				'type' => 'text',
				'title' => __( 'External File URL', 'lsvrtheme' ),
				'subtitle' => __( 'Insert full URL please, for example http://domain.com/my-file.pdf', 'lsvrtheme' ),
				'required'  => array( 'meta_document_file_location', "=", 'external' ),
			),

			// EXTERNAL FILE SIZE
			array(
				'id' => 'meta_document_external_file_size',
				'type' => 'text',
				'title' => __( 'External File Size', 'lsvrtheme' ),
				'subtitle' => __( 'It is not possible to display file size automatically for externally hosted files, so if you want to show this file\'s size, you have to specify it manually. For example 12kB or 2MB', 'lsvrtheme' ),
				'required'  => array( 'meta_document_file_location', "=", 'external' ),
			),

			// TYPE
			array(
				'id' => 'meta_document_type',
				'type' => 'select',
				'title' => __( 'Document Type', 'lsvrtheme' ),
				'options' => array( 'default' => __( 'Non-specified', 'lsvrtheme' ), 'zip' => __( '.zip Archive', 'lsvrtheme' ),
					'audio' => __( 'Audio', 'lsvrtheme' ), 'code' => __( 'Code', 'lsvrtheme' ), 'excel' => __( 'Excel', 'lsvrtheme' ),
					'image' => __( 'Image', 'lsvrtheme' ), 'video' => __( 'Video', 'lsvrtheme' ), 'pdf' => __( 'PDF', 'lsvrtheme' ),
					'powerpoint' => __( 'PowerPoint', 'lsvrtheme' ), 'text' => __( 'Text', 'lsvrtheme' ), 'word' => __( 'Word', 'lsvrtheme' ),
					'custom' => __( 'Custom', 'lsvrtheme' ) ),
				'subtitle' => __( 'Choose "Custom" if you want to define your own icon"', 'lsvrtheme' ),
				'default' => 'default'
			),

			// CUSTOM LABEL
			array(
				'id' => 'meta_document_custom_label',
				'type' => 'text',
				'title' => __( 'Custom Type Label', 'lsvrtheme' ),
				'required'  => array( 'meta_document_type', "=", 'custom' ),
			),

			// CUSTOM ICON
			array(
				'id' => 'meta_document_custom_icon',
				'type' => 'text',
				'title' => __( 'Custom Type Icon', 'lsvrtheme' ),
				'subtitle' => __( 'For example "fa fa-file-o". Please refer to the documentation to learn more about icons', 'lsvrtheme' ),
				'default' => 'fa fa-file-o',
				'required'  => array( 'meta_document_type', "=", 'custom' ),
			),

			// EXPIRATION DATE
			array(
				'id' => 'meta_document_expiration_date',
				'type' => 'datetime',
				'title' => __( 'Expiration Date', 'lsvrtheme' ),
				'subtitle' => __( 'After this date, document will be moved into archive and won\'t be displayed in default document list. Leave blank to always show this document in default document list. You can enable displaying of the archive link under document list under <strong>Theme Options / Documents</strong> with <strong>Show Link To Archive</strong> option', 'lsvrtheme' ),
				'date-format' => 'yy-mm-dd',
				'time-format' => 'HH:mm',
				'date-min' => 0
			),

		)
	);

	$metaboxes[] = array(
		'id' => 'document_settings',
		'title' => __( 'Document Settings', 'lsvrtheme' ),
		'post_types' => array( 'lsvrdocument' ),
		'position' => 'normal',
		'priority' => 'high',
		'sidebar' => false,
		'sections' => $document_settings
	);


/* -----------------------------------------------------------------------------

    EVENT SETTINGS

----------------------------------------------------------------------------- */

	$event_settings[] = array(
		'title' => __( 'General', 'lsvrtheme' ),
		'icon' => 'el-icon-wrench',
		'fields' => array(

			// EVENT DATE
			array(
				'id' => 'meta_event_date',
				'type' => 'datetime',
				'title' => __( 'Event Date', 'lsvrtheme' ),
				'date-format' => 'yy-mm-dd',
				'time-format' => 'HH:mm',
				'date-min' => 0
			),

			// EVENT LOCATION
			array(
				'id' => 'meta_event_location',
				'type' => 'text',
				'title' => __( 'Event Location', 'lsvrtheme' ),
				'subtitle' => __( 'A brief description of event location. For example "Town Hall" or "Stadium"', 'lsvrtheme' ),
			),

			// GOOGLE MAP ENABLE
            array(
                'id' => 'meta_event_gmap_enable',
				'type' => 'switch',
				'title' => __( 'Show Location On Map', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 0
			),

			// GOOGLE MAP ADDRESS
            array(
                'id' => 'meta_event_gmap_address',
				'type' => 'text',
				'title' => __( 'Address', 'lsvrtheme' ),
				'subtitle' => __( 'For example: Main St, Stowe, VT 05672, USA', 'lsvrtheme' ),
				'default' => 'Main St, Stowe, VT 05672, USA',
				'required'  => array( 'meta_event_gmap_enable', "=", 1 ),
			),

			// GOOGLE MAP LATITUDE
            array(
                'id' => 'meta_event_gmap_latitude',
				'type' => 'text',
				'title' => __( 'Latitude', 'lsvrtheme' ),
				'subtitle' => __( 'Optional, it can be more precise than using just the address. For example: 44.465446', 'lsvrtheme' ),
				'default' => '',
				'required'  => array( 'meta_event_gmap_enable', "=", 1 ),
			),

			// GOOGLE MAP LONGITUDE
            array(
                'id' => 'meta_event_gmap_longitude',
				'type' => 'text',
				'title' => __( 'Longitude', 'lsvrtheme' ),
				'subtitle' => __( 'Optional, it can be more precise than using just the address. For example: -72.687425', 'lsvrtheme' ),
				'default' => '',
				'required'  => array( 'meta_event_gmap_enable', "=", 1 ),
			),

			// GOOGLE MAP TYPE
            array(
                'id' => 'meta_event_gmap_type',
				'type' => 'button_set',
				'title' => __( 'Map Type', 'lsvrtheme' ),
				'options'  => array(
					'roadmap' => __( 'Roadmap', 'lsvrtheme' ),
					'satellite' => __( 'Satellite', 'lsvrtheme' ),
					'terrain' => __( 'Terrain', 'lsvrtheme' ),
					'hybrid' => __( 'Hybrid', 'lsvrtheme' ),
				),
				'default' => 'hybrid',
				'required'  => array( 'meta_event_gmap_enable', "=", 1 ),
			),

			// GOOGLE MAP ZOOM
            array(
                'id' => 'meta_event_gmap_zoom',
				'type' => 'slider',
				'title' => __( 'Map Zoom Level', 'lsvrtheme' ),
				'subtitle' => __( 'Higher number means closer view. Not all map types support all zoom levels.', 'lsvrtheme' ),
				'default' => '17',
                'min' => '1',
                'step' => '1',
                'max' => '20',
				'required'  => array( 'meta_event_gmap_enable', "=", 1 ),
			),

			// GOOGLE MAP ENABLE MOUSE SCROLL
            array(
                'id' => 'meta_event_gmap_mouse_scroll_enable',
				'type' => 'switch',
				'title' => __( 'Mouse Scroll on Map', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 0,
				'required'  => array( 'meta_event_gmap_enable', "=", 1 ),
			),

		)
	);

	$metaboxes[] = array(
		'id' => 'event_settings',
		'title' => __( 'Event Settings', 'lsvrtheme' ),
		'post_types' => array( 'lsvrevent' ),
		'position' => 'normal',
		'priority' => 'high',
		'sidebar' => false,
		'sections' => $event_settings
	);


/* -----------------------------------------------------------------------------

    GALLERY SETTINGS

----------------------------------------------------------------------------- */

	$gallery_settings[] = array(
		'title' => __( 'General', 'lsvrtheme' ),
		'icon' => 'el-icon-wrench',
		'fields' => array(

			// GALLERY
			array(
				'id' => 'meta_gallery_images',
				'type' => 'gallery',
				'title' => __( 'Gallery Images', 'lsvrtheme' ),
			),

		)
	);

	$metaboxes[] = array(
		'id' => 'gallery_settings',
		'title' => __( 'Gallery Settings', 'lsvrtheme' ),
		'post_types' => array( 'lsvrgallery' ),
		'position' => 'normal',
		'priority' => 'high',
		'sidebar' => false,
		'sections' => $gallery_settings
	);


/* -----------------------------------------------------------------------------

    SLIDE SETTINGS

----------------------------------------------------------------------------- */

	$slide_settings[] = array(
		'fields' => array(

			// VERTICAL ALIGN
			array(
				'id' => 'meta_slide_valign',
				'type' => 'button_set',
				'title' => __( 'Vertical Align:', 'lsvrtheme' ),
				'options' => array( 'top' => __( 'Top', 'lsvrtheme' ), 'middle' => __( 'Middle', 'lsvrtheme' ), 'bottom' => __( 'Bottom', 'lsvrtheme' ) ),
				'default' => 'middle',
			),

		)
	);

	$metaboxes[] = array(
		'id' => 'slide-settings',
		'title' => __( 'Slide Settings', 'lsvrtheme' ),
		'post_types' => array( 'lsvrslide' ),
		'position' => 'normal',
		'priority' => 'high',
		'sections' => $slide_settings
	);

	// SECTIONS END

	return $metaboxes;

	}
	add_action( 'redux/metaboxes/' . $redux_opt_name . '/boxes', 'lsvr_redux_add_metaboxes' );

}