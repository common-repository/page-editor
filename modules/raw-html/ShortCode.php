<?php
/**
 * Class PageEditor_Module_RawHtml_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_RawHtml_ShortCode' ) ) {
  class PageEditor_Module_RawHtml_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'raw-html';
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

      $attributes['raw-html'] = $content;

      // --- --- --- --- ---

      $classes = [
        'page-editor_element_raw-html'
      ];

      // --- --- --- --- ---

      //
      // Build edit mode HTML
      //
      if ( $add_wrapper ) {

        $html = "<div";

        $html .= self::build_html_element_line(
          $add_wrapper, $attributes, self::id(), $classes
        );

        $html .= ">";
        $html .= $content;
        $html .= "</div>";

        $html = self::add_wrapper( $html );
      }


      //
      // Production mode HTML
      //
      else {
        $html = $content;
      }

      // --- --- --- --- ---

      return $html;
    }


  }
}