<?php
use WeFixElementor\Widgets\WeFixElementorWidgetBase;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Header_Menu extends WeFixElementorWidgetBase {

    public function get_name() {
        return 'wdt-header-menu';
    }

    public function get_title() {
        return esc_html__('Header Menu', 'wefix-plus');
    }

    public function get_icon() {
		return 'eicon-header wdt-icon';
	}

    protected function register_controls() {

		$nav_menus = array( 0 => esc_html__('Select Menu', 'wefix-plus')  );
		$menus     = wp_get_nav_menus();

		foreach ($menus as $menu ) {
			$nav_menus[$menu->term_id] = $menu->name;
		}

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'wefix-plus'),
        ) );
            $this->add_control( 'nav_type', array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Navigation Type', 'wefix-plus'),
				'default' => 'primary-nav',
				'options' => array(
                    'primary-nav' => esc_html__('Primary Nav','wefix-plus'),
                    'secondary-nav' => esc_html__('Secondary Nav','wefix-plus')
                )
            ) );

            $this->add_control( 'nav_id', array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Choose Menu', 'wefix-plus'),
				'default' => '0',
				'options' => $nav_menus
            ) );

            $this->add_responsive_control( 'align', array(
                'label'        => esc_html__( 'Alignment', 'wefix-plus' ),
                'type'         => Controls_Manager::CHOOSE,
                'prefix_class' => 'elementor%s-align-',
                'options'      => array(
                    'left'   => array( 'title' => esc_html__('Left','wefix-plus'), 'icon' => 'eicon-h-align-left' ),
                    'center' => array( 'title' => esc_html__('Center','wefix-plus'), 'icon' => 'eicon-h-align-center' ),
                    'right'  => array( 'title' => esc_html__('Right','wefix-plus'), 'icon' => 'eicon-h-align-right' ),
                )
            ) );
        $this->end_controls_section();

        $this->start_controls_section( 'wdt_section_typography', array(
        	'label'      => esc_html__( 'Menu', 'wefix-plus' ),
			'tab'        => Controls_Manager::TAB_STYLE,
			'show_label' => false,
		) );

			$this->add_group_control( Group_Control_Typography::get_type(), array(
                'label'      => esc_html__( 'Menu Typography', 'wefix-plus' ),
				'name'     => 'menu_typography',
				'selector' => '{{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li > a',
				'separator' => 'before',
			) );

			$this->add_group_control( Group_Control_Typography::get_type(), array(
                'label'      => esc_html__( 'Sub Menu Typography', 'wefix-plus' ),
				'name'     => 'sub_menu_typography',
				'selector' => '{{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav li ul.sub-menu li > a',
				'separator' => 'before',
			) );

        $this->end_controls_section();

        $this->start_controls_section( 'wdt_section_color', array(
        	'label'      => esc_html__( 'Colors', 'wefix-plus' ),
			'tab'        => Controls_Manager::TAB_STYLE,
			'show_label' => false,
		) );

			$this->add_control( 'menu_color', array(
				'label'     => esc_html__( 'Menu Color', 'wefix-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => array( '{{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li > a' => 'color: {{VALUE}}' )
			) );

			$this->add_control( 'menu_hover_color', array(
				'label'     => esc_html__( 'Menu Hover Color', 'wefix-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => array( '
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li.focus > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li:focus > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li:hover > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li > a.focus,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li > a:focus,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li > a:hover,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li.current-menu-item > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li.current-page-item > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li.current-menu-ancestor > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li.current-page-ancestor > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li.current_menu_item > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li.current_page_item > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li.current_menu_ancestor > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li.current_page_ancestor > a' => 'color: {{VALUE}}' )
			) );

			$this->add_control( 'sub_menu_color', array(
				'label'     => esc_html__( 'Sub Menu Color', 'wefix-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => array( '{{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav li ul.sub-menu li > a' => 'color: {{VALUE}}' )
			) );

			$this->add_control( 'sub_menu_hover_color', array(
				'label'     => esc_html__( 'Sub Menu Hover Color', 'wefix-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => array( '
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li.focus > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li:focus > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li:hover > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li > a.focus,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li > a:focus,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li > a:hover,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li.current-menu-item > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li.current-page-item > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li.current-menu-ancestor > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li.current-page-ancestor > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li.current_menu_item > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li.current_page_item > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li.current_menu_ancestor > a,
                {{WRAPPER}} .wdt-header-menu .menu-container .wdt-primary-nav > li ul.sub-menu > li.current_page_ancestor > a' => 'color: {{VALUE}}' )
			) );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

        $nav_class = '';
        if($nav_type == 'secondary-nav') {
            $nav_class = 'wdt-secondary-nav';
        }

        $navigation = wp_nav_menu( array(
        	'menu'            => $nav_id,
			'container_class' => 'menu-container',
			'items_wrap'      => '<ul id="%1$s" class="%2$s" data-menu="'.esc_attr($nav_id).'"> <li class="close-nav">
			<a href="#"></a></li> %3$s </ul> <div class="sub-menu-overlay"></div>',
			'menu_class'      => 'wdt-primary-nav '.$nav_class,
			'link_before'     => '<span data-text="%1$s">',
			'link_after'      => '</span>',
            'walker'          => new WeFix_Walker_Nav_Menu,
            'echo'            => false
        ) );

        $out = '<div class="wdt-header-menu" data-menu="'.esc_attr( $nav_id ).'">';

        	$out .= $navigation;

            if($nav_type == 'primary-nav') {
                $out .= '<div class="mobile-nav-container mobile-nav-offcanvas-right" data-menu="'.esc_attr( $nav_id ).'">';
                    $out .= '<a href="#" class="menu-trigger menu-trigger-icon" data-menu="'.esc_attr( $nav_id ).'">';
                        $out .= '<i></i>';
                        $out .= '<span>'.esc_html__('Menu', 'wefix-plus').'</span>';
                    $out .= '</a>';
                    $out .= '<div class="mobile-menu" data-menu="'.esc_attr( $nav_id ).'"></div>';
                    $out .= '<div class="overlay"></div>';
                $out .= '</div>';
            }

        $out .= '</div>';

        echo wefix_html_output($out);
    }

}