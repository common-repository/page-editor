<?php
/**
 * Class PageEditor_Model_Module_Stability
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Model_Module_Stability' ) ) {
  class PageEditor_Model_Module_Stability {

    const PRODUCTION  = 'production';
    const TESTING     = 'testing';
    const DEVELOPMENT = 'development';


    /**
     * @return array
     */
    public static function stability_options() {
      return array(
        self::PRODUCTION, self::TESTING, self::DEVELOPMENT
      );
    }


    /**
     * Get the description for the given stability.
     *
     * @param $stability
     *
     * @return null|string
     */
    public static function stability_description( $stability ) {
      switch ( $stability ) {

        case self::PRODUCTION:
          return 'Ready for production use.';

        case self::TESTING:
          return 'Should work reasonably - but may have some issues.';

        case self::DEVELOPMENT:
          return 'Under development - may not work correctly.';

        default: return null;
      }
    }


    /**
     * Represent the given stability as a number (stability level).
     *
     * @param $stability
     *
     * @return int
     */
    public static function stability_as_number( $stability ) {
      switch ( $stability ) {
        case self::PRODUCTION: return 3;
        case self::TESTING: return 2;
        case self::DEVELOPMENT: return 1;
        default: return -1;
      }
    }


    /**
     * Given the current stability setting and the stability of a module,
     * determine whether the module is enabled or not.
     *
     * @param $stability_setting
     * @param $module_stability string
     *
     * @return bool
     */
    public static function module_enabled_from_stability(
      $stability_setting, $module_stability
    ) {
      $setting_stability_level = self::stability_as_number( $stability_setting );
      $module_stability_level = self::stability_as_number( $module_stability );
      return $module_stability_level >= $setting_stability_level;
    }


  }
}