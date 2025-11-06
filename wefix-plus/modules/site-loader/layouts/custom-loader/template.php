<div class="pre-loader custom_loader">
    <div class="loader-inner">
        <?php
        $loader_image = wefix_customizer_settings('site_loader_image');
        if ( ! empty( $loader_image ) ) : ?>
            <img class="pre_loader_image" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" src="<?php echo esc_url( $loader_image ); ?>"/>
        <?php else : ?>
            <div class="wdt__wefix_pre_loader"></div>
        <?php endif; ?>
    </div>
</div>