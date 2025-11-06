<?php
	if( empty( $code ) ) {
	    return;
	}?>
	<div id="slider">
	    <div id="wdt-custom-slider" class="wdt-main-slider"><?php
	        echo do_shortcode( $code );
	    ?></div>
	</div>