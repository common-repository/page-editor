<?php
/**
 * Class PageEditor_Model_Template_TemplateManager
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Model_Template_TemplateManager' ) ) {
  class PageEditor_Model_Template_TemplateManager {


    /**
     * @var $templates PageEditor_Model_Template_Template[]
     */
    public $templates = array();


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Construct a new template manager.
     *
     * @param $load_core_templates bool
     */
    public function __construct( $load_core_templates = true ) {

      // Load core templates?
      if ( $load_core_templates ) {
        $this->load_core_templates();
      }
    }


    /**
     * Load all core PageEditor templates.
     */
    public function load_core_templates() {
      //$this->load_from_standard_template_file( 'customer-reviews-1' );
      //$this->load_from_standard_template_file( 'our-services-1' );
      $this->load_from_standard_template_file( 'progress-target-1' );
      $this->load_from_standard_template_file( 'row-of-3-item-summary-with-icon-1' );
      $this->load_from_standard_template_file( 'about-1' );
      $this->load_from_standard_template_file( 'about-2' );
      $this->load_from_standard_template_file( 'join-the-project-1' );
    }


    /**
     * @return string
     */
    public function build_load_js() {

      $javascript = '';
      foreach ( $this->templates as $template ) {
        $javascript .= $template->build_load_js();
      }

      return $javascript;
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Load the given template.
     *
     * @param $template PageEditor_Model_Template_Template
     */
    public function load( $template ) {
      $this->templates[$template->id] = $template;
    }


    /**
     * Load a PageEditor template from a standard template file using the given
     * template id to locate and construct the module.
     *
     * @param $template_id string
     *
     * @return PageEditor_Model_Template_Template|null
     */
    public function load_from_standard_template_file( $template_id ) {
      $this->load(
        PageEditor_Model_Template_Template::from_standard_module_file(
          $template_id
        )
      );
    }


    /**
     * Load a PageEditor template from the given json file.
     *
     * @param $file_path string
     *
     * @return PageEditor_Model_Template_Template|null
     */
    public function from_json_file( $file_path ) {
      $this->load( PageEditor_Model_Template_Template::from_json_file(
        $file_path
      ) );
    }


    /**
     * Register a PageEditor template to be loaded.
     *
     * @param string|null $id
     * @param string|null $name
     * @param string|null $version
     * @param string|null $icon
     * @param string|null $author_name
     * @param string|null $author_url
     * @param string|null $license_name
     * @param string|null $license_url
     * @param string|null $description
     * @param string|null $shortcode
     */
    public function load_template(
      $id, $name = null, $version = null, $icon = null, $author_name = null,
      $author_url = null, $license_name = null, $license_url = null,
      $description = null, $shortcode = null
    ) {
      $this->templates[$id] = new PageEditor_Model_Template_Template(
        $name, $version, $icon, $author_name, $author_url,
        $license_name, $license_url, $description, $shortcode
      );
    }


  }
}