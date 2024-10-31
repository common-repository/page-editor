<?php
/**
 * Class PageEditor_Module_Tabs_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_Tabs_ShortCode' ) ) {
  class PageEditor_Module_Tabs_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


		private static $tabsContainers = array();


		/**
		 *
		 */
		private static function pushTabsContainer() {
			array_push( self::$tabsContainers, array() );
		}


		/**
		 * @return array
		 */
		private static function popTabsContainer() {
			return array_pop( self::$tabsContainers );
		}


		/**
		 * Register a tab.
		 *
		 * @param $attributes
		 * @param $content
		 */
		public static function registerTab( $attributes, $content ) {

			// If we don't have a tabs container - ignore
			if ( ! count( self::$tabsContainers ) ) { return; }

			// Add the tab content and attributes to the current tabs container
			self::$tabsContainers[0][] = array(
				'attributes' => $attributes,
				'content'    => $content,
			);
		}


		// --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'tabs';
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
        'tab-default' => null,
        'tab-shape'   => 'rectangle',
        'tab-size'    => 'md',
        'tab-align'   => 'left',
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

      //
      // Find the tabs specified within this tabs container
      //

      // Construct a new tabs container
      self::pushTabsContainer();

      // Generate the tabs by rendering the content.
      // We don't care about the returned value since rendering simply registers the tabs found.
      // Each tab found are rendered below.
      PageEditor_Model_ShortCode_Renderer::do_shortcode( $content );

      // Fetch the tabs
      $tabs = self::popTabsContainer();


      $tab_default = $attributes['tab-default'];
      $tab_shape   = $attributes['tab-shape'];
      $tab_size    = $attributes['tab-size'];
      $tab_align   = $attributes['tab-align'];

      // --- --- --- --- ---


      //
      // Build the navigation html
      //
      $navigation_html = '<ul class="page-editor_element_tabs_navigation" role="tablist">';
      foreach ( $tabs as $index => $tab ) {

        // Get the current tab's attributes
        $tab_attributes = $tab['attributes'];

        // Get the current tab's id and title
        $tab_id    = wp_strip_all_tags( $tab_attributes['id'] );
        $tab_title = wp_strip_all_tags( $tab_attributes['title'] );

        $active = ( null == $tab_default && 0 == $index ) || ( $tab_id == $tab_default );


        $navigation_html .= '<li role="presentation"';

        if ( $add_wrapper ) {
          $navigation_html .= ' ' . self::build_settings_metadata_string( $tab_attributes );
        }

        if ( $active ) {
          $navigation_html .= ' class="active"';
        }

        $navigation_html .= "><a href='#$tab_id' aria-controls='$tab_id' role='tab' data-toggle='tab' aria-expanded='false'>$tab_title</a></li>";
      }
      $navigation_html .= '</ul>';


      // --- --- --- --- ---


      //
      // Build the content html
      //
      $content_html = '<div class="page-editor_element_tabs_content">';
      foreach ( $tabs as $index => $tab ) {

        // Get the current tab's content
        $tab_content    = PageEditor_Model_ShortCode_Renderer::do_shortcode( $tab['content'] );
        $tab_attributes = $tab['attributes'];
        $tab_id         = PageEditor_Util::strip_all_tags( $tab_attributes['id'] );

        $tab_classes = ['page-editor_element_tab'];

        // ---

        // If this tab is active - add the active class to the tab content classes
        $active = ( null == $tab_default && $index == 0 ) || ( $tab_id == $tab_default );
        if ( $active ) { $tab_classes[] = 'active'; }

        // If in edit mode - add PageEditor container class to the tab content classes
        if ( $add_wrapper ) {
          $tab_classes[] = self::CONTAINER_CLASS;
        }

        // ---

        $classes_string = implode( " ", $tab_classes );
        $content_html .= "<div role='tabpanel' class='{$classes_string}' id='{$tab_id}'>$tab_content</div>";
      }
      $content_html .= '</div>';


      // --- --- --- --- ---


      //
      // Build the wrapper
      //
      $classes = [
        "page-editor_element_tabs",
        "page-editor_element_tabs_navigation_shape-$tab_shape",
        "page-editor_element_tabs_navigation_size-$tab_size",
        "page-editor_element_tabs_navigation_align-$tab_align",
      ];

      $html = '<div';
      $html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes
      );
      $html .= '>';
      $html .=   $navigation_html;
      $html .=   $content_html;
      $html .= '</div>';


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
