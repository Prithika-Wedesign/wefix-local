<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFix_Shop_Metabox_Single_360_Viewer' ) ) {
    class WeFix_Shop_Metabox_Single_360_Viewer {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'cs_metabox_options', array( $this, 'product_options' ) );
        }

        function product_options( $options ) {

			$options[] = array(
				'id'        => '_360viewer_gallery',
				'title'     => esc_html__('Product 360 View Gallery','wefix-pro'),
				'post_type' => 'product',
				'context'   => 'side',
				'priority'  => 'low',
				'sections'  => array(
							array(
							'name'   => '360view_section',
							'fields' =>  array(
											array (
												'id'          => 'product-360view-gallery',
												'type'        => 'gallery',
												'title'       => esc_html__('Gallery Images', 'wefix-pro'),
												'desc'        => esc_html__('Simply add images to gallery items.', 'wefix-pro'),
												'add_title'   => esc_html__('Add Images', 'wefix-pro'),
												'edit_title'  => esc_html__('Edit Images', 'wefix-pro'),
												'clear_title' => esc_html__('Remove Images', 'wefix-pro'),
											)
										)
							)
							)
			);
			$options[] = array(
				'id'        => '_featured_video',
				'title'     => esc_html__('Featured Video', 'wefix-pro'),
				'post_type' => 'product',
				'context'   => 'side',
				'priority'  => 'low',
				'sections'  => array(
					array(
					'name'   => 'video_section',
					'fields' => array( 
						array(
						'id'      => 'video_input_type',
						'type'    => 'select',
						'title'   => esc_html__('Video Type', 'wefix-pro'),
						'options' => array(
							'upload' => esc_html__('Upload Video', 'wefix-pro'),
							'url'    => esc_html__('Video URL', 'wefix-pro'),
						),
						'default' => 'upload',
						), 
						array(
						'id'       => 'product_featured_video_upload',
						'type'     => 'upload',
						'title'    => esc_html__('Upload Video', 'wefix-pro'),
						'desc'     => esc_html__('Upload a video file (MP4, WebM, etc.).', 'wefix-pro'),
						'settings' => array(
							'library' => 'video',
						),
						'dependency' => array('video_input_type', '==', 'upload'),  
						), 

						array(
						'id'       => 'product_featured_video_fallbackimage',
						'type'     => 'upload',
						'title'    => esc_html__('Upload Fallback image', 'wefix-pro'),
						'desc'     => esc_html__('Upload a Image file.', 'wefix-pro'),
						'settings' => array(
							'library' => 'image',
						),
						'dependency' => array('video_input_type', '==', 'upload'),  
						), 
						array(
						'id'         => 'product_featured_video_url',
						'type'       => 'text',
						'title'      => esc_html__('Video URL', 'wefix-pro'),
						'desc'       => esc_html__('Enter a YouTube, Vimeo, or video URL.', 'wefix-pro'),
						'attributes' => array(
							'placeholder' => 'https://www.youtube.com/watch?v=...',
						),
						'dependency' => array('video_input_type', '==', 'url'),  
						),

					array(
						'id'      => 'default_playfeatured_video',
						'type'    => 'switcher',
						'title'   => esc_html__('Default Play video', 'wefix-pro'),
						'label'   => esc_html__('Yes, Play video', 'wefix-pro'),
						'default' => false,
					),
					) )
				)
			);


			return $options;

		}

    }
}

WeFix_Shop_Metabox_Single_360_Viewer::instance();