<?php

// CREATE ARRAY WITH LIST OF GALLERIES
$galleries_arr = array();

if ( is_admin() ) {

	$args = array(
		'posts_per_page'   => 1000,
		'orderby'          => 'title',
		'order'            => 'ASC',
		'post_type'        => 'lsvrgallery',
		'post_status'      => 'publish',
	);
	$galleries = get_posts( $args );

	if ( ! empty( $galleries ) ) {
		foreach( $galleries as $gallery ) {
			$galleries_arr[ $gallery->post_title ] = $gallery->ID;
		}
	}
	else {
		$galleries_arr = array( __( 'Create your gallery under <strong>Galleries</strong> first' ) => 'none'  );
	}

}

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Gallery (CPT)', 'lsvrtoolkit' ),
	'description' => __( 'Pre-created gallery', 'lsvrtoolkit' ),
    'base' => 'lsvr_gallery_cpt',
	'icon' => 'lsvr-vc-ico fa fa-th',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'gallery',
            'type' => 'dropdown',
			'heading' => __( 'Gallery', 'lsvrtoolkit' ),
			'description' => __( 'Galleries can be managed under <strong>Galleries</strong>.', 'lsvrtoolkit' ),
			'value' => $galleries_arr,
		),
        array(
			'param_name' => 'items_per_row',
            'type' => 'dropdown',
			'heading' => __( 'Images per row', 'lsvrtoolkit' ),
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4 ),
			'std' => 3
        ),
		array(
			'param_name' => 'size',
            'type' => 'textfield',
            'heading' => __( 'Size of images', 'lsvrtoolkit' ),
			'description' => __( 'You can specify an image size which will be used, e.g. "large" or "full". Sizes can be defined under <strong>Settings / Media</strong>. Leave blank to use a "medium" size.', 'lsvrtoolkit' ),
        ),
        array(
			'param_name' => 'masonry',
            'type' => 'checkbox',
			'heading' => __( 'Masonry Layout', 'lsvrtoolkit' ),
			'value' => array( __( 'Enable', 'lsvrtoolkit' ) => 'yes' ),
			'std' => 'yes'
        ),
		array(
			'param_name' => 'click_action',
            'type' => 'dropdown',
			'heading' => __( 'Click action', 'lsvrtoolkit' ),
			'value' => array( __( 'Open in Lightbox', 'lsvrtoolkit' ) => 'lightbox', __( 'Open in new tab', 'lsvrtoolkit' ) => 'tab', __( 'No click action', 'lsvrtoolkit' ) => 'disable' ),
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