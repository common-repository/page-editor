<?php
/**
 * Class PageEditor_Module_TextBlock_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_TextBlock_ShortCode' ) ) {
  class PageEditor_Module_TextBlock_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'text-block';
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
     * @param $add_wrapper bool
     * @param $content string|null
     *
     * @return string
     */
    static function build_html(
      $attributes, $add_wrapper = false, $content = null
    ) {
      $attributes['content'] = $content;

      // --- --- --- --- ---

      $classes = [
        'page-editor_element_text-block'
      ];

      // --- --- --- --- ---

      $html = "<div";

      $html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes
      );

      $html .= ">";

      /** @noinspection PhpUndefinedFunctionInspection */
      $html .= wpautop( $content );

      $html .= "</div>";

      // --- --- --- ---

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