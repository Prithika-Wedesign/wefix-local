<?php
	if( empty( $code ) ) {
	    return;
	}?>
	<div id="slider">
	    <div id="wdt-elementor-section" class="wdt-main-slider"><?php

            $content_id = $code;

            if( !empty( $content_id ) ){
                if( class_exists( '\Elementor\Plugin' ) ) {
                    $elementor_instance = Elementor\Plugin::instance();

                    if( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
                        $css_file = new \Elementor\Core\Files\CSS\Post( $content_id );
                        $css_file->enqueue();
                    }

                    if( !empty( $elementor_instance ) ) {
                        echo wefix_html_output($elementor_instance->frontend->get_builder_content_for_display( $content_id ));
                    }

                } else {
                    $content = get_the_content( '', false, $content_id );
                    echo do_shortcode( $content );
                }
            }

	    ?></div>
	</div>