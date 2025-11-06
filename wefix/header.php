<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="canonical" href="<?php echo esc_url( home_url( add_query_arg( null, null ) ) ); ?>">

    <?php if ( is_singular() && pings_open() ) { ?>
		<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php } ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
        wp_body_open();

        // Hook to add additional content after body tag open.
        do_action( 'wefix_hook_top' ); ?>

    <a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'wefix' ); ?></a>

    <!-- **Wrapper** -->
    <div class="wrapper">

        <!-- ** Inner Wrapper ** -->
        <div class="inner-wrapper">

            <?php do_action( 'wefix_hook_content_before' ); ?>

            <!-- ** Header Wrapper ** -->
            <div id="header-wrapper" class="<?php echo esc_attr( wefix_get_header_wrapper_classes() ); ?>">

                <!-- **Header** -->
                    <?php do_action( 'wefix_header' ); ?>
                <!-- **Header - End ** -->

                <!-- ** Slider ** -->
                    <?php do_action( 'wefix_slider' ); ?>

                <!-- ** Slider End ** -->

                <!-- ** Breadcrumb ** -->
                    <?php do_action( 'wefix_breadcrumb' ); ?>
                <!-- ** Breadcrumb End ** -->

            </div><!-- ** Header Wrapper - End ** -->

            <!-- **Main** -->
            <div id="main">

                <?php do_action( 'wefix_hook_container_before' ); ?>

                <?php
                if(is_page_template('elementor_header_footer')) {
                    $class = 'wdt-elementor-container-fluid';
                } else {
                    $class = 'container';
                }
                ?>
                <!-- ** Container ** -->
                <div class="<?php echo esc_attr($class); ?>">
                    <?php do_action( 'wefix_hook_sections_before' ); ?>