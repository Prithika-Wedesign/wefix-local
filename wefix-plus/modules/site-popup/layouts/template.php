<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; 
}
$data_settings = htmlspecialchars(json_encode($args), ENT_QUOTES, 'UTF-8');
?>

<div class="wdt-popup-box-widget">
    <div class="wdt-popup-box-widget-container">

        <div class="wdt-popup-box-trigger-holder wdt-click-element-on-load"
             data-settings='<?php echo $data_settings; ?>'>
        </div>

        <div id="wdt-popup-box-wrapper"
             class="wdt-popup-box-content-holder wdt-content-type-inline mfp-hide">
            <div class="wdt-popup-box-content-inner">
                <?php
                if ( class_exists( '\Elementor\Plugin' ) && class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
                    $elementor_instance = \Elementor\Plugin::instance();
                    if ( method_exists( $elementor_instance->frontend, 'get_builder_content_for_display' ) ) {
                        $css_file = new \Elementor\Core\Files\CSS\Post( $template_id );
                        $css_file->enqueue();
                        echo wefix_html_output( $elementor_instance->frontend->get_builder_content_for_display( $template_id ) );
                    }

                } elseif ( $template_id ) {
                    $post_obj = get_post( $template_id);
                    if ( $post_obj ) {
                        echo apply_filters( 'the_content', $post_obj->post_content );
                    return;
                    } else {
                        echo esc_html__( 'No template selected for the popup.', 'wefix-plus' );
                    return;
                    }
                } else {
                    echo esc_html__( 'No template selected for the popup.', 'wefix-plus' );
                    return;
                }
                ?>
                <button class="wdt-popup-close-button mfp-close" title="Close (Esc)">×</button>
            </div>
        </div>

    </div>
</div>
