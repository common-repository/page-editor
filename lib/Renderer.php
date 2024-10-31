<?php
/**
 * Class PageEditor_Renderer
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Renderer' ) ) {
  class PageEditor_Renderer {


    /**
     * @param $module_manager PageEditor_Model_Module_ModuleManager
     * @param $module_asset_loader PageEditor_Model_Module_AssetLoader
     */
    public function __construct( $module_manager, $module_asset_loader ) {

      //
      // When rendering, we need jQuery and FontAwesome
      // Enqueue dependencies
      //
      PageEditor_Enqueue::jquery();
      PageEditor_Enqueue::font_awesome();

      // ---

      //
      // Enqueue PageEditor module assets (CSS and JS required for rendering)
      //
      $module_asset_loader->enqueue_css_assets();
      $module_asset_loader->enqueue_js_assets();

      // --- --- ---

      //
      // Register the PageEditor shortcodes
      //
      $module_manager->register_shortcodes();

      // --- --- ---

      //
      // Filters...
      //

      // Remove the WordPress auto p filter
      $this->remove_autop_content_filter();

      // Add the PageEditor recursive shortcode renderer filter.
      $this->add_recursive_shortcode_fix_filter();

      // --- --- ---

      //
      // Add PageEditor metadata to page head
      //
      $this->add_metadata_to_head();

      //
      //
      //
      //add_action( 'wp_footer', function() {
      //  $settings = new PageEditor_Model_Settings();
      //  if ( $settings->footer_link_enabled() ) {}
      //} );

		}


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Add the PageEditor metadata to the page head.
     */
    private function add_metadata_to_head() {

      // Generator
      PageEditor_WordPress::add_meta_tag_to_head(
        'generator', 'PageEditor ' . PAGEEDITOR_PLUGIN_VERSION
      );

      // Generator Url
      PageEditor_WordPress::add_meta_tag_to_head(
        'generator-url', 'https://page-editor.com'
      );
    }


    /**
     * Remove the auto-p content filter added by WordPress since this disrupts
     * the majority of PageEditor modules.
     */
    private function remove_autop_content_filter() {
      /** @noinspection PhpUndefinedFunctionInspection */
      remove_filter( 'the_content', 'wpautop' );
    }


    /**
     * Add a filter that performs the recursive shortcode fix to the content
     * to ensure modules that are nested within themselves are rendered
     * correctly.
     *
     * Very similar to calling 'do_shortcode' except with the recursive fix.
     */
    private function add_recursive_shortcode_fix_filter() {
      /** @noinspection PhpUndefinedFunctionInspection */
      add_filter( 'the_content', function( $content ) {
        return PageEditor_Model_ShortCode_Renderer::do_shortcode( $content );
      }, 1 );
    }


	}
}