<?php
/**
 * Class PageEditor_Module_EmptySpace_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_EmptySpace_ShortCode' ) ) {
  class PageEditor_Module_EmptySpace_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


    //
    // Setting keys
    //
		private static $setting_key__height = 'height';


    //
    // Default values
    //
		private static $default_height      = 100;


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'empty-space';
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


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function height_from_attributes( $attributes ) {
			return PageEditor_Util::strip_all_tags(
        $attributes[ self::$setting_key__height ]
      );
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

      //
      // Build classes and styles
      //
      $classes = [
        'page-editor_element_empty-space'
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
      $html = "<div";
      $html .= self::build_html_element_line(
        $edit_mode, $attributes, self::id(), $classes, $styles
      );
      $html .= ">";
      $html .= "</div>";

      // --- --- ---

      //
      // Add wrapper if in edit mode
      //
      if ( $edit_mode ) {
        $html = self::add_wrapper( $html );
      }

      return $html;
    }


  }
}