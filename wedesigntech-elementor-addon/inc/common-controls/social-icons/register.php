<?php

class WeDesignTech_Common_Controls_Social_Icons {

	private $add_as_section;

    function __construct($add_as_section = false) {
		$this->add_as_section = $add_as_section;
    }

    public function init_styles() {
		return array ();
	}

	public function init_scripts() {
		return array ();
	}

	public function get_controls($elementor_object) {

		if($this->add_as_section) {
			$elementor_object->start_controls_section( 'wdt_section_social_icons', array(
				'label' => esc_html__( 'Social Icons', 'wdt-elementor-addon'),
			) );
		}

			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
				'icon',
				array (
					'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => array( 'value' => 'fab fa-wordpress', 'library' => 'fa-brands' ),
					'recommended' => array (
						'fa-brands' => array (
							'android',
							'apple',
							'behance',
							'bitbucket',
							'codepen',
							'delicious',
							'deviantart',
							'digg',
							'dribbble',
							'elementor',
							'facebook',
							'flickr',
							'foursquare',
							'free-code-camp',
							'github',
							'gitlab',
							'globe',
							'houzz',
							'instagram',
							'jsfiddle',
							'linkedin',
							'medium',
							'meetup',
							'mix',
							'mixcloud',
							'odnoklassniki',
							'pinterest',
							'product-hunt',
							'reddit',
							'shopping-cart',
							'skype',
							'slideshare',
							'snapchat',
							'soundcloud',
							'spotify',
							'stack-overflow',
							'steam',
							'telegram',
							'thumb-tack',
							'tripadvisor',
							'tumblr',
							'twitch',
							'twitter',
							'viber',
							'vimeo',
							'vk',
							'weibo',
							'weixin',
							'whatsapp',
							'wordpress',
							'xing',
							'yelp',
							'youtube',
							'500px',
						),
						'fa-solid' => array (
							'envelope',
							'link',
							'rss',
						),
					),
				)
			);

			$repeater->add_control( 'link', array(
				'label'       => esc_html__( 'Link', 'wdt-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'label_block' => true,
				'default' => array (
					'is_external' => 'true',
				),
				'dynamic' => array (
					'active' => true,
				),
				'placeholder' => esc_html__( 'https://your-link.com', 'wdt-elementor-addon' )
			) );

			$elementor_object->add_control( 'social_icons', array(
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'label'       => esc_html__('Social Icons', 'wdt-elementor-addon'),
				'description' => esc_html__('Social Icons', 'wdt-elementor-addon' ),
				'fields'      => $repeater->get_controls(),
				'default' => array (
					array (
						'icon' => array (
							'value' => 'fab fa-facebook',
							'library' => 'fa-brands',
						),
					),
					array (
						'icon' => array (
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands',
						),
					),
					array (
						'icon' => array (
							'value' => 'fab fa-youtube',
							'library' => 'fa-brands',
						),
					),
				),
				'title_field' => '{{{ elementor.helpers.getSocialNetworkNameFromIcon( icon, false, true, false, true ) }}}'
			) );


		if($this->add_as_section) {
			$elementor_object->end_controls_section();
		}

	}

    public function render_html($social_icons) {

        $output = '';

        if(is_array($social_icons) && !empty($social_icons)) {
			$output .= '<ul class="wdt-social-icons-list">';
            foreach( $social_icons as $key => $social_item ) {

				$link_start = $link_end = '';
				if( !empty( $social_item['link']['url'] ) ){
					$target = ( $social_item['link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
					$nofollow = ( $social_item['link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';
					$link_start = '<a href="'.esc_url( $social_item['link']['url'] ).'"'. $target . $nofollow.'>';
					$link_end = '</a>';
				}

				$output .= '<li>';
					$output .= $link_start;
						ob_start();
						\Elementor\Icons_Manager::render_icon( $social_item['icon'], [ 'aria-hidden' => 'true' ] );
						$output .= ob_get_clean();
					$output .= $link_end;
				$output .= '</li>';

            }
			$output .= '</ul>';
        }

        return $output;

    }

}