<?php
/**
 * Class PageEditor_Model_InputDataArray
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Model_InputDataArray' ) ) {
  class PageEditor_Model_InputDataArray {

    /**
     * The array of input data.
     *
     * @var array
     */
    private $data;


    /**
     * Construct a new input data array from the given array of values.
     *
     * @param array $data
     */
    public function __construct( array $data ) {
      $this->data = $data;
    }


    /**
     * Does this input data array have a value for the given key?
     *
     * @param $key
     *
     * @return bool
     */
    public function has( $key ) {
      return isset( $this->data[ $key ] );
    }


    /**
     * Read value from the data array (Raw uncleaned data).
     * If no value exists, return the given default value.
     *
     * PRIVATE since values that have not been sanitized / validated should
     * not be accessible from outside of this class.
     *
     * @param $key
     * @param $default_value
     *
     * @return mixed
     */
    private function read( $key, $default_value = null ) {
      return $this->has( $key ) ? $this->data[ $key ] : $default_value;
    }


    /**
     * Read the value for the given key as a string. Also ensures the string is
     * sanitized.
     *
     * @param $key
     * @param $default_value
     *
     * @return string
     */
    public function read_as_string( $key, $default_value = null ) {
      /** @noinspection PhpUndefinedFunctionInspection */
      return ( string ) sanitize_text_field(
        $this->read( $key, $default_value )
      );
    }


    /**
     * Read the value for the given key as a sanitized string. Also ensures that
     * the string is in the given selection of valid values.
     *
     * If no value is set, or the value is not in the array of valid values...
     * return the given default value.
     *
     * @param $key
     * @param $valid_values
     * @param $default_value
     *
     * @return string
     */
    public function read_as_string_from_selection(
      $key, array $valid_values, $default_value
    ) {
      // Read the key value as a string.
      $value = $this->read_as_string( $key, $default_value );

      // The string is valid if it is in the array of valid values.
      $valid = in_array( $value, $valid_values );

      // Return the read value if it is valid, otherwise return the default.
      return $valid ? $value : $default_value;
    }


    /**
     * Read the value for the given key as a boolean, or use the given default
     * value if no value is set.
     *
     * Based on code from http://php.net/manual/en/function.is-bool.php
     *
     * @param $key
     * @param $default_value
     *
     * @return bool
     */
    public function read_as_boolean( $key, $default_value = false ) {

      // Sanitize the read value
      /** @noinspection PhpUndefinedFunctionInspection */
      $value = sanitize_text_field( $this->read( $key, $default_value ) );

      // If we have a non string value, cast it as a boolean so only the
      // boolean values TRUE or FALSE can be returned.
      if ( ! is_string( $value ) ) {
        return ( bool ) $value;
      }

      // If we have a string, check against acceptable TRUE string values,
      // otherwise return FALSE
      switch ( strtolower( $value ) ) {
        case '1':
        case 'true':
        case 'on':
        case 'yes':
        case 'y':
          return true;
        default:
          return false;
      }
    }


  }
}