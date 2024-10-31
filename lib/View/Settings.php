<?php
/**
 * Class PageEditor_View_Settings
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_View_Settings' ) ) {
  class PageEditor_View_Settings extends PageEditor_View_Template {

    private static $csrf_token;


		public static function current_url() {
			return 'admin.php?page=pe-settings';
		}


		/**
 		 *
		 */
    public static function content() {

      //
      // Update settings if POST given
      //
      $saved = false;
      $savedErrorMessage = 'Cannot save your settings. Write permission was denied. <a target="_blank" href="https://codex.wordpress.org/Changing_File_Permissions">Read about permissions</a>';

      // Update the settings from the post (if sent)
      if ( ! empty( $_POST ) ) {
        try {
          $saved = self::post_settings_page();
        } catch ( \Exception $e ) {
          $savedErrorMessage = $e->getMessage();
        }
      }

      // --- --- ---

      // Retrieve the settings to be displayed
      $settings = PageEditor_WordPressPlugin::settings( true );

      // Generate a new CSRF token
      self::$csrf_token = uniqid( 'page-editor_' );
      ?>


			<?php if ( ! empty( $_POST ) ): ?>
				<?php if ( $saved ): ?>
					<div class="alert-boxed alert alert-success w-600">
						<b><?php echo __('Settings Saved!', 'page-editor') ?></b>
					</div>
				<?php else: ?>
					<div class="alert-boxed alert alert-danger w-600">
						<b><?php echo __('Error Saving Settings', 'page-editor') ?>:</b> <?php echo $savedErrorMessage; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>


			<form method="post" id="page-editor-settings-form">

				<?php self::settings_page_tabs( $settings ); ?>

				<!-- CSRF token -->
				<input type="hidden" name="__token" value="<?php echo self::$csrf_token ?>"/>

			</form>

    <?php
    }






    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---



    /*
     *   _____              _    _         _
     *  |  __ \            | |  (_)       | |
     *  | |__) |__ _  _ __ | |_  _   __ _ | | ___
     *  |  ___// _` || '__|| __|| | / _` || |/ __|
     *  | |   | (_| || |   | |_ | || (_| || |\__ \
     *  |_|    \__,_||_|    \__||_| \__,_||_||___/
     *
     */

    /**
     * @param PageEditor_Model_Settings $settings
     */
    private static function settings_page_tabs( $settings ) {
      ?>

        <?php self::settings_page_tab_general( $settings ); ?>

        <div class="mt-30">
          <button type="submit" class="button button-primary"><?php echo __('Save Settings', 'page-editor') ?></button>
          <button type="submit" value="1" name="clear-settings" class="button button-default"><?php echo __('Reset Settings', 'page-editor') ?></button>
        </div>
      <?php
    }


    /**
     * @param PageEditor_Model_Settings $settings
     */
    private static function settings_page_tab_general( $settings ) {
      ?>
      <table class="form-table">

        <tr>
          <th scope="row"><?php echo __( 'Enable Footer Link', 'page-editor' ) ?></th>
          <td>
            <label>
              <input type="checkbox" id="footer-link-enabled" name="_page-editor_settings[footer-link-enabled]" value="1" <?php checked( 1, $settings->footer_link_enabled(), true ); ?>/>
              <?php echo __( 'Show PageEditor link in the footer of your website.', 'page-editor' ) ?>
            </label>
            <p class="below-label">
              <?php echo __( 'Help support PageEditor by adding a link to the footer of your website.', 'page-editor' ) ?>
              <?php echo __( 'This helps us to spread the word and introduce new people to PageEditor.', 'page-editor' ) ?>
            </p>
          </td>
        </tr>

        <tr>
          <th scope="row"><?php echo __( 'Filter module stability', 'page-editor' ) ?></th>
          <td>
            <label>
              <?php
              $module_stability  = $settings->module_stability();
              $stability_options = PageEditor_Model_Module_Stability::stability_options();
              ?>
              <select id="module-stability" name="_page-editor_settings[module-stability]">
                <?php foreach ( $stability_options as $stability ): ?>
                <option value="<?php echo $stability ?>"<?php if( $module_stability == $stability ): ?> selected<?php endif; ?>>
                  <?php echo __( ucwords( $stability ), 'page-editor' ); ?>
                </option>
                <?php endforeach; ?>
              </select>
            </label>
            <p class="below-label">
              <?php echo __( 'Filter the stability of modules that should be loaded.', 'page-editor' ) ?>
            </p>
          </td>
        </tr>

      </table>
    <?php
    }



    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /*
     *   _____             _
     *  |  __ \           | |
     *  | |__) |___   ___ | |_
     *  |  ___// _ \ / __|| __|
     *  | |   | (_) |\__ \| |_
     *  |_|    \___/ |___/ \__|
     *
     */


    /**
     * Handle post of settings_page.
     *
     * @throws Exception
     *
     * @return boolean
     */
    private static function post_settings_page() {

      //
      // Clear Settings?
      //
      if ( isset( $_POST['clear-settings'] ) && $_POST['clear-settings'] ) {
        PageEditor_Model_Settings::clear();
        return true;
      }

      // --- --- ---

      //
      // Update Settings
      //
      $settings   = new PageEditor_Model_Settings();
      $input_data = new PageEditor_Model_InputDataArray(
        $_POST['_page-editor_settings']
      );


      // Footer Link Enabled?
      $settings->set_footer_link_enabled(
        $input_data->read_as_boolean(
          'footer-link-enabled',
          PageEditor_Model_Settings::$default__footer_link_enabled
        )
      );

      // Module Stability
      $settings->set_module_stability(
        $input_data->read_as_string_from_selection(
          'module-stability',
          PageEditor_Model_Module_Stability::stability_options(),
          PageEditor_Model_Settings::$default__module_stability
        )
      );

      // Save the updated settings
      return $settings->save();
    }


  }
}