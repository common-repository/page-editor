<?php
/**
 * Class PageEditor_Module_Stage_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_Stage_ShortCode' ) ) {
  class PageEditor_Module_Stage_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


		//
		// Setting keys
		//
		private static $setting_key__shadow   = 'shadow';


		//
		// Default values
		//
		private static $default_shadow        = 'medium';


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'stage';
    }


    /**
     * @return bool
     */
    static function is_container() {
      return true;
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
			return array(

				self::$setting_key__shadow  => self::$default_shadow,

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
		private static function shadow_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__shadow
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

			$shadow = self::shadow_from_attributes( $attributes );

			// --- --- ---

			//
			// Build Classes
			//
			$classes = [
				"page-editor_element_stage",
				"page-editor_element_stage_shadow-$shadow",
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
			$html .= "<div class='page-editor_element_stage_content";
			if ( $add_wrapper ) {
				$html .= ' ' . self::CONTAINER_CLASS;
			}
			$html .=  "'>";
      $html .=    PageEditor_Model_ShortCode_Renderer::do_shortcode( $content );
      $html .=  "</div>";
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