<?php

class WeFix_Widget_Advance_Template extends WP_Widget {

    #1.constructor
	function __construct() {
		$widget_options = array(
			'classname'   => 'widget_advance_template',
			'description' => esc_html__('To add advance template', 'ai-globe-pro')
		);

        $theme_name =  defined('WEFIX_THEME_NAME') ? WEFIX_THEME_NAME : 'WeFix';
		parent::__construct( false, $theme_name . esc_html__(' Advanced Template','ai-globe-pro'), $widget_options );
	}

	#2.widget input form in back-end
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'templateid'            => '',
		) );

		$templateid            = strip_tags($instance['templateid']);
	?>

        <!-- Form -->
        <p>
        	<label for="<?php echo esc_attr($this->get_field_id('templateid')); ?>">
        		<?php esc_html_e('Template Id:','ai-globe-pro');?>
        		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('templateid')); ?>" name="<?php echo esc_attr($this->get_field_name('templateid')); ?>" type="text" value="<?php echo esc_attr($templateid); ?>"/>
			</label>
		</p>

	   <!-- Form end--><?php
	}

	#3.processes & saves the twitter widget option
	function update( $new_instance,$old_instance ) {
		$instance = $old_instance;

		$instance['templateid']            = strip_tags($new_instance['templateid']);

		return $instance;
	}

	#4.output in front-end
	function widget($args, $instance) {
		extract($args);

		global $post;

		$templateid         = empty($instance['templateid']) ? '' : strip_tags($instance['templateid']);

		echo wefix_pro_before_after_widget( $before_widget );

		echo '<div class="wdt-widget-advanced-template-group">';
			if( !empty( $templateid ) ) {

                if (class_exists("\\Elementor\\Plugin")) {
					$pluginElementor = \Elementor\Plugin::instance();
					$contentElementor = $pluginElementor->frontend->get_builder_content($templateid);
				}
				
				echo $contentElementor;
			}
		echo '</div>';

		echo wefix_pro_before_after_widget( $after_widget );
	}
}
?>