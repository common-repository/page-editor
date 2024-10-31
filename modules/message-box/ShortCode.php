<?php
/**
 * Class PageEditor_Module_MessageBox_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_MessageBox_ShortCode' ) ) {
  class PageEditor_Module_MessageBox_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


		//
		// Setting keys
		//
		private static $setting_key__text           = 'text';
		private static $setting_key__text_size      = 'text-size';
		private static $setting_key__text_color     = 'text-color';
		private static $setting_key__text_opacity   = 'text-opacity';

		private static $setting_key__icon           = 'icon';
		private static $setting_key__icon_size      = 'icon-size';
		private static $setting_key__icon_color     = 'icon-color';

		private static $setting_key__style          = 'style';
		private static $setting_key__shape          = 'shape';
		private static $setting_key__color          = 'color';
		private static $setting_key__dismissible    = 'dismissible';


		/*
		 * Default values
		 */
		private static $default_text                = 'I am a Message Box! Click me to edit.';
		private static $default_text_size           = 18;
		private static $default_text_color          = '#ffffff';
		private static $default_text_opacity        = 70;

		private static $default_icon                = array( 'id' => 'check-circle', 'style' => 'regular' );
		private static $default_icon_size           = 'small';
		private static $default_icon_color          = '#ffffff';

		private static $default_style               = 'solid';
		private static $default_shape               = 'square';
		private static $default_color               = '#2ECC71';
		private static $default_dismissible         = true;


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'message-box';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
			return array(

				self::$setting_key__text          => self::$default_text,
				self::$setting_key__text_size     => self::$default_text_size,
				self::$setting_key__text_color    => self::$default_text_color,
				self::$setting_key__text_opacity  => self::$default_text_opacity,

				self::$setting_key__icon          => self::$default_icon,
				self::$setting_key__icon_size     => self::$default_icon_size,
				self::$setting_key__icon_color    => self::$default_icon_color,

				//self::$setting_key__style         => self::$default_style,
				//self::$setting_key__shape         => self::$default_shape,
				self::$setting_key__color         => self::$default_color,
				self::$setting_key__dismissible   => self::$default_dismissible,

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
		private static function text_size_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__text_size
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function text_color_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__text_color
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function text_opacity_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__text_opacity
			);
		}


		/**
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
		 * @return string|null
		 */
		private static function icon_size_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__icon_size
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function icon_color_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__icon_color
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
		private static function color_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__color
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return boolean
		 */
		private static function dismissible_from_attributes( $attributes ) {
			return self::read_attribute_as_boolean(
				$attributes, self::$setting_key__dismissible
			);
		}


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


		/**
		 * Build a html style string from the given styles array.
		 *
		 * @param $styles
		 *
		 * @return string
		 */
		private static function build_style_string( $styles ) {
			$style_string = '';
			foreach ( $styles as $key => $value ) {
				$style_string .= "$key:$value;";
			}
			return count( $styles ) > 0 ? ' style="'.$style_string.'"' : '';
		}


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


		/**
		 * Build the html for the dismiss button component.
		 *
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function build_dimiss_button_html( $attributes ) {
			//if ( $dismissible ) {
			//  $html .= "<button type='button' class='close' data-dismiss='alert'>×</button>";
			//}
			return '';
		}


		/**
		 * Build the html for the icon component.
		 *
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function build_icon_html( $attributes ) {

			$icon = self::icon_from_attributes( $attributes );
			$icon_color = self::icon_color_from_attributes( $attributes );

			// ---

			$icon_class = PageEditor_Model_FontAwesome::generate_classes_from_object(
        $icon
      );

			// Build styles
			$styles = [];
			if ( $icon_color ) { $styles['color'] = $icon_color; }

			// Build style string
			$style_string = self::build_style_string( $styles );


			$icon_html  = '<div class="page-editor_element_message-box_content_icon"'.$style_string.'>';
			$icon_html .=   '<i class="'.$icon_class.'"></i>';
			$icon_html .= '</div>';

			return $icon_html;
		}


		/**
		 * Build the html for the text component.
		 *
		 * @param $attributes
		 *
		 * @return string
		 */
		private static function build_text_html( $attributes ) {

			$text_color = self::text_color_from_attributes( $attributes );
			$text_opacity = self::text_opacity_from_attributes( $attributes );

			// Build styles
			$styles = array();
			if ( $text_color ) { $styles['color'] = $text_color; }
			if ( $text_opacity ) { $styles['opacity'] = $text_opacity / 100; }

			// Build style string
			$style_string = self::build_style_string( $styles );

			return '<div class="page-editor_element_message-box_content_text"'.$style_string.'>' .
				self::text_from_attributes( $attributes ) .
				'</div>';
		}


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

			$dismiss_button_html = self::build_dimiss_button_html( $attributes );
			$icon_html = self::build_icon_html( $attributes );
			$text_html = self::build_text_html( $attributes );

			// ---

			$classes = array(
				'page-editor_element_message-box',
				'page-editor_element_message-box_text-size-' . self::text_size_from_attributes( $attributes ),
				'page-editor_element_message-box_icon-size-' . self::icon_size_from_attributes( $attributes ),
				//'page-editor_element_message-box_style-' . self::style_from_attributes( $attributes ),
				//'page-editor_element_message-box_shape-' . self::shape_from_attributes( $attributes ),
			);
			if ( self::dismissible_from_attributes( $attributes ) ) {
				$classes[] = ' alert-dismissible';
			}


			$styles = array(
				'background-color' => self::color_from_attributes( $attributes ),
			);

			// --- --- ---

			$html = "<div";
      $html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes, $styles
      );
			$html .= ">";
			$html .=	 "<div class='page-editor_element_message-box_content'>{$dismiss_button_html}{$icon_html}{$text_html}</div>";
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