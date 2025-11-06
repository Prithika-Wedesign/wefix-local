<div class="wdt-custom-box">

    <label><?php echo esc_html__('Client','wdt-portfolio'); ?></label>
    <?php $wdt_client = get_post_meta($list_id, 'wdt_client', true); ?>
    <input name="wdt_client" type="text" value="<?php echo esc_attr( $wdt_client );?>" />
    <div class="wdt-note"><?php echo sprintf( esc_html__('Add Client name for your %1$s here.','wdt-portfolio'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="wdt-custom-box">

    <label><?php echo esc_html__('Email','wdt-portfolio'); ?></label>
    <?php $wdt_email = get_post_meta($list_id, 'wdt_email', true); ?>
    <input name="wdt_email" type="text" value="<?php echo esc_attr( $wdt_email );?>" />
    <div class="wdt-note"><?php echo sprintf( esc_html__('Add contact email for your %1$s here.','wdt-portfolio'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="wdt-custom-box">

    <label><?php echo esc_html__('Phone','wdt-portfolio'); ?></label>
    <?php $wdt_phone = get_post_meta($list_id, 'wdt_phone', true); ?>
    <input name="wdt_phone" type="text" value="<?php echo esc_attr( $wdt_phone );?>" />
    <div class="wdt-note"><?php echo sprintf( esc_html__('Add contact phone number for your %1$s here.','wdt-portfolio'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="wdt-custom-box">

    <label><?php echo esc_html__('Estimation','wdt-portfolio'); ?></label>
    <?php $wdt_estimation = get_post_meta($list_id, 'wdt_estimation', true); ?>
    <input name="wdt_estimation" type="text" value="<?php echo esc_attr( $wdt_estimation );?>" />
    <div class="wdt-note"><?php echo sprintf( esc_html__('Add estimation for your %1$s here.','wdt-portfolio'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="wdt-custom-box">

    <label><?php echo esc_html__('Place','wdt-portfolio'); ?></label>
    <?php $wdt_place = get_post_meta($list_id, 'wdt_place', true); ?>
    <input name="wdt_place" type="text" value="<?php echo esc_attr( $wdt_place );?>" />
    <div class="wdt-note"><?php echo sprintf( esc_html__('Add address for your %1$s here.','wdt-portfolio'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="wdt-custom-box">

    <label><?php echo esc_html__('Duration','wdt-portfolio'); ?></label>
    <?php $wdt_duration = get_post_meta($list_id, 'wdt_duration', true); ?>
    <input name="wdt_duration" type="text" value="<?php echo esc_attr( $wdt_duration );?>" />
    <div class="wdt-note"><?php echo sprintf( esc_html__('Add duration for your %1$s here.','wdt-portfolio'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="wdt-custom-box">

    <label><?php echo esc_html__('Social Details','wdt-portfolio'); ?></label>
    <?php echo wdt_social_details_field($list_id, 'list'); ?>

</div>