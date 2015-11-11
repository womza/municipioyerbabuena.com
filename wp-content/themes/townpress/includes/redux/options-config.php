<?php

if (!class_exists('Redux_Framework_Lsvrtheme_config')) {

    class Redux_Framework_Lsvrtheme_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            //$this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            //$this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);

            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'lsvrtheme'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'lsvrtheme'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'lsvrtheme'), $this->theme->display('Name'));

            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'lsvrtheme'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'lsvrtheme'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'lsvrtheme') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'lsvrtheme'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

/* -----------------------------------------------------------------------------

    SECTIONS

----------------------------------------------------------------------------- */

	$lsvr_theme_options = get_option( 'theme_options' );

    /* -------------------------------------------------------------------------
        HEADER
    ------------------------------------------------------------------------- */

	$this->sections[] = array(
		'title'     => __( 'Header Settings', 'lsvrtheme' ),
		'icon'      => 'el-icon-cog',
		'fields'    => array(

            // HEADER LOGO
            array(
                'id' => 'header_logo',
				'type' => 'media',
				'title' => __( 'Header Logo', 'lsvrtheme' ),
			),

			// HEADER LOGO 2X
            array(
                'id' => 'header_logo_2x',
				'type' => 'media',
				'title' => __( 'Header Logo (Retina)', 'lsvrtheme' ),
                'subtitle' => __( 'Retina (HiDPI) version of header logo (optional)', 'lsvrtheme' )
			),

            // HEADER LOGO MAX WIDTH
            array(
				'id' => 'header_logo_max_width',
				'type' => 'slider',
				'title' => __( 'Max Width of Small Header Logo', 'lsvrtheme' ),
				'subtitle' => __( 'You can switch between Small and Large sizes below and separately for each page under its <strong>Page Settings</strong>. Set to 0 to disable any restriction (not recommended if you are using both standard and Retina logos). This value will be also used for small screens', 'lsvrtheme' ),
				'default' => '120',
                'min' => '0',
                'step' => '1',
                'max' => '500',
			),

            // LARGE HEADER LOGO MAX WIDTH
            array(
				'id' => 'header_logo_max_width_large',
				'type' => 'slider',
				'title' => __( 'Max Width of Large Header Logo', 'lsvrtheme' ),
				'subtitle' => __( 'You can switch between Small and Large sizes below and separately for each page under its <strong>Page Settings</strong>. Set to 0 to disable any restriction (not recommended if you are using both standard and Retina logos)', 'lsvrtheme' ),
				'default' => '200',
                'min' => '0',
                'step' => '1',
                'max' => '500',
			),

            // DEFAULT LOGO
            array(
                'id' => 'header_logo_size',
				'type' => 'button_set',
				'title' => __( 'Default Logo Size', 'lsvrtheme' ),
				'subtitle' => __( 'You can change this option separately for each page (under <strong>Page Settings</strong>)', 'lsvrtheme' ),
				'options'  => array(
					'small' => __( 'Small', 'lsvrtheme' ),
					'large' => __( 'Large', 'lsvrtheme' ),
				),
				'default' => 'small',
			),

            array(
                'id'   => 'header_divider_10',
                'type' => 'divide'
            ),

            // ENABLE HEADER MENU
            array(
                'id' => 'header_menu_enable',
                'type' => 'switch',
                'title' => __( 'Header Menu (global)', 'lsvrtheme' ),
                'subtitle' => __( 'Display Main Menu in header. You can change this option separately for each page (under <strong>Page Settings</strong>)', 'lsvrtheme' ),
                'on' => __( 'Enable', 'lsvrtheme' ),
                'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 0
            ),

			array(
				'id'   => 'header_divider_20',
				'type' => 'divide'
			),

			// BACKGROUND IMAGE
            array(
                'id' => 'header_bg_image',
				'type' => 'media',
				'title' => __( 'Header Background', 'lsvrtheme' ),
				'subtitle' => __( 'Optimal resolution is about 2000x1200px', 'lsvrtheme' ),
			),

			// ENABLE SLIDESHOW
            array(
                'id' => 'header_slideshow_enable',
				'type' => 'switch',
				'title' => __( 'Header Slideshow (global)', 'lsvrtheme' ),
				'subtitle' => __( 'Image set as <strong>Header Background Image</strong> (above) will be used as the first image of slideshow. If you define a featured image for a page, that image will be used as the first one instead. Additional images for slideshow can be aded below. You can override this setting in <strong>Page Settings</strong> when editing a specific page.', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1
			),

			// SLIDESHOW IMAGES
            array(
                'id' => 'header_slideshow_images',
				'type' => 'gallery',
				'title' => __( 'Slideshow Images', 'lsvrtheme' ),
				'subtitle' => __( 'These images will be used for slideshow (with image set under <strong>Header Background Image</strong> as a first)', 'lsvrtheme' ),
			),

			// SLIDESHOW SPEED
            array(
                'id' => 'header_slideshow_speed',
				'type' => 'slider',
				'title' => __( 'Slideshow Speed', 'lsvrtheme' ),
				'subtitle' => __( 'In seconds', 'lsvrtheme' ),
				'default' => '5',
                'min' => '1',
                'step' => '1',
                'max' => '60',
			),

			array(
				'id'   => 'header_divider_30',
				'type' => 'divide'
			),

			// GOOGLE MAP ENABLE
            array(
                'id' => 'header_gmap_enable',
				'type' => 'switch',
				'title' => __( 'Header Google Map (global)', 'lsvrtheme' ),
				'subtitle' => __( 'You can override this setting in <strong>Page Settings</strong> when editing a specific page', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 0
			),

			// GOOGLE MAP ADDRESS
            array(
                'id' => 'header_gmap_address',
				'type' => 'text',
				'title' => __( 'Address', 'lsvrtheme' ),
				'subtitle' => __( 'For example: Main St, Stowe, VT 05672, USA', 'lsvrtheme' ),
				'default' => 'Main St, Stowe, VT 05672, USA',
			),

			// GOOGLE MAP LATITUDE
            array(
                'id' => 'header_gmap_latitude',
				'type' => 'text',
				'title' => __( 'Latitude', 'lsvrtheme' ),
				'subtitle' => __( 'Optional, it can be more precise than using just the address. For example: 44.465446', 'lsvrtheme' ),
				'default' => '',
			),

			// GOOGLE MAP LONGITUDE
            array(
                'id' => 'header_gmap_longitude',
				'type' => 'text',
				'title' => __( 'Longitude', 'lsvrtheme' ),
				'subtitle' => __( 'Optional, it can be more precise than using just the address. For example: -72.687425', 'lsvrtheme' ),
				'default' => '',
			),

			// GOOGLE MAP TYPE
            array(
                'id' => 'header_gmap_type',
				'type' => 'button_set',
				'title' => __( 'Map Type', 'lsvrtheme' ),
				'options'  => array(
					'roadmap' => __( 'Roadmap', 'lsvrtheme' ),
					'satellite' => __( 'Satellite', 'lsvrtheme' ),
					'terrain' => __( 'Terrain', 'lsvrtheme' ),
					'hybrid' => __( 'Hybrid', 'lsvrtheme' ),
				),
				'default' => 'hybrid',
			),

			// GOOGLE MAP ZOOM
            array(
                'id' => 'header_gmap_zoom',
				'type' => 'slider',
				'title' => __( 'Map Zoom Level', 'lsvrtheme' ),
				'subtitle' => __( 'Higher number means closer view. Not all map types support all zoom levels.', 'lsvrtheme' ),
				'default' => '17',
                'min' => '1',
                'step' => '1',
                'max' => '20',
			),

			// GOOGLE MAP ENABLE MOUSE SCROLL
            array(
                'id' => 'header_gmap_mouse_scroll_enable',
				'type' => 'switch',
				'title' => __( 'Mouse Scroll on Map', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1,
			),

			array(
				'id'   => 'header_divider_40',
				'type' => 'divide'
			),

            // HEADER LOGIN
            array(
                'id' => 'header_login_enable',
				'type' => 'switch',
				'title' => __( 'Enable Header Login', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 0,
			),

            // LOGIN LABEL
            array(
                'id' => 'header_login_label',
				'type' => 'text',
				'title' => __( 'Login Label', 'lsvrtheme' ),
				'subtitle' => __( 'This text will be displayed when you hover over login button in header', 'lsvrtheme' ),
				'default' => __( 'Login / Register', 'lsvrtheme' ),
				'required'  => array( 'header_login_enable', "=", 1 ),
			),

			// LOGIN PAGE
            array(
                'id' => 'header_login_page',
				'type' => 'select',
				'data' => 'pages',
				'title' => __( 'Login Page', 'lsvrtheme' ),
				'subtitle' => __( 'Select a page which contains login form (if you are using <strong>bbPress</strong> plugin, you can create such page using <strong>[bbpress-login]</strong> and <strong>[bbp-register]</strong> shortcodes)', 'lsvrtheme' ),
				'required'  => array( 'header_login_enable', "=", 1 ),
			),

			array(
				'id'   => 'header_divider_40',
				'type' => 'divide'
			),

            // HEADER SEARCH
            array(
                'id' => 'header_search_enable',
				'type' => 'switch',
				'title' => __( 'Header Search', 'lsvrtheme' ),
				'subtitle' => __( 'It will be displayed under main menu', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 1
			),

		),
	);

    /* -------------------------------------------------------------------------
        FOOTER
    ------------------------------------------------------------------------- */

	$this->sections[] = array(
		'title'     => __( 'Footer Settings', 'lsvrtheme' ),
		'icon'      => 'el-icon-cog',
		'fields'    => array(

            // BACKGROUND IMAGE
            array(
                'id' => 'footer_bg_image',
				'type' => 'media',
				'title' => __( 'Footer Background Image', 'lsvrtheme' ),
				'subtitle' => __( 'Optimal resolution is about 2000x1200px.', 'lsvrtheme' ),
			),

			array(
				'id'   => 'footer_divider_10',
				'type' => 'divide'
			),

            // BOTTOM PANEL COLUMNS
            array(
				'id' => 'bottom_panel_columns',
				'type' => 'slider',
				'title' => __( 'Bottom Panel Columns', 'lsvrtheme' ),
				'subtitle' => __( 'Set number of columns for Bottom Panel. In most cases, the number should be the same as number of widgets. Widgets can be added under <strong>Appearance / Widgets</strong>', 'lsvrtheme' ),
				'default' => '4',
                'min' => '1',
                'step' => '1',
                'max' => '4',
			),

			array(
				'id'   => 'footer_divider_20',
				'type' => 'divide'
			),

            // SOCIAL ICONS
            array(
                'id' => 'footer_social_enable',
				'type' => 'switch',
				'title' => __( 'Social Icons', 'lsvrtheme' ),
				'subtitle' => __( 'Social icons can be defined under <strong>Social</strong> tab of <strong>Theme Options</strong>', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1
			),

			array(
				'id'   => 'footer_divider_40',
				'type' => 'divide'
			),

            // FOOTER TEXT
            array(
                'id' => 'footer_text',
				'type' => 'editor',
				'title' => __( 'Footer Text', 'lsvrtheme' ),
                'subtitle' => __( 'Ideal for copyright notice', 'lsvrtheme' ),
				'default' => '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' )
			),

		),
	);


    /* -------------------------------------------------------------------------
        SIDEBARS
    ------------------------------------------------------------------------- */

	$this->sections[] = array(
        'title' => __( 'Sidebar Settings', 'lsvrtheme' ),
		'icon' => 'el-icon-puzzle',
        'fields' => array(

			// SIDEBAR MENU POSITION
            array(
                'id' => 'sidebar_menu_position',
                'type' => 'button_set',
                'title' => __( 'Side Menu Position (global)', 'lsvrtheme' ),
                'subtitle' => __( 'You can override this setting in <strong>Page Settings</strong> when editing a specific page', 'lsvrtheme' ),
                'options'  => array(
                    'left' => __( 'Left', 'lsvrtheme' ),
                    'right' => __( 'Right', 'lsvrtheme' ),
                    'disable' => __( 'Disable', 'lsvrtheme' ),
                ),
                'default' => 'left',
            ),

            // SIDEBAR MENU SHOW SUBMENU
            array(
                'id' => 'sidebar_menu_submenu_visible',
				'type' => 'switch',
				'title' => __( 'Show Submenus in Side Menu', 'lsvrtheme' ),
				'subtitle' => __( 'Active item\'s submenu will be displayed without hovering', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1
			),

			array(
				'id'   => 'sidebar_divider_10',
				'type' => 'divide'
			),

			// INFO
			array(
				'id' => 'sidebars_info',
				'type' => 'info',
				'desc' => __( 'Here you can create your custom sidebars. Once created, you can populate them with widgets under <strong>Appearance / Widgets</strong>. Then you can assign sidebar as primary (displayed under main menu) or secondary (displayed on opposing side) to any page under <strong>Page Settings / Sidebars</strong> when editing a page.', 'lsvrtheme' ),
            ),

			// CUSTOM SIDEBARS
            array(
                'id' => 'custom_sidebars',
				'type' => 'repeater',
				'group_values' => true,
				'bind_title' => 'sidebar_title',
				'title' => __( 'Custom Sidebars', 'lsvrtheme' ),
				'subtitle' => __( 'Each sidebar must have an <strong>unique simple ID</strong> which contains just letters and digits (for example "sidebar1").', 'lsvrtheme' ),
				'limit' => 50,
                'fields' => array(
					array(
						'id' => 'sidebar_id',
						'type' => 'text',
						'title' => __( 'Sidebar ID', 'lsvrtheme' ),
					),
					array(
						'id' => 'sidebar_title',
						'type' => 'text',
						'title' => __( 'Sidebar Title', 'lsvrtheme' ),
					),
				)
			),

		)
    );

	$this->sections[] = array(
		'type' => 'divide',
	);

    /* -------------------------------------------------------------------------
        POSTS
    ------------------------------------------------------------------------- */

	$this->sections[] = array(
        'title' => __( 'Standard Posts', 'lsvrtheme' ),
		'icon' => 'el-icon-pencil',
        'fields' => array(

			// INFO
			array(
				'id' => 'article_info',
				'type' => 'info',
				'desc' => __( 'Don\'t forget to set your <strong>Posts page</strong> under <strong>Settings / Reading</strong> first.', 'lsvrtheme' ),
            ),

            // BASE PAGE
            array(
                'id' => 'articles_base_page',
                'type' => 'select',
                'data' => 'pages',
                'title' => __( 'Posts Base Page', 'lsvrtheme' ),
                'subtitle' => __( 'Page settings of this page (header, sidebars, etc.) will be used for all posts pages (archive, single, category). This option should be set if you choose <strong>Front page displays</strong> (under <strong>Settings / Reading</strong>) to <strong>Your latest posts</strong>', 'lsvrtheme' ),
            ),

            array(
                'id'   => 'articles_divider_10',
                'type' => 'divide'
            ),

			// THUMBNAIL ENABLE
            array(
				'id' => 'article_list_thumb',
				'type' => 'button_set',
				'title' => __( 'Show Featured Image (List)', 'lsvrtheme' ),
				'options'  => array(
					'full' => __( 'Show Full', 'lsvrtheme' ),
					'cropped' => __( 'Show Cropped', 'lsvrtheme' ),
					'disable' => __( 'Disable', 'lsvrtheme' ),
				),
                'default' => 'full',
			),

			// ARTICLE LIST CATEGORIES
            array(
                'id' => 'article_list_categories_enable',
				'type' => 'switch',
				'title' => __( 'Show Categories (List)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1,
			),

			array(
				'id'   => 'articles_divider_20',
				'type' => 'divide'
			),

			// ARTICLE DETAIL THUMB
            array(
                'id' => 'article_detail_thumb',
				'type' => 'button_set',
				'title' => __( 'Show Featured Image (Detail)', 'lsvrtheme' ),
				'options'  => array(
					'header' => __( 'Show In Header', 'lsvrtheme' ),
					'top' => __( 'Show On Top', 'lsvrtheme' ),
					'disable' => __( 'Disable', 'lsvrtheme' ),
				),
				'default' => 'top',
			),

			// ARTICLE CROP
            array(
				'id' => 'article_detail_thumb_crop',
				'type' => 'switch',
				'title' => __( 'Crop Featured Image (Detail)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 0,
				'required'  => array( 'article_detail_thumb', "=", 'top' ),
			),

			// ARTICLE DETAIL CATEGORIES
            array(
                'id' => 'article_detail_categories_enable',
				'type' => 'switch',
				'title' => __( 'Show Categories (Detail)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1,
			),

			// ARTICLE DETAIL NAVIGATION
            array(
                'id' => 'article_detail_navigation_enable',
				'type' => 'switch',
				'title' => __( 'Show Previous/Next Post Links (Detail)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1,
			),

			// ARTICLE DETAIL TAGS
            array(
                'id' => 'article_detail_tags_enable',
				'type' => 'switch',
				'title' => __( 'Show Tags (Detail)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1,
			),

		),
	);


    /* -------------------------------------------------------------------------
        NOTICES
    ------------------------------------------------------------------------- */

	$lsvr_notices_slug = $lsvr_theme_options && array_key_exists( 'notices_slug', $lsvr_theme_options ) ? $lsvr_theme_options[ 'notices_slug' ] : 'notices';

	$this->sections[] = array(
        'title' => __( 'Notices', 'lsvrtheme' ),
		'icon' => 'el-icon-bullhorn',
        'fields' => array(

			// BASE PAGE
            array(
                'id' => 'notices_base_page',
				'type' => 'select',
				'data' => 'pages',
				'title' => __( 'Notices Base Page', 'lsvrtheme' ),
				'subtitle' => __( 'Page settings of this page (header, sidebars, etc.) will be used for all notices pages (archive, single, category). Remember that slug of this page <strong>MUST BE DIFFERENT</strong> from <strong>Notices URL Slug</strong> defined below (for example, you can name base page\'s slug "notices-base"). ', 'lsvrtheme' ),
			),

			// NOTICES SLUG
            array(
                'id' => 'notices_slug',
				'type' => 'text',
				'title' => __( 'Notices URL Slug', 'lsvrtheme' ),
				'subtitle' => sprintf( __( 'Slug defines the URL of your default notices page. Your current URL is <a href="%s/%s">%s/%s</a>.<br><br><strong>IMPORTANT:</strong> After changing the slug, go to <strong>Settings / Permalinks</strong> and hit Save Changes.', 'lsvrtheme' ), get_site_url(), $lsvr_notices_slug, get_site_url(), $lsvr_notices_slug ),
				'default' => 'notices',
			),

			// NOTICE CATEGORY SLUG
            array(
                'id' => 'notice_cat_slug',
				'type' => 'text',
				'title' => __( 'Notice Category URL Slug', 'lsvrtheme' ),
				'subtitle' => __( 'This Slug defines the URL of page which shows posts from certain notice category.', 'lsvrtheme' ),
				'default' => 'notice-category',
			),

			array(
				'id'   => 'notices_divider_10',
				'type' => 'divide'
			),

            // NOTICES PER PAGE
            array(
				'id' => 'notice_list_items_per_page',
				'type' => 'slider',
				'title' => __( 'Number of Notices Per Page', 'lsvrtheme' ),
				'default' => '20',
                'min' => '1',
                'step' => '1',
                'max' => '50',
			),

			// THUMBNAIL ENABLE
            array(
				'id' => 'notice_list_thumb',
				'type' => 'button_set',
				'title' => __( 'Show Featured Image (List)', 'lsvrtheme' ),
				'options'  => array(
					'full' => __( 'Show Full', 'lsvrtheme' ),
					'cropped' => __( 'Show Cropped', 'lsvrtheme' ),
					'disable' => __( 'Disable', 'lsvrtheme' ),
				),
                'default' => 'full',
			),

			// NOTICE LIST CATEGORIES
            array(
                'id' => 'notice_list_categories_enable',
				'type' => 'switch',
				'title' => __( 'Show Categories (List)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1,
			),

			array(
				'id'   => 'notices_divider_20',
				'type' => 'divide'
			),

			// NOTICE DETAIL THUMB
            array(
                'id' => 'notice_detail_thumb',
				'type' => 'button_set',
				'title' => __( 'Show Featured Image (Detail)', 'lsvrtheme' ),
				'options'  => array(
					'header' => __( 'Show In Header', 'lsvrtheme' ),
					'top' => __( 'Show On Top', 'lsvrtheme' ),
					'disable' => __( 'Disable', 'lsvrtheme' ),
				),
				'default' => 'header',
			),

			// THUMBNAIL CROP
            array(
				'id' => 'notice_detail_thumb_crop',
				'type' => 'switch',
				'title' => __( 'Crop Featured Image (Detail)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 1,
				'required'  => array( 'notice_detail_thumb', "=", 'top' ),
			),

			// NOTICE DETAIL CATEGORIES
            array(
                'id' => 'notice_detail_categories_enable',
				'type' => 'switch',
				'title' => __( 'Show Categories (Detail)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1,
			),

		),
	);

    /* -------------------------------------------------------------------------
        DOCUMENTS
    ------------------------------------------------------------------------- */

	$lsvr_documents_slug = $lsvr_theme_options && array_key_exists( 'documents_slug', $lsvr_theme_options ) ? $lsvr_theme_options[ 'documents_slug' ] : 'documents';

	$this->sections[] = array(
        'title' => __( 'Documents', 'lsvrtheme' ),
		'icon' => 'el-icon-file',
        'fields' => array(

			// BASE PAGE
            array(
                'id' => 'documents_base_page',
				'type' => 'select',
				'data' => 'pages',
				'title' => __( 'Documents Base Page', 'lsvrtheme' ),
				'subtitle' => __( 'Page settings of this page (header, sidebars, etc.) will be used for all documents pages (archive, category). Remember that slug of this page <strong>MUST BE DIFFERENT</strong> from <strong>Documents URL Slug</strong> defined below (for example, you can name base page\'s slug "documents-base"). ', 'lsvrtheme' ),
			),

			// DOCUMENTS SLUG
            array(
                'id' => 'documents_slug',
				'type' => 'text',
				'title' => __( 'Documents URL Slug', 'lsvrtheme' ),
				'subtitle' => sprintf( __( 'Slug defines the URL of your default documents page. Your current URL is <a href="%s/%s">%s/%s</a>.<br><br><strong>IMPORTANT:</strong> After changing the slug, go to <strong>Settings / Permalinks</strong> and hit Save Changes.', 'lsvrtheme' ), get_site_url(), $lsvr_documents_slug, get_site_url(), $lsvr_documents_slug ),
				'default' => 'documents',
			),

			// DOCUMENT CATEGORY SLUG
            array(
                'id' => 'document_cat_slug',
				'type' => 'text',
				'title' => __( 'Document Category URL Slug', 'lsvrtheme' ),
				'subtitle' => __( 'This Slug defines the URL of page which shows posts from certain document category.', 'lsvrtheme' ),
				'default' => 'document-category',
			),

			array(
				'id'   => 'documents_divider_10',
				'type' => 'divide'
			),

            // DOCUMENTS PER PAGE
            array(
				'id' => 'document_list_items_per_page',
				'type' => 'slider',
				'title' => __( 'Number of Documents Per Page', 'lsvrtheme' ),
				'default' => '20',
                'min' => '1',
                'step' => '1',
                'max' => '50',
			),

            // OPEN IN NEW TAB
            array(
				'id' => 'document_new_tab_enable',
				'type' => 'switch',
				'title' => __( 'Open Documents in New Tab', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 1,
			),

            // ENABLE FILE SIZE
            array(
				'id' => 'document_list_filesize_enable',
				'type' => 'switch',
				'title' => __( 'Show File Size', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 1,
			),

            // ENABLE ICON
            array(
				'id' => 'document_list_icon_enable',
				'type' => 'switch',
				'title' => __( 'Show File Icon', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 1,
			),

            // ENABLE UPLOADER
            array(
                'id' => 'document_list_uploader_enable',
                'type' => 'switch',
                'title' => __( 'Show Uploader', 'lsvrtheme' ),
                'on' => __( 'Enable', 'lsvrtheme' ),
                'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 0,
            ),

            // ENABLE UPLOAD DATE
            array(
                'id' => 'document_list_upload_date_enable',
                'type' => 'switch',
                'title' => __( 'Show Upload Date', 'lsvrtheme' ),
                'on' => __( 'Enable', 'lsvrtheme' ),
                'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 0,
            ),

            // ENABLE EXPIRATION DATE
            array(
                'id' => 'document_list_expiration_date_enable',
                'type' => 'switch',
                'title' => __( 'Show Expiration Date', 'lsvrtheme' ),
                'on' => __( 'Enable', 'lsvrtheme' ),
                'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 0,
            ),

            // ENABLE EXPIRED LINK
            array(
                'id' => 'document_list_expired_link_enable',
                'type' => 'switch',
                'title' => __( 'Show Link To Archive', 'lsvrtheme' ),
                'subtitle' => __( 'Link to expired documents will be displayed at the bottom of document list', 'lsvrtheme' ),
                'on' => __( 'Enable', 'lsvrtheme' ),
                'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 0,
            ),

		),
	);

    /* -------------------------------------------------------------------------
        EVENTS
    ------------------------------------------------------------------------- */

	$lsvr_events_slug = $lsvr_theme_options && array_key_exists( 'events_slug', $lsvr_theme_options ) ? $lsvr_theme_options[ 'events_slug' ] : 'events';

	$this->sections[] = array(
        'title' => __( 'Events', 'lsvrtheme' ),
		'icon' => 'el-icon-calendar',
        'fields' => array(

			// BASE PAGE
            array(
                'id' => 'events_base_page',
				'type' => 'select',
				'data' => 'pages',
				'title' => __( 'Events Base Page', 'lsvrtheme' ),
				'subtitle' => __( 'Page settings of this page (header, sidebars, etc.) will be used for all events pages (archive, category). Remember that slug of this page <strong>MUST BE DIFFERENT</strong> from <strong>Events URL Slug</strong> defined below (for example, you can name base page\'s slug "events-base"). ', 'lsvrtheme' ),
			),

			// EVENTS SLUG
            array(
                'id' => 'events_slug',
				'type' => 'text',
				'title' => __( 'Events URL Slug', 'lsvrtheme' ),
				'subtitle' => sprintf( __( 'Slug defines the URL of your default events page. Your current URL is <a href="%s/%s">%s/%s</a>.<br><br><strong>IMPORTANT:</strong> After changing the slug, go to <strong>Settings / Permalinks</strong> and hit Save Changes.', 'lsvrtheme' ), get_site_url(), $lsvr_events_slug, get_site_url(), $lsvr_events_slug ),
				'default' => 'events',
			),

			// EVENT CATEGORY SLUG
            array(
                'id' => 'event_cat_slug',
				'type' => 'text',
				'title' => __( 'Event Category URL Slug', 'lsvrtheme' ),
				'subtitle' => __( 'This Slug defines the URL of page which shows posts from certain event category.', 'lsvrtheme' ),
				'default' => 'event-category',
			),

			array(
				'id'   => 'events_divider_10',
				'type' => 'divide'
			),

            // EVENTS PER PAGE
            array(
				'id' => 'event_list_items_per_page',
				'type' => 'slider',
				'title' => __( 'Number of Events Per Page', 'lsvrtheme' ),
				'default' => '20',
                'min' => '1',
                'step' => '1',
                'max' => '50',
			),

            // GROUP BY MONTH
            array(
				'id' => 'event_list_group_by_month',
				'type' => 'switch',
				'title' => __( 'Group Events By Month', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 1,
			),

			// THUMBNAIL ENABLE
            array(
				'id' => 'event_list_thumb',
				'type' => 'button_set',
				'title' => __( 'Show Featured Image (List)', 'lsvrtheme' ),
				'options'  => array(
					'full' => __( 'Show Full', 'lsvrtheme' ),
					'cropped' => __( 'Show Cropped', 'lsvrtheme' ),
					'disable' => __( 'Disable', 'lsvrtheme' ),
				),
                'default' => 'full',
			),

			// EVENT TIME ENABLE
            array(
				'id' => 'event_list_time_enable',
				'type' => 'switch',
				'title' => __( 'Show Event Time (List)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 1,
			),

			// EVENT LOCATION ENABLE
            array(
				'id' => 'event_list_location_enable',
				'type' => 'switch',
				'title' => __( 'Show Event Location (List)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 1,
			),

			// EXCERPT
            array(
				'id' => 'event_list_excerpt_enable',
				'type' => 'button_set',
				'title' => __( 'Show Excerpt (List)', 'lsvrtheme' ),
				'options'  => array(
					'excerpt' => __( 'Show Excerpt', 'lsvrtheme' ),
					'content' => __( 'Show Full Content', 'lsvrtheme' ),
					'disable' => __( 'Disable', 'lsvrtheme' ),
				),
                'default' => 'excerpt',
			),

            // ENABLE ARCHIVE LINK
            array(
                'id' => 'event_list_archive_link_enable',
                'type' => 'switch',
                'title' => __( 'Show Link To Archive', 'lsvrtheme' ),
                'subtitle' => __( 'Link to past events will be displayed at the bottom of event list', 'lsvrtheme' ),
                'on' => __( 'Enable', 'lsvrtheme' ),
                'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 0,
            ),

			array(
				'id'   => 'events_divider_20',
				'type' => 'divide'
			),

			// EVENT DETAIL THUMB
            array(
                'id' => 'event_detail_thumb',
				'type' => 'button_set',
				'title' => __( 'Show Featured Image (Detail)', 'lsvrtheme' ),
				'options'  => array(
					'header' => __( 'Show In Header', 'lsvrtheme' ),
					'top' => __( 'Show On Top', 'lsvrtheme' ),
					'disable' => __( 'Disable', 'lsvrtheme' ),
				),
				'default' => 'header',
			),

			// THUMBNAIL CROP
            array(
				'id' => 'event_detail_thumb_crop',
				'type' => 'switch',
				'title' => __( 'Crop Featured Image (Detail)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 0,
				'required'  => array( 'event_detail_thumb', "=", 'top' ),
			),

		),
	);

    /* -------------------------------------------------------------------------
        GALLERIES
    ------------------------------------------------------------------------- */

	$lsvr_galleries_slug = $lsvr_theme_options && array_key_exists( 'galleries_slug', $lsvr_theme_options ) ? $lsvr_theme_options[ 'galleries_slug' ] : 'galleries';

	$this->sections[] = array(
        'title' => __( 'Galleries', 'lsvrtheme' ),
		'icon' => 'el-icon-picture',
        'fields' => array(

			// BASE PAGE
            array(
                'id' => 'galleries_base_page',
				'type' => 'select',
				'data' => 'pages',
				'title' => __( 'Galleries Base Page', 'lsvrtheme' ),
				'subtitle' => __( 'Page settings of this page (header, sidebars, etc.) will be used for all galleries pages (archive, category). Remember that slug of this page <strong>MUST BE DIFFERENT</strong> from <strong>Galleries URL Slug</strong> defined below (for example, you can name base page\'s slug "galleries-base"). ', 'lsvrtheme' ),
			),

			// GALLERIES SLUG
            array(
                'id' => 'galleries_slug',
				'type' => 'text',
				'title' => __( 'Gallery List URL Slug', 'lsvrtheme' ),
				'subtitle' => sprintf( __( 'Slug defines the URL of your default gallery list page. Your current URL is <a href="%s/%s">%s/%s</a>.<br><br><strong>IMPORTANT:</strong> After changing the slug, go to <strong>Settings / Permalinks</strong> and hit Save Changes.', 'lsvrtheme' ), get_site_url(), $lsvr_galleries_slug, get_site_url(), $lsvr_galleries_slug ),
				'default' => 'galleries',
			),

			// GALLERY CATEGORY SLUG
            array(
                'id' => 'gallery_cat_slug',
				'type' => 'text',
				'title' => __( 'Gallery Category URL Slug', 'lsvrtheme' ),
				'subtitle' => __( 'This Slug defines the URL of page which shows posts from certain gallery category.', 'lsvrtheme' ),
				'default' => 'gallery-category',
			),

			array(
				'id'   => 'galleries_divider_10',
				'type' => 'divide'
			),

            // GALLERIES PER PAGE
            array(
				'id' => 'gallery_list_items_per_page',
				'type' => 'slider',
				'title' => __( 'Number of Galleries Per Page', 'lsvrtheme' ),
				'default' => '20',
                'min' => '1',
                'step' => '1',
                'max' => '50',
			),

			// GALLERY LIST IMAGES COLUMNS
            array(
                'id' => 'gallery_list_images_columns',
				'type' => 'slider',
				'title' => __( 'Number of Columns (List)', 'lsvrtheme' ),
				'default' => '3',
                'min' => '1',
                'step' => '1',
                'max' => '5',
				'required'  => array( 'gallery_list_layout', "=", 'masonry' ),
			),

			// GALLERY LIST TITLE ENABLE
            array(
                'id' => 'gallery_list_title_enable',
				'type' => 'switch',
				'title' => __( 'Show Titles (List)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1,
				'required'  => array( 'gallery_list_layout', "=", 'masonry' ),
			),

			// GALLERY LIST CATEGORIES
            array(
                'id' => 'gallery_list_categories_enable',
				'type' => 'switch',
				'title' => __( 'Show Categories (List)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1,
				'required'  => array( 'gallery_list_layout', "=", 'list' ),
			),

			array(
				'id'   => 'galleries_divider_20',
				'type' => 'divide'
			),

			// GALLERY DETAIL THUMB
            array(
                'id' => 'gallery_detail_thumb',
				'type' => 'button_set',
				'title' => __( 'Show Featured Image (Detail)', 'lsvrtheme' ),
				'options'  => array(
					'header' => __( 'Show In Header', 'lsvrtheme' ),
					'disable' => __( 'Disable', 'lsvrtheme' ),
				),
				'default' => 'header',
			),

			// GALLERY LIST LAYOUT
            array(
                'id' => 'gallery_detail_layout',
				'type' => 'button_set',
				'title' => __( 'Image List Layout (Detail)', 'lsvrtheme' ),
				'options'  => array(
					'grid' => __( 'Grid', 'lsvrtheme' ),
					'masonry' => __( 'Masonry', 'lsvrtheme' ),
				),
				'default' => 'masonry',
			),

			// GALLERY DETAIL IMAGES COLUMNS
            array(
                'id' => 'gallery_detail_images_columns',
				'type' => 'slider',
				'title' => __( 'Number of Columns (Detail)', 'lsvrtheme' ),
				'default' => '3',
                'min' => '1',
                'step' => '1',
                'max' => '5',
			),

			// GALLERY DETAIL NAVIGATION
            array(
                'id' => 'gallery_detail_navigation_enable',
				'type' => 'switch',
				'title' => __( 'Show Previous/Next Post Links (Detail)', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1,
			),

		),
	);


    /* -------------------------------------------------------------------------
        bbPRESS
    ------------------------------------------------------------------------- */

	if ( class_exists( 'bbPress' ) ) {

	$this->sections[] = array(
        'title' => __( 'Forums (bbPress)', 'lsvrtheme' ),
		'icon' => 'el-icon-comment-alt',
        'fields' => array(

			// INFO
			array(
				'id' => 'forums_info',
				'type' => 'info',
				'desc' => __( 'Don\'t forget to check your forum settings under <strong>Settings / Forums</strong> first.', 'lsvrtheme' ),
            ),

			// BASE PAGE
            array(
                'id' => 'forums_base_page',
				'type' => 'select',
				'data' => 'pages',
				'title' => __( 'Forums Base Page', 'lsvrtheme' ),
				'subtitle' => __( 'Page settings of this page (header, sidebars, etc.) will be used for all forum pages. Remember that slug of this page <strong>MUST BE DIFFERENT</strong> from <strong>Forums URL Slug</strong> which can be defined under <strong>Settings / Forums</strong> (for example, you can name base page\'s slug "forums-base"). ', 'lsvrtheme' ),
			),

		),
	);

	}

	$this->sections[] = array(
		'type' => 'divide',
	);

    /* -------------------------------------------------------------------------
        LOCALE
    ------------------------------------------------------------------------- */

	$this->sections[] = array(
        'title' => __( 'Locale', 'lsvrtheme' ),
		'icon' => 'el-icon-map-marker',
        'fields' => array(

			// INFO
			array(
				'id' => 'locale_info',
				'type' => 'info',
				'desc' => __( 'The following settings will be used as data for <strong>LSVR Locale Info</strong> widget which can be added to sidebar of any page. Don\'t forget to set your basic locale settings under <strong>Settings / General</strong> (especially <strong>Timezone</strong> option).<br><strong>IMPORTANT</strong>: After you make your changes on this page, don\'t forget to wipe the weather cache. This can be done by setting "Weather Data Update Interval" option (the last option on this page) to "0". Then refresh your page on front end (until you see your changes have taken effect), and then set this setting back to some value (e.g. "120").', 'lsvrtheme' ),
            ),

            // BACKGROUND IMAGE
            array(
                'id' => 'locale_widget_bg_image',
				'type' => 'media',
				'title' => __( 'Widget Background', 'lsvrtheme' ),
				'subtitle' => __( 'Optimal resolution is about 300x450px.', 'lsvrtheme' ),
			),

			array(
				'id'   => 'locale_divider_10',
				'type' => 'divide'
			),

			// CUSTOM LOCALE FIELDS
            array(
                'id' => 'locale_custom_fields',
				'type' => 'repeater',
				'group_values' => true,
				'bind_title' => 'field_title',
				'title' => __( 'Custom Fields', 'lsvrtheme' ),
				'subtitle' => __( 'Here you can add any text data, for example latitude and longitude values', 'lsvrtheme' ),
                'fields' => array(
					array(
						'id' => 'field_title',
						'type' => 'text',
						'title' => __( 'Field Title', 'lsvrtheme' ),
					),
					array(
						'id' => 'field_value',
						'type' => 'text',
						'title' => __( 'Field Value', 'lsvrtheme' ),
					),
				)
			),

			array(
				'id'   => 'locale_divider_20',
				'type' => 'divide'
			),

            // ENABLE LOCAL TIME
            array(
                'id' => 'locale_time_enable',
				'type' => 'switch',
				'title' => __( 'Show Local Time', 'lsvrtheme' ),
				'subtitle' => __( 'Change your <strong>Timezone</strong> and <strong>Time Format</strong> under <strong>Settings / General</strong>', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1,
			),

			array(
				'id'   => 'locale_divider_40',
				'type' => 'divide'
			),

            // ENABLE LOCAL WEATHER
            array(
                'id' => 'locale_weather_enable',
				'type' => 'switch',
				'title' => __( 'Show Local Weather', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 0,
			),

            // LOCATION
            array(
                'id' => 'locale_weather_location',
				'type' => 'text',
				'title' => __( 'Location', 'lsvrtheme' ),
				'subtitle' => __( 'For example: "stowe,vermont,us". You can search for your location on <a href="http://openweathermap.org/">openweathermap.org</a> to see if it\'s in the database.', 'lsvrtheme' ),
				'default' => 'stowe,vermont,us',
				'required'  => array( 'locale_weather_enable', "=", 1 ),
			),

            // LOCATION LATITUDE
            array(
                'id' => 'locale_weather_latitude',
				'type' => 'text',
				'title' => __( 'Location Latitude', 'lsvrtheme' ),
				'subtitle' => __( 'Optional. Use <strong>only</strong> if your location is not in <a href="http://openweathermap.org/">openweathermap.org</a> database.', 'lsvrtheme' ),
				'default' => '',
				'required'  => array( 'locale_weather_enable', "=", 1 ),
			),

            // LOCATION LONGITUDE
            array(
				'id' => 'locale_weather_longitude',
				'type' => 'text',
				'title' => __( 'Location Longitude', 'lsvrtheme' ),
				'subtitle' => __( 'Optional. Use <strong>only</strong> if your location is not in <a href="http://openweathermap.org/">openweathermap.org</a> database.', 'lsvrtheme' ),
				'default' => '',
				'required'  => array( 'locale_weather_enable', "=", 1 ),
			),

            // SHOW CURRENT WEATHER
            array(
                'id' => 'locale_weather_current_enable',
				'type' => 'switch',
				'title' => __( 'Current Weather', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 1,
				'required'  => array( 'locale_weather_enable', "=", 1 ),
			),

            // FORECAST LENGTH
            array(
                'id' => 'locale_weather_forecast_length',
				'type' => 'slider',
				'title' => __( 'Forecast Length', 'lsvrtheme' ),
				'subtitle' => __( 'How many days of forecast will be displayed. Set to 0 to disable forecast', 'lsvrtheme' ),
				'default' => '3',
                'min' => '0',
                'step' => '1',
                'max' => '7',
				'required'  => array( 'locale_weather_enable', "=", 1 ),
			),

			// UNITS FORMAT
            array(
                'id' => 'locale_weather_units_format',
				'type' => 'button_set',
				'title' => __( 'Units Format', 'lsvrtheme' ),
				'options'  => array(
					'metric' => __( 'Metric', 'lsvrtheme' ),
					'imperial' => __( 'Imperial', 'lsvrtheme' ),
				),
				'default' => 'metric',
				'required'  => array( 'locale_weather_enable', "=", 1 ),
			),

            // OPEN WEATHER API KEY
            array(
                'id' => 'locale_weather_api_key',
				'type' => 'text',
				'title' => __( 'Openweathermap.org API key', 'lsvrtheme' ),
				'subtitle' => __( 'Optional, but recommended. Weather functionality may not work properly without inserting your own API key. You have to <a href="http://openweathermap.org/register">register on openweathermap.org</a> to obtain it', 'lsvrtheme' ),
				'default' => '',
				'required'  => array( 'locale_weather_enable', "=", 1 ),
			),

            // WEATHER CACHE INTERVAL
            array(
                'id' => 'locale_weather_cache_interval',
				'type' => 'slider',
				'title' => __( 'Weather Data Update Interval', 'lsvrtheme' ),
				'subtitle' => __( 'In minutes. Set to 0 to disable cache (not recommended)', 'lsvrtheme' ),
				'default' => '30',
                'min' => '0',
                'step' => '10',
                'max' => '120',
				'required'  => array( 'locale_weather_enable', "=", 1 ),
			),

		)
    );

    /* -------------------------------------------------------------------------
        TYPOGRAPHY
    ------------------------------------------------------------------------- */

	$this->sections[] = array(
        'title' => __( 'Typography', 'lsvrtheme' ),
		'icon' => 'el-icon-fontsize',
        'fields' => array(

            // ENABLE GOOGLE FONTS
            array(
                'id' => 'fonts_gf_enable',
				'type' => 'switch',
				'title' => __( 'Google Fonts', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 1
			),

			// PRIMARY FONT
			array(
				'id'        => 'font_primary',
				'type'      => 'typography',
				'title'     => __( 'Theme Font', 'lsvrtheme' ),
				'subtitle'  => __( 'Default font family is "Source Sans Pro".', 'lsvrtheme' ),
				'google'    => true,
				'all_styles' => true,
				'font-weight' => true,
				'font-style' => false,
				'line-height' => false,
				'text-align' => false,
				'subsets' => true,
				'color' => false,
				'default'   => array(
					'font-size'     => '16px',
					'font-weight'     => '400',
					'font-family'   => 'Source Sans Pro',
				),
				'required'  => array( 'fonts_gf_enable', "=", 1 ),
			),

		),
	);

    /* -------------------------------------------------------------------------
        SOCIAL
    ------------------------------------------------------------------------- */

	$this->sections[] = array(
		'title'     => __( 'Social', 'lsvrtheme' ),
		'icon'      => 'el-icon-network',
		'fields'    => array(

            // SOCIAL ICONS
            array(
                'id' => 'social_links',
				'type' => 'sortable',
				'title' => __( 'Social Links', 'lsvrtheme' ),
                'subtitle' => __( 'Fill in the respective field with a full URL (starting with http:// or https:// respectively).', 'lsvrtheme' ),
				'label' => true,
                'options' => array(
                    'AngelList' => '',
                    'Behance' => '',
                    'Bitbucket' => '',
                    'Bitcoin' => '',
                    'Codepen' => '',
                    'Delicious' => '',
					'DeviantArt' => '',
                    'Digg' => '',
                    'Dribbble' => '',
                    'Dropbox' => '',
					'Email' => '',
                    'Facebook' => '',
                    'Flickr' => '',
                    'FourSquare' => '',
					'Git' => '',
                    'GitHub' => '',
                    'GooglePlus' => '',
                    'Instagram' => '',
					'LastFM' => '',
                    'LinkedIn' => '',
                    'PayPal' => '',
                    'Pinterest' => '',
                    'Reddit' => '',
                    'Skype' => '',
					'SoundCloud' => '',
                    'Spotify' => '',
					'Steam' => '',
                    'Trello' => '',
					'Tumblr' => '',
					'Twitch' => '',
					'Twitter' => '',
					'Vimeo' => '',
					'Vine' => '',
					'VK' => '',
					'WordPress' => '',
					'Xing' => '',
					'Yahoo' => '',
					'Yelp' => '',
					'YouTube' => '',
        	    ),
			),

			// SOCIAL ICONS TARGET
            array(
                'id' => 'social_links_target',
				'type' => 'switch',
				'title' => __( 'Open Social Links in New Tab', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 0
			),

		),
	);

    /* -------------------------------------------------------------------------
        LOCALIZATION
    ------------------------------------------------------------------------- */

	$this->sections[] = array(
		'title'     => __( 'Localization', 'lsvrtheme' ),
		'icon'      => 'el-icon-flag',
		'fields'    => array(

			// INFO
			array(
				'id' => 'localization_info',
				'type' => 'info',
				'desc' => __( 'You need WPML plugin to use this feature', 'lsvrtheme' ),
            ),

            // ENABLE LANG SWITCHER
            array(
                'id' => 'localization_switcher_enable',
				'type' => 'button_set',
				'title' => __( 'Language Switcher', 'lsvrtheme' ),
				'subtitle' => __( 'It will be shown in top right corner of header', 'lsvrtheme' ),
				'options'  => array(
					'disable' => __( 'Disable', 'lsvrtheme' ),
					'wpml' => __( 'WPML Generated', 'lsvrtheme' ),
				),
				'default' => 'wpml'
			),

		),
	);


    /* -------------------------------------------------------------------------
        STYLING
    ------------------------------------------------------------------------- */

	$this->sections[] = array(
        'title' => __( 'Styling', 'lsvrtheme' ),
		'icon' => 'el-icon-tint',
        'fields' => array(

            // THEME SKIN
            array(
                'id' => 'skin_default',
				'type' => 'select',
				'title' => __( 'Theme Color Scheme', 'lsvrtheme' ),
                'options' => array(
                    'red' => __( 'Red', 'lsvrtheme' ),
                    'blue' => __( 'Blue', 'lsvrtheme' ),
                    'green' => __( 'Green', 'lsvrtheme' ),
					'orange' => __( 'Orange', 'lsvrtheme' ),
					'bluegrey' => __( 'Blue Grey', 'lsvrtheme' ),
                ),
                'default' => 'red',
				'required'  => array( 'skin_custom_enabled', "=", 0 ),
			),

            // ENABLE CUSTOM THEME SKIN
            array(
                'id' => 'skin_custom_enabled',
				'type' => 'switch',
				'title' => __( 'Enable Custom Color Scheme', 'lsvrtheme' ),
				'subtitle' => __( 'Please refer to the documentation on how to generate a correct code for your custom color scheme. If you already have the code, enable this option and insert it either to <strong>customskin.css</strong> file located in <strong>Child Theme / library / css</strong> folder (recommended), or into text field below.', 'lsvrtheme' ),
                'default' => 0
			),

            // CUSTOM THEME SKIN
            array(
                'id' => 'skin_custom_code',
				'type' => 'textarea',
				'title' => __( 'Custom Scheme Code', 'lsvrtheme' ),
				'subtitle' => __( 'Please refer to the documentation to learn how to generate it', 'lsvrtheme' ),
                'required'  => array( 'skin_custom_enabled', "=", 1 )
			),

		),
	);

    /* -------------------------------------------------------------------------
        MISC
    ------------------------------------------------------------------------- */

	$this->sections[] = array(
		'title'     => __( 'Misc', 'lsvrtheme' ),
		'icon'      => 'el-icon-cog',
		'fields'    => array(

            // FAVICON
            array(
                'id' => 'favicon',
				'type' => 'media',
				'title' => __( 'Favicon', 'lsvrtheme' ),
				'subtitle' => __( '64px x 64px .PNG file.', 'lsvrtheme' ),
				'mode' => false
			),

            // PAGE 404 CONTENT
            array(
                'id' => 'page404_content',
				'type' => 'editor',
				'title' => __( 'Page 404 Text', 'lsvrtheme' ),
				'default' => 'The page you are looking for is no longer available or has been moved'
			),

            // DEFAULT PAGINATION
            array(
                'id' => 'pagination_default_enable',
				'type' => 'switch',
				'title' => __( 'Default Pagination', 'lsvrtheme' ),
				'subtitle' => __( 'Useful if you are using plugin which is not compatible with theme\'s custom pagination', 'lsvrtheme' ),
				'on' => __( 'Enable', 'lsvrtheme' ),
				'off' => __( 'Disable', 'lsvrtheme' ),
				'default' => 0
			),

            // REDIRECT AFTER LOGIN
            array(
                'id' => 'login_redirect_home',
                'type' => 'switch',
                'title' => __( 'Redirect After Login', 'lsvrtheme' ),
                'subtitle' => __( 'Will redirect users to home page after they log in', 'lsvrtheme' ),
                'on' => __( 'Enable', 'lsvrtheme' ),
                'off' => __( 'Disable', 'lsvrtheme' ),
                'default' => 0
            ),

		),
	);

	$this->sections[] = array(
		'type' => 'divide',
	);

    /* -------------------------------------------------------------------------
        CUSTOM CSS
    ------------------------------------------------------------------------- */

    $this->sections[] = array(
        'title' => __( 'Custom CSS/JS', 'lsvrtheme' ),
		'icon' => 'el-icon-cogs',
        'fields' => array(

			// CSS
			array(
				'id'        => 'custom_css_code',
				'type'      => 'ace_editor',
				'title'     => __( 'CSS Code', 'lsvrtheme' ),
				'subtitle'  => __( 'Paste your CSS code here.', 'lsvrtheme' ),
				'mode'      => 'css',
				'theme'     => 'chrome',
			),

			// JS
			array(
				'id'        => 'custom_js_code',
				'type'      => 'ace_editor',
				'title'     => __( 'JS Code', 'lsvrtheme' ),
				'subtitle'  => __( 'Paste your JS code here.', 'lsvrtheme' ),
				'mode'      => 'javascript',
				'theme'     => 'chrome',
			),

            // custom code
            array(
                'id' => 'custom_any_code',
				'type' => 'textarea',
				'title' => __( 'Any Custom Code', 'lsvrtheme' ),
                'subtitle' => __( 'This field can be used for adding any code which contains &lt;script&gt;&lt;/script&gt; tags. For example Google Analytics code.', 'lsvrtheme' )
			)

        )
    );

// SECTIONS END

            $theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'lsvrtheme') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'lsvrtheme') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'lsvrtheme') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'lsvrtheme') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            if (file_exists(dirname(__FILE__) . '/../README.md')) {
                $this->sections['theme_docs'] = array(
                    'icon'      => 'el-icon-list-alt',
                    'title'     => __('Documentation', 'lsvrtheme'),
                    'fields'    => array(
                        array(
                            'id'        => '17',
                            'type'      => 'raw',
                            'markdown'  => true,
                            'content'   => file_get_contents(dirname(__FILE__) . '/../README.md')
                        ),
                    ),
                );
            }

            $this->sections[] = array(
                'title'     => __('Import / Export', 'lsvrtheme'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'lsvrtheme'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );

            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', 'lsvrtheme'),
                //'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'lsvrtheme'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );

            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'lsvrtheme'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'lsvrtheme'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'lsvrtheme')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'lsvrtheme'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'lsvrtheme')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'lsvrtheme');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'theme_options',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Theme Options', 'lsvrtheme'),
                'page_title'        => __('Theme Options', 'lsvrtheme'),

                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyDCOyIiq-EGJPTCJbrg2NeFDGd59ouIL3w', // Must be defined to add google fonts to the typography module

                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                //$this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'lsvrtheme'), $v);
            } else {
                //$this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'lsvrtheme');
            }

            // Add content after the form.
            //$this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'lsvrtheme');
        }

    }

    global $reduxConfig;
    $reduxConfig = new Redux_Framework_Lsvrtheme_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
