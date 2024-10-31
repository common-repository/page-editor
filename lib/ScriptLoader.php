<?php
/**
 * Class PageEditor_ScriptLoader
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_ScriptLoader' ) ) {
  class PageEditor_ScriptLoader {


    /**
     * Require common PageEditor script files
     */
    public static function require_common_files() {
      require_once( 'CurrentPage.php' );
      require_once( 'Util.php' );
      require_once( 'Enqueue.php' );
      require_once( 'WordPress.php' );
      require_once( 'Post.php' );
      require_once( 'Assets.php' );
      require_once( 'Model/InputDataArray.php' );
      require_once( 'Model/FontAwesome.php' );
    }


    /**
     *
     */
    public static function require_settings_files() {
      require_once( 'Model/Settings.php' );
    }


    /**
     *
     */
    public static function require_module_manager_files() {
      require_once( 'Model/Module/Module.php' );
      require_once( 'Model/Module/ModuleManager.php' );
      require_once( 'Model/Module/Stability.php' );
    }


    /**
     *
     */
    public static function require_module_asset_loader_files() {
      require_once( 'Model/Module/AssetLoader.php' );
    }


    /**
     *
     */
    public static function require_template_manager_files() {
      require_once( 'Model/Template/Template.php' );
      require_once( 'Model/Template/TemplateManager.php' );
    }

    public static function require_shortcode_files() {
      require_once( 'Model/ShortCode/ShortCodeProvider.php' );
      require_once( 'Model/ShortCode/BaseShortCode.php' );
      require_once( 'Model/ShortCode/Renderer.php' );
    }

    public static function require_renderer_files() {
      require_once( 'Renderer.php' );
      self::require_shortcode_files();
    }

    public static function require_editor_files() {
      require_once( 'Editor.php' );
    }

    public static function require_embedded_editor_files() {
      require_once( 'EditorPage.php' );
    }

    public static function require_admin_interface_files() {
      require_once( 'View/TemplateViewProvider.php' );
      require_once( 'View/Template.php' );
      require_once( 'View/Settings.php' );
      require_once( 'View/Modules.php' );
      require_once( 'View/About.php' );
      require_once( 'AdminInterface.php' );
    }


	}
}