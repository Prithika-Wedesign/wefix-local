<?php

class WeFix_Widget_Advance_Field extends WP_Widget {

    #1.constructor
	function __construct() {
		$widget_options = array(
			'classname'   => 'widget_advance_field',
			'description' => esc_html__('To add advance field', 'wefix-pro')
		);

        $theme_name =  defined('WEFIX_THEME_NAME') ? WEFIX_THEME_NAME : 'WeFix';
		parent::__construct( false, $theme_name . esc_html__(' Advanced Fields','wefix-pro'), $widget_options );
	}

	#2.widget input form in back-end
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'            => '',
			'sub_title'        => '',
			'description'	   => '',
			'button_text'      => '',
			'button_url'       => '',
			'image'        	   => '',
			'image_url'    	   => ''
		) );

		$title            = strip_tags($instance['title']);
		$sub_title        = strip_tags($instance['sub_title']);
		$description      = strip_tags($instance['description']);
		$button_text      = strip_tags($instance['button_text']);
		$button_url       = strip_tags($instance['button_url']);
		$image            = strip_tags($instance['image']);
		$image_url        = strip_tags($instance['image_url']);
	?>

        <!-- Form -->
        <p>
        	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
        		<?php esc_html_e('Title:','wefix-pro');?>
        		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
			</label>
		</p>

		<p>
        	<label for="<?php echo esc_attr($this->get_field_id('sub_title')); ?>">
        		<?php esc_html_e('Sub Title:','wefix-pro');?>
        		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('sub_title')); ?>" name="<?php echo esc_attr($this->get_field_name('sub_title')); ?>" type="text" value="<?php echo esc_attr($sub_title); ?>"/>
			</label>
		</p>

		<p>
        	<label for="<?php echo esc_attr($this->get_field_id('description')); ?>">
        		<?php esc_html_e('Description:','wefix-pro');?>
        		<textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>" type="text" value="<?php echo esc_attr($description); ?>"><?php echo esc_attr($description); ?> </textarea>
			</label>
		</p>

		<p>
        	<label for="<?php echo esc_attr($this->get_field_id('button_text')); ?>">
        		<?php esc_html_e('Button Text:','wefix-pro');?>
        		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('button_text')); ?>" name="<?php echo esc_attr($this->get_field_name('button_text')); ?>" type="text" value="<?php echo esc_attr($button_text); ?>"/>
			</label>
		</p>

		<p>
        	<label for="<?php echo esc_attr($this->get_field_id('button_url')); ?>">
        		<?php esc_html_e('Button Link:','wefix-pro');?>
        		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('button_url')); ?>" name="<?php echo esc_attr($this->get_field_name('button_url')); ?>" type="text" placeholder="https://" value="<?php echo esc_attr($button_url); ?>"/>
			</label>
		</p>

		<p>        
        	<img class="wdt-widget-image-media" src="<?php echo esc_url( $image ); ?>" style="display: block; width: 100%;" />

			<label for="<?php echo esc_attr($this->get_field_id('image_url')); ?>">
        		<?php esc_html_e('Image Link:','wefix-pro');?>
        		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('image_url')); ?>" name="<?php echo esc_attr($this->get_field_name('image_url')); ?>" type="text" placeholder="https://" value="<?php echo esc_attr($image_url); ?>"/>
			</label>

      	</p>
      	<p>
			<input type="hidden" class="wdt-widget-image-hidden-input widefat" name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" value="<?php echo esc_url( $image ); ?>" />
			<input type="button" class="wdt-widget-image-upload-button button button-primary" value="<?php esc_attr_e('Choose Image','lami')?>">
			<input type="button" class="wdt-widget-image-delete-button button" value="<?php esc_attr_e('Remove Image', 'lami') ?>">
      	</p>

	   <!-- Form end--><?php
	}

	#3.processes & saves the twitter widget option
	function update( $new_instance,$old_instance ) {
		$instance = $old_instance;

		$instance['title']            = strip_tags($new_instance['title']);
		$instance['sub_title']        = strip_tags($new_instance['sub_title']);
		$instance['description']      = strip_tags($new_instance['description']);
		$instance['button_text']      = strip_tags($new_instance['button_text']);
		$instance['button_url']       = strip_tags($new_instance['button_url']);
		$instance['image']            = strip_tags($new_instance['image'] );
		$instance['image_url']        = strip_tags($new_instance['image_url']);

		return $instance;
	}

	#4.output in front-end
	function widget($args, $instance) {
		extract($args);

		global $post;

		$title         = empty($instance['title']) ? '' : strip_tags($instance['title']);
		$sub_title     = empty($instance['sub_title']) ? '' : strip_tags($instance['sub_title']);
		$description   = empty($instance['description']) ? '' : strip_tags($instance['description']);
		$button_text   = empty($instance['button_text']) ? '' : strip_tags($instance['button_text']);
		$button_url    = empty($instance['button_url']) ? '' : strip_tags($instance['button_url']);
		$image         = empty($instance['image']) ? '' : strip_tags($instance['image']);
		$image_url     = empty($instance['image_url']) ? '' : strip_tags($instance['image_url']);
	

		echo wefix_pro_before_after_widget( $before_widget );

		if( !empty( $image ) ) {
			$image_url_link = '#';
			$image_url_link_start = $image_url_link_end = '';
			if( isset($image_url) && !empty($image_url) ) {
				$image_url_link = $image_url;
				$image_url_link_start = '<a href="'.esc_attr($image_url_link).'">';
				$image_url_link_end = '</a>';
			}

			echo '<div class="wdt-widget-advanced-media-group">';
			echo $image_url_link_start;
				echo '<img src="'.esc_url($instance['image']).'" alt="'.esc_attr($title).'" title="'.esc_attr($title).'"/>';
			echo $image_url_link_end;
			echo '</div>';
		}

		echo '<div class="wdt-widget-advanced-content-group">';
			if( !empty( $title ) ) {
				echo wefix_pro_widget_title( $before_title . $title . $after_title );
			}

			if( !empty( $sub_title ) ) {
				echo '<h6 class="wdt-widget-advanced-sub-title">';
				echo esc_html($sub_title);
				echo '</h6>';
			}

			if( !empty( $description ) ) {
				echo '<div class="wdt-widget-advanced-description"><p class="widget-description">';
				echo esc_html($description);
				echo '</p></div>';
			}

			if( !empty( $button_url ) && !empty( $button_text ) ) {
				echo '<div class="wdt-widget-advanced-button"><a href="'.esc_attr($button_url).'">';
				echo esc_html($button_text);
				echo '</a></div>';
			}
		echo '</div>';

		echo wefix_pro_before_after_widget( $after_widget );
	}
}
?>