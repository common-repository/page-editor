<?php
/**
 * Class PageEditor_AdminInterface
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_AdminInterface' ) ) {
  class PageEditor_AdminInterface {

		private static $square_logo = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAMAAAC6V+0/AAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAABRUExURUxpcf///////5nMM5nMM////5nMM////////5nMM5nMM5nMM5nMM////////+v1163WW6XSTPP55pjMMYrFFZjLMJnMM/////P556XSS5jMMfLDPgcAAAAWdFJOUwCFDPf4hoYK+AqFlAyU95SU+Pj4DIVFC+muAAAAZUlEQVQY023RVxKAMAgE0CSWxN5TvP9BNU3FWT7fDAMsjKXa50mwXzXHsnL5s3pzVlWSWnk6a4jepj1+1VvEV4MlzBotY9S+DfagUVywrtAUzThghO1wEF4JL4/PxIHg6HDI9B0XrmIQq6SK3LIAAAAASUVORK5CYII=';


    // --- --- ---


    /**
     *
     */
    public function __construct() {

			//
			// Load admin view assets
			//
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );


			//
			// Add
			//
			self::construct_admin_menus();


			//
			// Add settings link to plugin
			//
			add_filter( 'plugin_action_links_' . PAGEEDITOR_PLUGIN_BASE_NAME, function( $links ) {

				$url = admin_url( 'admin.php?page=pe-settings' );

				return array_merge( $links, array(
					"<a href='$url'>" . PageEditor_WordPress::prepare_text( 'Settings' ) . '</a>',
				) );

			} );

		}


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


		/**
		 * Enqueue assets (css and js)
		 *
		 * @param $hook
		 */
		function enqueue_assets( $hook ) {
			if ( self::is_settings_page( $hook ) ) {
        PageEditor_Enqueue::jquery();
        PageEditor_Enqueue::bootstrap();
        PageEditor_Enqueue::admin_view_styles();
			}
		}


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


		/**
		 *
		 */
		private static function construct_admin_menus() {
			add_action( 'admin_menu', function() {

				// Top level menu
				self::construct_admin_menu_main();

				// Setting page
				self::construct_admin_menu_settings();

        // Modules page
				self::construct_admin_menu_modules();

				// About page
				self::construct_admin_menu_about();

			} );
		}


		/**
		 *
		 */
		private static function construct_admin_menu_main() {
			add_menu_page(
				PageEditor_WordPress::prepare_text( 'PageEditor' ),
        PageEditor_WordPress::prepare_text( 'PageEditor' ),
				'edit_posts',
				'pe-settings',
				null,
				self::$square_logo,
				80
			);
		}


		/**
		 *
		 */
		private static function construct_admin_menu_settings() {
			add_submenu_page(
				'pe-settings',
        PageEditor_WordPress::prepare_text( 'PageEditor Settings' ),
        PageEditor_WordPress::prepare_text( 'Settings' ),
				'edit_themes',
				'pe-settings',
				array( 'PageEditor_View_Settings', 'render' )
			);
		}


		/**
		 *
		 */
		private static function construct_admin_menu_modules() {
			add_submenu_page(
				'pe-settings',
        PageEditor_WordPress::prepare_text( 'PageEditor Modules' ),
        PageEditor_WordPress::prepare_text( 'Modules' ),
				'edit_themes',
				'pe-modules',
				array( 'PageEditor_View_Modules', 'render' )
			);
		}


		/**
		 *
		 */
		private static function construct_admin_menu_about() {
			add_submenu_page(
				'pe-settings',
        PageEditor_WordPress::prepare_text( 'Welcome to PageEditor' ) . ' ' . PAGEEDITOR_PLUGIN_VERSION,
        PageEditor_WordPress::prepare_text( 'About' ),
				'edit_themes',
				'pe-about',
				array( 'PageEditor_View_About', 'render' )
			);
		}


		// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


		/**
		 * @param $hook
		 *
		 * @return bool
		 */
		private static function is_settings_page( $hook ) {
			return
				'toplevel_page_pe-settings' == $hook ||
				'pageeditor_page_pe-settings' == $hook ||
				'pageeditor_page_pe-modules' == $hook ||
				'pageeditor_page_pe-about' == $hook;
		}


	}
}