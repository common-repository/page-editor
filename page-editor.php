<?php
/*
 * Plugin Name: PageEditor
 * Plugin URI: https://page-editor.com
 * Description: Visual WordPress page content editor.
 * Author: PageEditor
 * Version: 1.0.1
 * License: GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_WordPressPlugin' ) ) {

	/**
	 * Class PageEditor_WordPressPlugin
	 *
	 * @author	support@page-editor.com
	 * @version 1.0.1
	 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
	 */
	class PageEditor_WordPressPlugin {

    /**
     * @var PageEditor_Model_Settings $settings
     */
    private static $settings;


    /**
     * @var PageEditor_Model_Module_ModuleManager $module_manager
     */
    private static $module_manager;


    /**
     * @var PageEditor_Model_Module_AssetLoader $module_asset_loader
     */
    private static $module_asset_loader;


    /**
     * @var PageEditor_Model_Template_TemplateManager $template_manager
     */
    private static $template_manager;


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the settings.
     *
     * @param bool $refresh
     *
     * @return PageEditor_Model_Settings
     */
    public static function settings( $refresh = false ) {

      if ( ! self::$settings || $refresh ) {
        PageEditor_ScriptLoader::require_settings_files();
        self::$settings = new PageEditor_Model_Settings();
      }

      return self::$settings;
    }


    /**
     * Get the module manager.
     *
     * @return \PageEditor_Model_Module_ModuleManager
     */
    public static function module_manager() {

      if ( ! self::$module_manager ) {
        PageEditor_ScriptLoader::require_module_manager_files();

        $settings = self::settings();

        self::$module_manager = new PageEditor_Model_Module_ModuleManager();
        self::$module_manager->set_required_module_stability(
          $settings->module_stability()
        );
      }

      return self::$module_manager;
    }


    /**
     * Get the module asset loader.
     *
     * @return PageEditor_Model_Module_AssetLoader
     */
    public static function module_asset_loader() {

      if ( ! self::$module_asset_loader ) {
        PageEditor_ScriptLoader::require_module_asset_loader_files();
        self::$module_asset_loader = new PageEditor_Model_Module_AssetLoader(
          self::module_manager()
        );
      }

      return self::$module_asset_loader;
    }


    /**
     * Get the template manager.
     *
     * @return PageEditor_Model_Template_TemplateManager
     */
    public static function template_manager() {

      if ( ! self::$template_manager ) {
        PageEditor_ScriptLoader::require_template_manager_files();
        self::$template_manager =
          new PageEditor_Model_Template_TemplateManager();
      }

      return self::$template_manager;
    }



    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Define the PageEditor constants.
     */
    private static function define_constants() {

      // Define the base file path of PageEditor
      if ( ! defined( 'PAGEEDITOR_PLUGIN_BASE_PATH' ) ) {
        define( 'PAGEEDITOR_PLUGIN_BASE_PATH', __DIR__ );
      }

      // Define the base url of PageEditor
      if ( ! defined( 'PAGEEDITOR_PLUGIN_BASE_URL' ) ) {
        /** @noinspection PhpUndefinedFunctionInspection */
        define( 'PAGEEDITOR_PLUGIN_BASE_URL', plugins_url( '', __FILE__ ) );
      }

      // Define the base name of PageEditor
      if ( ! defined( 'PAGEEDITOR_PLUGIN_BASE_NAME' ) ) {
        /** @noinspection PhpUndefinedFunctionInspection */
        define( 'PAGEEDITOR_PLUGIN_BASE_NAME', plugin_basename( __FILE__ ) );
      }

      // Define whether PageEditor is running in development mode
      if ( ! defined( 'PAGEEDITOR_PLUGIN_DEVELOPMENT_MODE' ) ) {
        define(
        'PAGEEDITOR_PLUGIN_DEVELOPMENT_MODE',
          isset( $_SERVER['PAGEEDITOR_DEV'] ) && $_SERVER['PAGEEDITOR_DEV']
        );
      }

      // Define the PageEditor version
      if ( ! defined( 'PAGEEDITOR_PLUGIN_VERSION' ) ) {
        define( 'PAGEEDITOR_PLUGIN_VERSION', '1.0.1' );
      }

    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Boot PageEditor
     */
    public static function boot() {

      // We need the ability to load additional scripts
      require_once( 'lib/ScriptLoader.php' );

      // Load the common files required to run PageEditor
      PageEditor_ScriptLoader::require_common_files();

      // Define PageEditor constants
      self::define_constants();

      // Define the colors available
      //self::define_colors();

      // --- --- ---

      //
      // Work out which page we're on so we can ascertain which scripts should
      // be loaded + models constructed.
      //
      $current_page_is_wordpress_admin =
        PageEditor_CurrentPage::current_page_is_wordpress_admin();

      $current_page_is_rendering_a_page =
        PageEditor_CurrentPage::current_page_is_render_page();

      $current_page_is_admin_editor =
        PageEditor_CurrentPage::current_page_is_admin_editor();

      //$current_page_is_admin_interface =
      //  PageEditor_CurrentPage::current_page_is_admin_interface();


      $user_can_edit_pages = PageEditor_WordPress::user_can_rich_edit();

      // --- --- ---

      //
      // Add WordPress functionality / links based on current page
      //

      // Add 'Edit with PageEditor' links to the list of pages / posts displayed
      // in the WordPress admin section.
      if ( $current_page_is_wordpress_admin ) {
        PageEditor_WordPress::add_edit_page_with_pageeditor_row_action();
      }

      // Add 'Edit with PageEditor' link to admin top bar when either editing a
      // page / post or when viewing a rendered page / post.
      if (
        $current_page_is_admin_editor || $current_page_is_rendering_a_page
      ) {
        PageEditor_WordPress::add_edit_with_pageeditor_link_to_admin_top_bar();
      }


      // --- --- ---

      //
      // Decide how to boot PageEditor
      //

      // Rendering a page
      if ( $current_page_is_rendering_a_page ) {
        self::boot_as_rendering_a_page();
      }

      // Admin Editor (Edit a page)
      if ( $current_page_is_admin_editor && $user_can_edit_pages ) {
        self::boot_as_admin_editor();
      }

      // Admin Interface
      if ( $current_page_is_wordpress_admin ) {
        self::boot_as_admin_interface();
      }
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Boot the PageEditor plugin as a page being rendered.
     */
    private static function boot_as_rendering_a_page() {
      PageEditor_ScriptLoader::require_renderer_files();

      // Construct the renderer
      new PageEditor_Renderer(
        self::module_manager(), self::module_asset_loader()
      );

      // Render with embedded editor
      if ( PageEditor_CurrentPage::current_page_has_launch_query_parameter() ) {
        PageEditor_ScriptLoader::require_embedded_editor_files();
        new PageEditor_EditorPage();
      }

      // Rendering in normal mode - add footer link?
      else {
        $settings = self::settings();
        if ( $settings->footer_link_enabled() ) {
          PageEditor_WordPress::add_built_with_page_editor_footer_link();
        }
      }

    }


    /**
     * Boot the PageEditor plugin as the admin page / post editor.
     */
    private static function boot_as_admin_editor() {
      PageEditor_ScriptLoader::require_editor_files();

      // Shortcodes must also be loaded since we need the ability to render
      // templates to html
      PageEditor_ScriptLoader::require_shortcode_files();

      // ---

      $module_manager      = self::module_manager();
      $module_asset_loader = self::module_asset_loader();
      $template_manager    = self::template_manager();

      // Construct the editor
      new PageEditor_Editor(
        $module_manager, $module_asset_loader, $template_manager
      );
    }


    /**
     * Boot the PageEditor plugin as the admin interface.
     * View / change PageEditor setting etc...
     */
    private static function boot_as_admin_interface() {

      // Require admin interface files
      PageEditor_ScriptLoader::require_admin_interface_files();

      // Populate the module manager
      self::module_manager();

      // Construct the admin interface
      new PageEditor_AdminInterface();
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---




    /**
     * @return array
     */
    public static function shortcode_tags() {

      $tags = array();

      $enabled_modules = self::$module_manager->enabled_modules();
      foreach ( $enabled_modules as $module ) {
        $shortcode_classes = $module->shortcode_classes;
        foreach ( $shortcode_classes as $class ) {
          /** @noinspection PhpUndefinedMethodInspection */
          $tags[] = $class::signature();
        }
      }

      return $tags;
    }


    /**
     * @return array
     */
    public static function container_shortcode_tags() {

      $tags = array();

      $enabled_modules = self::$module_manager->enabled_modules();
      foreach ( $enabled_modules as $module ) {
        $shortcode_classes = $module->shortcode_classes;
        foreach ( $shortcode_classes as $class ) {
          /** @noinspection PhpUndefinedMethodInspection */
          if ( $class::is_container() ) {
            /** @noinspection PhpUndefinedMethodInspection */
            $tags[] = $class::signature();
          }
        }
      }

      return $tags;
    }


	}
}

// --- --- ---

//
// Boot Plugin
//
PageEditor_WordPressPlugin::boot();