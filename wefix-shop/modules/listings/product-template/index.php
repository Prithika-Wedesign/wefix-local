<?php

/**
 * Listing Framework Template Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Woo_Listing_Fw_Template_Settings' ) ) {

    class WeFix_Woo_Listing_Fw_Template_Settings {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Template Options Filter */
                add_action( 'cs_framework_options', array($this, 'woo_cs_fw_template_options' ), 10 );
                add_action('admin_enqueue_scripts',  array($this, 'enqueue_variation_media_uploader'));

        }

        /*
        Template Options
        */
            function woo_cs_fw_template_options( $options ) {

                # Template Name
                    $custom_tpl_name = array( array(
                        'id'    => 'product-template-id',
                        'type'  => 'text',
                        'title' => esc_html__('Template', 'wefix-shop')
                    ) );


                # Default Options
                    $custom_tpl_default_options = apply_filters( 'wefix_woo_custom_product_template_default_options', array () );
                    if( is_array ( $custom_tpl_default_options ) && !empty ( $custom_tpl_default_options ) ) {
                        array_unshift($custom_tpl_default_options, array (
                            'type'    => 'notice',
                            'class'   => 'info',
                            'content' => esc_html__('Default Options.', 'wefix-shop')
                        ));
                    }

                # Hover Options
                    $custom_tpl_hover_options = apply_filters( 'wefix_woo_custom_product_template_hover_options', array () );
                    if( is_array ( $custom_tpl_hover_options ) && !empty ( $custom_tpl_hover_options ) ) {
                        array_unshift($custom_tpl_hover_options, array (
                            'type'    => 'notice',
                            'class'   => 'info',
                            'content' => esc_html__('Hover Options.', 'wefix-shop')
                        ));
                    }

                # Common Options
                    $custom_tpl_common_options = apply_filters( 'wefix_woo_custom_product_template_common_options', array () );
                    if( is_array ( $custom_tpl_common_options ) && !empty ( $custom_tpl_common_options ) ) {
                        array_unshift($custom_tpl_common_options, array (
                            'type'    => 'notice',
                            'class'   => 'info',
                            'content' => esc_html__('Common Options.', 'wefix-shop')
                        ));
                    }

                # Thumb Options
                    $custom_tpl_thumb_options = apply_filters( 'wefix_woo_custom_product_template_thumb_options', array () );
                    if( is_array ( $custom_tpl_thumb_options ) && !empty ( $custom_tpl_thumb_options ) ) {
                        array_unshift($custom_tpl_thumb_options, array (
                            'type'    => 'notice',
                            'class'   => 'info',
                            'content' => esc_html__('Thumb Options.', 'wefix-shop')
                        ));
                    }

                # Content Options
                    $custom_tpl_content_options = apply_filters( 'wefix_woo_custom_product_template_content_options', array () );
                    if( is_array ( $custom_tpl_content_options ) && !empty ( $custom_tpl_content_options ) ) {
                        array_unshift($custom_tpl_content_options, array (
                            'type'    => 'notice',
                            'class'   => 'info',
                            'content' => esc_html__('Content Options.', 'wefix-shop')
                        ));
                    }

                $custom_template_options = array_merge ( $custom_tpl_name, $custom_tpl_default_options, $custom_tpl_hover_options, $custom_tpl_common_options, $custom_tpl_thumb_options, $custom_tpl_content_options );

                # Default & Custom Template Section

                    $product_template_section = array (
                        array (
                            'name'   => 'product_template_section',
                            'title'  => esc_html__('Shop - Product Template', 'wefix-shop'),
                            'icon'   => 'fa fa-shopping-bag',
                            'fields' => array_merge (
                                apply_filters( 'wefix_woo_default_product_templates', array () ),
                                array (
                                    array (
                                        'id'              => 'wefix-woo-product-style-templates',
                                        'type'            => 'group',
                                        'title'           => esc_html__( 'Product Style Templates', 'wefix-shop' ),
                                        'button_title'    => esc_html__('Add New', 'wefix-shop'),
                                        'accordion_title' => esc_html__('Add New Template', 'wefix-shop'),
                                        'fields'          => $custom_template_options
                                    )
                                )
                            )
                        )
                    );

                return array_merge ( $options, $product_template_section );

            }
