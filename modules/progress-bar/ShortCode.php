<?php
/**
 * Class PageEditor_Module_ProgressBar_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_ProgressBar_ShortCode' ) ) {
  class PageEditor_Module_ProgressBar_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


		//
		// Setting keys
		//
		private static $setting_key__percentage   = 'percentage';
		private static $setting_key__color        = 'color';
		private static $setting_key__size         = 'size';
		private static $setting_key__shape        = 'shape';
		private static $setting_key__striped      = 'striped';
		private static $setting_key__animated     = 'animated';


		//
		// Default values
		//
		private static $default_percentage        = 75.0;
		private static $default_color             = '#3498DB';
		private static $default_size              = 'md';
		private static $default_shape             = 'rounded';
		private static $default_striped           = true;
		private static $default_animated          = true;


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'progress-bar';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(

        self::$setting_key__percentage  => self::$default_percentage,
        self::$setting_key__color       => self::$default_color,
        self::$setting_key__size        => self::$default_size,
        self::$setting_key__shape       => self::$default_shape,
        self::$setting_key__striped     => self::$default_striped,
        self::$setting_key__animated    => self::$default_animated,

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
		private static function percentage_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__percentage
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function color_from_attributes( $attributes ) {
			return self::read_attribute_as_string( $attributes, self::$setting_key__color );
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function size_from_attributes( $attributes ) {
			return self::read_attribute_as_string( $attributes, self::$setting_key__size );
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function shape_from_attributes( $attributes ) {
			return self::read_attribute_as_string( $attributes, self::$setting_key__shape );
		}


		/**
		 * @param $attributes
		 *
		 * @return boolean
		 */
		private static function striped_from_attributes( $attributes ) {
			return self::read_attribute_as_boolean( $attributes, self::$setting_key__striped );
		}


		/**
		 * @param $attributes
		 *
		 * @return boolean
		 */
		private static function animated_from_attributes( $attributes ) {
			return self::read_attribute_as_boolean( $attributes, self::$setting_key__animated );
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

			$percentage = self::percentage_from_attributes( $attributes );
			$color = self::color_from_attributes( $attributes );
			$size = self::size_from_attributes( $attributes );
			$shape = self::shape_from_attributes( $attributes );
			$striped = self::striped_from_attributes( $attributes );
			$animated = self::animated_from_attributes( $attributes );

			// ---

			//
			// Build Classes
			//
			$classes = array( 'page-editor_element_progress-bar' );
			if ( $size != null ) { $classes[] = "page-editor_element_progress-bar_size-$size"; }
			if ( $shape != null ) { $classes[] = "page-editor_element_progress-bar_shape-$shape"; }
			if ( $striped ) { $classes[] = "page-editor_element_progress-bar_striped"; }
			if ( $animated ) { $classes[] = "page-editor_element_progress-bar_animated"; }

			// --- --- --- --- ---

			//
			// Build Html
			//
			$html = "<div";

      $html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes
      );

			$html .= ">";
			$html .=   "<div class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' data-percentage='{$percentage}' style='width:{$percentage}%;background-color:{$color}'></div>";
			$html .= "</div>";

			// --- --- --- ---

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