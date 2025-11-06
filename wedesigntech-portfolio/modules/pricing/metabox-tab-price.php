<?php
echo '<input type="hidden" name="wdt_woocommerce_meta_nonce" value="'.wp_create_nonce('wdt_woocommerce_nonce').'" />';
?>

<div class="wdt-custom-box">
    <label><?php echo esc_html__('Currency Symbol','wdt-portfolio'); ?></label>
    <?php $wdt_currency_symbol = get_post_meta($list_id, 'wdt_currency_symbol', true); ?>
    <input name="wdt_currency_symbol" type="text" value="<?php echo esc_attr( $wdt_currency_symbol );?>" />
    <div class="wdt-note"><?php echo esc_html__('Add currency symbol here.','wdt-portfolio'); ?> </div>
</div>

<div class="wdt-custom-box">
    <label><?php echo esc_html__('Currency Symbol - Position','wdt-portfolio'); ?></label>
    <?php
    $wdt_currency_symbol_position = get_post_meta($list_id, 'wdt_currency_symbol_position', true);
    $wdt_currency_symbol_position = ($wdt_currency_symbol_position != '') ? $wdt_currency_symbol_position : 'left';
    $currency_symbol_positions = array ('' => esc_html__('Default','wdt-portfolio'), 'left' => esc_html__('Left','wdt-portfolio'), 'right' => esc_html__('Right','wdt-portfolio'), 'left_space' => esc_html__('Left With Space','wdt-portfolio'), 'right_space' => esc_html__('Right With Space','wdt-portfolio'));
    ?>
    <select name="wdt_currency_symbol_position" class="wdt-chosen-select">
        <?php
        foreach($currency_symbol_positions as $currency_symbol_position_key => $currency_symbol_position_item) {
            echo '<option value="'.esc_attr( $currency_symbol_position_key ).'" '.selected($currency_symbol_position_key, $wdt_currency_symbol_position, false ).'>';
                echo esc_html( $currency_symbol_position_item );
            echo '</option>';
        }
        ?>
    </select>
    <div class="wdt-note"><?php echo esc_html__('Add currency symbol position here.','wdt-portfolio'); ?> </div>
</div>

<div class="wdt-custom-box">
    <label><?php echo esc_html__('Regular Price','wdt-portfolio');?></label>
    <?php $_regular_price = get_post_meta($list_id, '_regular_price', true); ?>
    <input name="_regular_price" id="_regular_price" type="text" value="<?php echo esc_attr( $_regular_price );?>" />
    <div class="wdt-note"><?php echo sprintf( esc_html__('Add regular price for your %1$s here. Avoid comma while adding price.','wdt-portfolio'), strtolower($listing_singular_label) ); ?> </div>
</div>

<div class="wdt-custom-box">
    <label><?php echo esc_html__('Sale Price','wdt-portfolio'); ?></label>
    <?php $_sale_price = get_post_meta($list_id, '_sale_price', true); ?>
    <input name="_sale_price" id="_sale_price" type="text" value="<?php echo esc_attr( $_sale_price );?>" />
    <div class="wdt-note"><?php echo sprintf( esc_html__('Add sale price for your %1$s here. Avoid comma while adding price.','wdt-portfolio'), strtolower($listing_singular_label) ); ?> </div>
</div>

<div class="wdt-custom-box">
    <label><?php echo esc_html__('Before Price Label','wdt-portfolio'); ?></label>
    <?php $wdt_before_price_label = get_post_meta($list_id, 'wdt_before_price_label', true); ?>
    <input name="wdt_before_price_label" type="text" value="<?php echo esc_attr( $wdt_before_price_label );?>" />
    <div class="wdt-note"><?php echo esc_html__('If needed you can add before price label here.','wdt-portfolio'); ?> </div>
</div>

<div class="wdt-custom-box">
    <label><?php echo esc_html__('After Price Label','wdt-portfolio'); ?></label>
    <?php $wdt_after_price_label = get_post_meta($list_id, 'wdt_after_price_label', true); ?>
    <input name="wdt_after_price_label" type="text" value="<?php echo esc_attr( $wdt_after_price_label );?>" />
    <div class="wdt-note"><?php echo esc_html__('If needed you can add after price label here.','wdt-portfolio'); ?> </div>
</div>