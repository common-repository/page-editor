<?php
/**
 * Class PageEditor_Model_Module_AssetLoader
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Model_Module_AssetLoader' ) ) {
  class PageEditor_Model_Module_AssetLoader {

    /**
     * @var $module_manager PageEditor_Model_Module_ModuleManager
     */
    private $module_manager;


    /**
     * Is concatenating assets enable? (CSS, JS and manifestos)
     *
     * If enabled the assets of each module will be concatenated to produce an
     * optimized single file. Otherwise each asset file for each module is
     * loaded individually.
     *
     * @var $concatenation_enabled
     */
    private $concatenation_enabled = true;


    /**
     * Construct a new asset loader.
     *
     * @param $module_manager PageEditor_Model_Module_ModuleManager
     * @param $concatenation_enabled bool
     */
    public function __construct(
      $module_manager, $concatenation_enabled = true
    ) {
      $this->module_manager = $module_manager;
      $this->concatenation_enabled = $concatenation_enabled;
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Enable concatenation.
     */
    public function enable_concatenation() {
      $this->concatenation_enabled = true;
    }


    /**
     * Disable concatenation.
     */
    public function disable_concatenation() {
      $this->concatenation_enabled = false;
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Generate the concatenation id.
     *
     * This is generated from each module's id and version. Adding or removing
     * any module, or changing the version number of any module will result in
     * a different concatenation id.
     *
     * @return string
     */
    private function concatenation_id() {

      $enabled_modules = $this->module_manager->enabled_modules();

      // Construct array of module ids
      $module_ids = array();
      foreach ( $enabled_modules as $module ) {
        $module_ids[] = $module->id . '-' . $module->version;
      }

      // Sort module id so we get the same array regardless of module order
      sort( $module_ids );

      // Implode and hash to produce a string id
      return sha1( implode( ',', $module_ids ) );
    }


    /**
     * Get the path to the directory where the generated concatenated files
     * will be stored.
     *
     * @param $id
     *
     * @return string
     */
    private static function concatenated_directory( $id ) {
      return '@PE/cache/modules/' . $id;
    }


    /**
     * Get the file for the concatenated CSS file using the given
     * concatenation id.
     *
     * @param $id
     *
     * @return string
     */
    private static function concatenated_css_file( $id ) {
      return self::concatenated_directory( $id ) . '/modules.css';
    }


    /**
     * Get the file for the concatenated JS file using the given
     * concatenation id.
     *
     * @param $id
     *
     * @return string
     */
    private static function concatenated_js_file( $id ) {
      return self::concatenated_directory( $id ) . '/modules.js';
    }


    /**
     * Get the file for the concatenated manifesto file using the given
     * concatenation id.
     *
     * @param $id
     *
     * @return string
     */
    private static function concatenated_manifestos_file( $id ) {
      return self::concatenated_directory( $id ) . '/module-manifestos.js';
    }


    /**
     * Ensure that the concatenation storage directory exists.
     *
     * @param $id
     */
    private static function ensure_concatenated_directory_exists( $id ) {
      PageEditor_Util::ensure_directory_exists(
        self::concatenated_directory( $id )
      );
    }


    // --- --- ---



    private function build_concatenated_file(
      $id, $destination_file, $sources
    ) {

      $path = PageEditor_Util::parse_asset_path( $destination_file );

      // ---

      // If we're in development mode...
      if ( PAGEEDITOR_PLUGIN_DEVELOPMENT_MODE ) {

        // Delete existing concatenation (if it exists)
        PageEditor_Util::ensure_file_deleted( $path );
      }

      // ---

      // If the concatenated file does not exist...
      if ( ! file_exists( $path ) ) {

        // Ensure that the concatenation directory exists
        self::ensure_concatenated_directory_exists( $id );

        // Build the concatenated css file
        PageEditor_Util::build_concatenated_file( $path, $sources );
      }
    }





    /**
     * Build the concatenated CSS file.
     */
    private function build_concatenated_css_file() {

      $id      = $this->concatenation_id();
      $file    = self::concatenated_css_file( $id );
      $sources = $this->module_manager->all_css_assets();

      $this->build_concatenated_file( $id, $file, $sources );

      return $file;
    }


    /**
     *
     */
    private function enqueue_concatenated_css_file() {

      $file = $this->build_concatenated_css_file();

      wp_enqueue_style(
        "page-editor_concatenated-modules",
        PageEditor_Util::parse_asset_url( $file ),
        array(),
        PageEditor_Util::generate_enqueue_version_value(
          PAGEEDITOR_PLUGIN_VERSION
        )
      );

    }


    // --- --- ---

    /**
     * Build the concatenated JS file.
     */
    private function build_concatenated_js_file() {

      $id      = $this->concatenation_id();
      $file    = self::concatenated_js_file( $id );
      $sources = $this->module_manager->all_js_assets();

      $this->build_concatenated_file( $id, $file, $sources );

      return $file;
    }


    /**
     *
     */
    private function enqueue_concatenated_js_file() {

      $file = $this->build_concatenated_js_file();

      wp_enqueue_script(
        "page-editor_concatenated-modules",
        PageEditor_Util::parse_asset_url( $file ),
        array( 'jquery' ),
        PageEditor_Util::generate_enqueue_version_value(
          PAGEEDITOR_PLUGIN_VERSION
        )
      );

    }


    // --- --- ---

    /**
     * Build the concatenated JS file.
     */
    private function build_concatenated_manifestos_file() {

      $id      = $this->concatenation_id();
      $file    = self::concatenated_manifestos_file( $id );
      $sources = $this->module_manager->all_manifestos();

      $this->build_concatenated_file( $id, $file, $sources );

      return $file;
    }


    /**
     *
     */
    private function enqueue_concatenated_manifestos_file() {

      $file = $this->build_concatenated_manifestos_file();

      wp_enqueue_script(
        "page-editor_concatenated-module-manifestos",
        PageEditor_Util::parse_asset_url( $file ),
        array( 'page-editor' ),
        PageEditor_Util::generate_enqueue_version_value(
          PAGEEDITOR_PLUGIN_VERSION
        )
      );

    }



    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     *
     */
    public function enqueue_css_assets() {

      // Enqueue concatenated css file
      if ( $this->concatenation_enabled ) {
        $this->enqueue_concatenated_css_file();
      }

      // Enqueue css asset files individually (un-concatenated)
      else {
        $enabled_modules = $this->module_manager->enabled_modules();
        foreach ( $enabled_modules as $module ) {
          $module->enqueue_css_assets();
        }
      }

    }


    /**
     * Enqueue the module
     */
    public function enqueue_js_assets() {

      // Enqueue concatenated js file
      if ( $this->concatenation_enabled ) {
        $this->enqueue_concatenated_js_file();
      }

      // Enqueue js asset files individually (un-concatenated)
      else {
        $enabled_modules = $this->module_manager->enabled_modules();
        foreach ( $enabled_modules as $module ) {
          $module->enqueue_js_assets();
        }
      }

    }


    /**
     * Enqueue the module manifestos.
     */
    public function enqueue_manifestos() {

      // Enqueue concatenated manifestos file
      if ( $this->concatenation_enabled ) {
        $this->enqueue_concatenated_manifestos_file();
      }

      // Enqueue module manifestos individually (un-concatenated)
      else {
        $enabled_modules = $this->module_manager->enabled_modules();
        foreach ( $enabled_modules as $module ) {
          $module->enqueue_manifesto();
        }
      }

    }



  }
}