<?php
/**
 * Class PageEditor_Module_NumberInput_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_NumberInput_ShortCode' ) ) {
  class PageEditor_Module_NumberInput_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


		private static $setting_key__label                = 'label';
		private static $setting_key__placeholder          = 'placeholder';
		private static $setting_key__size                 = 'size';
		private static $setting_key__shape                = 'shape';
		private static $setting_key__default              = 'default';
		private static $setting_key__minimum              = 'minimum';
		private static $setting_key__maximum              = 'maximum';
		private static $setting_key__step                 = 'step';
    private static $event_key__on_change              = 'on-change';


		private static $default_setting__label            = null;
		private static $default_setting__placeholder      = null;
		private static $default_setting__size             = null;
		private static $default_setting__shape            = null;
		private static $default_setting__default          = null;
		private static $default_setting__minimum          = null;
		private static $default_setting__maximum          = null;
		private static $default_setting__step             = null;
		private static $default_event__on_change          = null;


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'number-input';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(

        // Settings
        self::$setting_key__label         => self::$default_setting__label,
        self::$setting_key__placeholder   => self::$default_setting__placeholder,
        self::$setting_key__size          => self::$default_setting__size,
        self::$setting_key__shape         => self::$default_setting__shape,
        self::$setting_key__default       => self::$default_setting__default,
        self::$setting_key__minimum       => self::$default_setting__minimum,
        self::$setting_key__maximum       => self::$default_setting__maximum,
        self::$setting_key__step          => self::$default_setting__step,

        // Events
        self::$event_key__on_change       => self::$default_event__on_change,

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
    private static function label_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__label
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function placeholder_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__placeholder
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function size_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__size
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function shape_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__shape
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function default_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__default
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function minimum_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__minimum
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function maximum_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__maximum
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function step_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__step
      );
    }



    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function on_change_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$event_key__on_change
      );
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


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

      $input_id = 'number-input-' . uniqid();

      $label       = self::label_from_attributes( $attributes );
      $placeholder = self::placeholder_from_attributes( $attributes );
      $size        = self::size_from_attributes( $attributes );
      $shape       = self::shape_from_attributes( $attributes );
      $default     = self::default_from_attributes( $attributes );
      $minimum     = self::minimum_from_attributes( $attributes );
      $maximum     = self::maximum_from_attributes( $attributes );
      $step        = self::step_from_attributes( $attributes );

      $on_change   = self::on_change_from_attributes( $attributes );

      // --- --- --- --- ---

      //
      // Build classes and styles
      //
      $classes = [
        'page-editor_element_number-input',
        'page-editor_element_number-input_size-' . $size,
        'page-editor_element_number-input_shape-' . $shape,
      ];

      // --- --- ---

      //
      // Build HTML
      //
      $html = "<div";
      $html .= self::build_html_element_line(
        $edit_mode, $attributes, self::id(), $classes
      );
      $html .= ">";

      // ---

      // Actual input element
      $html .= "<label>";
      $html .= "<span>$label</span>";
      $html .= "<input type='number'";
      if ( ! $edit_mode ) { $html .= " id='{$input_id}'"; }
      if ( $placeholder ) { $html .= " placeholder='{$placeholder}'"; }
      if ( $default !== null ) { $html .= " value='{$default}'"; }
      if ( $minimum !== null ) { $html .= " min='{$minimum}'"; }
      if ( $maximum !== null ) { $html .= " max='{$maximum}'"; }
      if ( $step !== null ) { $html .= " step='{$step}'"; }
      $html .= "/>";
      $html .= "</label>";

      // ---

      $html .= "</div>";

      // --- --- ---

      //
      // Build Script
      //
      if ( ! $edit_mode ) {
        $html .= self::build_script( $input_id, $on_change );
      }

      // --- --- ---

      //
      // Add wrapper if in edit mode
      //
      if ( $edit_mode ) {
        $html = self::add_wrapper( $html );
      }

      return $html;
    }



    /**
     * @param $input_id
     * @param $on_change
     *
     * @return string
     */
    private static function build_script( $input_id, $on_change ) {

      $html = '';
      $html .= "<div>";
      $html .= "<script>";
      $html .= "$(function() {";

      $html .= "$('#{$input_id}')";

      $html .= ".bind('input', function() {\n";
      $html .= "var value = $(this).val();\n";
      $html .= base64_decode( $on_change );
      $html .= "\n})";

      $html .= ";";


      $html .= "});";
      $html .= "</script>";
      $html .= "</div>";

      return $html;
    }



	}
}