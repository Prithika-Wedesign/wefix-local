<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MetaboxBreadcrumb' ) ) {
    class MetaboxBreadcrumb {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'cs_metabox_options', array( $this, 'breadcrumb' ) );
        }

        function breadcrumb( $options ) {

            $post_types = apply_filters( 'wefix_breadcrumb_posts', array( 'post', 'page' ) );

            $options[] = array(
                'id'        => '_wefix_breadcrumb_settings',
                'title'     => esc_html('Breadcrumb', 'wefix-pro'),
                'post_type' => $post_types,
                'context'   => 'advanced',
                'priority'  => 'high',
                'sections'  => array(
                    array(
                        'name'   => 'layout_section',
                        'fields' => array(
                            array(
                                'id'      => 'layout',
                                'type'    => 'image_select',
                                'title'   => esc_html__('Breadcrumb Settings?', 'wefix-pro'),
                                'options' => array(
                                    'global-option'     => WEFIX_PRO_DIR_URL . 'modules/breadcrumb/assets/images/admin-option.png',
                                    'individual-option' => WEFIX_PRO_DIR_URL . 'modules/breadcrumb/assets/images/individual-option.png',
                                    'disable'           => WEFIX_PRO_DIR_URL . 'modules/breadcrumb/assets/images/disable.png',
                                ),
                                'default'    => 'global-option',
                                'attributes' => array( 'data-depend-id' => 'breadcrumb-layout' )
                            ),
                            array(
                                'id'         => 'enable_dark_bg',
                                'type'       => 'switcher',
                                'title'      => esc_html__('Dark BG?', 'wefix-pro' ),
                                'default'    => true,
                                'dependency' => array( 'breadcrumb-layout', 'any', 'individual-option' ),
                            ),
                            array(
                                'id'         => 'position',
                                'type'       => 'select',
                                'title'      => esc_html__('Position?', 'wefix-pro'),
                                'options'    => array(
                                    'header-top-absolute' => esc_html__('Behind the Header','wefix-pro'),
                                    'header-top-relative' => esc_html__('Default','wefix-pro'),
                                ),
                                'default'    => 'header-top-relative',
                                'dependency' => array( 'breadcrumb-layout', 'any', 'individual-option' ),
                            ),
                            array(
                                'id'         => 'background',
                                'type'       => 'background',
                                'title'      => esc_html__('Background', 'wefix-pro' ),
                                'dependency' => array( 'breadcrumb-layout', 'any', 'individual-option' ),
                            ),
                            array(
                                'id'         => 'enable_overlay',
                                'type'       => 'switcher',
                                'title'      => esc_html__('Enable Overlay', 'wefix-pro' ),
                                'default'    => true,
                                'dependency' => array( 'breadcrumb-layout', 'any', 'individual-option' ),
                            ),
                            array(
                                'id'         => 'gradient_color',
                                'type'       => 'color_picker',
                                'title'      => esc_html__('Gradient Color', 'wefix-pro' ),
                                'dependency' => array( 'breadcrumb-layout', 'any', 'individual-option' ),
                            ),
                            array(
                                'id'         => 'hide_content',
                                'type'       => 'switcher',
                                'title'      => esc_html__('Hide Content', 'wefix-pro' ),
                                'default'    => false,
                                'dependency' => array( 'breadcrumb-layout', 'any', 'individual-option' ),
                            )
                        )
                    )
                )
            );

            return $options;
        }
    }
}

MetaboxBreadcrumb::instance();