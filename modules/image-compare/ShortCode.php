<?php
/**
 * Class PageEditor_Module_ImageCompare_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_ImageCompare_ShortCode' ) ) {
  class PageEditor_Module_ImageCompare_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


		//
		// Setting keys
		//
		private static $setting_key__image1       = 'image-1';
		private static $setting_key__image2       = 'image-2';
    private static $setting_key__aspect_ratio = 'aspect-ratio';
		private static $setting_key__style        = 'style';
		private static $setting_key__shadow       = 'shadow';
		private static $setting_key__shape        = 'shape';


		//
		// Default values
		//
		private static $default_aspect_ratio  = '16-9';
		private static $default_style         = 'default';
		private static $default_shadow        = 'none';
		private static $default_shape         = 'rectangle';


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'image-compare';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(

        self::$setting_key__image1        => PageEditor_Assets::$default_image_with_logo,
        self::$setting_key__image2        => PageEditor_Assets::$default_image,
        self::$setting_key__aspect_ratio  => self::$default_aspect_ratio,
        self::$setting_key__style         => self::$default_style,
        self::$setting_key__shadow        => self::$default_shadow,
        self::$setting_key__shape         => self::$default_shape,

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
		private static function image1_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__image1
			);
		}

		/**
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function image2_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__image2
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function aspect_ratio_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__aspect_ratio
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
		private static function shadow_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__shadow
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function shape_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__shape
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

      $aspect_ratio = self::aspect_ratio_from_attributes( $attributes );

			//
			// Build classes
			//
			$classes = [
				'page-editor_element_image-compare',
				'page-editor_element_image-compare_aspect-ratio-' . $aspect_ratio
			];

			// --- --- ---

			//
			// Build Html
			//
			$html = "<div";
      $html .= self::build_html_element_line(
        $edit_mode, $attributes, self::id(), $classes
      );
			$html .= ">";
			$html .=   "<div class='page-editor_element_image-compare_wrapper'>";

			$element_id = "page-editor_image-compare_".uniqid();
			$html .=     "<div class='cocoen' id='{$element_id}'>";
			$html .=       "<img class='image-1' src='" . self::image1_from_attributes( $attributes ) . "'/>";
			$html .=       "<img class='image-2' src='" . self::image2_from_attributes( $attributes ) . "'/>";
			$html .=     "</div>";

			$html .=   "</div>";

      // Overlay
      if ( $edit_mode ) {
        $html .= '<div class="overlay"></div>';
      }

			$html .= "</div>";

			// --- --- ---

      //
      // Script
      //
      if ( ! $edit_mode ) {
        $html .= "<div>";
        $html .= "<script>";
        $html .= "jQuery(document).ready(function($) { new Cocoen(document.getElementById('{$element_id}')); });";
        $html .= "</script>";
        $html .= "</div>";
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


	}
}