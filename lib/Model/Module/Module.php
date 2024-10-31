<?php
/**
 * Class PageEditor_Model_Module_Module
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Model_Module_Module' ) ) {
  class PageEditor_Model_Module_Module {

    /**
     * @var $id string
     */
    public $id;

    /**
     * @var $name string|null
     */
    public $name;

    /**
     * @var $version string|null
     */
    public $version;

    /**
     * @var $stability string|null
     */
    public $stability;

    /**
     * @var $author_name string|null
     */
    public $author_name;

    /**
     * @var $author_url string|null
     */
    public $author_url;

    /**
     * @var $license_name string|null
     */
    public $license_name;

    /**
     * @var $license_url string|null
     */
    public $license_url;

    /**
     * @var $description string|null
     */
    public $description;

    /**
     * @var $shortcode_files string[]
     */
    private $shortcode_files;

    /**
     * @var $shortcode_classes string[]
     */
    public $shortcode_classes;

    /**
     * @var $manifesto_script string|null
     */
    public $manifesto_script;

    /**
     * @var $css_files string[]
     */
    public $css_files;

    /**
     * @var $js_files string[]
     */
    public $js_files;


    /**
     * Construct a new Module.
     *
     * @param $id                 string
     * @param $name               string|null
     * @param $version            string|null
     * @param $stability          string|null
     * @param $author_name        string|null
     * @param $author_url         string|null
     * @param $license_name       string|null
     * @param $license_url        string|null
     * @param $description        string|null
     * @param $shortcode_files    string[]
     * @param $shortcode_classes  string[]
     * @param $manifesto_script   string|null
     * @param $css_files          string[]
     * @param $js_files           string[]
     */
    public function __construct(
      $id, $name = null, $version = null, $stability = null,
      $author_name = null, $author_url = null,
      $license_name = null, $license_url = null,
      $description = null, array $shortcode_files = array(),
      array $shortcode_classes = array(), $manifesto_script = null,
      array $css_files = array(), array $js_files = array()
    ) {
      $this->id                 = $id;
      $this->name               = $name;
      $this->version            = $version;
      $this->stability          = $stability;
      $this->author_name        = $author_name;
      $this->author_url         = $author_url;
      $this->license_name       = $license_name;
      $this->license_url        = $license_url;
      $this->description        = $description;
      $this->shortcode_files    = $shortcode_files;
      $this->shortcode_classes  = $shortcode_classes;
      $this->manifesto_script   = $manifesto_script;
      $this->css_files          = $css_files;
      $this->js_files           = $js_files;
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Enqueue the manifesto.
     *
     * @param array $dependencies
     */
    public function enqueue_manifesto(
      $dependencies = array( 'page-editor' )
    ) {
      /** @noinspection PhpUndefinedFunctionInspection */
      wp_enqueue_script(
        "page-editor_module_{$this->id}_manifesto",
        PageEditor_Util::parse_asset_url( $this->manifesto_script ),
        $dependencies,
        PageEditor_Util::generate_enqueue_version_value( $this->version )
      );
    }


    /**
     * Enqueue the CSS asset files specified.
     *
     * @param $dependencies string[]
     */
    public function enqueue_css_assets( $dependencies = array() ) {
      foreach ( $this->css_files as $css_file ) {
        /** @noinspection PhpUndefinedFunctionInspection */
        wp_enqueue_style(
          "page-editor_module_{$this->id}",
          PageEditor_Util::parse_asset_url( $css_file ),
          $dependencies,
          PageEditor_Util::generate_enqueue_version_value( $this->version )
        );
      }
    }


    /**
     * Enqueue the JS asset files specified.
     *
     * @param $dependencies string[]
     */
    public function enqueue_js_assets( $dependencies = array( 'jquery' ) ) {
      foreach ( $this->js_files as $js_file ) {
        /** @noinspection PhpUndefinedFunctionInspection */
        wp_enqueue_script(
          "page-editor_module_{$this->id}",
          PageEditor_Util::parse_asset_url( $js_file ),
          $dependencies,
          PageEditor_Util::generate_enqueue_version_value( $this->version )
        );
      }
    }


    /**
     * Register the module shortcodes.
     */
    public function register_shortcode() {

      // Require module class files
      $scripts = $this->shortcode_files;
      foreach ( $scripts as $script ) {
        /** @noinspection PhpIncludeInspection */
        require_once( PAGEEDITOR_PLUGIN_BASE_PATH . '/' . $script );
      }

      // Register module shortcodes
      $class_names = $this->shortcode_classes;
      foreach ( $class_names as $class_name ) {
        call_user_func( array( $class_name, 'register' ) );
      }
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Produce a string containing the concatenation of all of this module's
     * css asset files.
     *
     * @return string
     */
    public function concatenated_css_assets() {
      $css = '';

      foreach ( $this->css_files as $css_file ) {
        $path = PageEditor_Util::parse_asset_path( $css_file );
        $css .= file_get_contents( $path );
      }

      return $css;
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the module's stability description.
     *
     * @return string|null
     */
    public function stability_description() {
      return PageEditor_Model_Module_Stability::stability_description(
        $this->stability
      );
    }


    /**
     * Is this module enabled for the given stability?
     *
     * @param $stability
     *
     * @return bool
     */
    public function enabled_for_stability( $stability ) {
      return PageEditor_Model_Module_Stability::module_enabled_from_stability(
        $stability, $this->stability
      );
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Construct a PageEditor module from a standard module file using the given
     * module id to locate and construct the module.
     *
     * @param $module_id string
     *
     * @return PageEditor_Model_Module_Module|null
     */
    public static function from_standard_module_file( $module_id ) {
      return self::from_json_file(
        PAGEEDITOR_PLUGIN_BASE_PATH . '/modules/' . $module_id . '/module.json'
      );
    }


    /**
     * Construct a PageEditor module from the given json file.
     *
     * @param $file_path string
     *
     * @return PageEditor_Model_Module_Module|null
     */
    public static function from_json_file( $file_path ) {
      return self::from_json_object(

        // Enforce that the json string is decoded as an array instead of an
        // standard object
        json_decode(  file_get_contents( $file_path ), true )
      );
    }


    /**
     * Construct a PageEditor module from the given json object.
     *
     * @param $json_object array
     *
     * @return PageEditor_Model_Module_Module|null
     */
    public static function from_json_object( array $json_object ) {

      //
      // Parse data from given json object.
      //
      $id = PageEditor_Util::get_key_value(
        $json_object, 'id', null
      );
      $name = PageEditor_Util::get_key_value(
        $json_object, 'name', null
      );
      $version = PageEditor_Util::get_key_value(
        $json_object, 'version', null
      );
      $stability = PageEditor_Util::get_key_value(
        $json_object, 'stability', null
      );
      $author = PageEditor_Util::get_key_value(
        $json_object, 'author', array()
      );
      $author_name = PageEditor_Util::get_key_value(
        $author, 'name', null
      );
      $author_url = PageEditor_Util::get_key_value(
        $author, 'url', null
      );
      $license = PageEditor_Util::get_key_value(
        $json_object, 'license', array()
      );
      $license_name = PageEditor_Util::get_key_value(
        $license, 'name', null
      );
      $license_url = PageEditor_Util::get_key_value(
        $license, 'url', null
      );
      $description = PageEditor_Util::get_key_value(
        $json_object, 'description', null
      );
      $shortcode = PageEditor_Util::get_key_value(
        $json_object, 'shortcode', array()
      );
      $shortcode_files = PageEditor_Util::get_key_value(
        $shortcode, 'files', null
      );
      $shortcode_classes = PageEditor_Util::get_key_value(
        $shortcode, 'classes', null
      );
      $manifesto_script = PageEditor_Util::get_key_value(
        $json_object, 'manifesto-script', null
      );
      $css_files = PageEditor_Util::get_key_value(
        $json_object, 'css-files', array()
      );
      $js_files = PageEditor_Util::get_key_value(
        $json_object, 'js-files', array()
      );

      // --- --- ---

      //
      // Cancel if no id is provided
      //
      if ( ! $id ) {
        return null;
      }

      // --- --- ---

      //
      // Construct the module
      //
      return new PageEditor_Model_Module_Module(
        $id, $name, $version, $stability, $author_name, $author_url,
        $license_name, $license_url, $description, $shortcode_files,
        $shortcode_classes, $manifesto_script, $css_files, $js_files
      );
    }


  }
}