<?php
/**
 * Class PageEditor_Module_RawJs_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_RawJs_ShortCode' ) ) {
  class PageEditor_Module_RawJs_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


    private static $icon = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAD8UExURUxpce7u7u7u7v/MAO7u7u7u7u7u7u7u7u7u7u7u7u7u7ui5AP////DAAP/32PLBAP321/7LAP/UKPjGAPbFAP3KAPjff//dVP/qlv/QEvrIAPnHAPLJKPnZWf7ODvHowfvUO/3QHfDq0PPjo+m/HfzKAPXUU+rNWf/87uy9AO3kwenGO+3n0O+/AOzdo+u7AOi8DvvJAP/OCP/++PXEAPDBCP/zwvTDAP/mgPTPPv/hav/99/rpp//YPvHAAPHEEvvwwv/tp/TLKP777fLFEvfXVPTQPv/77frllfHCCP732P312P322PPGEvnllvPKJ/rQKPbaav7ywv3XPiq0vRUAAAAKdFJOUwBwUP9AIJDAoPC1334yAAAC3klEQVR42u2baW/aQBCGIQaMj7VjbMx9X+U+AiFp0qRJ7/v6//+lXi8EolbVWvLuRNW8X7yaCN5H65lZsdEkEkc6yaiaLliamjlJ/FWprC5N2dQf9mlVlyo1/dg/qemSpSWP/bM6gLLA/kcESR1Iu7eQ1qAANJaJqg4mNax/HVApuAw85KEOqqD/wwKcJDKwABnIGmB1oMECaMA5GGQhAiAAAiAAAiAAAiAAAiAAAiDAEwZo1FpKPGrVGtEB2k0lTjXbEQE6dSVe1TuRADpK/OpEAGjXBQDU2/wATUWEmtwADUWMGrwANUEANV6AliCAFi+AIkoI8H8BFC3LKrJlrmiZpmkVV1IBQs9wdW7uVQQBeGYedCcZ4JNte89D56vPV+EzJxfglBCbPs03hJBruvjqwQAQKjOMrEEA+hTg/lu1ektIXjIAy4HTfjmIrSmHJxngoQruggSkALZsgEMfsEr5QI50AOX7yz1CQZFfhnR9s/nxihGs5APkAilbQqohwntHNEAhOIOsUrA4YwD3bOfz230fKAsGuNi96hWzI1/o85z+pbKLCAbIsWR7ERafH7wCuhPmz185FrkW3wfOjg6/TQBQMI9VFd8HSge3fth2Lo78fRmNqGQxs4+vad9zg8C+Dbx7SyNr8WX44dL3+7fhCRimXJlUfd+/3LCIhMPIIQ9iReceAnRLxDcix2Zm9r7tONud/c0yjkbU42iES9ctP+p6edd1l//+TI8XwBP0s8DjBRgKAhjyAnQrQvwrXV6AwdwR4O/MB7wAI2MqAGBqjLjviMbGNO49cKbGmP+SarIw5vHmQWVuLCYR7glnhmEMvV5M7j1vGHzfLNJN6WxhxKvFLOJd8WQcq/94Ev22fDToxuTeHYzwHxYIgAAIgAAIgAAIgAAIgABPGAB8wAF8xAN8yAV8zAd80Al+1At82A183A9+4BF85BN+6BV+7Bd+8Bl+9Bt++B1s/P837PY8IlZLsfIAAAAASUVORK5CYII=';


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'raw-js';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array();
    }


    /**
     * Build the html for this module.
     *
     * @param $attributes
     * @param $add_wrapper bool
     * @param $content string|null
     *
     * @return string
     */
    static function build_html(
      $attributes, $add_wrapper = false, $content = null
    ) {

      $attributes['raw-js'] = $content;

      // --- --- --- --- ---

      $classes = [
        'page-editor_element_raw-js'
      ];

      // --- --- --- --- ---

      // Script must go in a <div> otherwise WordPress will put it in a <p>
      $scriptHtml = "<div><script>jQuery(document).ready(function($) {{$content}});</script></div>";


      //
      // Build edit mode HTML
      //
      if ( $add_wrapper ) {

        $html = "<div";

        $html .= self::build_html_element_line(
          $add_wrapper, $attributes, self::id(), $classes
        );

        $html .= ">";
        $html .= "<div style='text-align: center'><img style='height: 60px' src='" . self::$icon . "'></div>";
        $html .= "</div>";
        $html .= $scriptHtml;

        // Add wrapper
        $html = self::add_wrapper( $html );
      }


      //
      // Production mode HTML
      //
      else {
        $html = "{$scriptHtml}";
      }


      return $html;
    }


  }
}