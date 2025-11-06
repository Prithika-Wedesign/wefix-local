<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Pro_Woo_Sidebar' ) ) {
    class WeFix_Pro_Woo_Sidebar {

        private static $_instance = null;
        private $global_layout    = '';
        private $global_sidebar   = '';
        private $global_shop_sidebar   = '';
        private $hide_standard_sidebar   = '';

        private $primary_class   = '';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->global_layout  = wefix_customizer_settings('global_sidebar_layout');
            $this->global_sidebar = wefix_customizer_settings('global_sidebar');
            $this->global_shop_sidebar = wefix_customizer_settings('global_shop_sidebar');
            $this->hide_standard_sidebar = wefix_customizer_settings('hide_standard_sidebar');

            if(empty( $this->global_sidebar ) && $this->hide_standard_sidebar){
                $this->global_layout = 'content-full-width';
            }

            $this->frontend();

        }

        function frontend() {
            add_filter('wefix_primary_classes', array( $this, 'primary_classes' ) );
            add_filter('wefix_secondary_classes', array( $this, 'secondary_classes' ) );
            add_filter('wefix_active_sidebars', array( $this, 'active_sidebars' ), 20 );
            add_filter('wefix_woo_loop_column_class', array( $this, 'woo_loop_column_class' ), 10, 2 );
        }

        function primary_classes( $primary_class ) {

            if( is_shop()  ) {
                $settings = get_post_meta( get_option('woocommerce_shop_page_id'), '_wefix_layout_settings', true );
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
            }

            if( is_product_category() || is_product_tag() ) {
                $primary_class = $this->global_layout;
            }

            if( $primary_class == 'with-left-sidebar' ) {
                $primary_class = 'page-with-sidebar with-left-sidebar';
            }elseif( $primary_class == 'with-right-sidebar' ) {
                $primary_class = 'page-with-sidebar with-right-sidebar';
            }

            $this->primary_class = $primary_class;

            return $primary_class;
        }

        function secondary_classes( $secondary_class ) {
            if( is_shop()  ) {
                $settings = get_post_meta( get_option('woocommerce_shop_page_id'), '_wefix_layout_settings', true );
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
            }

            if( is_product_category() || is_product_tag() ) {
                $secondary_class = $this->global_layout;
            }

            if( $secondary_class == 'with-left-sidebar' ) {
                $secondary_class = 'secondary-sidebar secondary-has-left-sidebar';
            }elseif( $secondary_class == 'with-right-sidebar' ) {
                $secondary_class = 'secondary-sidebar secondary-has-right-sidebar';
            }

            return $secondary_class;
        }

        function active_sidebars( $sidebars = array() ) {

            if( is_shop()  ) {
                $settings = get_post_meta( get_option('woocommerce_shop_page_id'), '_wefix_layout_settings', true );
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
                }else{
                    $sidebars[] = $this->global_sidebar;
                    if($this->hide_standard_sidebar) {
                        unset($sidebars[array_search('wefix-standard-sidebar-1', $sidebars)]);
                    }
                }
            }

            if( is_product_category() || is_product_tag() ) {
                $sidebars[] = $this->global_shop_sidebar;
                if($this->hide_standard_sidebar) {
                    unset($sidebars[array_search('wefix-standard-sidebar-1', $sidebars)]);
                }
            }

            return array_filter( $sidebars );
        }

        function woo_loop_column_class( $class, $columns ) {

            if(isset($this->primary_class) && ($this->primary_class == 'page-with-sidebar with-left-sidebar' || $this->primary_class == 'page-with-sidebar with-right-sidebar')) {

                switch( $columns ) {
                    case 1:
                        $class = 'wdt-col wdt-col-xs-12 wdt-col-sm-12 wdt-col-md-12 wdt-col-lg-12';
                    break;

                    case 2:
                        $class = 'wdt-col wdt-col-xs-12 wdt-col-sm-12 wdt-col-md-6 wdt-col-qxlg-6 wdt-col-qxlg-6 wdt-col-lg-6';
                    break;

                    case 3:
                    case 4:
                    default:
                        $class = 'wdt-col wdt-col-xs-12 wdt-col-sm-12 wdt-col-md-6 wdt-col-qxlg-4 wdt-col-hxlg-4 wdt-col-lg-4';
                    break;
                }

            }

            return $class;

        }
    }
}

WeFix_Pro_Woo_Sidebar::instance();