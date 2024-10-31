<?php
/**
 * Class PageEditor_Module_Icon_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_Icon_ShortCode' ) ) {
  class PageEditor_Module_Icon_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


		//
		// Setting keys
		//
		private static $setting_key__icon                = 'icon';
		private static $setting_key__icon_color          = 'icon-color';
		private static $setting_key__background_shape    = 'background-shape';
		private static $setting_key__background_color    = 'background-color';
		private static $setting_key__size                = 'size';
		private static $setting_key__alignment           = 'alignment';


		//
		// Default values
		//
		private static $default_icon                    = ['id' => 'angle-double-up', 'style' => 'solid'];
		private static $default_icon_color              = '#2ECC71';
		private static $default_background_shape        = 'circle-outline';
		private static $default_background_color        = '#2ECC71';
		private static $default_size                    = '3x';
		private static $default_alignment               = 'left';


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'icon';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(

        self::$setting_key__icon              => self::$default_icon,
        self::$setting_key__icon_color        => self::$default_icon_color,
        self::$setting_key__background_shape  => self::$default_background_shape,
        self::$setting_key__background_color  => self::$default_background_color,
        self::$setting_key__size              => self::$default_size,
        self::$setting_key__alignment         => self::$default_alignment,

      );
    }


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---



		/**
		 *
		 * @param $attributes
		 *
		 * @return mixed[]
		 */
		private static function icon_from_attributes( $attributes ) {
			return self::read_attribute_as_icon(
				$attributes, self::$setting_key__icon
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function icon_color_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__icon_color
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function background_shape_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__background_shape
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function background_color_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__background_color
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function size_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__size
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function alignment_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__alignment
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

			$icon             = self::icon_from_attributes( $attributes );
			$icon_color       = self::icon_color_from_attributes( $attributes );
			$background_color = self::background_color_from_attributes( $attributes );
			$background_shape = self::background_shape_from_attributes( $attributes );
			$size             = self::size_from_attributes( $attributes );
			$alignment        = self::alignment_from_attributes( $attributes );

			// --- --- ---

			//
			// Build Classes
			//
			$classes = [
				"page-editor_element_icon",
				"page-editor_element_icon_alignment-$alignment",
			];

			$iconClass = PageEditor_Model_FontAwesome::generate_classes_from_object( $icon );
			$backgroundClass = PageEditor_Model_FontAwesome::generate_background_shape_classes( $background_shape );

			// --- --- ---

			//
			// Build Html
			//
			$html = "<div";

      $html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes
      );

			$html .= ">";
			$html .=   "<span class='fa-stack fa-{$size}'>";
			$html .=     "<i class='{$backgroundClass} fa-stack-2x' style='color:{$background_color}'></i>";
			$html .=     "<i class='{$iconClass} fa-stack-1x' style='color:{$icon_color}'></i>";
			$html .=   "</span>";
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