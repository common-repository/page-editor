<?php
/**
 * Class PageEditor_Enqueue
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Enqueue' ) ) {
  class PageEditor_Enqueue {

    private static $version = null;


    /**
     * Get the version to be used when enqueuing assets.
     *
     * @return string
     */
    public static function version() {

      if ( null == self::$version ) {
        self::$version = PAGEEDITOR_PLUGIN_VERSION;

        if ( PAGEEDITOR_PLUGIN_DEVELOPMENT_MODE ) {
          self::$version .= '_DEV' . uniqid();
        }
      }

      return self::$version;
    }


    /**
     * @param $id
     * @param $path
     * @param array $dependencies
     */
    public static function enqueue_script(
      $id, $path, $dependencies = array()
    ) {
      /** @noinspection PhpUndefinedFunctionInspection */
      wp_enqueue_script( $id, $path, $dependencies, self::version() );
    }


    /**
     * @param $id string
     * @param $path string
     * @param $dependencies string[]
     */
    public static function enqueue_style(
      $id, $path, $dependencies = array()
    ) {
      /** @noinspection PhpUndefinedFunctionInspection */
      wp_enqueue_style( $id, $path, $dependencies, self::version() );
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     *
     */
    public static function page_editor_admin_assets() {

      // Load PageEditor launcher assets
      PageEditor_Enqueue::page_editor_launcher();

      // Enqueue WordPress text editor api
      PageEditor_Enqueue::wordpress_text_editor();

      //
      // Load Dependencies
      // See: https://developer.wordpress.org/reference/functions/wp_enqueue_script/
      //
      PageEditor_Enqueue::jquery_ui_draggable();
      PageEditor_Enqueue::jquery_ui_droppable();
      PageEditor_Enqueue::jquery_ui_resizable();
      PageEditor_Enqueue::jquery_ui_sortable();
      PageEditor_Enqueue::jquery_ui_slider();
      PageEditor_Enqueue::jquery_ui_selectmenu();

      // Enqueue Font Awesome
      PageEditor_Enqueue::font_awesome();

      // Currently required for the insert element modal
      PageEditor_Enqueue::bootstrap();

      // Ace Code Editor
      PageEditor_Enqueue::ace_code_editor();

      // jQuery Palette Color Picker
      PageEditor_Enqueue::palette_color_picker();

    }


    /**
     *
     */
    public static function page_editor_embedded_assets() {

      PageEditor_Enqueue::jquery_ui_sortable();

      // Load PageEditor embedded
      PageEditor_Enqueue::page_editor_embedded();
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     *
     */
    public static function page_editor_launcher() {
      self::enqueue_script(
        'page-editor',
        PAGEEDITOR_PLUGIN_BASE_URL.'/assets/js/editor-launcher.min.js',
        array( 'jquery' )
      );
      self::enqueue_style(
        'page-editor',
        PAGEEDITOR_PLUGIN_BASE_URL.'/assets/css/editor-launcher.min.css',
        array()
      );
    }


    /**
     *
     */
    public static function page_editor_embedded() {
      self::enqueue_style(
        'page-editor',
        PAGEEDITOR_PLUGIN_BASE_URL.'/assets/css/editor-embedded.min.css',
        array()
      );
    }



    /**
     *
     */
    public static function admin_view_styles() {
      self::enqueue_style(
        'page-editor-admin-view',
        PAGEEDITOR_PLUGIN_BASE_URL.'/assets/css/admin-view.min.css',
        array()
      );
    }


    /**
     * @param $theme
     */
    public static function page_editor_theme( $theme ) {
      self::enqueue_style(
        'page-editor-theme',
        PAGEEDITOR_PLUGIN_BASE_URL.'/assets/css/editor-theme/'.$theme.'.min.css',
        array( 'page-editor' )
      );
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     *
     */
    public static function wordpress_text_editor() {
      /** @noinspection PhpUndefinedFunctionInspection */
      wp_enqueue_editor();
    }


    /**
     * See: http://jeroensormani.com/how-to-include-the-wordpress-media-selector-in-your-plugin/
     * https://codex.wordpress.org/Function_Reference/wp_enqueue_media
     */
    public static function wordpress_image_select() {
      /** @noinspection PhpUndefinedFunctionInspection */
      wp_enqueue_media();
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     *
     */
    public static function jquery() {
      /** @noinspection PhpUndefinedFunctionInspection */
      wp_enqueue_script( 'jquery' );
    }


    /**
     *
     */
    public static function jquery_ui_draggable() {
      /** @noinspection PhpUndefinedFunctionInspection */
      wp_enqueue_script( 'jquery-ui-draggable' );
    }


    /**
     *
     */
    public static function jquery_ui_droppable() {
      /** @noinspection PhpUndefinedFunctionInspection */
      wp_enqueue_script( 'jquery-ui-droppable' );
    }


    /**
     *
     */
    public static function jquery_ui_resizable() {
      /** @noinspection PhpUndefinedFunctionInspection */
      wp_enqueue_script( 'jquery-ui-resizable' );
    }


    /**
     *
     */
    public static function jquery_ui_sortable() {
      /** @noinspection PhpUndefinedFunctionInspection */
      wp_enqueue_script( 'jquery-ui-sortable' );
    }


    /**
     *
     */
    public static function jquery_ui_slider() {
      /** @noinspection PhpUndefinedFunctionInspection */
      wp_enqueue_script( 'jquery-ui-slider' );
    }


    /**
     *
     */
    public static function jquery_ui_selectmenu() {
      /** @noinspection PhpUndefinedFunctionInspection */
      wp_enqueue_script( 'jquery-ui-selectmenu' );
    }


    /**
     *
     */
    public static function bootstrap() {
      self::enqueue_script(
        'bootstrap',
        PAGEEDITOR_PLUGIN_BASE_URL.'/assets/packages/bootstrap/3.3.7/js/bootstrap.min.js',
        array( 'jquery' )
      );
    }


    /**
     *
     */
    public static function font_awesome() {
      self::enqueue_style(
        'font-awesome',
        PAGEEDITOR_PLUGIN_BASE_URL.'/assets/packages/font-awesome/v5.0.10/css/all.css',
        array()
      );
    }


    /**
     * See https://github.com/ajaxorg/ace
     */
    public static function ace_code_editor() {
      self::enqueue_script(
        'ace-code-editor',
        PAGEEDITOR_PLUGIN_BASE_URL.'/assets/packages/ace-code-editor/ace.js',
        array()
      );
      self::enqueue_script(
        'ace-code-editor_ext-language-tools',
        PAGEEDITOR_PLUGIN_BASE_URL.'/assets/packages/ace-code-editor/ext-language_tools.js',
        array()
      );
    }


    /**
     *
     */
    public static function palette_color_picker() {
      self::enqueue_script(
        'palette-color-picker',
        PAGEEDITOR_PLUGIN_BASE_URL.'/assets/packages/jquery-palette-color-picker/palette-color-picker.min.js',
        array( 'jquery' )
      );
      self::enqueue_style(
        'palette-color-picker',
        PAGEEDITOR_PLUGIN_BASE_URL.'/assets/packages/jquery-palette-color-picker/palette-color-picker.css',
        array()
      );
    }


  }
}