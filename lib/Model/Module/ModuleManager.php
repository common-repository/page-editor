<?php
/**
 * Class PageEditor_Model_Module_ModuleManager
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Model_Module_ModuleManager' ) ) {
  class PageEditor_Model_Module_ModuleManager {


    /**
     * @var $modules PageEditor_Model_Module_Module[]
     */
    private $modules = array();


    /**
     * @var string
     */
    private $stability = PageEditor_Model_Module_Stability::PRODUCTION;


    /**
     * Construct a new module manager.
     *
     * @param $load_core_modules bool
     */
    public function __construct( $load_core_modules = true ) {

      // Load core modules?
      if ( $load_core_modules ) {
        $this->load_core_modules();
      }
    }


    /**
     * @param $required_stability
     */
    public function set_required_module_stability( $required_stability ) {
      $this->stability = $required_stability;
    }


    /**
     * Get all modules (whether enabled or not).
     *
     * @return PageEditor_Model_Module_Module[]
     */
    public function all_modules() {
      return $this->modules;
    }


    /**
     * Get all enabled modules (for the given stability).
     *
     * @return PageEditor_Model_Module_Module[]
     */
    public function enabled_modules() {
      $enabled_modules = array();

      // For each module..
      foreach ( $this->modules as $module ) {

        // If meets required stability level, add to enabled modules.
        if ( $module->enabled_for_stability( $this->stability ) ) {
          $enabled_modules[] = $module;
        }
      }

      return $enabled_modules;
    }


    /**
     * Load the core PageEditor modules.
     */
    public function load_core_modules() {
      $this->load_from_standard_module_file( 'row' );
      $this->load_from_standard_module_file( 'group' );
      $this->load_from_standard_module_file( 'text-block' );

      $this->load_from_standard_module_file( 'blockquote' );
      //$this->load_from_standard_module_file( 'breadcrumb' );
      $this->load_from_standard_module_file( 'button' );
      $this->load_from_standard_module_file( 'call-to-action' );
      $this->load_from_standard_module_file( 'dropzone' );
      $this->load_from_standard_module_file( 'empty-space' );
      $this->load_from_standard_module_file( 'facebook-button' );
      $this->load_from_standard_module_file( 'google-adsense' );
      $this->load_from_standard_module_file( 'google-map' );
      $this->load_from_standard_module_file( 'google-plus-button' );
      $this->load_from_standard_module_file( 'heading' );
      $this->load_from_standard_module_file( 'icon' );
      $this->load_from_standard_module_file( 'image' );
      $this->load_from_standard_module_file( 'image-carousel' );
      $this->load_from_standard_module_file( 'image-compare' );
      $this->load_from_standard_module_file( 'linkedin-button' );
      //$this->load_from_standard_module_file( 'list' );
      $this->load_from_standard_module_file( 'message-box' );
      $this->load_from_standard_module_file( 'number-input' );
      $this->load_from_standard_module_file( 'panel' );
      $this->load_from_standard_module_file( 'pinterest-button' );
      //$this->load_from_standard_module_file( 'popup-modal' );
      $this->load_from_standard_module_file( 'price-list' );
      $this->load_from_standard_module_file( 'progress-bar' );
      $this->load_from_standard_module_file( 'raw-css' );
      $this->load_from_standard_module_file( 'raw-html' );
      $this->load_from_standard_module_file( 'raw-js' );
      $this->load_from_standard_module_file( 'separator' );
      $this->load_from_standard_module_file( 'stage' );
      $this->load_from_standard_module_file( 'tabs' );
      $this->load_from_standard_module_file( 'text-area' );
      $this->load_from_standard_module_file( 'text-input' );
      //$this->load_from_standard_module_file( 'tour' );
      $this->load_from_standard_module_file( 'twitter-button' );
      $this->load_from_standard_module_file( 'video-player' );
    }


    /**
     * Load the given module.
     *
     * @param $module PageEditor_Model_Module_Module
     */
    public function load( $module ) {
      $this->modules[$module->id] = $module;
    }


    /**
     * Load a PageEditor module from a standard module file using the given
     * module id to locate and construct the module.
     *
     * @param $module_id string
     *
     * @return PageEditor_Model_Module_Module|null
     */
    public function load_from_standard_module_file( $module_id ) {
      $this->load( PageEditor_Model_Module_Module::from_standard_module_file(
        $module_id
      ) );
    }


    /**
     * Load a PageEditor module from the given json file.
     *
     * @param $file_path string
     *
     * @return PageEditor_Model_Module_Module|null
     */
    public function from_json_file( $file_path ) {
      $this->load( PageEditor_Model_Module_Module::from_json_file(
        $file_path
      ) );
    }


    /**
     * Register a PageEditor module to be loaded.
     *
     * @param $id
     * @param string|null $name
     * @param string|null $version
     * @param string|null $stability
     * @param string|null $author_name
     * @param string|null $author_url
     * @param string|null $license_name
     * @param string|null $license_url
     * @param string|null $description
     * @param array $shortcode_files
     * @param array $shortcode_classes
     * @param string|null $manifesto_script
     * @param array $css_files
     * @param array $js_files
     */
    public function load_module(
      $id, $name = null, $version = null, $stability = null,
      $author_name = null, $author_url = null,
      $license_name = null, $license_url = null,
      $description = null, array $shortcode_files = array(),
      array $shortcode_classes = array(), $manifesto_script = null,
      array $css_files = array(), array $js_files = array()
    ) {
      $this->modules[$id] = new PageEditor_Model_Module_Module(
        $id, $name, $version, $stability, $author_name, $author_url,
        $license_name, $license_url, $description, $shortcode_files,
        $shortcode_classes, $manifesto_script, $css_files, $js_files
      );
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Enqueue the module assets for the given modules.
     */
    public function enqueue_assets() {

      $enabled_modules = $this->enabled_modules();

      // For each module...
      foreach ( $enabled_modules as $module ) {
        $module->enqueue_css_assets();
        $module->enqueue_js_assets();
      }
    }


    /**
     * Enqueue the module manifestos.
     */
    public function enqueue_manifestos() {

      $enabled_modules = $this->enabled_modules();

      // For each module...
      foreach ( $enabled_modules as $module ) {
        $module->enqueue_manifesto();
      }
    }


    /**
     *
     */
    public function register_shortcodes() {

      $enabled_modules = $this->enabled_modules();

      // Require module class files
      foreach ( $enabled_modules as $module ) {
        $module->register_shortcode();
      }
    }




    public function all_ids() {
      return array_keys( $this->enabled_modules() );
    }


    /**
     * Get an array of all of the module css files.
     * (all of the css files for all of the modules)
     *
     * @return string[]
     */
    public function all_css_assets() {
      $css_files = array();

      $enabled_modules = $this->enabled_modules();
      foreach ( $enabled_modules as $module ) {
        $css_files = array_merge( $css_files, $module->css_files );
      }

      return $css_files;
    }


    /**
     * Get an array of all of the module js files.
     * (all of the js files for all of the modules)
     *
     * @return string[]
     */
    public function all_js_assets() {
      $js_files = array();

      $enabled_modules = $this->enabled_modules();
      foreach ( $enabled_modules as $module ) {
        $js_files = array_merge( $js_files, $module->js_files );
      }

      return $js_files;
    }


    /**
     * Get an array of all of the module manifesto files.
     * (the manifesto file for all of the modules)
     *
     * @return string[]
     */
    public function all_manifestos() {
      $manifestos = array();

      $enabled_modules = $this->enabled_modules();
      foreach ( $enabled_modules as $module ) {
        $manifestos[] = $module->manifesto_script;
      }

      return $manifestos;
    }






  }
}