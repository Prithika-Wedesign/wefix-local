<?php

abstract class WeDesignTech_Elementor_Widget_Base extends \Elementor\Widget_Base {

	public function __construct( $data, $args ) {
		parent::__construct( $data, $args );
	}

	public function get_categories() {
		return [ 'wdt-widgets' ];
	}

	public function get_elementor_page_list(){
		$pagelist = get_posts(array(
			'post_type' => 'elementor_library',
			'showposts' => 999,
		));

		if ( ! empty( $pagelist ) && ! is_wp_error( $pagelist ) ){
			foreach ( $pagelist as $post ) {
				$options[ $post->ID ] = esc_html( $post->post_title );
			}
	        return $options;
		}
	}

}