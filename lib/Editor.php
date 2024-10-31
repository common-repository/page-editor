<?php
/**
 * Class PageEditor_Editor
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Editor' ) ) {
  class PageEditor_Editor {


    /**
     * Construct the admin page editor.
     *
     * @param $module_manager      PageEditor_Model_Module_ModuleManager
     * @param $module_asset_loader PageEditor_Model_Module_AssetLoader
     * @param $template_manager    PageEditor_Model_Template_TemplateManager
     */
    public function __construct(
      $module_manager, $module_asset_loader, $template_manager
    ) {

      //
      // Enqueue dependencies
      //
      PageEditor_Enqueue::jquery();
      PageEditor_Enqueue::font_awesome();

      //
      // Enqueue PageEditor module js scripts (required for editing)
      //
      $module_asset_loader->enqueue_js_assets();

      //
      // Register the PageEditor shortcodes
      //
      $module_manager->register_shortcodes();


      // --- --- ---


      // Add "Edit with PageEditor" button where 'Pages' and 'Posts' are
      // edited with WordPress
      PageEditor_WordPress::add_edit_button_to_pages_and_posts();

      // Enqueue all core editor assets for the given theme
      PageEditor_Enqueue::page_editor_admin_assets();

      // Enqueue all module manifestos
      $module_asset_loader->enqueue_manifestos();

      // Add the PageEditor HTML to the page
      $this->add_footer_launch_script( $template_manager );

    }



		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * @param $template_manager PageEditor_Model_Template_TemplateManager
     */
    private function add_footer_launch_script( $template_manager ) {
      /** @noinspection PhpUndefinedFunctionInspection */
      add_action( 'admin_footer', function() use ( $template_manager ) {

        $current_post = PageEditor_Post::current_post();
        $iframe_src   = $current_post->permalink( array(
          'page-editor' => 'true'
        ) );

        ?>
        <div id="page-editor">
          <div id="page-editor_editor"></div>
          <div id="page-editor_modal-container"></div>
        </div>

        <script type="text/javascript">
          jQuery( document ).ready( function( $ ) {
            var editor_container = $( '#page-editor_editor' );
            var modal_container  = $( '#page-editor_modal-container' );
            var url = '<?php echo addslashes( $iframe_src ) ?>';
            var title_input_element = $( '#title' );

            new PageEditor(
              editor_container, modal_container, url, title_input_element
            );

            <?php echo $template_manager->build_load_js(); ?>
          });
        </script>

      <?php
      } );
    }








	}
}