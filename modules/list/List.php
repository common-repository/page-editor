<?php
/**
 * Class PageEditor_Model_ShortCode_List_List
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Model_ShortCode_List_List' ) ) {
  class PageEditor_Model_ShortCode_List_List
    extends PageEditor_Model_ShortCode_BaseShortCode {


    static function signature() {
      return 'pe_list';
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
     * @param $content
     * @return mixed
     */
    public static function handler( $attributes, $content ) {

      //
      // Find the tabs specified within this tabs container
      //

      // Construct a new tabs container
      self::pushTabsContainer();

      // Generate the tabs by rendering the content.
      // We don't care about the returned value since rendering simply registers the tabs found.
      // Each tab found are rendered below.
      do_shortcode( $content );

      // Fetch the tabs
      $tabs = self::popTabsContainer();


      // --- --- --- --- ---

      $attributes = self::shortcode_attributes( [
        'default-id'  => null,
        'shape'       => 'rectangle',
      ], $attributes, self::signature() );


      $defaultTabId = $attributes['default-id'];
      $shape = $attributes['shape'];

      // --- --- --- --- ---


      //
      // Build the navigation html
      //
      $navigationHtml = '<ul class="page-editor_element_tabs_navigation" role="tablist">';
      foreach ($tabs as $index => $tab) {
        $tabAttributes = $tab['attributes'];

        $tabId = wp_strip_all_tags( $tabAttributes['id'] );
        $tabTitle = wp_strip_all_tags( $tabAttributes['title'] );

        $active = ($defaultTabId == null && $index == 0) || ($tabId == $defaultTabId);


        $navigationHtml .= '<li role="tabpanel"';
        if ($active) { $navigationHtml .= ' class="active"'; }
        $navigationHtml .= '><a href="#'.$tabId.'" aria-controls="'.$tabId.'" role="tab" data-toggle="tab" aria-expanded="false">'.$tabTitle.'</a></li>';
      }
      $navigationHtml .= '</ul>';


      // --- --- --- --- ---


      //
      // Build the content html
      //
      $contentHtml = '<div class="page-editor_element_tabs_content">';
      foreach ($tabs as $index => $tab) {
        $tabContent = do_shortcode( $tab['content'] );
        $tabAttributes = $tab['attributes'];
        $tabId = wp_strip_all_tags( $tabAttributes['id'] );

        $tabClasses = ['page-editor_element_tab'];

        $active = ($defaultTabId == null && $index == 0) || ($tabId == $defaultTabId);
        if ($active) { $tabClasses[] = 'active'; }

        if ( $edit_mode ) {
          $tabClasses[] = self::CONTAINER_CLASS;
        }

        $contentHtml .= '<div role="tabpanel" class="'.implode(' ', $tabClasses).'" id="'.$tabId.'">'.$tabContent.'</div>';
      }
      $contentHtml .= '</div>';


      // --- --- --- --- ---


      //
      // Build the wrapper
      //
      $classes = [
        'page-editor_element_tabs',
        'page-editor_element_tabs_shape-'.$shape,
      ];

      //if ( PageEditor_Model_ShortCode_Util::is_edit_mode() ) {
      //  $classes[] = PageEditor_Model_ShortCode_Util::CONTAINER_CLASS;
      //}

      $html = '<div';
      $html .= PageEditor_Model_ShortCode_Util::build_html(
        $attributes, 'tabs', $classes
      );
      $html .= '>';
      $html .= $navigationHtml;
      $html .= $contentHtml;
      $html .= '</div>';


      // --- --- --- ---


      //
      // Add wrapper if in edit mode
      //
      if ( $edit_mode ) {
        $html = self::add_wrapper( $html );
      }

      return $html;
    }


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id()
    {
      // TODO: Implement id() method.
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
