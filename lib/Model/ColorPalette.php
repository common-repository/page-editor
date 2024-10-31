<?php
/**
 * Class PageEditor_Model_ColorPalette
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Model_ColorPalette' ) ) {
  class PageEditor_Model_ColorPalette {


    /**
     * @var array
     */
    private static $colors = [];


    /**
     * @param $id
     * @param $displayName
     * @param $color
     */
    public static function defineColor( $id, $displayName, $color ) {
      self::$colors[$id] = [
        'name'  => $displayName,
        'color' => $color
      ];
    }


    /**
     * @return array
     */
    public static function colors() {
      return self::$colors;
    }


  }


  PageEditor_Model_ColorPalette::defineColor( 'blue', 'Blue', '#007bff' );
  PageEditor_Model_ColorPalette::defineColor( 'cyan', 'Cyan', '#2ecedb' );
  PageEditor_Model_ColorPalette::defineColor( 'turquoise', 'Turquoise', '#18BC9C' );
  PageEditor_Model_ColorPalette::defineColor( 'green', 'Green', '#7EB62E' );
  PageEditor_Model_ColorPalette::defineColor( 'yellow', 'Yellow', '#F6CA2F' );
  PageEditor_Model_ColorPalette::defineColor( 'orange', 'Orange', '#FF851B' );
  PageEditor_Model_ColorPalette::defineColor( 'red', 'Red', '#F64B2F' );
  PageEditor_Model_ColorPalette::defineColor( 'purple', 'Purple', '#A555CA' );

  //
  // Pastel Colours
  //
  PageEditor_Model_ColorPalette::defineColor( 'pastel-blue', 'Pastel Blue', '#007bff');
  PageEditor_Model_ColorPalette::defineColor( 'pastel-cyan', 'Pastel Cyan', '#2ecedb');
  PageEditor_Model_ColorPalette::defineColor( 'pastel-turquoise', 'Pastel Turquoise', '#18BC9C');
  PageEditor_Model_ColorPalette::defineColor( 'pastel-green', 'Pastel Green', '#7EB62E');
  PageEditor_Model_ColorPalette::defineColor( 'pastel-yellow', 'Pastel Yellow', '#F6CA2F');
  PageEditor_Model_ColorPalette::defineColor( 'pastel-orange', 'Pastel Orange', '#FF851B');
  PageEditor_Model_ColorPalette::defineColor( 'pastel-red', 'Pastel Red', '#F64B2F');
  PageEditor_Model_ColorPalette::defineColor( 'pastel-purple', 'Pastel Purple', '#A555CA');

}