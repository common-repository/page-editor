<?php
/**
 * Class PageEditor_Module_ImageCarousel_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_ImageCarousel_ShortCode' ) ) {
  class PageEditor_Module_ImageCarousel_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


		//
		// Setting keys
		//
		private static $setting_key__aspect_ratio							= 'aspect-ratio';
		private static $setting_key__swiping                  = 'swiping';
		private static $setting_key__autoplay   							= 'autoplay';
		private static $setting_key__autoplay_pause_on_hover	= 'autoplay-pause-on-hover';
		private static $setting_key__autoplay_time						= 'autoplay-time';
		private static $setting_key__dots											= 'dots';
		private static $setting_key__dots_position						= 'dots-position';
		private static $setting_key__dots_size                = 'dots-size';
		private static $setting_key__dots_style               = 'dots-style';
		private static $setting_key__navigation								= 'navigation';
		private static $setting_key__navigation_button_style	= 'navigation-button-style';


		//
		// Default values
		//
		private static $default__aspect_ratio     						= '3-2';
		private static $default__swiping                      = true;
		private static $default__autoplay   						      = true;
		private static $default__autoplay_pause_on_hover			= true;
		private static $default__autoplay_time					     	= '5000';
		private static $default__dots					     						= true;
		private static $default__dots_position					     	= 'bottom';
		private static $default__dots_size                    = 'sm';
		private static $default__dots_style                   = 'round';
		private static $default__navigation							     	= false;
		private static $default__navigation_button_style     	= 'arrows-only';


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    private static $imagesContainers = array();


    /**
     *
     */
    private static function pushImagesContainer() {
      array_push( self::$imagesContainers, [] );
    }


    /**
     * @return array
     */
    private static function popImagesContainer() {
      return array_pop( self::$imagesContainers );
    }


    /**
     * @param $attributes
     * @param $content
     */
    public static function registerImage( $attributes, $content ) {

      // If we don't have a images container - ignore
      if ( ! count( self::$imagesContainers ) ) { return; }

      // Add the tab content and attributes to the current images container
      self::$imagesContainers[0][] = array(
        'attributes' => $attributes,
        'content' => $content,
			);
    }


    // --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'image-carousel';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(

        self::$setting_key__aspect_ratio						=> self::$default__aspect_ratio,
        self::$setting_key__swiping                 => self::$default__swiping,
        self::$setting_key__autoplay								=> self::$default__autoplay,
        self::$setting_key__autoplay_pause_on_hover	=> self::$default__autoplay_pause_on_hover,
        self::$setting_key__autoplay_time						=> self::$default__autoplay_time,
        self::$setting_key__dots						        => self::$default__dots,
        self::$setting_key__dots_position						=> self::$default__dots_position,
        self::$setting_key__dots_size               => self::$default__dots_size,
        self::$setting_key__dots_style              => self::$default__dots_style,
        self::$setting_key__navigation					    => self::$default__navigation,
        self::$setting_key__navigation_button_style => self::$default__navigation_button_style,

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
		private static function aspect_ratio_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__aspect_ratio
			);
		}


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function swiping_from_attributes( $attributes ) {
      return self::read_attribute_as_boolean(
        $attributes, self::$setting_key__swiping
      );
    }


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function autoplay_from_attributes( $attributes ) {
			return self::read_attribute_as_boolean(
				$attributes, self::$setting_key__autoplay
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function autoplay_pause_on_hover_from_attributes( $attributes ) {
			return self::read_attribute_as_boolean(
				$attributes, self::$setting_key__autoplay_pause_on_hover
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function autoplay_time_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__autoplay_time
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function dots_from_attributes( $attributes ) {
			return self::read_attribute_as_boolean(
				$attributes, self::$setting_key__dots
			);
		}


		/**
		 * @param $attributes
		 *
		 * @return string|null
		 */
		private static function dots_position_from_attributes( $attributes ) {
			return self::read_attribute_as_string(
				$attributes, self::$setting_key__dots_position
			);
		}


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function dots_size_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__dots_size
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function dots_style_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__dots_style
      );
    }


    /**
     * @param $attributes
     *
     * @return bool
     */
    private static function navigation_from_attributes( $attributes ) {
			return self::read_attribute_as_boolean(
				$attributes, self::$setting_key__navigation
			);
		}


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function navigation_button_style_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__navigation_button_style
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

      // Construct a new image carousel container
      self::pushImagesContainer();

      // Generate the image carousel slides by rendering the content.
      // We don't care about the returned value since rendering simply registers the image slides found.
      // Each image slide found is rendered below.
      /** @noinspection PhpUndefinedFunctionInspection */
      do_shortcode( $content );

      // Fetch the images
      $images = self::popImagesContainer();

      // --- --- --- --- --- --- --- --- --- ---

			$aspect_ratio = self::aspect_ratio_from_attributes( $attributes );
			$swiping = self::swiping_from_attributes( $attributes );

			$autoplay = self::autoplay_from_attributes( $attributes );
			$autoplay_pause_on_hover = self::autoplay_pause_on_hover_from_attributes( $attributes );
			$autoplay_time = self::autoplay_time_from_attributes( $attributes );

      // Navigation Buttons
      $navigation = self::navigation_from_attributes( $attributes );
      $navigation_button_style = self::navigation_button_style_from_attributes( $attributes );

      // Navigation Dots
			$dots = self::dots_from_attributes( $attributes );
			$dots_position = self::dots_position_from_attributes( $attributes );
			$dots_size = self::dots_size_from_attributes( $attributes );
			$dots_style = self::dots_style_from_attributes( $attributes );


			$unique_class = 'page-editor_element_image-carousel_uid-'.uniqid();


			// --- --- --- --- --- --- --- --- --- ---

			//
			// Build classes
			//
			$classes = array(
				'page-editor_element_image-carousel',
				'page-editor_element_image-carousel_aspect-ratio-'.$aspect_ratio,
			);

      if ( $navigation ) {
        $classes[] = 'page-editor_element_image-carousel_nav_style-'.$navigation_button_style;
      }

			if ( $dots ) {
				$classes[] = 'page-editor_element_image-carousel_dots_position-'.$dots_position;
				$classes[] = 'page-editor_element_image-carousel_dots_size-'.$dots_size;
				$classes[] = 'page-editor_element_image-carousel_dots_style-'.$dots_style;
			}


			// --- --- ---

			//
			// Build Html
			//
			$html = "<div";
      $html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes
      );
			$html .= ">";


			$html .= self::build_carousel_container_html( $unique_class, $images, $add_wrapper );


			if ( $add_wrapper ) {
				$html .= '<div class="overlay"></div>';
			}

			$html .= "</div>";

      // --- --- ---

			//
			// Script
			//
      if ( ! $add_wrapper ) {
        $html .= "<div>";
        $html .= "<script>";
        $html .= "jQuery(document).ready(function($) {";

        $html .=   "$('.{$unique_class}').pageEditorImageCarousel({";
        $html .=     "items:1,";
        $html .=     "loop:true,";
        $html .=     "mouseDrag:".($swiping ? 'true': 'false').",";
        $html .=     "touchDrag:".($swiping ? 'true': 'false').",";
        $html .=     "pullDrag:".($swiping ? 'true': 'false').",";
        $html .=     "autoplay:".($autoplay ? 'true': 'false').",";
        if ( $autoplay ) {
          $html .=     "autoplayHoverPause:".($autoplay_pause_on_hover ? 'true' : 'false').",";
          $html .=     "autoplayTimeout:$autoplay_time,";
        }
        $html .=     "dots:".($dots ? 'true': 'false').",";
        $html .=     "nav:".($navigation ? 'true': 'false');
        $html .= "  });";

        $html .= "});";
        $html .= "</script>";
        $html .= "</div>";
      }

			// --- --- ---

			//
			// Add wrapper if in edit mode
			//
			if ( $add_wrapper ) {
        $html = self::add_wrapper( $html );
			}

			return $html;
		}


    /**
     * @param $images
     * @param $add_wrapper
     *
     * @return string
     */
    private static function build_images_html( $images, $add_wrapper ) {
      $html = '';

      foreach ( $images as $image ) {

        $classes = array( 'item' );
        $image_attributes = $image['attributes'];

        $image_url = $image_attributes['url'];
        $text_layout = $image_attributes['text-layout'];
        $heading = $image_attributes['heading'];

        $classes[] = 'page-editor_element_image-carousel_image_text-layout-'.$text_layout;

        // ---

        $html .= '<div class="'.implode( ' ', $classes ).'" style="background-image: url(\''.$image_url.'\');"';
        if ( $add_wrapper ) {
          $html .= ' ' .PageEditor_Model_ShortCode_BaseShortCode::build_settings_metadata_string( $image_attributes );
        }
        $html .= '>';
        //$html .= '<h2>'.$heading.'</h2>';
        $html .= '</div>';
      }

      return $html;
    }


    /**
     * @param $unique_class
     * @param $images
     * @param $add_wrapper
     *
     * @return string
     */
    private static function build_carousel_wrapper_html( $unique_class, $images, $add_wrapper ) {

      $html = '<div class="carousel-wrapper';
      if ( ! PageEditor_Model_ShortCode_Renderer::is_edit_mode() ) {
        $html .= ' ' . $unique_class;
      }
      $html .= '">';

      $html .= self::build_images_html( $images, $add_wrapper );

      $html .= '</div>';

      return $html;
    }


    /**
     * @param $unique_class
     * @param $images
     * @param $add_wrapper
     *
     * @return string
     */
    private static function build_carousel_container_html( $unique_class, $images, $add_wrapper ) {
      $html = '<div class="carousel-container">';
      $html .= self::build_carousel_wrapper_html( $unique_class, $images, $add_wrapper );
      $html .= '</div>';
      return $html;
    }



  }
}