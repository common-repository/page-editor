<?php
/**
 * Class PageEditor_CurrentPage
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_CurrentPage' ) ) {
  class PageEditor_CurrentPage {


    /**
     * Get the current request uri.
     *
     * @return string
     */
    public static function current_request_uri() {
      return $_SERVER['REQUEST_URI'];
    }


    /**
     * Is the current request uri part of the admin interface?
     *
     * @return bool
     */
    public static function current_page_is_admin_interface() {
      $current_uri = self::current_request_uri();
      return '/wp-admin/admin.php?page=pe-' == substr( $current_uri, 0, 28 );
    }


    /**
     * Is the current request uri the admin page editor.
     *
     * @return bool
     */
    public static function current_page_is_admin_editor() {
      $current_uri = self::current_request_uri();
      $edit_page = '/wp-admin/post.php' == substr( $current_uri, 0, 18 );
      $new_page = '/wp-admin/post-new.php' == substr( $current_uri, 0, 22 );
      return $edit_page || $new_page;
    }


    /**
     * Is the current page part of the WordPress admin section?
     *
     * @return bool
     */
    public static function current_page_is_wordpress_admin() {
      $current_uri = self::current_request_uri();
      return '/wp-admin' == substr( $current_uri, 0, 9 );
    }


    /**
     * Is the current request uri a page being rendered?
     *
     * @return bool
     */
    public static function current_page_is_render_page() {
      return ! self::current_page_is_wordpress_admin();
    }


    /**
     * Is the current request uri a page being rendered - but also requires
     * the embedded editor assets be loaded?
     *
     * @return bool
     */
    public static function current_page_has_launch_query_parameter() {
      return 'true' == $_GET[ 'page-editor' ];
    }


	}
}