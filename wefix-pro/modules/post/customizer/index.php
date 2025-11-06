<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixProCustomizerBlogPost' ) ) {
    class WeFixProCustomizerBlogPost {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'wefix_pro_customizer_default', array( $this, 'default' ) );
			add_action( 'customize_register', array( $this, 'register' ), 20 );
        }

        function default( $option ) {

            $post_defaults = array();
            if( function_exists('wefix_single_post_params_default') ) {
                $post_defaults = wefix_single_post_params_default();
            }

            $option['enable_title'] 		  = $post_defaults['enable_title'];
            $option['enable_image_lightbox']  = $post_defaults['enable_image_lightbox'];
			$option['enable_disqus_comments'] = $post_defaults['enable_disqus_comments'];
			$option['post_disqus_shortname']  = $post_defaults['post_disqus_shortname'];
			$option['post_dynamic_elements']  = $post_defaults['post_dynamic_elements'];
            $option['post_commentlist_style'] = $post_defaults['post_commentlist_style'];
			$option['select_post_navigation'] = $post_defaults['select_post_navigation'];

            $post_misc_defaults = array();
            if( function_exists('wefix_single_post_misc_default') ) {
                $post_misc_defaults = wefix_single_post_misc_default();
            }

            $option['enable_related_article'] = $post_misc_defaults['enable_related_article'];
			$option['rposts_title']    		  = $post_misc_defaults['rposts_title'];
			$option['rposts_column']   		  = $post_misc_defaults['rposts_column'];
			$option['rposts_count']    		  = $post_misc_defaults['rposts_count'];
			$option['rposts_excerpt']  		  = $post_misc_defaults['rposts_excerpt'];
			$option['rposts_excerpt_length']  = $post_misc_defaults['rposts_excerpt_length'];
			$option['rposts_carousel']  	  = $post_misc_defaults['rposts_carousel'];
			$option['rposts_carousel_nav']    = $post_misc_defaults['rposts_carousel_nav'];

            return $option;
        }

        function register( $wp_customize ) {

			/**
			 * Option : Post Title
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[enable_title]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new WeFix_Customize_Control_Switch(
					$wp_customize, WEFIX_CUSTOMISER_VAL . '[enable_title]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Title', 'wefix-pro'),
						'description' => esc_html__('YES! to enable the title of single post.', 'wefix-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'wefix-pro' ),
							'off' => esc_attr__( 'No', 'wefix-pro' )
						)
					)
				)
			);

			/**
			 * Option : Post Elements
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[post_dynamic_elements]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new WeFix_Customize_Control_Sortable(
					$wp_customize, WEFIX_CUSTOMISER_VAL . '[post_dynamic_elements]', array(
						'type' => 'wdt-sortable',
						'label' => esc_html__( 'Post Elements Positioning', 'wefix-pro'),
						'section' => 'site-blog-post-section',
						'choices' => apply_filters( 'wefix_blog_post_dynamic_elements', array(
							'author'		=> esc_html__('Author', 'wefix-pro'),
							'author_bio' 	=> esc_html__('Author Bio', 'wefix-pro'),
							'category'    	=> esc_html__('Categories', 'wefix-pro'),
							'comment' 		=> esc_html__('Comments', 'wefix-pro'),
							'comment_box' 	=> esc_html__('Comment Box', 'wefix-pro'),
							'content'    	=> esc_html__('Content', 'wefix-pro'),
							'date'     		=> esc_html__('Date', 'wefix-pro'),
							'image'			=> esc_html__('Feature Image', 'wefix-pro'),
							'navigation'    => esc_html__('Navigation', 'wefix-pro'),
							'tag'  			=> esc_html__('Tags', 'wefix-pro'),
							'title'      	=> esc_html__('Title', 'wefix-pro'),
							'likes_views'   => esc_html__('Likes & Views', 'wefix-pro'),
							'related_posts' => esc_html__('Related Posts', 'wefix-pro'),
							'social'  		=> esc_html__('Social Share', 'wefix-pro'),
						)
					),
				)
			));

			/**
			 * Option : Post Navigation
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[select_post_navigation]', array(
					'type' => 'option',
				)
			);
			$wp_customize->add_control( new WeFix_Customize_Control(
				$wp_customize, WEFIX_CUSTOMISER_VAL . '[select_post_navigation]', array(
					'type'    => 'select',
					'section' => 'site-blog-post-section',
					'label'   => esc_html__( 'Navigation Type', 'wefix-pro' ),
					'choices' => array(
						'type1' 	=> esc_html__('Type 1', 'wefix-pro'),
						'type2'   	=> esc_html__('Type 2', 'wefix-pro'),
						'type3'   	=> esc_html__('Type 3', 'wefix-pro'),
					),
				)
			));


			/**
			 * Option : Image Lightbox
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[enable_image_lightbox]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new WeFix_Customize_Control_Switch(
					$wp_customize, WEFIX_CUSTOMISER_VAL . '[enable_image_lightbox]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Feature Image Lightbox', 'wefix-pro'),
						'description' => esc_html__('YES! to enable lightbox for feature image. Will not work in "Overlay" style.', 'wefix-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'wefix-pro' ),
							'off' => esc_attr__( 'No', 'wefix-pro' )
						)
					)
				)
			);

			/**
			 * Option : Related Article
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[enable_related_article]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new WeFix_Customize_Control_Switch(
					$wp_customize, WEFIX_CUSTOMISER_VAL . '[enable_related_article]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Related Article', 'wefix-pro'),
						'description' => esc_html__('YES! to enable related article at right hand side of post.', 'wefix-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'wefix-pro' ),
							'off' => esc_attr__( 'No', 'wefix-pro' )
						)
					)
				)
			);

			/**
			 * Option : Disqus Comments
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[enable_disqus_comments]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new WeFix_Customize_Control_Switch(
					$wp_customize, WEFIX_CUSTOMISER_VAL . '[enable_disqus_comments]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Disqus Comments', 'wefix-pro'),
						'description' => esc_html__('YES! to enable disqus platform comments module.', 'wefix-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'wefix-pro' ),
							'off' => esc_attr__( 'No', 'wefix-pro' )
						)
					)
				)
			);

			/**
			 * Option : Disqus Short Name
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[post_disqus_shortname]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new WeFix_Customize_Control(
					$wp_customize, WEFIX_CUSTOMISER_VAL . '[post_disqus_shortname]', array(
						'type'    	  => 'textarea',
						'section'     => 'site-blog-post-section',
						'label'       => esc_html__( 'Shortname', 'wefix-pro' ),
						'input_attrs' => array(
							'placeholder' => 'disqus',
						),
						'dependency' => array( 'enable_disqus_comments', '==', 'true' ),
					)
				)
			);

			/**
			 * Option : Disqus Description
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[post_disqus_description]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new WeFix_Customize_Control_Description(
					$wp_customize, WEFIX_CUSTOMISER_VAL . '[post_disqus_description]', array(
						'type'    	  => 'wdt-description',
						'section'     => 'site-blog-post-section',
						'description' => esc_html__('Your site\'s unique identifier', 'wefix-pro').' '.'<a href="'.esc_url('https://help.disqus.com/customer/portal/articles/466208').'" target="_blank">'.esc_html__('What is this?', 'wefix-pro').'</a>',
						'dependency' => array( 'enable_disqus_comments', '==', 'true' ),
					)
				)
			);

			/**
			 * Option : Comment List Style
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[post_commentlist_style]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control( new WeFix_Customize_Control(
				$wp_customize, WEFIX_CUSTOMISER_VAL . '[post_commentlist_style]', array(
					'type'    => 'select',
					'section' => 'site-blog-post-section',
					'label'   => esc_html__( 'Comments List Style', 'wefix-pro' ),
					'choices' => array(
						'rounded' 	=> esc_html__('Rounded', 'wefix-pro'),
						'square'   	=> esc_html__('Square', 'wefix-pro'),
					),
					'description' => esc_html__('Choose comments list style to display single post.', 'wefix-pro'),
					'dependency' => array( 'enable_disqus_comments', '!=', 'true' ),
				)
			));

			/**
			 * Option : Post Related Title
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[rposts_title]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new WeFix_Customize_Control(
					$wp_customize, WEFIX_CUSTOMISER_VAL . '[rposts_title]', array(
						'type'    	  => 'text',
						'section'     => 'site-blog-post-section',
						'label'       => esc_html__( 'Related Posts Section Title', 'wefix-pro' ),
						'description' => esc_html__('Put the related posts section title here', 'wefix-pro'),
						'input_attrs' => array(
							'value'	=> esc_html__('Related Posts', 'wefix-pro'),
						)
					)
				)
			);

			/**
			 * Option : Related Columns
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[rposts_column]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control( new WeFix_Customize_Control_Radio_Image(
				$wp_customize, WEFIX_CUSTOMISER_VAL . '[rposts_column]', array(
					'type' => 'wdt-radio-image',
					'label' => esc_html__( 'Columns', 'wefix-pro'),
					'section' => 'site-blog-post-section',
					'choices' => apply_filters( 'wefix_blog_post_related_columns', array(
						'one-column' => array(
							'label' => esc_html__( 'One Column', 'wefix-pro' ),
							'path' => WEFIX_PRO_DIR_URL . 'modules/post/customizer/images/one-column.png'
						),
						'one-half-column' => array(
							'label' => esc_html__( 'One Half Column', 'wefix-pro' ),
							'path' => WEFIX_PRO_DIR_URL . 'modules/post/customizer/images/one-half-column.png'
						),
						'one-third-column' => array(
							'label' => esc_html__( 'One Third Column', 'wefix-pro' ),
							'path' => WEFIX_PRO_DIR_URL . 'modules/post/customizer/images/one-third-column.png'
						),
					)),
				)
			));

			/**
			 * Option : Related Count
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[rposts_count]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new WeFix_Customize_Control(
					$wp_customize, WEFIX_CUSTOMISER_VAL . '[rposts_count]', array(
						'type'    	  => 'text',
						'section'     => 'site-blog-post-section',
						'label'       => esc_html__( 'No.of Posts to Show', 'wefix-pro' ),
						'description' => esc_html__('Put the no.of related posts to show', 'wefix-pro'),
						'input_attrs' => array(
							'value'	=> 3,
						),
					)
				)
			);

			/**
			 * Option : Enable Excerpt
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[rposts_excerpt]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new WeFix_Customize_Control_Switch(
					$wp_customize, WEFIX_CUSTOMISER_VAL . '[rposts_excerpt]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Excerpt Text', 'wefix-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'wefix-pro' ),
							'off' => esc_attr__( 'No', 'wefix-pro' )
						)
					)
				)
			);

			/**
			 * Option : Excerpt Text
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[rposts_excerpt_length]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new WeFix_Customize_Control(
					$wp_customize, WEFIX_CUSTOMISER_VAL . '[rposts_excerpt_length]', array(
						'type'    	  => 'text',
						'section'     => 'site-blog-post-section',
						'label'       => esc_html__( 'Excerpt Length', 'wefix-pro' ),
						'description' => esc_html__('Put Excerpt Length', 'wefix-pro'),
						'input_attrs' => array(
							'value'	=> 25,
						),
						'dependency' => array( 'rposts_excerpt', '==', 'true' ),
					)
				)
			);

			/**
			 * Option : Related Carousel
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[rposts_carousel]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control(
				new WeFix_Customize_Control_Switch(
					$wp_customize, WEFIX_CUSTOMISER_VAL . '[rposts_carousel]', array(
						'type'    => 'wdt-switch',
						'label'   => esc_html__( 'Enable Carousel', 'wefix-pro'),
						'description' => esc_html__('YES! to enable carousel related posts', 'wefix-pro'),
						'section' => 'site-blog-post-section',
						'choices' => array(
							'on'  => esc_attr__( 'Yes', 'wefix-pro' ),
							'off' => esc_attr__( 'No', 'wefix-pro' )
						)
					)
				)
			);

			/**
			 * Option : Related Carousel Nav
			 */
			$wp_customize->add_setting(
				WEFIX_CUSTOMISER_VAL . '[rposts_carousel_nav]', array(
					'type' => 'option',
				)
			);

			$wp_customize->add_control( new WeFix_Customize_Control(
				$wp_customize, WEFIX_CUSTOMISER_VAL . '[rposts_carousel_nav]', array(
					'type'    => 'select',
					'section' => 'site-blog-post-section',
					'label'   => esc_html__( 'Navigation Style', 'wefix-pro' ),
					'choices' => array(
						'' 			 => esc_html__('None', 'wefix-pro'),
						'navigation' => esc_html__('Navigations', 'wefix-pro'),
						'pager'   	 => esc_html__('Pager', 'wefix-pro'),
					),
					'description' => esc_html__('Choose navigation style to display related post carousel.', 'wefix-pro'),
					'dependency' => array( 'rposts_carousel', '==', 'true' ),
				)
			));

        }
    }
}

WeFixProCustomizerBlogPost::instance();