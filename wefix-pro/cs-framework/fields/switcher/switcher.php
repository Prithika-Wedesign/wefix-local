<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Switcher
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_switcher extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    echo apply_filters( 'cs_element_before', $this->element_before() );
    $label = ( isset( $this->field['label'] ) ) ? '<div class="cs-text-desc">'. $this->field['label'] . '</div>' : '';
    echo '<label><input type="checkbox" name="'. esc_attr($this->element_name()) .'" value="1"'. wefix_html_output($this->element_class()) . $this->element_attributes() . checked( $this->element_value(), 1, false ) .'/><em data-on="'. esc_attr__( 'on', 'wefix-pro' ) .'" data-off="'. esc_attr__( 'off', 'wefix-pro' ) .'"></em><span></span></label>' . wefix_html_output($label);
    echo apply_filters( 'cs_element_after', $this->element_after() );
  }

}
