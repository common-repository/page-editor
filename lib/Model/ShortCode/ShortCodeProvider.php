<?php
/**
 * Interface PageEditor_Model_ShortCode_ShortCodeProvider
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! interface_exists( 'PageEditor_Model_ShortCode_ShortCodeProvider' ) ) {
  interface PageEditor_Model_ShortCode_ShortCodeProvider {


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id();


    /**
     * Get the shortcode signature.
     *
     * @return string
     */
    static function signature();


    /**
     * Is this module a container? Can it container other modules?
     *
     * @return boolean
     */
    static function is_container();


    /**
     * Register this module.
     *
     * @return
     */
    static function register();


    /**
     * Build the html for this module.
     *
     * @param $attributes
     * @param $edit_mode bool
     * @param $content string|null
     *
     * @return string
     */
    static function build_html(
      $attributes, $edit_mode = false, $content = null
    );


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values();

	}
}