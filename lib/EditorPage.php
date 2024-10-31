<?php
/**
 * Class PageEditor_EditorPage
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_EditorPage' ) ) {
  class PageEditor_EditorPage {


    /**
     * Constructor - PageEditor_EditorPage is embedded in the page that contains
     * the content being edited (not the admin page).
     */
    public function __construct() {

			// If the current user can edit content...
			//if ( $this->current_user_can_edit_content() ) {

      //
      // If page editor launch query parameter is provided
      //
      if ( $this->page_editor_launch_query_parameter_provided() ) {

        //
        // Hide the admin bar
        //
        PageEditor_WordPress::hide_admin_bar();

        //
        // Enqueue all embedded assets
        //
        PageEditor_Enqueue::page_editor_embedded_assets();

        //
        // Add the PageEditor main content anchor - allows PageEditor to find
        // where content should be inserted.
        //
        $this->add_main_content_anchor();

      }

			//}
		}


    /**
     * Is the PageEditor launch query parameter is provided?
     *
     * @return bool
     */
    private function page_editor_launch_query_parameter_provided() {
      return 'true' == $_GET[ 'page-editor' ];
    }


    /**
     * Add the PageEditor main content anchor.
     * Allows PageEditor to find where content should be inserted.
     */
    private function add_main_content_anchor() {
      /** @noinspection PhpUndefinedFunctionInspection */
      add_filter( 'the_content', function( $content ) {
        return $content . "<div id='page-editor_main-anchor'></div>";
      }, 9999 );
    }


	}
}