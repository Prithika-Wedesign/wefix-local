<?php

    add_action( 'wefix_after_main_css', 'search_style' );
    function search_style() {
        wp_enqueue_style( 'wefix-quick-search', get_theme_file_uri('/modules/search/assets/css/search.css'), false, WEFIX_THEME_VERSION, 'all');
    }

    add_action('wp_ajax_wefix_search_data_fetch' , 'wefix_search_data_fetch');
	add_action('wp_ajax_nopriv_wefix_search_data_fetch','wefix_search_data_fetch');
	function wefix_search_data_fetch(){
        $nonce = $_POST['security'];
        if ( ! wp_verify_nonce( $nonce, 'search_data_fetch_nonce' ) ) {
            die( 'Security check failed' );
        }
        $search_val = wefix_sanitization($_POST['search_val']);

        $the_query = new WP_Query( array( 'posts_per_page' => 5, 's' => $search_val, 'post_type' => array('post', 'product') ) );
        if( $the_query->have_posts() ) :
            while( $the_query->have_posts() ): $the_query->the_post(); ?>
                <li class="quick_search_data_item">
                    <a href="<?php echo esc_url( get_permalink() ); ?>">
                        <?php the_post_thumbnail( 'thumbnail', array( 'class' => ' ' ) ); ?>
                        <?php the_title();?>
                    </a>
                </li>
            <?php endwhile;
            wp_reset_postdata();
        else:
            echo'<p>'. esc_html__( 'No Results Found', 'wefix') .'</p>';
        endif;

        die();
}
add_action( 'wp_enqueue_scripts', 'wefix_enqueue_scripts' );
    function wefix_enqueue_scripts() {
        // Enqueue your script here
        wp_enqueue_script( 'wefix-jqcustom', get_theme_file_uri('/assets/js/custom.js'), array('jquery'), false, true ); 
        $ajax_nonce = wp_create_nonce( 'search_data_fetch_nonce' );
        wp_localize_script( 'wefix-jqcustom', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'ajax_nonce' => $ajax_nonce ) );
    }

?>