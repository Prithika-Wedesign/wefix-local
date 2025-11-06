<?php

/**
 * Listing Framework Archive Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Woo_Listing_Fw_Archive_Sidebar_Settings' ) ) {

    class WeFix_Woo_Listing_Fw_Archive_Sidebar_Settings {

        private static $_instance = null;

        private $shop_custom_options = array ();
        private $global_layout = '';
        private $global_sidebar = '';
        private $primary_class = '';
        private $secondary_class = '';
        private $opts = '';
        private $cs_custom_layout = 'global-sidebar-layout';
        private $cs_custom_sidebars = array ();

        function __construct($shop_custom_options) {

            $this->shop_custom_options = $shop_custom_options;
            $this->global_layout  = wefix_customizer_settings('global_sidebar_layout');
            $this->global_sidebar = wefix_customizer_settings('global_sidebar');
            $this->hide_standard_sidebar = wefix_customizer_settings('hide_standard_sidebar');

            if(empty( $this->global_sidebar ) && $this->hide_standard_sidebar){
                $this->global_layout = 'content-full-width';
            }

            $this->cs_custom_layout = $this->shop_custom_options['layout'];
            $this->cs_custom_sidebars = $this->shop_custom_options['sidebars'];
            $this->frontend();

        }

        function frontend() {
            add_filter('wefix_primary_classes', array( $this, 'primary_classes' ), 50 );
            add_filter('wefix_secondary_classes', array( $this, 'secondary_classes' ), 50 );
            add_filter('wefix_active_sidebars', array( $this, 'active_sidebars' ), 50 );
            add_filter('wefix_woo_loop_column_class', array( $this, 'woo_loop_column_class' ), 50, 2 );
        }

        function primary_classes( $primary_class ) {

            if(is_shop()) {

                if($this->cs_custom_layout == 'global-sidebar-layout' || $this->cs_custom_layout == '') {
                    $primary_layout = $this->global_layout;
                } else {
                    $primary_layout = $this->cs_custom_layout;
                }

                if($primary_layout == 'content-full-width') {
                    $primary_class = 'content-full-width';
                } else if($primary_layout == 'with-left-sidebar') {
                    $primary_class = 'page-with-sidebar with-left-sidebar';
                } elseif($primary_layout == 'with-right-sidebar') {
                    $primary_class = 'page-with-sidebar with-right-sidebar';
                }

            }

            $this->primary_class = $primary_class;

            return $primary_class;

        }

        function secondary_classes( $secondary_class ) {

            if(is_shop()) {

                if($this->cs_custom_layout == 'global-sidebar-layout' || $this->cs_custom_layout == '') {
                    $secondary_layout = $this->global_layout;
                } else {
                    $secondary_layout = $this->cs_custom_layout;
                }

                if($secondary_layout == 'with-left-sidebar') {
                    $secondary_class = 'secondary-sidebar secondary-has-left-sidebar';
                } elseif($secondary_layout == 'with-right-sidebar') {
                    $secondary_class = 'secondary-sidebar secondary-has-right-sidebar';
                }

            }

            $this->secondary_class = $secondary_class;

            return $secondary_class;

        }

        function active_sidebars( $sidebars = array() ) {

            $sidebars = array();

            if(is_shop()) {

                if($this->primary_class != 'content-full-width') {
                    if($this->cs_custom_layout == 'global-sidebar-layout' || $this->cs_custom_layout == '') {
                        $global_sidebar = $this->global_sidebar;
                        if($global_sidebar) {
                            $sidebars[] = $global_sidebar;
                        }
                        if($this->hide_standard_sidebar) {
                            unset($sidebars[array_search('wefix-standard-sidebar-1', $sidebars)]);
                        }
                    } else {
                        if(isset($this->cs_custom_sidebars)){
                            $sidebars = $this->cs_custom_sidebars;
                        }
                    }
                }

            }

            return array_filter($sidebars);

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