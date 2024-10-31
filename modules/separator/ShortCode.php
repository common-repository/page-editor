<?php
/**
 * Class PageEditor_Module_Separator_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_Separator_ShortCode' ) ) {
  class PageEditor_Module_Separator_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


		//
		// Setting keys
		//
		private static $setting_key__color      = 'color';
		private static $setting_key__style      = 'style';
		private static $setting_key__thickness  = 'thickness';


		//
		// Default values
		//
		private static $default_color           = '#BDC3C7';
		private static $default_style           = 'solid';
		private static $default_thickness       = 1;


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'separator';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(

        self::$setting_key__color     => self::$default_color,
        self::$setting_key__style     => self::$default_style,
        self::$setting_key__thickness => self::$default_thickness,

      );
    }


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


		/**
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function color_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__color
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function style_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__style
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function thickness_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__thickness
			);
		}


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


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

			$color      = self::color_from_attributes( $attributes );
			$style      = self::style_from_attributes( $attributes );
			$thickness  = self::thickness_from_attributes( $attributes );

			// ---

			//
			// Build Classes
			//
			$classes = [
				"page-editor_element_separator",
				"page-editor_element_separator_style-$style",
				"page-editor_element_separator_thickness-$thickness",
			];

			// ---

			//
			// Build Styles
			//
			$styles = [];
			if ( $color ) {
				$styles['border-top-color'] = $color;
			}

			// ---

			//
			// Build Html
			//
			$html = '<hr ';
      $html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes, $styles
      );
			$html .= " />";

			// ---

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