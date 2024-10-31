<?php
/**
 * Class PageEditor_Model_Settings
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Model_Settings' ) ) {
  class PageEditor_Model_Settings {

		const SETTINGS_PRIORITISE_FALLBACK      = false;
		const SETTINGS_FALLBACK_FILE_NAME       = '.page-editor_settings';
		const SETTINGS_OPTION_NAME              = '_page-editor_settings';

		// ---

		const KEY__FOOTER_LINK_ENABLED          = 'footer-link-enabled';
		const KEY__MODULE_STABILITY             = 'module-stability';
		const KEY__COMPATIBILITY_MODE_ENABLED   = 'compatibility-mode-enabled';
		const KEY__EDITOR_THEME                 = 'editor-theme';

    // ---

    public static $default__footer_link_enabled = false;
    public static $default__module_stability =
      PageEditor_Model_Module_Stability::PRODUCTION;

		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


		/**
		 * Array of settings - provides {key} -> {value} map structure
		 *
		 * @var $data mixed[]
		 */
		private $data;


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


		/**
		 * Construct the settings...
		 */
		public function __construct() {
			$this->reload();
		}


		/**
		 * Save the settings
		 *
		 * @return bool
		 */
		public function save() {
			return self::write( $this->data );
		}


		/**
		 * Reload the settings
		 */
		public function reload() {
			$this->data = self::read();
		}


		/**
		 * Represent the settings as a string.
		 *
		 * @return string
		 */
		public function __toString() {
			return json_encode( $this->data );
		}


		/**
		 * Get the absolute path to the fallback settings file.
		 *
		 * @return string
		 */
		private static function fallback_file_path() {
			/** @noinspection PhpUndefinedConstantInspection */
			return ABSPATH.DIRECTORY_SEPARATOR.self::SETTINGS_FALLBACK_FILE_NAME;
		}


		/**
		 * Read settings.
		 *
		 * @return array|null
		 */
		public static function read() {

			// Force cache clear
			/** @noinspection PhpUndefinedFunctionInspection */
			wp_cache_delete( self::SETTINGS_OPTION_NAME );

			// Read settings from the WP options database
			/** @noinspection PhpUndefinedFunctionInspection */
			$data = get_option( self::SETTINGS_OPTION_NAME );

			// Fallback settings file if get_option not working
			if ( ( ! $data || self::SETTINGS_PRIORITISE_FALLBACK ) && file_exists( self::fallback_file_path() ) ) {
				$data = json_decode( file_get_contents( self::fallback_file_path() ), true );
			}

			return $data;
		}


		/**
		 * Write settings.
		 *
		 * @param $settings
		 * @return bool
		 */
		private static function write( $settings ) {

			// Settings unchanged
			$settings_unchanged = json_encode( self::read() ) == json_encode( $settings );

			// Save settings in the WP options database
			/** @noinspection PhpUndefinedFunctionInspection */
			$saved = $settings_unchanged || update_option( self::SETTINGS_OPTION_NAME, $settings, false );

			// Fallback settings file if update_option not working
			$saved = file_put_contents( self::fallback_file_path(), json_encode( $settings ) ) || $saved;

			// Clean $saved into boolean value (file_put_contents returns bytes written)
			return $saved ? true : false;
		}


		/**
		 * Clear the settings.
		 */
		public static function clear() {

			// Force cache clear
			/** @noinspection PhpUndefinedFunctionInspection */
			wp_cache_delete( self::SETTINGS_OPTION_NAME );

			/** @noinspection PhpUndefinedFunctionInspection */
			delete_option( self::SETTINGS_OPTION_NAME );

			// Delete fallback file
			if ( file_exists( self::fallback_file_path() ) ) {
				unlink( self::fallback_file_path() );
			}
		}


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


		/**
		 * Read an attribute as a string.
		 *
		 * @param $key
		 * @param null $default
		 * @return string
		 */
		private function read_attribute_as_string( $key, $default = null ) {
			return is_array( $this->data ) && array_key_exists( $key, $this->data )
				? ( string ) $this->data[$key] : $default;
		}


    /**
     * Write an attribute as a string.
     *
     * @param $key
     * @param $value
     */
    private function write_attribute_as_string( $key, $value ) {
      $this->data[$key] = ( string ) $value;
    }


		/**
		 * Read an attribute as a boolean.
		 *
		 * @param string $key
		 * @param bool $default
		 * @return bool
		 */
		private function read_attribute_as_boolean( $key, $default = true ) {
			return is_array( $this->data ) && array_key_exists( $key, $this->data )
				? ( boolean ) $this->data[$key] : $default;
		}


    /**
     * Write an attribute as a boolean.
     *
     * @param $key
     * @param $value
     */
    private function write_attribute_as_boolean(
      $key, $value
    ) {
      $this->data[$key] = ( boolean ) $value;
    }


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


		/**
		 * Get whether whether the footer link is enabled.
		 *
		 * @return bool
		 */
		public function footer_link_enabled() {
			return $this->read_attribute_as_boolean(
        self::KEY__FOOTER_LINK_ENABLED, self::$default__footer_link_enabled
      );
		}


    /**
     * Set whether the footer link is enabled.
     *
     * @param bool $footer_link_enabled
     */
    public function set_footer_link_enabled( $footer_link_enabled ) {
      $this->write_attribute_as_boolean(
        self::KEY__FOOTER_LINK_ENABLED, $footer_link_enabled,
        self::$default__footer_link_enabled
      );
    }


		// --- --- ---


		/**
		 * Get the module stability.
		 *
		 * @return string
		 */
		public function module_stability() {
			return $this->read_attribute_as_string(
        self::KEY__MODULE_STABILITY, self::$default__module_stability

      );
		}


		/**
		 * Set the module stability.
		 *
		 * @param string $module_stability
		 */
		public function set_module_stability( $module_stability ) {
			$this->write_attribute_as_string(
				self::KEY__MODULE_STABILITY, $module_stability
			);
		}



	}
}