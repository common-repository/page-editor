<?php
/**
 * Class PageEditor_Module_PopupModal_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_PopupModal_ShortCode' ) ) {
  class PageEditor_Module_PopupModal_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'popup-modal';
    }


    /**
     * A 'popup-modal' is a container since other module elements can be placed
     * within it.
     *
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
      return array();
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
      $classes = [
        'page-editor_element_modal'
      ];

      if ( $add_wrapper ) {
        $classes[] = self::CONTAINER_CLASS;
      }

      // --- --- --- --- ---

      $html = "<div";

      $html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes
      );

      $html .= ">";

      $html .= "<div class='modal-dialog'>";
      $html .= "<div class='modal-content'>";

      $html .= "<div class='modal-header'>";
      $html .= "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>";
      $html .= "<h4 class='modal-title'>Modal title</h4>";
      $html .= "</div>";

      $html .= "<div class='modal-body'>";
      $html .= $content;
      $html .= "</div>";

      $html .= "<div class='modal-footer'>";
      $html .= "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
      $html .= "<button type='button' class='btn btn-primary'>Save changes</button>";
      $html .= "</div>";

      $html .= "</div>";
      $html .= "</div>";

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