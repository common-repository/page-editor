<?php
/**
 * Class PageEditor_Model_ShortCode_List_ListItem
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Model_ShortCode_List_ListItem' ) ) {
  class PageEditor_Model_ShortCode_List_ListItem
    extends PageEditor_Model_ShortCode_BaseShortCode {


    static function signature() {
      return 'pe_list-item';
    }


    /**
     * @return bool
     */
    static function is_container() {
      return false;
    }


    static function register() {
      add_shortcode( self::signature(), array( get_called_class(), 'handler' ) );
    }



    /**
     * @param $attributes
     * @param null $content
     * @return string
     */
    public static function handler( $attributes, $content ) {

      $attributes = PageEditor_Model_ShortCode_Util::shortCodeAttributes( [
        'icon'  => 'none',
        'text'  => 'New List Item',
      ], $attributes, self::signature() );

      // --- --- --- --- ---

      $iconBrand = wp_strip_all_tags( $attributes['icon-brand'] );
      $iconId    = wp_strip_all_tags( $attributes['icon-id'] );
      $iconStyle = wp_strip_all_tags( $attributes['icon-style'] );
      $text = wp_strip_all_tags( $attributes['text'] );

      // --- --- --- --- ---

      $classes = [
        'page-editor_element_list_list-item'
      ];

      if ( PageEditor_Model_ShortCode_Util::is_edit_mode() ) {
        $classes[] = self::CONTAINER_CLASS;
      }

      // --- --- --- --- ---

      $html  = '<li class="page-editor_element_list_list-item">';
      $html .=   '<div class="page-editor_element_list_list-item_icon">';
      $html .=     '<i class="fa-fw fa-dot-circle fas"></i>';
      $html .=   '</div>';
      $html .=   '<div class="page-editor_element_list_list-item_text">' . $text . '</div>';
      $html .= '</li>';

      // --- --- --- ---

      //
      // Add wrapper if in edit mode
      //
      if (PageEditor_Model_ShortCode_Util::is_edit_mode()) {
        $html = PageEditor_Model_ShortCode_Util::addWrapper( $html );
      }

      return $html;
    }


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      // TODO: Implement id() method.
    }

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
      // TODO: Implement build_html() method.
    }

    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      // TODO: Implement default_attribute_values() method.
    }
  }
}