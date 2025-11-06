<?php
    if( empty( $code ) ) {
        return;
    }?>
<div id="slider">
    <div id="wdt-rev-slider" class="wdt-main-slider"><?php
        echo do_shortcode('[rev_slider '.esc_attr( $code ).'/]');
    ?></div>
</div>