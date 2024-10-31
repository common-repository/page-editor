<?php
/**
 * Class PageEditor_Module_Row_ColumnShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_Row_ColumnShortCode' ) ) {
  class PageEditor_Module_Row_ColumnShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'column';
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
        'width' => null,
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
      $width  = wp_strip_all_tags( $attributes['width'] );
      $class  = wp_strip_all_tags( $attributes['class'] );
      $id     = wp_strip_all_tags( $attributes['id'] );

      // --- --- --- ---

      $classes = array(
        'page-editor_element_row_column',
      );
      $classes[] = $class;


      // --- --- --- ---

      $html  = "<div class='" . implode( ' ', $classes ) . "'";
      $html .= " style='width:{$width}'";
      $html .= ">";
      $html .= "<div class='page-editor_element_row_column_element-container page-editor_container'>";

      // Render any shortcodes in the column's content
      $shortcode_html = PageEditor_Model_ShortCode_Renderer::do_shortcode(
        $content
      );

      if ( trim( $shortcode_html ) == '' ) { $shortcode_html = ''; }
      $html .= $shortcode_html;

      $html .= "</div>";
      $html .= "</div>";

      return $html;
    }





  }
}