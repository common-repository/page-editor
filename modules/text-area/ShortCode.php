<?php
/**
 * Class PageEditor_Module_TextArea_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_TextArea_ShortCode' ) ) {
  class PageEditor_Module_TextArea_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


		private static $setting_key__height = 'height';

		private static $default_height      = 100;


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'text-area';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(

        self::$setting_key__height  => self::$default_height,

      );
    }


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function height_from_attributes( $attributes ) {
			return wp_strip_all_tags( $attributes[ self::$setting_key__height ] );
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

      //
      // Build classes and styles
      //
      $classes = [
        'page-editor_element_text-area'
      ];

      $styles = [
        'height' => self::format_dimension(
          self::height_from_attributes( $attributes )
        ),
      ];

      // --- --- ---

      //
      // Build HTML
      //
      $html = "<textarea";
      $html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes
      );
      $html .= ">";
      $html .= "</textarea>";

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