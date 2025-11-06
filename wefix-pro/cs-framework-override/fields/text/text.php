<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Text
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_text extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output(){

    echo apply_filters( 'cs_element_before', $this->element_before() );
    echo '<input type="'. esc_attr($this->element_type()) .'" name="'. esc_attr($this->element_name()) .'" value="'. esc_attr($this->element_value()) .'"'. wefix_html_output($this->element_class()) . $this->element_attributes() .'/>';
    if( isset( $this->field['slugify_title'] ) ){
        echo "<br>".'<label>'.esc_html__('Menu Slug', 'wefix-pro').'</label>';
        echo '<input type="'. esc_attr($this->element_type()) .'" name="menu-slug" value="'. esc_attr($this->slugify($this->element_value())) .'"'. wefix_html_output($this->element_class()) . $this->element_attributes() .' readonly />';
    }
    echo apply_filters( 'cs_element_after', $this->element_after() );
  }

  public function slugify($string){
    if($string != '') {
        $string = str_replace(' ', '-', strtolower($string));
    }
    return $string;
  }

}