/* Swatches Admin Media Uploader */

            function enqueue_variation_media_uploader($hook) {  
                if ($hook === 'post.php' || $hook === 'post-new.php') {
                    wp_enqueue_script(
                        'variation-material-image-uploader',
                        get_template_directory_uri() . '/assets/js/variant-color-picker.js',
                        ['jquery'],
                        '1.0',
                        true
                    );
                } 
                if (in_array($hook, ['edit-tags.php', 'term.php']) && isset($_GET['taxonomy']) && strpos($_GET['taxonomy'], 'pa_') === 0) {
                    wp_enqueue_script(
                        'custom-term-meta-js',
                        get_template_directory_uri() . '/assets/js/custom-term-meta.js',
                        ['jquery', 'wp-color-picker', 'media-upload', 'thickbox'],
                        null,
                        true
                    );
            
                    wp_enqueue_style('wp-color-picker');
                    wp_enqueue_media();
                }
            }


       /*
        Get Options Params
        */
            function woo_get_options_params( $options_param, $option_type ) {

                $default_options_settings = $hover_options_settings = $common_options_settings = $thumb_options_settings = $content_options_settings = array ();

                if( is_array ( $options_param ) && !empty ( $options_param ) ) {
                    foreach ( $options_param as $option_param_key => $option_param ) {

                        $option_param_key = str_replace( 'product-', '', $option_param_key);
                        $option_param_key = str_replace( '-', '_', $option_param_key);
                        $option_class_instance = 'wefix_woo_listing_option_'.$option_param_key;  // Option Class Instance

                        if ( function_exists( $option_class_instance ) ) {

                            if($option_class_instance()->setting_group() == 'default') {
                                array_push( $default_options_settings, $option_class_instance()->setting_args() );
                            } else if($option_class_instance()->setting_group() == 'hover') {
                                array_push( $hover_options_settings, $option_class_instance()->setting_args() );
                            } else if($option_class_instance()->setting_group() == 'common') {
                                array_push( $common_options_settings, $option_class_instance()->setting_args() );
                            } else if($option_class_instance()->setting_group() == 'thumb') {
                                array_push( $thumb_options_settings, $option_class_instance()->setting_args() );
                            } else if($option_class_instance()->setting_group() == 'content') {
                                array_push( $content_options_settings, $option_class_instance()->setting_args() );
                            }

                        }

                    }
                }

                $listing_options = array (
                    array(
                        'id'    => 'product-template-id',
                        'type'  => 'text',
                        'title' => esc_html__('Template', 'wefix-shop')
                    )
                );

                if( $option_type == 'default' ) {
                    $listing_options[0]['attributes']['readonly'] = 'only-key';
                }

                # Default Options
                    if( is_array ( $default_options_settings ) && !empty ( $default_options_settings ) ) {
                        array_unshift($default_options_settings, array (
                            'type'    => 'notice',
                            'class'   => 'info',
                            'content' => esc_html__('Default Options.', 'wefix-shop')
                        ));
                        $listing_options = array_merge ( $listing_options, $default_options_settings );
                    }

                # Hover Options
                    if( is_array ( $hover_options_settings ) && !empty ( $hover_options_settings ) ) {
                        array_unshift($hover_options_settings, array (
                            'type'    => 'notice',
                            'class'   => 'info',
                            'content' => esc_html__('Hover Options.', 'wefix-shop')
                        ));
                        $listing_options = array_merge ( $listing_options, $hover_options_settings );
                    }

                # Common Options
                    if( is_array ( $common_options_settings ) && !empty ( $common_options_settings ) ) {
                        array_unshift($common_options_settings, array (
                            'type'    => 'notice',
                            'class'   => 'info',
                            'content' => esc_html__('Common Options.', 'wefix-shop')
                        ));
                        $listing_options = array_merge ( $listing_options, $common_options_settings );
                    }

                # Thumb Options
                    if( is_array ( $thumb_options_settings ) && !empty ( $thumb_options_settings ) ) {
                        array_unshift($thumb_options_settings, array (
                            'type'    => 'notice',
                            'class'   => 'info',
                            'content' => esc_html__('Thumb Options.', 'wefix-shop')
                        ));
                        $listing_options = array_merge ( $listing_options, $thumb_options_settings );
                    }

                # Content Options
                    if( is_array ( $content_options_settings ) && !empty ( $content_options_settings ) ) {
                        array_unshift($content_options_settings, array (
                            'type'    => 'notice',
                            'class'   => 'info',
                            'content' => esc_html__('Content Options.', 'wefix-shop')
                        ));
                        $listing_options = array_merge ( $listing_options, $content_options_settings );
                    }

                return $listing_options;

            }

    }

}


if( !function_exists('wefix_woo_listing_fw_template_settings') ) {
	function wefix_woo_listing_fw_template_settings() {
		return WeFix_Woo_Listing_Fw_Template_Settings::instance();
	}
}

wefix_woo_listing_fw_template_settings();