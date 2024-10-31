<?php
/**
 * Class PageEditor_Module_ImageCarousel_Image_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_ImageCarousel_Image_ShortCode' ) ) {
  class PageEditor_Module_ImageCarousel_Image_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'image-carousel_image';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(

        'title'       => false,
        'url'         => PageEditor_Assets::$default_image_with_logo,
        'text-layout' => 'none',
        'heading'     => 'Hello World',

      );
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

      // Register this image with it's container
      PageEditor_Module_ImageCarousel_ShortCode::registerImage(
        $attributes, $content
      );

      return null;
    }


  }
}