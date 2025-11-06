<?php
namespace WeFixElementor\Widgets;

use Elementor\Widget_Base;

abstract class WeFixElementorWidgetBase extends Widget_Base {
	/**
	 * Get categories
	 */

	public function get_categories() {
		return [ 'wefix-widgets' ];
	}

	public function wefix_post_categories(){
		$terms = get_terms( array(
			'taxonomy'   => 'category',
			'hide_empty' => true,
		));

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
			foreach ( $terms as $term ) {
				$options[ $term->term_id ] = $term->name;
			}
		}

		return $options;
	}

	public function wefix_get_elementor_page_list(){
		$pagelist = get_posts(array(
			'post_type' => 'elementor_library',
			'showposts' => 999,
		));

		if ( ! empty( $pagelist ) && ! is_wp_error( $pagelist ) ){
			foreach ( $pagelist as $post ) {
				$options[ $post->ID ] = esc_html__( $post->post_title, 'wefix-plus' );
			}
	        return $options;
		}
	}

	public function wefix_post_ids(){
		$posts = get_posts( array(
			'post_type'  => 'post',
			'post_status'=> 'publish',
			'numberposts' => -1
		));

		if ( ! empty( $posts ) && ! is_wp_error( $posts ) ){
			foreach ( $posts as $post ) {
				$options[ $post->ID ] = $post->post_title;
			}
		}

		return $options;
	}

}