<?php
/**
 * Class PageEditor_Module_GooglePlusButton_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_GooglePlusButton_ShortCode' ) ) {
  class PageEditor_Module_GooglePlusButton_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'google-plus-button';
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

      $classes = [
        'page-editor_element_raw-js'
      ];

      // --- --- --- --- ---

      // Script must go in a <div> otherwise WordPress will put it in a <p>
      $scriptHtml = "<div><script>jQuery(document).ready(function($) {{$content}});</script></div>";


      //
      // Build edit mode HTML
      //
      if ( $add_wrapper ) {

        $html = "<div";

        $html .= self::build_html_element_line(
          $add_wrapper, $attributes, self::id(), $classes
        );

        $html .= ">";
        //$html .= "<div style='text-align: center'><img style='height: 60px' src='" . self::$icon . "'></div>";
        $html .= "</div>";
        $html .= $scriptHtml;

        // Add wrapper
        $html = self::add_wrapper( $html );
      }


      //
      // Production mode HTML
      //
      else {
        $html = "{$scriptHtml}";
      }


      return $html;
    }


  }
}