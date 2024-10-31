<?php
/**
 * Class PageEditor_Model_Template_Template
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Model_Template_Template' ) ) {
  class PageEditor_Model_Template_Template {

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
     * @var $version string|null
     */
    public $icon;

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
     * @var $shortcode string|null
     */
    public $shortcode;


    /**
     * Construct a new Template.
     *
     * @param $id
     * @param null $name
     * @param null $version
     * @param null $icon
     * @param null $author_name
     * @param null $author_url
     * @param null $license_name
     * @param null $license_url
     * @param null $description
     * @param null $shortcode
     */
    public function __construct(
      $id, $name = null, $version = null, $icon = null, $author_name = null,
      $author_url = null, $license_name = null, $license_url = null,
      $description = null, $shortcode = null
    ) {
      $this->id           = $id;
      $this->name         = $name;
      $this->version      = $version;
      $this->icon         = $icon;
      $this->author_name  = $author_name;
      $this->author_url   = $author_url;
      $this->license_name = $license_name;
      $this->license_url  = $license_url;
      $this->description  = $description;
      $this->shortcode    = $shortcode;
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Represent this Template as a json object.
     *
     * @return array
     */
    public function to_json_object() {
      return array(
        'id' => $this->id,
        'name' => $this->name,
        'version' => $this->version,
        'icon' => $this->icon,
        'author' => array(
          'name' => $this->author_name,
          'url' => $this->author_url,
        ),
        'license' => array(
          'name' => $this->license_name,
          'url' => $this->license_url,
        ),
        'description' => $this->description,
        'shortcode' => $this->shortcode,
        'html' => $this->generate_html(),
      );
    }


    /**
     * Build the HTML for this template.
     * Produced by rendering the template shortcode as HTML.
     *
     * @return string
     */
    public function generate_html() {

      // Generate the html for the template shortcode - and force edit mode so
      // it displays correctly for the user to edit.
      return PageEditor_Model_ShortCode_Renderer::do_shortcode_in_edit_mode(
        $this->shortcode
      );
    }


    /**
     *
     *
     * @return string
     */
    public function build_load_js() {
      $json = json_encode( $this->to_json_object() );
      return "$.fn.PageEditor('register-template', $json);";
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Construct a PageEditor template from a standard template file using the
     * given template id to locate and construct the module.
     *
     * @param $template_id string
     *
     * @return PageEditor_Model_Template_Template|null
     */
    public static function from_standard_module_file( $template_id ) {
      return self::from_json_file(
        PAGEEDITOR_PLUGIN_BASE_PATH . '/templates/' . $template_id .
        '/template.json'
      );
    }


    /**
     * Construct a PageEditor template from the given json file.
     *
     * @param $file_path string
     *
     * @return PageEditor_Model_Template_Template|null
     */
    public static function from_json_file( $file_path ) {
      return self::from_json_object(

      // Enforce that the json string is decoded as an array instead of an
      // standard object
        json_decode(  file_get_contents( $file_path ), true )
      );
    }


    /**
     * Construct a PageEditor template from the given json object.
     *
     * @param $json_object array
     *
     * @return PageEditor_Model_Template_Template|null
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
      $icon = PageEditor_Util::get_key_value(
        $json_object, 'icon', null
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

      // --- --- ---

      //
      // Cancel if no id is provided
      //
      if ( ! $id ) {
        return null;
      }

      // --- --- ---

      //
      // Load the template
      //
      return new PageEditor_Model_Template_Template(
        $id, $name, $version, $icon, $author_name, $author_url, $license_name,
        $license_url, $description, $shortcode
      );

    }



  }
}