<?php
/**
 * Class PageEditor_Module_Heading_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_Heading_ShortCode' ) ) {
  class PageEditor_Module_Heading_ShortCode
		extends PageEditor_Model_ShortCode_BaseShortCode {


		//
		// Setting keys
		//
		private static $setting_key__text             = 'text';
		private static $setting_key__element_tag      = 'element-tag';
		private static $setting_key__alignment        = 'alignment';
		private static $setting_key__font_size        = 'font-size';
		private static $setting_key__font_weight      = 'font-weight';
		private static $setting_key__underline        = 'underline';
		private static $setting_key__italic           = 'italic';
		private static $setting_key__letter_spacing   = 'letter-spacing';
		private static $setting_key__word_spacing     = 'word-spacing';
		private static $setting_key__effect           = 'effect';


		//
		// Default values
		//
		private static $default__text                 = 'Custom heading';
		private static $default__element_tag          = 'h2';
		private static $default__alignment            = 'left';
		private static $default__font_size            = 'default';
		private static $default__font_weight          = 400;
		private static $default__underline            = false;
		private static $default__italic               = false;
		private static $default__letter_spacing       = '0';
		private static $default__word_spacing         = '0';
		private static $default__effect               = 'none';


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'heading';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(

        self::$setting_key__text            => self::$default__text,
        self::$setting_key__element_tag     => self::$default__element_tag,
        self::$setting_key__alignment       => self::$default__alignment,
        self::$setting_key__font_size       => self::$default__font_size,
        self::$setting_key__font_weight     => self::$default__font_weight,
        self::$setting_key__underline       => self::$default__underline,
        self::$setting_key__italic          => self::$default__italic,
        self::$setting_key__letter_spacing  => self::$default__letter_spacing,
        self::$setting_key__word_spacing    => self::$default__word_spacing,
        self::$setting_key__effect          => self::$default__effect,

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
		private static function element_tag_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__element_tag
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
		private static function font_size_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__font_size
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function font_weight_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__font_weight
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function underline_from_attributes( $attributes ) {
			return self::read_attribute_as_boolean(
				$attributes, self::$setting_key__underline
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function italic_from_attributes( $attributes ) {
			return self::read_attribute_as_boolean(
				$attributes, self::$setting_key__italic
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function letter_spacing_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__letter_spacing
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function word_spacing_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__word_spacing
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function effect_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__effect
			);
		}


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
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

			$text             = self::text_from_attributes( $attributes );
			$element_tag      = self::element_tag_from_attributes( $attributes );
			$alignment        = self::alignment_from_attributes( $attributes );
			$font_size        = self::font_size_from_attributes( $attributes );
			$font_weight      = self::font_weight_from_attributes( $attributes );
			$underline        = self::underline_from_attributes( $attributes );
			$italic           = self::italic_from_attributes( $attributes );
			$letter_spacing   = self::letter_spacing_from_attributes( $attributes );
			$word_spacing     = self::word_spacing_from_attributes( $attributes );
			$effect           = self::effect_from_attributes( $attributes );

			//
			// Build Classes
			//
			$classes = array(
				'page-editor_element_heading',
				'page-editor_element_heading_alignment-'.$alignment,
				'page-editor_element_heading_font-size-'.$font_size,
				'page-editor_element_heading_font-weight-'.$font_weight,
				'page-editor_element_heading_effect-'.$effect,
			);

      if ( $underline ) {
        $classes[] = 'page-editor_element_heading_underline';
      }
      if ( $italic ) {
        $classes[] = 'page-editor_element_heading_italic';
      }


			//
			// Build Html
			//
      $header_styles_string = PageEditor_Util::build_styles_string( array(
        'letter-spacing' => $letter_spacing . 'px',
        'word-spacing'   => $word_spacing . 'px',
      ) );

      // ---

			$html = "<div";

      $html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes
      );

			$html .= ">";
      $html .=   "<{$element_tag} style='{$header_styles_string}'>";
      $html .=     $text;
      $html .=   "</{$element_tag}>";
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