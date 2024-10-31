<?php
/**
 * Class PageEditor_Module_CallToAction_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_CallToAction_ShortCode' ) ) {
  class PageEditor_Module_CallToAction_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


    //
    // Setting keys
    //
    private static $setting_key__heading    = 'heading';
    private static $setting_key__text       = 'text';
    private static $setting_key__width      = 'width';


    //
    // Default values
    //
    private static $default__heading        = '';
    private static $default__text           = '';
    private static $default__width          = '100';


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'call-to-action';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(

        self::$setting_key__heading   => self::$default__heading,
        self::$setting_key__text      => self::$default__text,
        self::$setting_key__width     => self::$default__width,

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
    private static function heading_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
				$attributes, self::$setting_key__heading
			);
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function text_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__text
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function width_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__width
      );
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Build the element html using the given attributes.
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

      $heading = self::heading_from_attributes( $attributes );
      $text    = self::text_from_attributes( $attributes );
      $width   = self::width_from_attributes( $attributes );

      // --- --- --- ---

      //
      // Build Classes
      //
      $classes = array(
        'page-editor_element_call-to-action',
        'page-editor_element_call-to-action_width-'.$width,
      );

      // --- --- --- ---

      //
      // Build Html
      //
			$html = "<div";
      $html .= self::build_html_element_line(
        $edit_mode, $attributes, self::id(), $classes
      );
			$html .= ">";
      $html .= "<section>";
      $html .= "<h2>{$heading}</h2>";
      $html .= "<p>{$text}</p>";
      $html .= "</section>";
      $html .= "</div>";

      // --- --- --- ---

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