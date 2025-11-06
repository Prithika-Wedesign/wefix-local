<?php
    if( empty( $code ) ) {
        return;
    }?>
<div id="slider">
    <div id="wdt-layer-slider" class="wdt-main-slider"><?php
        echo do_shortcode('[layerslider id="'.esc_attr( $code ).'"/]');
    ?></div>
</div>