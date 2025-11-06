<?php

namespace WeFixElementor\Widgets;
use WeFixElementor\Widgets\WeFix_Shop_Widget_Product_Summary;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;


class WeFix_Shop_Widget_Product_Summary_Extend extends WeFix_Shop_Widget_Product_Summary {

	function dynamic_register_controls() {

		$this->start_controls_section( 'product_summary_extend_section', array(
			'label' => esc_html__( 'Social Options', 'wefix-pro' ),
		) );

			$this->add_control( 'share_follow_type', array(
				'label'   => esc_html__( 'Share / Follow Type', 'wefix-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'share',
				'options' => array(
					''       => esc_html__('None', 'wefix-pro'),
					'share'  => esc_html__('Share', 'wefix-pro'),
					'follow' => esc_html__('Follow', 'wefix-pro'),
				),
				'description' => esc_html__( 'Choose between Share / Follow you would like to use.', 'wefix-pro' ),
			) );

			$this->add_control( 'social_icon_style', array(
				'label'   => esc_html__( 'Social Icon Style', 'wefix-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'simple'        => esc_html__( 'Simple', 'wefix-pro' ),
					'bgfill'        => esc_html__( 'BG Fill', 'wefix-pro' ),
					'brdrfill'      => esc_html__( 'Border Fill', 'wefix-pro' ),
					'skin-bgfill'   => esc_html__( 'Skin BG Fill', 'wefix-pro' ),
					'skin-brdrfill' => esc_html__( 'Skin Border Fill', 'wefix-pro' ),
				),
				'description' => esc_html__( 'This option is applicable for all buttons used in product summary.', 'wefix-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

			$this->add_control( 'social_icon_radius', array(
				'label'   => esc_html__( 'Social Icon Radius', 'wefix-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'square'  => esc_html__( 'Square', 'wefix-pro' ),
					'rounded' => esc_html__( 'Rounded', 'wefix-pro' ),
					'circle'  => esc_html__( 'Circle', 'wefix-pro' ),
				),
				'condition'   => array(
					'social_icon_style' => array ('bgfill', 'brdrfill', 'skin-bgfill', 'skin-brdrfill'),
					'share_follow_type' => array ('share', 'follow')
				),
			) );

			$this->add_control( 'social_icon_inline_alignment', array(
				'label'        => esc_html__( 'Social Icon Inline Alignment', 'wefix-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'wefix-pro' ),
				'label_off'    => esc_html__( 'no', 'wefix-pro' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'This option is applicable for all buttons used in product summary.', 'wefix-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

		$this->end_controls_section();

	}

}