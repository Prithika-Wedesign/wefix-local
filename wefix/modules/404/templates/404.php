<?php
    if( isset( $enable_404message ) && ( $enable_404message == 1 || $enable_404message == true )  ) {
        $class = $notfound_style;
        $class .= ( isset( $notfound_darkbg ) && ( $notfound_darkbg == 1 ) ) ? " wdt-dark-bg" :"";
    ?>
    <div class="wrapper <?php echo esc_attr( $class );?>">
        <div class="container">
            <div class="center-content-wrapper">
                    <h3>404</h3>
                    <h4><?php esc_html_e("Ooops! Page not found!", 'wefix'); ?></h4>
                    <div class="wdt-hr-invisible-xsmall"></div>
                    <p><?php esc_html_e("Don’t worry, we can get you back on track. Head to our [Home Page] or check out our services to find what you need.", 'wefix'); ?></p>
                    <div class="wdt-hr-invisible-xsmall"></div>
                    <a class="wdt-button filled small" target="_self" href="<?php echo esc_url(home_url('/'));?>"><?php esc_html_e("Back to Home",'wefix');?></a>
            </div>
        </div>
    </div><?php
}?>