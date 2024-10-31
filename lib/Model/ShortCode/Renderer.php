<?php
/**
 * Class PageEditor_Model_ShortCode_Renderer
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Model_ShortCode_Renderer' ) ) {
  class PageEditor_Model_ShortCode_Renderer {

    private static $forced_edit_mode        = false;
    private static $forced_production_mode  = false;


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- RENDERING MODE  --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

		/**
     * Render in edit mode?
     *
		 * @return bool
		 */
		public static function is_edit_mode() {

      // Edit mode is forced.
      if ( self::$forced_edit_mode ) {
        return true;
      }

      // Production mode (not edit mode) is forced.
      if ( self::$forced_production_mode ) {
        return false;
      }

      // Otherwise work it out from the current url.
      return self::current_url_indicated_edit_mode();
		}


    /**
     * Reset the forced rendering mode.
     */
    static function reset_forced_mode() {
      self::$forced_edit_mode = false;
      self::$forced_production_mode = false;
    }


    /**
     * Force shortcodes to be rendered in edit mode.
     */
    static function force_render_in_edit_mode() {
      self::reset_forced_mode();
      self::$forced_edit_mode = true;
    }


    /**
     * Force shortcodes to be rendered in edit mode.
     */
    static function force_render_in_production_mode() {
      self::reset_forced_mode();
      self::$forced_production_mode = true;
    }


    /**
     * Does the current url indicate that shortcodes should be rendered in
     * edit mode?
     *
     * @return bool
     */
    private static function current_url_indicated_edit_mode() {
      return isset( $_GET['page-editor'] ) && 'true' == $_GET['page-editor'];
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- RECURSIVE NESTED SHORTCODES --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Remove any occurances of the given shortcode prefix from the content.
     *
     * @param $content
     * @param $prefix
     *
     * @return string
     */
    private static function remove_existing_prefix( $content, $prefix ) {
      return str_replace( $prefix, '', $content );
    }


    /**
     * @param $content
     * @param $tag
     * @param $prefix
     *
     * @return string
     */
    private static function prepare_recursive_shortcode_for_tag(
      $content, $tag, $prefix
    ) {

      // Construct open and close tags
      $open_tag  = '[' . $tag;
      $close_tag = '[/'. $tag . ']';

      // Construct replacement open and close tags
      $replacement_open_tag  = '[' . $prefix . $tag;
      $replacement_close_tag = '[/' . $prefix . $tag . ']';

      // Calculate string lengths (for use in content manipulation)
      $open_tag_length  = strlen( $open_tag );
      $close_tag_length = strlen( $close_tag );
      $prefix_length    = strlen( $prefix );

      // --- --- ---

      $depth = 0;

      // Find first opening tag
      $open_pos = stripos( $content, $open_tag );

      // Set offset for first closing tag
      $offset = $open_pos + strlen( $open_tag );

      while ( $open_pos !== false ) {

        // Find first closing tag
        $close_pos = stripos( $content, $close_tag, $offset );

        // ---

        // If we are already inside an open tag...
        if ( ++$depth > 1 ) {

          // Modify the open tag
          $content = substr( $content, 0, $open_pos ) .
            $replacement_open_tag .
            substr( $content, $offset );

          // Modify the closing tag
          $content = substr( $content, 0, $close_pos + $prefix_length ) .
            $replacement_close_tag .
            substr( $content, $close_pos + $close_tag_length + $prefix_length );

          $depth--;
        }

        // ---

        // Find the next open and close tags
        $open_pos  = stripos( $content, $open_tag, $offset );
        $close_pos = stripos( $content, $close_tag, $offset );

        // Set the offset for next open tag search
        $offset = $open_pos + $open_tag_length;

        // If closing tag comes before the next opening tag, lower the open
        // tag count since we have exited tag
        if ( $close_pos < $open_pos ) {
          $depth--;
        }

      }

      return $content;
    }


    /**
     * @param $content
     *
     * @return string
     */
    public static function prepare_recursive_shortcode( $content ) {

      $temp_prefix = 'PE_RECURSIVE__';

      // Define recursive shortcodes, these must have closing tags
      $recursive_tags = PageEditor_WordPressPlugin::container_shortcode_tags();

      // Remove old suffix on shortcodes to start process over
      $content = self::remove_existing_prefix( $content, $temp_prefix );

      // --- --- ---

      //
      // Foreach recursive tag...
      //
      foreach ( $recursive_tags as $recursive_tag ) {
        $content = self::prepare_recursive_shortcode_for_tag(
          $content, $recursive_tag, $temp_prefix
        );
      }

      return $content;
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- PERFORM RENDER  --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Render the given string containing shortcodes.
     *
     * This also fixes the recursive nested shortcode bug with WordPress and
     * allows shortcodes to be nested within themselves.
     *
     * @param $content
     *
     * @return string
     */
    public static function do_shortcode( $content ) {
      /** @noinspection PhpUndefinedFunctionInspection */
      return do_shortcode( self::prepare_recursive_shortcode( $content ) );
    }


    /**
     * Render the given string containing shortcodes in 'edit' mode.
     *
     * @param $content
     *
     * @return string
     */
    public static function do_shortcode_in_edit_mode( $content ) {
      self::force_render_in_edit_mode();
      $result = self::do_shortcode( $content );
      self::reset_forced_mode();
      return $result;
    }


    /**
     * Render the given string containing shortcodes in 'production' mode.
     *
     * @param $content
     *
     * @return string
     */
    public static function do_shortcode_in_production_mode( $content ) {
      self::force_render_in_production_mode();
      $result = self::do_shortcode( $content );
      self::reset_forced_mode();
      return $result;
    }



  }
}