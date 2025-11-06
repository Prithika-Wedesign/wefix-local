<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MetaboxSideNav' ) ) {
    class MetaboxSideNav {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'cs_metabox_options', array( $this, 'sidenav' ) );
        }

        function sidenav( $options ) {
            $options[] = array(
                'id'        => '_wefix_sidenav_settings',
                'title'     => esc_html('Side Navigation Template', 'wefix-pro'),
                'post_type' => 'page',
                'context'   => 'advanced',
                'priority'  => 'high',
                'sections'  => array(
                    array(
                        'name'   => 'sidenav_section',
                        'fields' => array(
                            array(
                                'id'      => 'sidenav-tpl-notice',
                                'type'    => 'notice',
                                'class'   => 'success',
                                'content' => esc_html__('Side Navigation Tab Works only if page template set to Side Navigation Template in Page Attributes','wefix-pro'),
                                'class'   => 'margin-30 cs-success'
                            ),
                            array(
                                'id'      => 'style',
                                'type'    => 'select',
                                'title'   => esc_html__('Side Navigation Style', 'wefix-pro' ),
                                'options' => array(
                                    'type1' => esc_html__('Type1','wefix-pro'),
                                    'type2' => esc_html__('Type2','wefix-pro'),
                                    'type3' => esc_html__('Type3','wefix-pro'),
                                    'type4' => esc_html__('Type4','wefix-pro'),
                                    'type5' => esc_html__('Type5','wefix-pro')
                                ),
                            ),
                            array(
                                'id'    => 'icon_prefix',
                                'type'  => 'image',
                                'title' => esc_html__('Icon Prefix', 'wefix-pro' ),
                                'info'  => esc_html__('You can choose image here which will be displayed along with your title','wefix-pro'),
                                'dependency' => array( 'style', '==', 'type4' )
                            ),
                            array(
                                'id'    => 'align',
                                'type'  => 'switcher',
                                'title' => esc_html__('Align Right', 'wefix-pro' ),
                                'info'  => esc_html__('YES! to align right of side navigation.','wefix-pro')
                            ),
                            array(
                                'id'    => 'sticky',
                                'type'  => 'switcher',
                                'title' => esc_html__('Sticky Side Navigation', 'wefix-pro' ),
                                'info'  => esc_html__('YES! to sticky side navigation content.','wefix-pro')
                            ),
                            array(
                                'id'    => 'show_content',
                                'type'  => 'switcher',
                                'title' => esc_html__('Show Content', 'wefix-pro' ),
                                'info'  => esc_html__('YES! to show content in below side navigation.','wefix-pro')
                            ),
                            array(
                                'id'         => 'content',
                                'type'       => 'select',
                                'title'      => esc_html__('Content', 'wefix-pro' ),
                                'options'    => $this->elementor_library_list(),
                                'dependency' => array( 'show_content', '==', 'true' ),
                            ),
                            array(
                                'id'    => 'show_bottom_content',
                                'type'  => 'switcher',
                                'title' => esc_html__('Show Bottom Content', 'wefix-pro' ),
                                'info'  => esc_html__('YES! to show content at very bottom of side navigation tempalte page.','wefix-pro')
                            ),
                            array(
                                'id'         => 'bottom_content',
                                'type'       => 'select',
                                'title'      => esc_html__('Bottom Content', 'wefix-pro' ),
                                'options'    => $this->elementor_library_list(),
                                'dependency' => array( 'show_bottom_content', '==', 'true' ),
                            ),
                        )
                    )
                )
            );

            return $options;
        }

        function elementor_library_list() {
            $ids = get_posts( array(
                'post_type' => 'elementor_library',
                'posts_per_page' => 100, // Limit to 100 for performance, adjust as needed
                'fields' => 'ids',
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
            ));
        
            $options = array();
            if ( ! empty( $ids ) && ! is_wp_error( $ids ) ) {
                foreach ( $ids as $id ) {
                    $options[ $id ] = get_the_title( $id );
                }
            }
        
            $options[0] = esc_html__('Select Elementor Library', 'wefix-pro');
            asort($options);
        
            return $options;
        }

    }
}

MetaboxSideNav::instance();