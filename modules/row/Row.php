<?php
/**
 * Class PageEditor_Module_Row_RowShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_Row_RowShortCode' ) ) {
  class PageEditor_Module_Row_RowShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'row';
    }


    /**
     * @return bool
     */
    static function is_container() {
      return true;
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(
        'column-spacing'  => null,
      );
    }


    /**
     * Build the html for this module.
     *
     * @param $attributes
     * @param $add_wrapper bool
     * @param $content string|null
     *
     * @return string
     */
    static function build_html(
      $attributes, $add_wrapper = false, $content = null
    ) {

      $column_spacing = wp_strip_all_tags( $attributes['column-spacing'] );

      // --- --- --- ---

      $classes = array(
        'page-editor_element',
        'page-editor_element_row',
        'page-editor_element_row_column-spacing-'.$column_spacing,
      );

      // --- --- --- ---

      $html = "<div";

      $html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes
      );

      $html .= ">";
      $html .=   "<div class='page-editor_element_row_table'>";
      $html .=     PageEditor_Model_ShortCode_Renderer::do_shortcode( $content );
      $html .=   "</div>";
      $html .= "</div>";

      // --- --- ---

      //
      // Add wrapper if in edit mode
      //
      if ( $add_wrapper ) {
        $html = self::add_wrapper( $html );
      }

      return $html;
    }



  }
}