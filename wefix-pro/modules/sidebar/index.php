<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixProSidebar' ) ) {
    class WeFixProSidebar {

        private static $_instance = null;
        private $global_layout  = '';
        private $global_sidebar = '';
        private $hide_standard_sidebar   = '';

        private $sidebar_post_types = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->global_layout  = wefix_customizer_settings('global_sidebar_layout');
            $this->global_sidebar = wefix_customizer_settings('global_sidebar');
            $this->hide_standard_sidebar = wefix_customizer_settings('hide_standard_sidebar');

            if(empty( $this->global_sidebar ) && $this->hide_standard_sidebar){
                $this->global_layout = 'content-full-width';
            }

            $this->sidebar_post_types = apply_filters( 'sidebar_post_types', array( 'post', 'page', 'product', 'wdt_services') );

            $this->load_modules();
            $this->frontend();
        }

        function load_modules() {
            include_once WEFIX_PRO_DIR_PATH.'modules/sidebar/customizer/index.php';
            include_once WEFIX_PRO_DIR_PATH.'modules/sidebar/metabox/index.php';
        }

        function frontend() {
            add_action('wefix_after_main_css', array( $this, 'enqueue_assets' ) );
            add_filter('wefix_primary_classes', array( $this, 'primary_classes' ), 20 );
            add_filter('wefix_secondary_classes', array( $this, 'secondary_classes' ), 20 );
            add_filter('wefix_active_sidebars', array( $this, 'active_sidebars' ), 20 );
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-sidebar', WEFIX_PRO_DIR_URL . 'modules/sidebar/assets/css/sidebar.css', false, WEFIX_PRO_VERSION, 'all' );
            $id       = get_the_ID();
            $settings = get_post_meta( $id, '_wefix_layout_settings', true );
            $settings = is_array( $settings ) ? array_filter( $settings ) : array();

            if( (function_exists('is_shop') && is_shop()) || ( isset($settings['sticky_sidebar'] ) && !empty($settings['sticky_sidebar'] ) )|| ( isset($settings['layout'] ) && !empty($settings['layout'] ) && $settings['layout'] == 'global-sidebar-layout' ) ) {
                wp_enqueue_style( 'sidebar', WEFIX_PRO_DIR_URL . 'modules/sidebar/assets/css/sidebar.css', false, WEFIX_PRO_VERSION, 'all' );
                wp_enqueue_script( 'theia-sticky-sidebar', WEFIX_PRO_DIR_URL . 'assets/js/theia-sticky-sidebar.min.js', array('jquery'), WEFIX_PRO_VERSION, true );
                wp_enqueue_script( 'sidebar-sticky', WEFIX_PRO_DIR_URL . 'modules/sidebar/assets/js/side-bar.js', array('theia-sticky-sidebar'), WEFIX_PRO_VERSION, true );
            }
        }

        function primary_classes( $primary_class ) {

            if( is_singular( $this->sidebar_post_types )  ) {
                $settings = get_post_meta( get_queried_object_id(), '_wefix_layout_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                if( isset( $settings['layout'] ) ) {
                    if( $settings['layout'] == 'content-full-width' ) {
                        $primary_class = 'content-full-width';
                    }elseif( $settings['layout'] == 'with-left-sidebar' || $settings['layout'] == 'with-right-sidebar' ) {
                        $sidebars      = isset( $settings['sidebars'] ) ? $settings['sidebars'] : array();
                        $primary_class = count( $sidebars ) ? $settings['layout'] : 'content-full-width';
                    }elseif( $settings['layout'] == 'global-sidebar-layout' ) {
                        $primary_class = $this->global_layout;
                    }
                } else {
                    $primary_class = $this->global_layout;
                }
            } else if( is_post_type_archive('post') || is_search() || is_category() || is_tag() || is_home() || is_author() || is_year() || is_month() || is_day() || is_time() || is_tax('post_format') ) {
                $primary_class = $this->global_layout;
            }

            if( $primary_class == 'with-left-sidebar' ) {
                $primary_class = 'page-with-sidebar with-left-sidebar';
            }elseif( $primary_class == 'with-right-sidebar' ) {
                $primary_class = 'page-with-sidebar with-right-sidebar';
            }

            return $primary_class;
        }

        function secondary_classes( $secondary_class ) {
            if( is_singular( $this->sidebar_post_types )  ) {
                $settings = get_post_meta( get_queried_object_id(), '_wefix_layout_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                if( isset( $settings['layout'] ) ) {
                    if( $settings['layout'] == 'global-sidebar-layout' ) {
                        $secondary_class = $this->global_layout;
                    } else {
                        $sidebars      = isset( $settings['sidebars'] ) ? $settings['sidebars'] : array();
                        $secondary_class = count( $sidebars ) ? $settings['layout'] : '';
                    }
                } else{
                    $secondary_class = $this->global_layout;
                }
            } else if( is_post_type_archive('post') || is_search() || is_category() || is_tag() || is_home() || is_author() || is_year() || is_month() || is_day() || is_time() || is_tax('post_format') ) {
            	$secondary_class = $this->global_layout;
            }

            if( $secondary_class == 'with-left-sidebar' ) {
                $secondary_class = 'secondary-sidebar secondary-has-left-sidebar leftSidebar';
            }elseif( $secondary_class == 'with-right-sidebar' ) {
                $secondary_class = 'secondary-sidebar secondary-has-right-sidebar rightSidebar';
            }

            return $secondary_class;
        }

        function active_sidebars( $sidebars = array() ) {

            if( is_singular( $this->sidebar_post_types )  ) {
                $settings = get_post_meta( get_queried_object_id(), '_wefix_layout_settings', true );
                $settings = is_array( $settings ) ? array_filter( $settings ) : array();

                if( isset( $settings['layout'] ) ) {
                    if( $settings['layout'] == 'global-sidebar-layout' ) {
                        $global_sidebar = $this->global_sidebar;
                        if( $global_sidebar ) {
                            $sidebars[] = $global_sidebar;
                        }
                        if($this->hide_standard_sidebar) {
                            unset($sidebars[array_search('wefix-standard-sidebar-1', $sidebars)]);
                        }
                    } else {
                        if(isset( $settings['sidebars'] )){
                            $sidebars = $settings['sidebars'];
                        }
                    }
                } else {
                    $sidebars[] = $this->global_sidebar;
                    if($this->hide_standard_sidebar) {
                        unset($sidebars[array_search('wefix-standard-sidebar-1', $sidebars)]);
                    }
                }
            } else if( is_post_type_archive('post') || is_search() || is_category() || is_tag() || is_home() || is_author() || is_year() || is_month() || is_day() || is_time() || is_tax('post_format') ) {
	            $global_sidebar = $this->global_sidebar;
	            if( $global_sidebar ) {
	                $sidebars[] = $global_sidebar;
	            }
                if($this->hide_standard_sidebar) {
                    unset($sidebars[array_search('wefix-standard-sidebar-1', $sidebars)]);
                }
            }

            return array_filter( $sidebars );

        }
    }
}

WeFixProSidebar::instance();