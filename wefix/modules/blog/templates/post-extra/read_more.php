<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	if( $archive_readmore_text != '' ) :
		echo '<!-- Entry Button --><div class="entry-button wdt-core-button">';
			echo '<a href="'.get_permalink().'" title="'.the_title_attribute('echo=0').'" class="wdt-button">'.esc_html($archive_readmore_text).'<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20" xml:space="preserve"><path d="M20,1.3C20,0.6,19.4,0,18.7,0H7.4C6.7,0,6.1,0.6,6.1,1.3c0,0.7,0.6,1.3,1.3,1.3h10.1v10.1c0,0.7,0.6,1.3,1.3,1.3 s1.3-0.6,1.3-1.3V1.3z M0.9,19.1L1.8,20L19.6,2.2l-0.9-0.9l-0.9-0.9L0,18.2L0.9,19.1z"></path></svg></span></a>';
		echo '</div><!-- Entry Button -->';
	endif; ?>