<?php
/**
 * Class PageEditor_Module_GoogleMap_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_GoogleMap_ShortCode' ) ) {
  class PageEditor_Module_GoogleMap_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {

    //
    // Setting keys
    //
    private static $setting_key__address    = 'address';
    private static $setting_key__zoom       = 'zoom';
    private static $setting_key__type       = 'type';
    private static $setting_key__height     = 'height';


    //
    // Default values
    //
    private static $default_value__address  = 'Buckingham Palace, Westminster, London SW1A 1AA';
    private static $default_value__zoom     = 15;
    private static $default_value__type     = 'm';
    private static $default_value__height   = 400;


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'google-map';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(
        self::$setting_key__address => self::$default_value__address,
        self::$setting_key__zoom    => self::$default_value__zoom,
        self::$setting_key__type    => self::$default_value__type,
        self::$setting_key__height  => self::$default_value__height,
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
    private static function address_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__address
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function zoom_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__zoom
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function type_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__type
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function height_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__height
      );
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    static function build_url( $address, $zoom, $type ) {
      $address = rawurlencode( $address );
      $zoom    = abs( $zoom );

      return "https://maps.google.com/maps"
        . "?q={$address}"
        . "&amp;t={$type}"
        . "&amp;z={$zoom}"
        . "&amp;output=embed"
        . "&amp;iwloc=near";
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
      $address  = self::address_from_attributes( $attributes );
      $zoom     = self::zoom_from_attributes( $attributes );
      $type     = self::type_from_attributes( $attributes );
      $height   = self::height_from_attributes( $attributes );

      $classes = [
        'page-editor_element_google-map'
      ];

      // --- --- --- ---

      //
      // Build html
      //
      $html = "<div";
      $html .= self::build_html_element_line(
        $edit_mode, $attributes, self::id(), $classes
      );
      $html .= ">";

      // Iframe HTML
      $html .= "<iframe";
      $html .= " src='" . self::build_url( $address, $zoom, $type ) . "'";
      $html .= " width='100%' height='{$height}'";
      $html .= " frameborder='0' allowfullscreen";
      $html .= "></iframe>";

      // Overlay HTML
      if ( $edit_mode ) {
        $html .= '<div class="overlay"></div>';
      }

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