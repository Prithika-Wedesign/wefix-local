<?php
class WeFix_Widget_OrderBy extends WP_Widget {
	#1.constructor
	function __construct() {
		$widget_options = array(
			'classname'   => 'widget_orderby',
			'description' => esc_html__('To display Order By items in a widget for Shop filter area.', 'wefix-pro')
		);

        $theme_name =  defined('WEFIX_THEME_NAME') ? WEFIX_THEME_NAME : 'WeFix';
		parent::__construct( false, $theme_name . esc_html__(' Shop OrderBy Filter','wefix-pro'), $widget_options );
	}

	#2.widget input form in back-end
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'type' => 'dropdown'
		) );

		$title = strip_tags($instance['title']);
		$type = !empty($instance['type']) ? $instance['type'] : 'dropdown';
        ?>
        <p>
        	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
        		<?php esc_html_e('Title:','wefix-pro');?>
        		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
			</label>
		</p>

        <p>
        	<label for="<?php echo esc_attr($this->get_field_id('type')); ?>">
        		<?php esc_html_e('Type','wefix-pro');?>
        	</label>
        	<select class="widefat" id="<?php echo esc_attr($this->get_field_id('type')); ?>" name="<?php echo esc_attr($this->get_field_name('type')); ?>"><?php
        		$options = array('dropdown' => esc_html__('Drop Down', 'wefix-pro'), 'list' => esc_html__('List', 'wefix-pro'));
		   		foreach ($options as $option_key => $option ):
		   			$selected = ($type == $option_key ) ? "selected='selected'" : "";?>
		   			<option <?php echo esc_attr($selected);?> value="<?php echo esc_attr($option_key);?>"><?php echo esc_attr($option);?></option><?php
		   		endforeach;?>
           </select>
        </p>
        <?php
	}

	#4.output in front-end
	function widget($args, $instance) {
		extract($args);

		global $post;

		$title = empty($instance['title']) ? '' : strip_tags($instance['title']);
		$type = isset($instance['type']) ? $instance['type'] : 'dropdown';

		echo wefix_pro_before_after_widget( $before_widget );

		if( !empty( $title ) ) {
			echo wefix_pro_widget_title( $before_title . $title . $after_title );
		}

		echo '<div class="wdt-shop-filters-widget-area">';

            if ( ! woocommerce_products_will_display() ) {
                return;
            }
            $show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', 'menu_order' ) );
            $catalog_orderby_options = apply_filters(
                'woocommerce_catalog_orderby',
                array(
                    'menu_order' => esc_html__( 'Default sorting', 'wefix-pro' ),
                    'popularity' => esc_html__( 'Sort by popularity', 'wefix-pro' ),
                    'rating'     => esc_html__( 'Sort by average rating', 'wefix-pro' ),
                    'date'       => esc_html__( 'Sort by latest', 'wefix-pro' ),
                    'price'      => esc_html__( 'Sort by price: low to high', 'wefix-pro' ),
                    'price-desc' => esc_html__( 'Sort by price: high to low', 'wefix-pro' ),
                )
            );

            $default_orderby = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
            // phpcs:disable WordPress.Security.NonceVerification.Recommended
            $orderby = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby;
            // phpcs:enable WordPress.Security.NonceVerification.Recommended

            if ( wc_get_loop_prop( 'is_search' ) ) {
                $catalog_orderby_options = array_merge( array( 'relevance' => __( 'Relevance', 'woocommerce' ) ), $catalog_orderby_options );

                unset( $catalog_orderby_options['menu_order'] );
            }

            if ( ! $show_default_orderby ) {
                unset( $catalog_orderby_options['menu_order'] );
            }

            if ( ! wc_review_ratings_enabled() ) {
                unset( $catalog_orderby_options['rating'] );
            }

            if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
                $orderby = current( array_keys( $catalog_orderby_options ) );
            }

            wc_get_template(
                'loop/orderby.php',
                array(
                    'catalog_orderby_options' => $catalog_orderby_options,
                    'orderby'                 => $orderby,
                    'show_default_orderby'    => $show_default_orderby,
                    'ordering_display_type'   => $type
                )
            );

	 	echo '</div>';

		echo wefix_pro_before_after_widget( $after_widget );
	}
}?>