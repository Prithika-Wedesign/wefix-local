<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusHeaderElementor' ) ) {
    class WeFixPlusHeaderElementor {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
        	$this->frontend();
        }

        function frontend() {
            add_filter( 'wefix_print_header_template', array( $this, 'register_header_template' ), 10, 1 );
        }

		function register_header_template( $id ) {

			$elementor_instance = '';

            if( class_exists( '\Elementor\Plugin' ) ) {
                $elementor_instance = Elementor\Plugin::instance();
            }

            $wp_upload_dir = wp_upload_dir();
            if(isset($wp_upload_dir['baseurl']) && $wp_upload_dir['baseurl'] != '') {
                if(file_exists($wp_upload_dir['basedir'].'/elementor/css/custom-widget-icon-list.min.css')) {
                    wp_enqueue_style( 'wdt-elementor-icons', $wp_upload_dir['baseurl'].'/elementor/css/custom-widget-icon-list.min.css' );
                }
            }

            ob_start();

            $page_template = get_post_meta( $id, '_wp_page_template', true );
            if($page_template == 'elementor_header_footer') {
                $class = 'wdt-elementor-container-fluid';
            } else {
                $class = 'container';
            }
            echo '<div class="'.esc_attr($class).'">';
                echo '<div id="header-'.esc_attr( $id ).'" class="wdt-header-tpl header-' .esc_attr( $id ). '">';

                    if( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
                        $css_file = new \Elementor\Core\Files\CSS\Post( $id );
                        $css_file->enqueue();

                        echo wefix_html_output($elementor_instance->frontend->get_builder_content_for_display( $id ));
                    } else {
                        $header = get_post( $id );
                        echo apply_filters( 'the_content', $header->post_content );
                    }

                echo '</div>';
            echo '</div>';

            $content = ob_get_clean();
            return apply_filters( 'wefix_plus_header_content', $content );
		}
    }
}

WeFixPlusHeaderElementor::instance();