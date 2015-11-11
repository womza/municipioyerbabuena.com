<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtoolkit' ),
    'name' => __( 'Team Member', 'lsvrtoolkit' ),
	'description' => __( 'Text block with portrait and title', 'lsvrtoolkit' ),
    'base' => 'lsvr_team_member',
	'icon' => 'lsvr-vc-ico fa fa-user',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'portrait',
            'type' => 'attach_image',
            'heading' => __( 'Portrait', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'name',
            'type' => 'textfield',
            'heading' => __( 'Name', 'lsvrtoolkit' ),
			'holder' => 'div'
        ),
		array(
			'param_name' => 'role',
            'type' => 'textfield',
            'heading' => __( 'Role', 'lsvrtoolkit' ),
			'description' => __( 'Short text which will be shown under name (e.g. "web designer").', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'content',
            'type' => 'textarea_html',
            'heading' => __( 'Text', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'wpautop',
            'type' => 'checkbox',
            'heading' => __( 'Automatically add paragraphs', 'lsvrtoolkit' ),
			'value' => array( __( 'Yes', 'lsvrtoolkit' ) => 'yes' ),
			'std' => 'yes'
        ),
		array(
			'param_name' => 'social_icons',
            'type' => 'textfield',
            'heading' => __( 'Social Icons', 'lsvrtoolkit' ),
			'description' => __( 'Use the following pattern for adding social icons: "<strong>icon_class1,link1|icon_class2,link2</strong>".<br>For example: "<strong>fa fa-twitter,https://twitter.com/MyTwitterProfile|fa fa-facebook,https://www.facebook.com/MyTwitterProfile</strong>".', 'lsvrtoolkit' ),
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