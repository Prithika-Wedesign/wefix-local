<div class="container">
    <div class="wdt-no-header-builder-content wdt-no-header-wefix">
        <div class="no-header">
            <div class="no-header-logo">
                <a href="<?php echo esc_url( home_url('/') );?>" title="<?php esc_attr(bloginfo('title')); ?>"><?php echo wefix_get_header_logo();?></a>
            </div>
            <?php
                $menu = false;
                if( has_nav_menu('main-menu') ) { ?>
                    <div class="no-header-menu wdt-header-menu" data-menu="dummy-menu">
                        <?php
                            $menu = wp_cache_get('wefix_main_menu_html');
                            if ($menu === false) {
                                $menu = wp_nav_menu( apply_filters( 'wefix_default_menu_args', array(
                                    'theme_location'  => 'main-menu',
                                    'container_class' => 'menu-container',
                                    'items_wrap'      => '<ul id="%1$s" class="%2$s" data-menu="dummy-menu"> <li class="close-nav"><a href="#"></a></li> %3$s </ul> <div class="sub-menu-overlay"></div>',
                                    'menu_class'      => 'wdt-primary-nav',
                                    'link_before'     => '<span>',
                                    'link_after'      => '</span>',
                                    'walker'          => new WeFix_Default_Header_Walker_Nav_Menu,
                                    'echo'            => false
                                ) ) );
                                wp_cache_set('wefix_main_menu_html', $menu, '', 3600); // cache for 1 hour
                            }

                            echo apply_filters( 'wefix_default_menu', $menu );

                            if( $menu ) { ?>
                                <div class="mobile-nav-container" data-menu="dummy-menu">
                                    <a href="#" class="menu-trigger menu-trigger-icon" data-menu="dummy-menu" aria-label="<?php esc_attr_e('Open main menu', 'wefix'); ?>">
                                        <i aria-hidden="true"></i>
                                        <span><?php esc_html_e('Menu', 'wefix'); ?></span>
                                    </a>
                                    <div class="mobile-menu mobile-nav-offcanvas-right" data-menu="dummy-menu"></div>
                                </div><?php
                            } ?>
                    </div><?php
                }?>
        </div>
    </div>
</div>