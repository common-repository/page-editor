<?php
/**
 * Class PageEditor_Module_GoogleAdsense_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_GoogleAdsense_ShortCode' ) ) {
  class PageEditor_Module_GoogleAdsense_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {

    //
    // Setting keys
    //
    private static $setting_key__size   = 'size';



    //
    // Default values
    //
    private static $default_value__size = 'leaderboard';


    private static $sizes = [
      'leaderboard'       => 'Leaderboard (728x90)',
      'banner'            => 'Banner (468x60)',
      'half-banner'       => 'Half Banner (234x60)',
      'button'            => 'Button (125x125)',
      'skyscraper'        => 'Skyscraper (120x600)',
      'wide-skyscraper'   => 'Wide Skyscraper (160x600)',
      'small-rectangle'   => 'Small Rectangle (180x150)',
      'vertical-banner'   => 'Vertical Banner (120x240)',
      'small-square'      => 'Small Square (200x200)',
      'square'            => 'Square (250x250)',
      'medium-rectangle'  => 'Medium Rectangle (300x250)',
      'large-rectangle'   => 'Large Rectangle (336x280)',
      'half-page'         => 'Half Page (300x600)',
      'portrait'          => 'Portrait (300x1050)',
      'mobile-banner'     => 'Mobile Banner (320x50)',
      'large-leaderboard' => 'Large Leaderboard (970x90)',
      'billboard'         => 'Billboard (970x250)',
    ];


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'google-adsense';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(
        self::$setting_key__size  => self::$default_value__size,
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
    private static function size_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__size
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
      $size = self::size_from_attributes( $attributes );

      $classes = [
        'page-editor_element_google-adsense'
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