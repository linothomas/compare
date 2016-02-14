<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: https://docs.reduxframework.com
 * */

global $compare_opts;

if (!class_exists('Compare_Options')) {

    class Compare_Options
    {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct()
        {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (true == Redux_Helpers::isTheme(__FILE__)) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array(
                    $this,
                    'initSettings'
                ), 10);
            }

        }

        public function initSettings()
        {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo()
        {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(
                    ReduxFrameworkPlugin::instance(),
                    'admin_notices'
                ));
            }
        }

        public function setSections()
        {

            /**
             * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns      = array();

            if (is_dir($sample_patterns_path)):
                if ($sample_patterns_dir = opendir($sample_patterns_path)):
                    $sample_patterns = array();
                    while (($sample_patterns_file = readdir($sample_patterns_dir)) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name              = explode('.', $sample_patterns_file);
                            $name              = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[] = array(
                                'alt' => $name,
                                'img' => $sample_patterns_url . $sample_patterns_file
                            );
                        }
                    }
                endif;
            endif;

            /////////////////////////////////////////////////////////////////////////////// 1. OVERALL //

            $this->sections[] = array(
                'title' => __('Overall Setup', 'compare'),
                'desc' => __('Here in overall setup section you can edit basic settings related to overall website.', 'compare'),
                'icon' => 'el-icon-cogs',
                'indent' => true,
                'fields' => array()
            );
            // SEO //
            $this->sections[] = array(
                'title' => __('Permalinks', 'compare'),
                'desc' => __('Set permalinks options.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'trans_keyword',
                        'type' => 'text',
                        'title' => __('Keyword Slug', 'compare'),
                        'desc' => __('Input keyword slug.', 'compare'),
                        'default' => 'keyword'
                    ),                    
                    array(
                        'id' => 'trans_product',
                        'type' => 'text',
                        'title' => __('Product Slug', 'compare'),
                        'desc' => __('Input products slug.', 'compare'),
                        'default' => 'product'
                    ),
                    array(
                        'id' => 'trans_product_cat',
                        'type' => 'text',
                        'title' => __('Product Category Slug', 'compare'),
                        'desc' => __('Input products category slug.', 'compare'),
                        'default' => 'product-cat'
                    ),
                    array(
                        'id' => 'trans_product_brand',
                        'type' => 'text',
                        'title' => __('Product Brand Slug', 'compare'),
                        'desc' => __('Input products brand slug.', 'compare'),
                        'default' => 'product-brand'
                    ),
                    array(
                        'id' => 'trans_product_tag',
                        'type' => 'text',
                        'title' => __('Product Tag Slug', 'compare'),
                        'desc' => __('Input products tag slug.', 'compare'),
                        'default' => 'product-tag'
                    ),
                )
            );
            // Theme Usage //
            $this->sections[] = array(
                'title' => __('Search Bar', 'compare'),
                'desc' => __('Choose will you use search bar.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'enable_search_bar',
                        'type' => 'select',
                        'options' => array(
                            'no' => __('No', 'compare'),
                            'yes' => __('Yes', 'compare')
                        ),
                        'title' => __('Enable Search Bar', 'compare'),
                        'desc' => __('Choose will you use search bar or not.', 'compare'),
                        'default' => 'no'
                    ),

                    array(
                        'id' => 'search_bar_categories',
                        'type' => 'select',
                        'multi' => true,
                        'data' => 'category',
                        'args' => array( 'hide_empty' => false, 'taxonomy' => array('product-cat') ),
                        'title' => __('Search Bar Categories', 'compare'),
                        'desc' => __('Select which categories will be visible in the search bar.', 'compare'),
                    ),                    
                )
            );

            // SEO //
            $this->sections[] = array(
                'title' => __('404 Page', 'compare'),
                'desc' => __('Set 404 page options.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'error_img',
                        'type' => 'media',
                        'title' => __('Error page image', 'compare'),
                        'desc' => __('Select image which will be dispalyed on the 404 page.', 'compare'),
                    ),
                )
            );

            // Direction //
            $this->sections[] = array(
                'title' => __('Content Direction', 'compare'),
                'desc' => __('Choose overall website text direction which can be RTL (right to left) or LTR (left to right).', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'direction',
                        'type' => 'select',
                        'options' => array(
                            'ltr' => __('LTR', 'compare'),
                            'rtl' => __('RTL', 'compare')
                        ),
                        'title' => __('Choose Site Content Direction', 'compare'),
                        'desc' => __('Choose overall website text direction which can be RTL (right to left) or LTR (left to right).', 'compare'),
                        'default' => 'ltr'
                    )

                )
            );


            // Favicon //
            $this->sections[] = array(
                'title' => __('White Titles', 'compare'),
                'desc' => __('White titles settings.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'white_title_icon',
                        'type' => 'select',
                        'title' => __('White Titles Icon', 'compare'),
                        'compiler' => 'true',
                        'options' => compare_awesome_icons_list(),
                        'desc' => __('Select an icon for the white titles.', 'compare'),
                        'default' => 'list-ul'
                    )


                )
            );

            $this->sections[] = array(
                'title' => __('Appearance', 'compare'),
                'desc' => __('Set up looks of the site.', 'compare'),
                'icon' => '',
                'indent' => true,
                'fields' => array(
                    array(
                        'id' => 'main_color',
                        'type' => 'color',
                        'title' => __('Main Color', 'compare'),
                        'desc' => __('Select main color', 'compare'),
                        'transparent' => false,
                        'default' => '#36a0c7'
                    ),
                    array(
                        'id' => 'main_color_font',
                        'type' => 'color',
                        'title' => __('Main Font Color', 'compare'),
                        'desc' => __('Select font color for the items who have main color as their background', 'compare'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'secondary_color',
                        'type' => 'color',
                        'title' => __('Secondary Color', 'compare'),
                        'desc' => __('Select secondary background color for the buttons', 'compare'),
                        'transparent' => false,
                        'default' => '#00a88e'
                    ),
                    array(
                        'id' => 'secondary_font_color',
                        'type' => 'color',
                        'title' => __('Secondary Font Color', 'compare'),
                        'desc' => __('Select font color for the elements with secondary color as their background.', 'compare'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'secondary_color_hvr',
                        'type' => 'color',
                        'title' => __('Secondary Color On Hover', 'compare'),
                        'desc' => __('Select secondary background color for the buttons on hover', 'compare'),
                        'transparent' => false,
                        'default' => '#008470'
                    ),
                    array(
                        'id' => 'secondary_font_color_hvr',
                        'type' => 'color',
                        'title' => __('Secondary Font Color On Hover', 'compare'),
                        'desc' => __('Select font color for the elements with secondary hover color as their background.', 'compare'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),

                    array(
                        'id' => 'top_bar_bg_color',
                        'type' => 'color',
                        'title' => __('Top Bar Bg Color', 'compare'),
                        'desc' => __('Select background color for the top bar and categories search.', 'compare'),
                        'transparent' => false,
                        'default' => '#162b32'
                    ),
                    array(
                        'id' => 'top_bar_font_color',
                        'type' => 'color',
                        'title' => __('Top Bar Font Color', 'compare'),
                        'desc' => __('Select font color for the top bar.', 'compare'),
                        'transparent' => false,
                        'default' => '#889ca3'
                    ),
                    array(
                        'id' => 'submenu_bg_color',
                        'type' => 'color',
                        'title' => __('Submenu Background Color', 'compare'),
                        'desc' => __('Select backgruond color for the submenu.', 'compare'),
                        'transparent' => false,
                        'default' => '#162b32'
                    ),                    
                    array(
                        'id' => 'submenu_font_color',
                        'type' => 'color',
                        'title' => __('Submenu Font Color', 'compare'),
                        'desc' => __('Select font color for the submenu.', 'compare'),
                        'transparent' => false,
                        'default' => '#ffffff'
                    ),
                    array(
                        'id' => 'submenu_bottom_border_color',
                        'type' => 'color',
                        'title' => __('Submenu Border Bottom Color', 'compare'),
                        'desc' => __('Select bottom border for the submenu.', 'compare'),
                        'transparent' => false,
                        'default' => '#1a3137'
                    ),
                    array(
                        'id' => 'categories_bg_color_hvr',
                        'type' => 'color',
                        'title' => __('Categories Background Color On Hover', 'compare'),
                        'desc' => __('Select backgruond color for the categories on hover.', 'compare'),
                        'transparent' => false,
                        'default' => '#162b32'
                    ),                    
                    array(
                        'id' => 'categories_font_color_hvr',
                        'type' => 'color',
                        'title' => __('Categories Font Color On Hover', 'compare'),
                        'desc' => __('Select font color for the categories on hover.', 'compare'),
                        'transparent' => false,
                        'default' => '#ffffff'
                    ),
                    array(
                        'id' => 'copyrights_bg_color',
                        'type' => 'color',
                        'title' => __('Copyrights Background Color', 'compare'),
                        'desc' => __('Select background color for the copyrights.', 'compare'),
                        'transparent' => false,
                        'default' => '#14272d'
                    ),
                    array(
                        'id' => 'copyrights_font_color',
                        'type' => 'color',
                        'title' => __('Copyrights Font Color', 'compare'),
                        'desc' => __('Select font color for the copyrights.', 'compare'),
                        'transparent' => false,
                        'default' => '#3b5a64'
                    ),
                    array(
                        'id' => 'copyrights_link_color',
                        'type' => 'color',
                        'title' => __('Copyrights Link Color', 'compare'),
                        'desc' => __('Select link color for the copyrights.', 'compare'),
                        'transparent' => false,
                        'default' => '#36a0c7'
                    ),
                    array(
                        'id' => 'font_family',
                        'type' => 'select',
                        'options' => compare_google_fonts(),
                        'title' => __('Site Main Font', 'compare'),
                        'desc' => __('Select main font for the site.', 'compare'),
                        'default' => 'Droid Sans'
                    ),
                )
            );

            /////////////////////////////////////////////////////////////////////////////////////// 2. TOP BAR //
            // General //
            $this->sections[] = array(
                'title' => __('Top Bar', 'compare'),
                'desc' => __('Basic settings for top bar.', 'compare'),
                'icon' => '',
                'fields' => array(

                    array(
                        'id' => 'show_top_bar',
                        'type' => 'select',
                        'title' => __('Show Top Bar', 'compare'),
                        'desc' => __('Enable or disable top bar', 'compare'),
                        'options' => array(
                            'yes' => __('Yes', 'compare'),
                            'no' => __('No', 'compare')
                        ),
                        'default' => 'no'
                    ),
                    array(
                        'id' => 'top_bar_facebook_link',
                        'type' => 'text',
                        'title' => __('Facebook Link', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Link to your facebook page', 'compare')
                    ),
                    array(
                        'id' => 'top_bar_twitter_link',
                        'type' => 'text',
                        'title' => __('Twitter link', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Link to your twitter page', 'compare')
                    ),
                    array(
                        'id' => 'top_bar_google_link',
                        'type' => 'text',
                        'title' => __('Google link', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Link to your google+ page', 'compare')
                    ),
                    array(
                        'id' => 'top_bar_mail',
                        'type' => 'text',
                        'title' => __('Top Bar Mail', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input mail which will be displayed on the top bar', 'compare'),
                    ),
                    array(
                        'id' => 'top_bar_phone',
                        'type' => 'text',
                        'title' => __('Top Bar Phone Number', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input phone number which will be displayed on the top bar', 'compare'),
                    ),

                )
            );


            //////////////////////////////////////////////////////////////////////////// 3. HEADER //
            $this->sections[] = array(
                'title' => __('Header', 'compare'),
                'desc' => __('Header Compare Settings', 'compare'),
                'icon' => '',
                'fields' => array()
            );

            // Logo //
            $this->sections[] = array(
                'title' => __('Logo', 'compare'),
                'desc' => __('Upload logo for website.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'site_logo',
                        'type' => 'media',
                        'title' => __('Site Logo', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Upload site logo', 'compare')
                    ),
                    array(
                        'id' => 'site_logo_padding',
                        'type' => 'text',
                        'title' => __('Logo Padding', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Set padding for logo if needed ( set 0 if not )', 'compare')
                    )


                )
            );

            // Navigation //
            $this->sections[] = array(
                'title' => __('Navigation', 'compare'),
                'desc' => __('Set up basic things for navigation.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'enable_sticky',
                        'type' => 'select',
                        'title' => __( 'Enable Sticky Navigation', 'compare' ),
                        'compiler' => 'true',
                        'options' => array(
                            'yes' => __( 'Yes', 'compare' ),
                            'no' => __( 'No', 'compare' ),
                        ),
                        'desc' => __( 'Show or hide sticky navigation', 'compare' ),
                        'std' => 'no'
                    )                    

                )
            );

            // Mega Menu //
            $this->sections[] = array(
                'title' => __('Mega Menu', 'compare'),
                'desc' => __('Set up mega menu.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'mega_menu_sidebars',
                        'type' => 'text',
                        'title' => __('Mega Menu Sidebars', 'compare'),
                        'desc' => __('Input number of mega menu sidebars you wish to use.', 'compare'),
                        'default' => '5'
                    ),
                )
            );


            // Copyrights //
            $this->sections[] = array(
                'title' => __('Copyrights', 'compare'),
                'desc' => __('Copyrights content.', 'compare'),
                'icon' => '',
                'fields' => array(
                    array(
                        'id' => 'footer_copyrights',
                        'type' => 'text',
                        'title' => __('Copyrights', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input copyrights', 'compare')
                    ),
                    array(
                        'id' => 'footer_copyrights_image',
                        'type' => 'media',
                        'title' => __('Copyrights Right Image', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Select copyrights image to the right', 'compare')
                    )
                )
            );

            $this->sections[] = array(
                'title' => __('Pages', 'compare'),
                'desc' => __('Set options for various pages.', 'compare'),
                'icon' => '',
            );

            // Search Page //
            $this->sections[] = array(
                'title' => __('Search Page', 'compare'),
                'desc' => __('Set search page options.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'search_sidebar_location',
                        'type' => 'select',
                        'options' => array(
                            'left' => __( 'Left', 'compare' ),
                            'right' => __( 'Right', 'compare' ),
                        ),
                        'title' => __('Sidebar Position', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Select position of the sidebar on the search page.', 'compare'),
                        'default' => 'left'
                    ),

                    array(
                        'id' => 'search_categories_visible',
                        'type' => 'text',
                        'title' => __('Visible Search Categories', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Number of visible categories to show on the search page. All will be visible once view more button is pressed.', 'compare'),
                        'default' => '10'
                    ),

                    array(
                        'id' => 'search_brands_visible',
                        'type' => 'text',
                        'title' => __('Visible Search Brands', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Number of visible brands to show on the search page. All will be visible once view more button is pressed.', 'compare'),
                        'default' => '10'
                    ),

                    array(
                        'id' => 'product_box_style',
                        'type' => 'select',
                        'options' => array(
                            'grid' => __( 'Grid', 'compare' ),
                            'list' => __( 'List', 'compare' ),
                        ),
                        'title' => __('Product Box Style', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Select style of ther product boxes.', 'compare'),
                        'default' => 'grid'
                    ),   

                    array(
                        'id' => 'price_ranges',
                        'type' => 'textarea',
                        'title' => __('Price Ranges', 'compare'),
                        'desc' => __('Input price ranges available for search. One per line to add between put for example 0-1 and for the more then put for example 5.', 'compare')
                    ),

                )
            );

            // All Categories Page //
            $this->sections[] = array(
                'title' => __('All Categories', 'compare'),
                'desc' => __('Set options for the all categories page.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'all_categories_sortby',
                        'type' => 'select',
                        'options' => array(
                            'name' => __( 'Name', 'compare' ),
                            'count' => __( 'Count', 'compare' ),
                            'slug' => __( 'Slug', 'compare' ),
                        ),
                        'title' => __('Sort By', 'compare'),
                        'desc' => __('Select field by which to sort the all categories listing.', 'compare'),
                        'default' => 'name'
                    ),
                    array(
                        'id' => 'all_categories_sort',
                        'type' => 'select',
                        'options' => array(
                            'desc' => __( 'Descending', 'compare' ),
                            'asc' => __( 'Ascending', 'compare' ),
                        ),
                        'title' => __('Sort Order', 'compare'),
                        'desc' => __('Select sort order for the all categories page.', 'compare'),
                        'default' => 'asc'
                    ),
                )
            );

            // All Brands Page //
            $this->sections[] = array(
                'title' => __('All Brands', 'compare'),
                'desc' => __('Set options for the all brands page.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'all_brands_sortby',
                        'type' => 'select',
                        'options' => array(
                            'name' => __( 'Name', 'compare' ),
                            'count' => __( 'Count', 'compare' ),
                            'slug' => __( 'Slug', 'compare' ),
                        ),
                        'title' => __('Sort By', 'compare'),
                        'desc' => __('Select field by which to sort the all brands listing.', 'compare'),
                        'default' => 'name'
                    ),
                    array(
                        'id' => 'all_brands_sort',
                        'type' => 'select',
                        'options' => array(
                            'desc' => __( 'Descending', 'compare' ),
                            'asc' => __( 'Ascending', 'compare' ),
                        ),
                        'title' => __('Sort Order', 'compare'),
                        'desc' => __('Select sort order for the all brands page.', 'compare'),
                        'default' => 'asc'
                    ),
                )
            );

            // REGISTRATION PAGE //
            $this->sections[] = array(
                'title' => __('Registration Page', 'compare'),
                'desc' => __('Set registration page options.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'packages',
                        'type' => 'textarea',
                        'title' => __('Input Price Packages', 'compare'),
                        'desc' => __('Input price packages in the form NAME|DAYS|PRICE|ACTIVE for example <strong>Monthly|30|25.99|A</strong> or <strong>Monthly|30|25.99</strong> use numbers only.', 'compare'),
                    ),
                    array(
                        'id' => 'email_sender',
                        'type' => 'text',
                        'title' => __('Email Of Sender', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input email address you wish to show on the email messages.', 'compare')
                    ),
                    array(
                        'id' => 'name_sender',
                        'type' => 'text',
                        'title' => __('Name Of Sender', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input name you wish to show on the email messages.', 'compare')
                    )                    

                )
            );

            // Contact Details //
            $this->sections[] = array(
                'title' => __('Contact Page', 'compare'),
                'desc' => __('Contact page settings', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'contact_mail',
                        'type' => 'text',
                        'title' => __('Mail', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input email where sent messages will arrive', 'compare')
                    ),
                    array(
                        'id' => 'contact_form_subject',
                        'type' => 'text',
                        'title' => __('Mail Subject', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input subject for the message.', 'compare')
                    ),
                    array(
                        'id' => 'contact_map',
                        'type' => 'multi_text',
                        'title' => __('Google Map Markers', 'couponxl'),
                        'compiler' => 'true',
                        'desc' => __('Input longitudes and latitudes separated by comma for example 92.3123,-105.54353 (longitude,latitude). <a href="http://www.latlong.net/" target="_blank">Find Long/Lat</a>', 'couponxl')
                    ),
                    array(
                        'id' => 'contact_map_scroll_zoom',
                        'type' => 'select',
                        'title' => __('Disable Scroll Zoom', 'couponxl'),
                        'compiler' => 'true',
                        'options' => array(
                            'no' => __('No', 'couponxl'),
                            'yes' => __('Yes', 'couponxl')
                        ),
                        'desc' => __('Enable or disable zoom on scroll of the contact map.', 'couponxl'),
                        'default' => 'no'
                    )                    

                )
            );



            ///////////////////////////////////////////////////////////////////////////////////////// 10. API //


            // PAYMENTS //
            $this->sections[] = array(
                'title' => __('Payments', 'compare'),
                'desc' => __('Important Payment Settings.', 'compare'),
                'icon' => '',
                'fields' => array(

                    array(
                        'id' => 'unit',
                        'type' => 'text',
                        'title' => __('Main Currency Unit', 'compare'),
                        'desc' => __('Input main currency unit. ($, £, €, руб).', 'compare')
                    ),
                    array(
                        'id' => 'main_unit_abbr',
                        'type' => 'text',
                        'title' => __('Main Currency Unit Abbreviation', 'compare'),
                        'desc' => __('Input main currency unit abbreviation.  (USD, EUR, RUB, AUD, GBP...)', 'compare')
                    ),
                    array(
                        'id' => 'unit_position',
                        'title' => __('Unit Position', 'compare'),
                        'desc' => __('Select position of the unit.', 'compare'),
                        'type' => 'select',
                        'options' => array(
                            'front' => __('Front', 'compare'),
                            'back' => __('Back', 'compare')
                        )
                    ),

                )
            );

            // PayPal API //
            $this->sections[] = array(
                'title' => __('PayPal API', 'compare'),
                'desc' => __('Important PayPal Settings.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'paypal_mode',
                        'type' => 'select',
                        'title' => __('PayPal Mode', 'compare'),
                        'compiler' => 'true',
                        'options' => array(
                            '' => __('Live mode', 'compare'),
                            '.sandbox' => __('Testing mode', 'compare')
                        )
                    ),
                    array(
                        'id' => 'paypal_username',
                        'type' => 'text',
                        'title' => __('Paypal API Username', 'compare'),
                        'desc' => __('Input paypal API username here.', 'compare')
                    ),
                    array(
                        'id' => 'paypal_password',
                        'type' => 'text',
                        'title' => __('Paypal API Password', 'compare'),
                        'desc' => __('Input paypal API password here.', 'compare')
                    ),
                    array(
                        'id' => 'paypal_signature',
                        'type' => 'text',
                        'title' => __('Paypal API Signature', 'compare'),
                        'desc' => __('Input paypal API signature here.', 'compare')
                    )

                )
            );

            // Stripe API //
            $this->sections[] = array(
                'title' => __('Stripe API', 'compare'),
                'desc' => __('Important Stripe Settings.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'stripe_pk_client_id',
                        'type' => 'text',
                        'title' => __('Public Client ID', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input your stripe public client ID', 'compare')
                    ),
                    array(
                        'id' => 'stripe_sk_client_id',
                        'type' => 'text',
                        'title' => __('Secret Client ID', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input your stripe secret client ID', 'compare')
                    ),
                )
            );

            // Skrill API //
            $this->sections[] = array(
                'title' => __('Skrill API', 'compare'),
                'desc' => __('Important Skrill Settings.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'skrill_owner_mail',
                        'type' => 'text',
                        'title' => __('You skrill mail', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input your email which is connected with your skrill account.', 'compare')
                    ),
                    array(
                        'id' => 'skrill_secret_word',
                        'type' => 'text',
                        'title' => __('You skrill secret word', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input your scrill secret word.', 'compare')
                    ),
                )
            );

            // BANK TRANSFER //
            $this->sections[] = array(
                'title' => __('Bank Transfer', 'compare'),
                'desc' => __('Important Bank Transfer Settings.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'bank_account_name',
                        'type' => 'text',
                        'title' => __('Bank Account Name', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input your bank account name', 'compare')
                    ),                    
                    array(
                        'id' => 'bank_name',
                        'type' => 'text',
                        'title' => __('Bank Name', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input your bank name', 'compare')
                    ),
                    array(
                        'id' => 'bank_account_number',
                        'type' => 'text',
                        'title' => __('Bank Account Number', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input your bank account number', 'compare')
                    ),
                    array(
                        'id' => 'bank_sort_number',
                        'type' => 'text',
                        'title' => __('Sort Number', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input your sort number', 'compare')
                    ),
                    array(
                        'id' => 'bank_iban_number',
                        'type' => 'text',
                        'title' => __('IBAN Code', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input your IBAN code', 'compare')
                    ),
                    array(
                        'id' => 'bank_bic_swift_number',
                        'type' => 'text',
                        'title' => __('BIC / Swift Code', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input your BIC / Swift code', 'compare')
                    ),                    
                )
            );

            // MOLLIE //
            $this->sections[] = array(
                'title' => __('iDEAL API', 'compare'),
                'desc' => __('Important Mollie iDEAL Settings.', 'compare'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'mollie_id',
                        'type' => 'text',
                        'title' => __('Mollie ID', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input your mollie ID', 'compare')
                    ),                   
                )
            );

            // Mailchimp API //
            $this->sections[] = array(
                'title' => __('Mail Chimp API', 'compare'),
                'desc' => __('Important PayPal Settings.', 'compare'),
                'icon' => '',
                'fields' => array(

                    array(
                        'id' => 'mail_chimp_api',
                        'type' => 'text',
                        'title' => __('Mail Chimp API', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input API key of your MailChimp. More <a href="http://kb.mailchimp.com/accounts/management/about-api-keys" target="_blank">here</a>', 'compare')
                    ),
                    array(
                        'id' => 'mail_chimp_list_id',
                        'type' => 'text',
                        'title' => __('Mail Chimp List ID', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input ID of the ailchimp list on which the users will subscribe. More <a href="http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id" target="_blank">here</a>', 'compare')
                    )

                )
            );


            // Cron Job //
            $this->sections[] = array(
                'title' => __('Stores Cron Job', 'compare'),
                'desc' => __('Store cron job settings.', 'compare'),
                'icon' => '',
                'fields' => array(

                    array(
                        'id' => 'cron_enable',
                        'type' => 'select',
                        'title' => __('Enable Cron', 'compare'),
                        'options' => array(
                            'no' => __( 'No', 'compare' ),
                            'yes' => __( 'Yes', 'compare' )
                        ),
                        'compiler' => 'true',
                        'desc' => __('Select date  when to start with the crone job', 'compare')
                    ),
                    array(
                        'id' => 'cron_start_date',
                        'type' => 'date',
                        'title' => __('Start Date Of Cron', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Select date  when to start with the crone job', 'compare')
                    ),
                    array(
                        'id' => 'cron_start_time',
                        'type' => 'text',
                        'title' => __('Start Time Of Cron', 'compare'),
                        'compiler' => 'true',
                        'desc' => __('Input time when to start crno job ( format is 24h for example 13:30 )', 'compare')
                    ),                    
                    array(
                        'id' => 'cron_frequency',
                        'type' => 'select',
                        'title' => __('Repeat Cron Job', 'compare'),
                        'options' => array(
                            'daily' => __( 'Daily', 'compare' ),
                            'weekly' => __( 'Meekly', 'compare' ),
                            'monthly' => __( 'Monthly', 'compare' ),
                        ),
                        'compiler' => 'true',
                        'desc' => __('Select date and time when to start with the crone', 'compare'), 
                        'default' => 'daily'
                    ),

                )
            );

            $this->sections[] = array(
                'title' => __('Products', 'compare'),
                'desc' => __('Products Settings.', 'compare'),
                'icon' => '',
                'fields' => array(

                    array(
                        'id' => 'products_per_page',
                        'type' => 'text',
                        'title' => __('Products Per Page', 'compare'),
                        'desc' => __('Input how many products to show per page.', 'compare')
                    ),
                    array(
                        'id' => 'products_single',
                        'type' => 'select',
                        'options' => array(
                            'style1' => __( 'Information In Tabs', 'compare' ),
                            'style2' => __( 'Information In Boxes With Sidebar', 'compare' ),
                            'style3' => __( 'Information In Boxes Without Sidebar', 'compare' ),
                        ),
                        'title' => __('Products Single Layout', 'compare'),
                        'desc' => __('Select layout for the product single page.', 'compare'),
                        'default' => 'style1'
                    ),
                    array(
                        'id' => 'similar_num',
                        'type' => 'text',
                        'title' => __('Number Of Similar Products', 'compare'),
                        'desc' => __('Input how many similar products to show on product single or leave empty to disable.', 'compare'),
                        'default' => '5'
                    ),                    
                )
            );


        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments()
        {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'compare_options',
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'),
                // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'),
                // Version that appears at the top of your panel
                'menu_type' => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true,
                // Show the sections below the admin menu item or not
                'menu_title' => __('Compare', 'redux-framework-demo'),
                'page_title' => __('Compare', 'redux-framework-demo'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly' => false,
                // Must be defined to add google fonts to the typography module
                'async_typography' => true,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar' => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon' => 'dashicons-portfolio',
                // Choose an icon for the admin bar menu
                'admin_bar_priority' => 50,
                // Choose an priority for the admin bar menu
                'global_variable' => '',
                // Set a different name for your global variable other than the opt_name
                'dev_mode' => false,
                // Show the time the page took to load, etc
                'update_notice' => true,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer' => true,
                // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority' => null,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options',
                // Permissions needed to access the options panel.
                //'menu_icon'            => get_template_directory_uri().'/images/icon.png',
                // Specify a custom URL to an icon
                'last_tab' => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options',
                // Page slug used to denote the panel
                'save_defaults' => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show' => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info' => false,
                // REMOVE

                // HINTS
                'hints' => array(
                    'icon' => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color' => 'lightgray',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'light',
                        'shadow' => true,
                        'rounded' => false,
                        'style' => ''
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right'
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'mouseover'
                        ),
                        'hide' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'click mouseleave'
                        )
                    )
                )
            );


        }

    }

    global $compare_opts;
    $compare_opts = new Compare_Options();
} else {
    echo "The class named Compare_Options has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
}