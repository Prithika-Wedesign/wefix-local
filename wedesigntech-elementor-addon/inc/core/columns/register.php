<?php

if (! class_exists ( 'WeDesignTechElementorColumn' )) {

    class WeDesignTechElementorColumn {

        private static $_instance = null;

        public $load_core_scripts = false;
		public $load_sticky_scripts = false;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            add_action( 'elementor/element/container/_section_transform/after_section_end', array( $this, 'after_section_end' ), 10, 2 );
			add_action( 'elementor/frontend/container/before_render', array( $this, 'column_before_render' ) );
			add_action( 'elementor/frontend/element/before_render', array( $this, 'column_before_render' ) );
			add_action( 'elementor/frontend/before_enqueue_scripts',  array( $this, 'enqueue_scripts' ), 10 );

        }

        public function after_section_end( $elementor_object, $args ) {

            if ( \Elementor\Plugin::$instance->breakpoints && method_exists( \Elementor\Plugin::$instance->breakpoints, 'get_active_breakpoints') ) {
                $active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
                $breakpoints_list   = array();

                foreach ($active_breakpoints as $key => $value) {
                    $breakpoints_list[$key] = $value->get_label();
                }

                $breakpoints_list['desktop'] = esc_html__( 'Desktop', 'wdt-elementor-addon' );
                $breakpoints_list            = array_reverse($breakpoints_list);
            } else {
                $breakpoints_list = array(
                    'desktop' => esc_html__( 'Desktop', 'wdt-elementor-addon' ),
                    'tablet'  => esc_html__( 'Tablet', 'wdt-elementor-addon' ),
                    'mobile'  => esc_html__( 'Mobile', 'wdt-elementor-addon' )
                );
            }


            $elementor_object->start_controls_section(
                'wdt_section_options',
                array(
                    'label' => esc_html__( 'WeDesignTech Options', 'wdt-elementor-addon' ),
                    'tab'   => Elementor\Controls_Manager::TAB_LAYOUT,
                )
            );

            $elementor_object->add_control(
                'wdt_sticky_column_css',
                array(
                    'label'        => esc_html__( 'Sticky Column CSS', 'wdt-elementor-addon' ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'     => esc_html__( 'On', 'wdt-elementor-addon' ),
                    'label_off'    => esc_html__( 'Off', 'wdt-elementor-addon' ),
                    'return_value' => 'yes',
                )
            );

            $elementor_object->add_control(
                'wdt_sticky_css_on_devices',
                array(
                    'label'       => esc_html__( 'Sticky CSS On Devices', 'wdt-elementor-addon' ),
                    'type'        => \Elementor\Controls_Manager::SELECT2,
                    'multiple'    => true,
                    'label_block' => 'true',
                    'default'     => array(
                        'desktop',
                        'tablet',
                    ),
                    'condition' => array(
                        'wdt_sticky_column_css' => 'yes',
                    ),
                    'options' => $breakpoints_list,
                )   
            );

            $elementor_object->end_controls_section();

        }

        public function column_before_render( $element ) {

            $data     = $element->get_data();
            $data_id  = $data['id'];
            $type     = (isset($data['elType']) && !empty($data['elType'])) ? $data['elType'] : 'column';

            if('container' !== $type) {
                return false;
            }

            $settings = $data['settings'];

            $sticky_css = isset($settings['wdt_sticky_column_css']) ? filter_var($settings['wdt_sticky_column_css'], FILTER_VALIDATE_BOOLEAN) : false;
            $stickyOn = isset($settings['wdt_sticky_css_on_devices']) ? $settings['wdt_sticky_css_on_devices'] : array('desktop', 'tablet');
            $sticky = false;
            if($sticky_css) {
                $sticky = true;
            }
            if ( $sticky && !empty( $stickyOn ) ) {
                $classes = [ 'wdt-sticky-css wdt-sticky-column-css-' . esc_attr( $data_id ) ];
        
                foreach ( $stickyOn as $device ) {
                    $classes[] = 'wdt-css-sticky-' . esc_attr( $device );
                }

                $column_settings = array(
                    'id'            => $data['id'],
                    'sticky'        => $sticky,
                    'stickyOn'      => isset($settings['wdt_sticky_css_on_devices']) ? $settings['wdt_sticky_css_on_devices'] : array( 'desktop', 'tablet' ),
                );
        
                $element->add_render_attribute( '_wrapper', [
                    'class' => implode( ' ', $classes ),
                    'data-wdt-settings' => wp_json_encode( $column_settings ),
                ]);
            }

        }

        public function enqueue_scripts() {
			
            wp_enqueue_style( 'wdt-elementor-columns', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/core/columns/assets/css/style.css', false, WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, 'all');
            wp_enqueue_script( 'wdt-elementor-columns-js', WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL . 'inc/core/columns/assets/js/script.js', array ('jquery'), WEDESIGNTECH_ELEMENTOR_ADDON_VERSION, true );
			
        }
    }
}
if( !function_exists('wedesigntech_elementor_column') ) {
    function wedesigntech_elementor_column() {
        return WeDesignTechElementorColumn::instance();
    }
}
wedesigntech_elementor_column();
?>