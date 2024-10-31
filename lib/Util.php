<?php
/**
 * Class PageEditor_Util
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Util' ) ) {
  class PageEditor_Util {


    /**
     * @return bool
     */
    public static function is_editor_page() {

      $protocol = 'http' . ( ( 443 == $_SERVER['SERVER_PORT'] ) ? 's://' : '://' );

      $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

      $url_components = parse_url( $url );

      return '/wp-admin/post.php' == $url_components['path'];
    }


    /**
     * Work out the version parameter for loading an asset.
     *
     * @param $version
     *
     * @return string
     */
    public static function generate_enqueue_version_value( $version ) {
      if ( PAGEEDITOR_PLUGIN_DEVELOPMENT_MODE ) {
        $version .= '_DEV' . uniqid();
      }
      return $version;
    }


    /**
     * Get the key value for the given array, or return the default.
     *
     * @param array $array
     * @param string $key
     * @param null $default
     *
     * @return mixed|null
     */
    public static function get_key_value(
      array $array, $key, $default = null
    ) {
      return isset( $array[$key] ) ? $array[$key] : $default;
    }


    /**
     * Parse the given url and return the correctly formatted url.
     *
     * @param $url
     *
     * @return string
     */
    public static function parse_asset_url( $url ) {
      if ( substr( $url, 0, 4 ) == '@PE/' ) {
        return PAGEEDITOR_PLUGIN_BASE_URL . substr( $url, 3 );
      }
      return $url;
    }


    /**
     * Parse the given array of urls and return an array containing correctly
     * formatted urls.
     *
     * @param array $urls
     *
     * @return array
     */
    public static function parse_asset_urls( array $urls ) {
      $parsed_urls = array();
      foreach ( $urls as $url ) {
        $parsed_urls[] = PageEditor_util::parse_asset_url( $url );
      }
      return $parsed_urls;
    }


    /**
     * Parse the given path and return the correctly formatted path.
     *
     * @param $path
     *
     * @return string
     */
    public static function parse_asset_path( $path ) {
      if ( substr( $path, 0, 4 ) == '@PE/' ) {
        return PAGEEDITOR_PLUGIN_BASE_PATH . substr( $path, 3 );
      }
      return $path;
    }


    /**
     * Ensure that the given directory exists.
     *
     * @param $path
     */
    public static function ensure_directory_exists( $path ) {

      // Ensure that the path has been parsed
      $path = PageEditor_Util::parse_asset_path( $path );

      // Ensure the directory exists
      if ( ! is_dir( $path ) ) {
        mkdir( $path );
      }
    }


    /**
     * Ensure that the given directory has been deleted.
     *
     * @param $path
     */
    public static function ensure_directory_deleted( $path ) {

      // Ensure that the path has been parsed
      $path = PageEditor_Util::parse_asset_path( $path );

      // Ensure the directory is deleted
      if ( is_dir( $path ) ) {
        unlink( $path );
      }
    }



    /**
     * Ensure that the given file has been deleted.
     *
     * @param $path
     */
    public static function ensure_file_deleted( $path ) {

      // Ensure that the path has been parsed
      $path = PageEditor_Util::parse_asset_path( $path );

      // Ensure the file is deleted
      if ( file_exists( $path ) ) {
        unlink( $path );
      }
    }




    /**
     * @param $destination_path string
     * @param $files string[]
     */
    public static function build_concatenated_file(
      $destination_path, array $files
    ) {

      // Open the destination file
      $destination_path = PageEditor_Util::parse_asset_path( $destination_path );
      $concatenated_file = fopen( $destination_path, 'w' );

      // Write the content of each file to the destination concatenated file
      foreach ( $files as $file ) {
        $file_path = PageEditor_Util::parse_asset_path( $file );
        fwrite( $concatenated_file, file_get_contents( $file_path ) );
      }

      // Close the file
      fclose( $concatenated_file );
    }


    /**
     * @param $string string
     *
     * @return string
     */
    public static function strip_all_tags( $string ) {
      /** @noinspection PhpUndefinedFunctionInspection */
      return wp_strip_all_tags( $string );
    }


    /**
     * @param $styles string[]
     *
     * @return string
     */
    public static function build_styles_string( array $styles ) {
      $formatted_styles = [];
      foreach ( $styles as $style_key => $style_value ) {
        $formatted_styles[] = "$style_key:$style_value;";
      }
      return implode( ' ', $formatted_styles );
    }


  }
}