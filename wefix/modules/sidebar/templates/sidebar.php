<?php
$sidebar_class   = wefix_get_secondary_classes();
$active_sidebars = wefix_get_active_sidebars();

if( $sidebar_class == 'content-full-width' || $sidebar_class == '' ) {
    return;
}

if( empty( $active_sidebars ) ) {
    return;
}?>
<!-- Secondary -->
 <?php
 if (function_exists('wefix_customizer_settings')) {
    
    $page_sidebartoggle =  wefix_customizer_settings('hide_toogle_sidebar' ); 
    $page_sidebartoggledefault =  wefix_customizer_settings('hide_sidebardisabletoogle' ); 
 } else {
    $page_sidebartoggle = false;
    $page_sidebartoggledefault = false;
 }
?>

<section id="secondary" class="<?php echo esc_attr( $sidebar_class ); ?>"><div class="wdt-sidebar-wrapper <?php if($page_sidebartoggle) { echo 'wdt-sidebartoogle-wrapper'; } ?>"><?php
    do_action( 'wefix_before_single_sidebar_wrap' );

    get_sidebar();

    do_action( 'wefix_after_single_sidebar_wrap' );?>
</div></section><!-- Secondary End -->