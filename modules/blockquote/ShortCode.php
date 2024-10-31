<?php
/**
 * Class PageEditor_Module_Blockquote_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_Blockquote_ShortCode' ) ) {
  class PageEditor_Module_Blockquote_ShortCode extends
    PageEditor_Model_ShortCode_BaseShortCode {


    //
    // Setting keys
    //
    private static $setting_key__style  = 'style';
    private static $setting_key__quote  = 'quote';
    private static $setting_key__author = 'author';



    //
    // Default values
    //
    private static $default__style      = 'border';
    private static $default__quote      = '';
    private static $default__author     = '';


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    private static $quotes = array(
      array(
        'quote'  => 'If you don’t initiate your young men into the tribe, they will burn down the village.',
        'author' => 'African Proverb',
      ),
      array(
        'quote'  => 'Government of the people, by the people, for the people, shall not perish from the Earth.',
        'author' => 'Abraham Lincoln',
      ),
      array(
        'quote'  => 'The nation which can prefer disgrace to danger is prepared for a master and deserves one.',
        'author' => 'Alexander Hamilton',
      ),
      array(
        'quote'  => 'Beware of an old man in a profession where men usually die young.',
      ),
    );


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'blockquote';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(
        self::$setting_key__style   => self::$default__style,
        self::$setting_key__quote   => self::$default__quote,
        self::$setting_key__author  => self::$default__author,
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
    private static function quote_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__quote
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function author_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__author
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

      $style  = self::style_from_attributes( $attributes );
      $quote  = self::quote_from_attributes( $attributes );
      $author = self::author_from_attributes( $attributes );

      // --- --- --- ---

			//
			// Build Classes
			//
			$classes = array(
        'page-editor_element_blockquote',
        'page-editor_element_blockquote_style-'.$style,
      );


			//
			// Build Html
			//
			$html = "<div";

      $html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes
      );

			$html .= ">";


			$html .= "<blockquote>";
      $html .=   "<span class='quote'>{$quote}</span>";
      $html .=   "<span class='author'>{$author}</span>";
      $html .= "</blockquote>";


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