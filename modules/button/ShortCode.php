<?php
/**
 * Class PageEditor_Module_Button_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists('PageEditor_Module_Button_ShortCode') ) {
  class PageEditor_Module_Button_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


    //
    // Setting keys
    //
    private static $setting_key__text             = 'text';
    private static $setting_key__url              = 'url';
    private static $setting_key__target           = 'target';
    private static $setting_key__alignment        = 'alignment';
    private static $setting_key__style            = 'style';
    private static $setting_key__color            = 'color';
    private static $setting_key__shape            = 'shape';
    private static $setting_key__size             = 'size';
    private static $setting_key__full_width       = 'full-width';
    private static $setting_key__hover_animation  = 'hover-animation';

    private static $setting_key__on_click         = 'on-click';


    //
    // Default values
    //
    private static $default__text                 = 'Click me';
    private static $default__url                  = '#';
    private static $default__target               = '_self';
    private static $default__alignment            = 'left';
    private static $default__style                = 'solid';
    private static $default__color                = '#0069d9';
    private static $default__shape                = 'rectangle';
    private static $default__size                 = 'md';
    private static $default__full_width           = 'false';
    private static $default__hover_animation      = 'none';

    private static $default__on_click             = '';


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'button';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(

        self::$setting_key__text            => self::$default__text,
        self::$setting_key__url             => self::$default__url,
        self::$setting_key__target          => self::$default__target,
        self::$setting_key__alignment       => self::$default__alignment,
        self::$setting_key__style           => self::$default__style,
        self::$setting_key__color           => self::$default__color,
        self::$setting_key__shape           => self::$default__shape,
        self::$setting_key__size            => self::$default__size,
        self::$setting_key__full_width      => self::$default__full_width,
        self::$setting_key__hover_animation => self::$default__hover_animation,

        self::$setting_key__on_click        => self::$default__on_click,

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
    private static function url_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
				$attributes, self::$setting_key__url
			);
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function target_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
				$attributes, self::$setting_key__target
			);
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function alignment_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
				$attributes, self::$setting_key__alignment
			);
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function style_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
				$attributes, self::$setting_key__style
			);
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function color_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
				$attributes, self::$setting_key__color
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
    private static function full_width_from_attributes( $attributes ) {
      return self::read_attribute_as_boolean(
				$attributes, self::$setting_key__full_width
			);
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function hover_animation_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
				$attributes, self::$setting_key__hover_animation
			);
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function on_click_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__on_click
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

      $id               = 'page-editor_button_' . uniqid();

      $text             = self::text_from_attributes( $attributes );
      $url              = self::url_from_attributes( $attributes );
      $target           = self::target_from_attributes( $attributes );
      $alignment        = self::alignment_from_attributes( $attributes );
      $style            = self::style_from_attributes( $attributes );
      $color            = self::color_from_attributes( $attributes );
      $shape            = self::shape_from_attributes( $attributes );
      $size             = self::size_from_attributes( $attributes );
      $full_width       = self::full_width_from_attributes( $attributes );
      $hover_animation  = self::hover_animation_from_attributes( $attributes );

      $on_click         = self::on_click_from_attributes( $attributes );

      // --- --- --- ---

      // If no url is provided - default to 'page-editor.com'
			$url = ( $url != null ) ? $url : 'https://page-editor.com';

      //
      // Build Classes
      //
      $classes = array(
        'page-editor_element_button',
        'page-editor_element_button_alignment-'.$alignment,
        'page-editor_element_button_style-'.$style,
        'page-editor_element_button_color-'.$color,
        'page-editor_element_button_shape-'.$shape,
        'page-editor_element_button_size-'.$size,
        'page-editor_element_button_hover-animation-'.$hover_animation,
      );

      if ( $full_width ) {
        $classes[] = 'page-editor_element_button_full-width';
      }

      // --- --- --- ---

      //
      // Build Html
      //
			$html = "<div";
      $html .= self::build_html_element_line(
        $edit_mode, $attributes, self::id(), $classes
      );
			$html .= ">";
      $html .= "<a id='{$id}' href='{$url}'";
      if ( $target != '_self' ) {
        $html .= " target='{$target}'";
      }

      $html .= ">{$text}</a>";
      $html .= "</div>";

      // --- --- ---

      if ( ! $edit_mode ) {
        $html .= self::build_script( $id, $on_click );
      }

      // --- --- --- ---

      //
      // Add wrapper if in edit mode
      //
      if ( $edit_mode ) {
        $html = self::add_wrapper( $html );
      }

      return $html;
    }





    /**
     * @param $button_id
     * @param $on_click
     *
     * @return string
     */
    private static function build_script( $button_id, $on_click ) {

      $html = '';
      $html .= "<div>";
      $html .= "<script>";
      $html .= "jQuery(document).ready(function($) {";

      $html .= "$('#$button_id')";
      $html .=   ".on('click', function(e) {\n";
      $html .=     base64_decode( $on_click );
      $html .=   "\n})";

      $html .= "});";
      $html .= "</script>";
      $html .= "</div>";

      return $html;
    }




  }
}