<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BlogPaginationInfiniteScroll' ) ) {
    class BlogPaginationInfiniteScroll {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
        	add_action( 'wefix_before_enqueue_js', array( $this, 'enqueue_js_assets' ) );
			add_action( 'wp_ajax_blog_archive_load_more_post', array( $this, 'blog_archive_load_more_post' ) );
			add_action( 'wp_ajax_nopriv_blog_archive_load_more_post', array( $this, 'blog_archive_load_more_post' ) );
        }

        function enqueue_js_assets() {
        	wp_enqueue_script( 'post-infinite', WEFIX_PLUS_DIR_URL . 'modules/blog/assets/js/post-infinite.js', array(), WEFIX_PLUS_VERSION, true );
			wp_localize_script('post-infinite', 'wefix_urls', array(
                'ajaxurl' => esc_url( admin_url('admin-ajax.php') )
            ));
        }

        function blog_archive_load_more_post() {

			$blogpostloadmore_nonce = wefix_sanitization($_POST['blogpostloadmore_nonce']);
			if( isset( $blogpostloadmore_nonce ) && wp_verify_nonce( $blogpostloadmore_nonce, 'blogpostloadmore_nonce' ) ) {

				$count = ( isset( $_REQUEST['count'] ) ) ? wefix_sanitization($_REQUEST['count']) : get_option( 'posts_per_page' );
				$page  = ( isset( $_REQUEST['pageNumber'] ) ) ? wefix_sanitization($_REQUEST['pageNumber']) : 2;

				$args = array( 'post_type' => 'post', 'posts_per_page' => $count, 'post_status' => 'publish', 'paged' => $page, 'ignore_sticky_posts' => true );
				$the_query = new WP_Query( $args );

		        if( $the_query->have_posts() ) {

		            $combine_class = wefix_get_archive_post_combine_class();
		            $post_style    = wefix_get_archive_post_style();

		            $template_args['Post_Style'] = $post_style;
		            $template_args = array_merge( $template_args, wefix_archive_blog_post_params() );

	                while( $the_query->have_posts() ) :
	                    $the_query->the_post();
	                    $post_ID = get_the_ID(); ?>

	                    <div class="<?php echo esc_attr($combine_class);?>">
	                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php
	                            $template_args['ID'] = $post_ID;
	                            wefix_template_part( 'blog', 'templates/'.esc_attr($post_style).'/post', '', $template_args ); ?>
	                        </article>
	                    </div><?php
	                endwhile;
	                wp_reset_postdata();
		        }
			}
			die();
        }
    }
}

BlogPaginationInfiniteScroll::instance();