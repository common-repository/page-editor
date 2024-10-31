<?php
/**
 * Class PageEditor_Model_FontAwesome
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Model_FontAwesome' ) ) {
  class PageEditor_Model_FontAwesome {


    /**
     * Get the icon id class from the given icon id.
     *
     * @param $id
     * @return string
     */
    private static function id_class( $id ) {
      return "fa-$id";
    }


    /**
     * Get the icon style class from the given icon style.
     *
     * @param $style
		 *
     * @return string
     */
    private static function style_class( $style ) {
      switch ( $style ) {
        case 'solid': return 'fas';
        case 'brands': return 'fab';
        case 'regular': return 'far';
        default: return 'fa';
      }
    }


    /**
     * @param $id
     * @param $style
		 *
     * @return string
     */
    public static function generate_classes( $id, $style ) {
      return self::id_class( $id ) . ' ' . self::style_class( $style );
    }


    /**
     * @param $icon_object
		 *
     * @return string
     */
    public static function generate_classes_from_object( $icon_object ) {
      $icon_object = (array) $icon_object;
      $id = $icon_object['id'];
      $style = $icon_object['style'];
      return self::generate_classes( $id, $style );
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * @var array
     */
    private static $background_shapes = [
      'circle'            => ['id' => 'circle', 'style' => 'solid'],
      'circle-outline'    => ['id' => 'circle', 'style' => 'regular'],
      'square'            => ['id' => 'square', 'style' => 'solid'],
      'square-outline'    => ['id' => 'square', 'style' => 'regular'],
      'star'              => ['id' => 'star', 'style' => 'solid'],
      'star-outline'      => ['id' => 'star', 'style' => 'regular'],
      'bookmark'          => ['id' => 'bookmark', 'style' => 'solid'],
      'bookmark-outline'  => ['id' => 'bookmark', 'style' => 'regular'],
      'calendar'          => ['id' => 'calendar', 'style' => 'solid'],
      'calendar-outline'  => ['id' => 'calendar', 'style' => 'regular'],
      'heart'             => ['id' => 'heart', 'style' => 'solid'],
      'heart-outline'     => ['id' => 'heart', 'style' => 'regular'],
      'comment'           => ['id' => 'comment', 'style' => 'solid'],
      'comment-outline'   => ['id' => 'comment', 'style' => 'regular'],
      'certificate'       => ['id' => 'certificate', 'style' => 'solid'],
      'map-marker'        => ['id' => 'map-marker', 'style' => 'solid'],
      'cloud'             => ['id' => 'cloud', 'style' => 'solid'],
      'trophy'            => ['id' => 'trophy', 'style' => 'solid'],
      'lock'              => ['id' => 'lock', 'style' => 'solid'],
      'unlock'            => ['id' => 'unlock', 'style' => 'solid'],
    ];


    /**
     * @param $background_shape
		 *
     * @return string
     */
    public static function generate_background_shape_classes( $background_shape ) {
      return self::generate_classes_from_object(self::$background_shapes[$background_shape]);
    }


  }
}