<?php

if ( ! class_exists( 'PageEditor_Module_Breadcrumb_ShortCode' ) ) {
  class PageEditor_Module_Breadcrumb_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'breadcrumb';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array();
    }


    /**
     * Build the html for this module.
     *
     * @param $attributes
     * @param $edit_mode bool
     * @param $content string|null
     *
     * @return string
     */
    static function build_html(
      $attributes, $edit_mode = false, $content = null
    ) {
      $attributes = shortcode_atts( array(
        'class'               => null,
        'id'                  => null,
      ), $attributes, self::signature() );

      // --- --- --- ---

      $class = wp_strip_all_tags( $attributes['class'] );
      $id    = wp_strip_all_tags( $attributes['id'] );

      // --- --- --- ---

      $classes = array(
        'page-editor_element',
        'page-editor_element_breadcrumb',
      );
      $classes[] = $class;

      // --- --- --- ---

      $html = "<div class='" . implode(' ', $classes);
      if ( $id != null && $id != '' ) { $html .= " id='".$id."'"; }
      $html .= "' data-page-editor-element-type='breadcrumb'>";
      $html .= $content;
      $html .= "</div>";

      return $html;
    }



  }
}