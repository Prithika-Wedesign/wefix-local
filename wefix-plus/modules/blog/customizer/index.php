<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'WeFixPlusCustomizerSiteBlog' ) ) {
    class WeFixPlusCustomizerSiteBlog {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'wefix_plus_customizer_default', array( $this, 'default' ) );
        }

        function default( $option ) {

            $blog_defaults = array();
            if( function_exists('wefix_archive_blog_post_defaults') ) {
                $blog_defaults = wefix_archive_blog_post_defaults();
            }
            $option['blog-post-layout']          = $blog_defaults['post-layout'];
            $option['blog-post-grid-list-style'] = 'wdt-simple';
            $option['blog-list-thumb']           = $blog_defaults['list-type'];
            $option['blog-image-hover-style']    = $blog_defaults['hover-style'];
            $option['blog-image-overlay-style']  = $blog_defaults['overlay-style'];
            $option['blog-alignment']            = $blog_defaults['post-align'];
            $option['blog-post-columns']         = $blog_defaults['post-column'];

            $blog_misc_defaults = array();
            if( function_exists('wefix_archive_blog_post_misc_defaults') ) {
                $blog_misc_defaults = wefix_archive_blog_post_misc_defaults();
            }

            $option['enable-equal-height']       = $blog_misc_defaults['enable-equal-height'];
            $option['enable-no-space']           = $blog_misc_defaults['enable-no-space'];

            $blog_params = array();
            if( function_exists('wefix_archive_blog_post_params_default') ) {
                $blog_params = wefix_archive_blog_post_params_default();
            }

            $option['enable-video-audio']        = $blog_params['enable_video_audio'];
            $option['enable-gallery-slider']     = $blog_params['enable_gallery_slider'];
            $option['blog-media-group']          = $blog_params['archive_media_elements'];
            $option['blog-elements-position']    = $blog_params['archive_post_elements'];
            $option['blog-meta-position']        = $blog_params['archive_meta_elements'];
            $option['blog-readmore-text']        = $blog_params['archive_readmore_text'];
            $option['enable-excerpt-text']       = $blog_params['enable_excerpt_text'];
            $option['blog-excerpt-length']       = $blog_params['archive_excerpt_length'];
            $option['blog-pagination']           = $blog_params['archive_blog_pagination'];


            return $option;

        }

        function register( $wp_customize ) {

            /**
             * Panel
             */
            $wp_customize->add_panel(
                new WeFix_Customize_Panel(
                    $wp_customize,
                    'site-blog-main-panel',
                    array(
                        'title'    => esc_html__('Blog Settings', 'wefix-plus'),
                        'priority' => wefix_customizer_panel_priority( 'blog' )
                    )
                )
            );

            $wp_customize->add_section(
                new WeFix_Customize_Section(
                    $wp_customize,
                    'site-blog-archive-section',
                    array(
                        'title'    => esc_html__('Blog Archives', 'wefix-plus'),
                        'panel'    => 'site-blog-main-panel',
                        'priority' => 10,
                    )
                )
            );


            /**
             * Option : Archive Post Layout
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new WeFix_Customize_Control_Radio_Image(
                $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'Post Layout', 'wefix-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'wefix_blog_archive_layout_options', array(
                        'entry-grid' => array(
                            'label' => esc_html__( 'Grid', 'wefix-plus' ),
                            'path' => WEFIX_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-grid.png'
                        ),
                        'entry-list' => array(
                            'label' => esc_html__( 'List', 'wefix-plus' ),
                            'path' => WEFIX_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-list.png'
                        )
                    ))
                )
            ));

            /**
             * Option : Post Columns
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new WeFix_Customize_Control_Radio_Image(
                $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'Columns', 'wefix-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'wefix_blog_archive_columns_options', array(
                        'one-column' => array(
                            'label' => esc_html__( 'One Column', 'wefix-plus' ),
                            'path' => WEFIX_PLUS_DIR_URL . 'modules/blog/customizer/images/one-column.png'
                        ),
                        'one-half-column' => array(
                            'label' => esc_html__( 'One Half Column', 'wefix-plus' ),
                            'path' => WEFIX_PLUS_DIR_URL . 'modules/blog/customizer/images/one-half-column.png'
                        ),
                        'one-third-column' => array(
                            'label' => esc_html__( 'One Third Column', 'wefix-plus' ),
                            'path' => WEFIX_PLUS_DIR_URL . 'modules/blog/customizer/images/one-third-column.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ))
            ));

            /**
             * Option : List Thumb
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new WeFix_Customize_Control_Radio_Image(
                $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'wdt-radio-image',
                    'label' => esc_html__( 'List Type', 'wefix-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'wefix_blog_archive_list_thumb_options', array(
                        'entry-left-thumb' => array(
                            'label' => esc_html__( 'Left Thumb', 'wefix-plus' ),
                            'path' => WEFIX_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-left-thumb.png'
                        ),
                        'entry-right-thumb' => array(
                            'label' => esc_html__( 'Right Thumb', 'wefix-plus' ),
                            'path' => WEFIX_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-right-thumb.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', '==', 'entry-list' ),
                )
            ));

            /**
             * Option : Post Alignment
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new WeFix_Customize_Control(
                $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Elements Alignment', 'wefix-plus' ),
                    'choices' => array(
                      'alignnone'   => esc_html__('None', 'wefix-plus'),
                      'alignleft'   => esc_html__('Align Left', 'wefix-plus'),
                      'aligncenter' => esc_html__('Align Center', 'wefix-plus'),
                      'alignright'  => esc_html__('Align Right', 'wefix-plus'),
                    ),
                    'dependency'   => array( 'blog-post-layout', 'any', 'entry-grid'),
                )
            ));

            /**
             * Option : Equal Height
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[enable-equal-height]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new WeFix_Customize_Control_Switch(
                    $wp_customize, WEFIX_CUSTOMISER_VAL . '[enable-equal-height]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable Equal Height', 'wefix-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'wefix-plus' ),
                            'off' => esc_attr__( 'No', 'wefix-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid' ),
                    )
                )
            );

            /**
             * Option : No Space
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[enable-no-space]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new WeFix_Customize_Control_Switch(
                    $wp_customize, WEFIX_CUSTOMISER_VAL . '[enable-no-space]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable No Space', 'wefix-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'wefix-plus' ),
                            'off' => esc_attr__( 'No', 'wefix-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid' ),
                    )
                )
            );

            /**
             * Option : Gallery Slider
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new WeFix_Customize_Control_Switch(
                    $wp_customize, WEFIX_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Display Gallery Slider', 'wefix-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'wefix-plus' ),
                            'off' => esc_attr__( 'No', 'wefix-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Divider : Blog Gallery Slider Bottom
             */
            $wp_customize->add_control(
                new WeFix_Customize_Control_Separator(
                    $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-gallery-slider-bottom-separator]', array(
                        'type'     => 'wdt-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );
            /**
             * Option : Blog Media Group
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[blog-media-group]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new WeFix_Customize_Control_Sortable(
                $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-media-group]', array(
                    'type' => 'wdt-sortable',
                    'label' => esc_html__( 'Media Group Positioning', 'wefix-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'wefix_archive_media_elements_options', array(
                        'feature_image' => esc_html__('Feature Image', 'wefix-plus'),
                        'title'         => esc_html__('Title', 'wefix-plus'),
                        'content'       => esc_html__('Content', 'wefix-plus'),
                        'read_more'     => esc_html__('Read More', 'wefix-plus'),
                        'meta_group'    => esc_html__('Meta Group', 'wefix-plus'),
                        'author'        => esc_html__('Author', 'wefix-plus'),
                        'date'          => esc_html__('Date', 'wefix-plus'),
                        'comment'       => esc_html__('Comments', 'wefix-plus'),
                        'category'      => esc_html__('Categories', 'wefix-plus'),
                        'tag'           => esc_html__('Tags', 'wefix-plus'),
                        'social'        => esc_html__('Social Share', 'wefix-plus'),
                        'likes_views'   => esc_html__('Likes & Views', 'wefix-plus')
                    )),
                    'description' => esc_html__('Note: The media group is positioned using the cover type layout.', 'wefix-plus'),
                )
            ));
            /**
             * Option : Blog Elements
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new WeFix_Customize_Control_Sortable(
                $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'wdt-sortable',
                    'label' => esc_html__( 'Elements Positioning', 'wefix-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'wefix_archive_post_elements_options', array(
                        'title'         => esc_html__('Title', 'wefix-plus'),
                        'content'       => esc_html__('Content', 'wefix-plus'),
                        'read_more'     => esc_html__('Read More', 'wefix-plus'),
                        'meta_group'    => esc_html__('Meta Group', 'wefix-plus'),
                        'author'        => esc_html__('Author', 'wefix-plus'),
                        'date'          => esc_html__('Date', 'wefix-plus'),
                        'comment'       => esc_html__('Comments', 'wefix-plus'),
                        'category'      => esc_html__('Categories', 'wefix-plus'),
                        'tag'           => esc_html__('Tags', 'wefix-plus'),
                        'social'        => esc_html__('Social Share', 'wefix-plus'),
                        'likes_views'   => esc_html__('Likes & Views', 'wefix-plus'),
                    )),
                )
            ));

            /**
             * Option : Blog Meta Elements
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new WeFix_Customize_Control_Sortable(
                $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'wdt-sortable',
                    'label' => esc_html__( 'Meta Group Positioning', 'wefix-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'wefix_blog_archive_meta_elements_options', array(
                        'author'        => esc_html__('Author', 'wefix-plus'),
                        'date'          => esc_html__('Date', 'wefix-plus'),
                        'comment'       => esc_html__('Comments', 'wefix-plus'),
                        'category'      => esc_html__('Categories', 'wefix-plus'),
                        'tag'           => esc_html__('Tags', 'wefix-plus'),
                        'social'        => esc_html__('Social Share', 'wefix-plus'),
                        'likes_views'   => esc_html__('Likes & Views', 'wefix-plus'),
                    )),
                    'description' => esc_html__('Note: Use max 3 items for better results.', 'wefix-plus'),
                )
            ));

            /**
             * Divider : Blog Meta Elements Bottom
             */
            $wp_customize->add_control(
                new WeFix_Customize_Control_Separator(
                    $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-meta-elements-bottom-separator]', array(
                        'type'     => 'wdt-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );
            /**
             * Option : Enable Excerpt
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new WeFix_Customize_Control_Switch(
                    $wp_customize, WEFIX_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Enable Excerpt Text', 'wefix-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'wefix-plus' ),
                            'off' => esc_attr__( 'No', 'wefix-plus' )
                        )
                    )
                )
            );

            /**
             * Option : Excerpt Text
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new WeFix_Customize_Control(
                    $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Excerpt Length', 'wefix-plus' ),
                        'description' => esc_html__('Put Excerpt Length', 'wefix-plus'),
                        'input_attrs' => array(
                            'value' => 25,
                        ),
                        'dependency'  => array( 'enable-excerpt-text', '==', 'true' ),
                    )
                )
            );

            /**
             * Option : Enable Video Audio
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[enable-video-audio]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new WeFix_Customize_Control_Switch(
                    $wp_customize, WEFIX_CUSTOMISER_VAL . '[enable-video-audio]', array(
                        'type'    => 'wdt-switch',
                        'label'   => esc_html__( 'Display Video & Audio for Posts', 'wefix-plus'),
                        'description' => esc_html__('YES! to display video & audio, instead of feature image for posts', 'wefix-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'wefix-plus' ),
                            'off' => esc_attr__( 'No', 'wefix-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Option : Readmore Text
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new WeFix_Customize_Control(
                    $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Read More Text', 'wefix-plus' ),
                        'description' => esc_html__('Put the read more text here', 'wefix-plus'),
                        'input_attrs' => array(
                            'value' => esc_html__('Read More', 'wefix-plus'),
                        )
                    )
                )
            );

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new WeFix_Customize_Control(
                $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Hover Style', 'wefix-plus' ),
                    'choices' => array(
                      'wdt-default'     => esc_html__('Default', 'wefix-plus'),
                      'wdt-fadeinleft'  => esc_html__('Fade InLeft', 'wefix-plus'),
                      'wdt-fadeinright' => esc_html__('Fade InRight', 'wefix-plus'),
                      'wdt-rotate'      => esc_html__('Rotate', 'wefix-plus'),
                      'wdt-rotate-alt'  => esc_html__('Rotate Alt', 'wefix-plus'),
                      'wdt-scalein'     => esc_html__('Scale In', 'wefix-plus'),
                      'wdt-scaleout'    => esc_html__('Scale Out', 'wefix-plus')
                    ),
                    'description' => esc_html__('Choose image hover style to display archives pages.', 'wefix-plus'),
                )
            ));

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new WeFix_Customize_Control(
                $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Overlay Style', 'wefix-plus' ),
                    'choices' => array(
                      'wdt-default'           => esc_html__('None', 'wefix-plus'),
                      'wdt-fixed'             => esc_html__('Fixed', 'wefix-plus'),
                      'wdt-middle'            => esc_html__('Middle', 'wefix-plus'),
                      'wdt-bt-gradient'       => esc_html__('Gradient - Bottom to Top', 'wefix-plus'),
                      'wdt-flash'             => esc_html__('Flash', 'wefix-plus')
                    ),
                    'description' => esc_html__('Choose image overlay style to display archives pages.', 'wefix-plus'),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                )
            ));

            /**
             * Option : Pagination
             */
            $wp_customize->add_setting(
                WEFIX_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new WeFix_Customize_Control(
                $wp_customize, WEFIX_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Pagination Style', 'wefix-plus' ),
                    'choices' => array(
                      'pagination-default'        => esc_html__('Older & Newer', 'wefix-plus'),
                      'pagination-numbered'       => esc_html__('Numbered', 'wefix-plus'),
                      'pagination-loadmore'       => esc_html__('Load More', 'wefix-plus'),
                      'pagination-infinite-scroll'=> esc_html__('Infinite Scroll', 'wefix-plus'),
                    ),
                    'description' => esc_html__('Choose pagination style to display archives pages.', 'wefix-plus')
                )
            ));

        }
    }
}

WeFixPlusCustomizerSiteBlog::instance();