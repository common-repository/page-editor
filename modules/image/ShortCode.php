<?php
/**
 * Class PageEditor_Module_Image_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_Image_ShortCode' ) ) {
  class PageEditor_Module_Image_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


		//
		// Setting keys
		//
		private static $setting_key__image  		= 'image';
		private static $setting_key__style  		= 'style';
		private static $setting_key__shadow 		= 'shadow';
		private static $setting_key__shape  		= 'shape';
		private static $setting_key__rendering	= 'rendering';


		//
		// Default values
		//
    private static $default_style       		= 'default';
		private static $default_shadow      		= 'none';
		private static $default_shape       		= 'rectangle';
		private static $default_rendering    		= 'antialised';


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'image';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(

        self::$setting_key__image   	=> PageEditor_Assets::$default_image_with_logo,
        self::$setting_key__style   	=> self::$default_style,
        self::$setting_key__shadow  	=> self::$default_shadow,
        self::$setting_key__shape   	=> self::$default_shape,
        self::$setting_key__rendering	=> self::$default_rendering,

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
		private static function image_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__image
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


		/**
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function rendering_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__rendering
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

			//
			// Build classes
			//
			$classes = [
				'page-editor_element_image',
				'page-editor_element_image_style-' . self::style_from_attributes( $attributes ),
				'page-editor_element_image_shadow-'. self::shadow_from_attributes( $attributes ),
				'page-editor_element_image_shape-' . self::shape_from_attributes( $attributes ),
				'page-editor_element_image_rendering-' . self::rendering_from_attributes( $attributes ),
			];

			// --- --- ---

			//
			// Build Html
			//
			$html = "<div";
      $html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes
      );
			$html .= ">";
			$html .=   "<div>";
			$html .=     "<img src='" . self::image_from_attributes( $attributes ) . "'/>";
			$html .=   "</div>";
			$html .= "</div>";

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