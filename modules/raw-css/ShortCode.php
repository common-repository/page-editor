<?php
/**
 * Class PageEditor_Module_RawCss_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_RawCss_ShortCode' ) ) {
  class PageEditor_Module_RawCss_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


		private static $icon = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAEdUExURUxpce7u7u7u7u7u7u7u7u7u7u7u7u7u7u7u7u7u7pnMM////4KsK4q3LpfJMpjKM5zCT5LCMKnUU+/34MTblqDQQfz++Yq4LpnLM8zmmefzzou5LrLYZYy6L/j88ZDAMM/hqI65NLvddqbIYZXHMu7238PhiPf68JK8PJTFMePq197oy57OPq7UYaPQStPjs7nZedztubrVhZbIMo+0Q6rFdIayLfv9+J7FT9riyZ28W5PEMeDm1oWwLIiwNom2LszZsY++MO3035PDMfj78bDOcu7136jTU/v9+ZzOOcrimdnqt9Hkqvj78MLfh467NJC9Ndbmt8Xcl5S/Pe/24JvJQJ7MQcnhmI66NJ3DTqnTU+TvzbnbdrLRc7bXdNhB+WUAAAAKdFJOUwBwUP9AIJDAoPC1334yAAADVklEQVR42u2baVfaQBSGkSiQIUMgAiKKKLiyK0sF2bRaa1u779v//xmdmQQTCZakZ4Zrz5n3S5I3nHsfmLmTOJ4bCDgUDIVVRbDUcCgYmKnliLIwRZZd6VfCykIVXrmff0lVFix1yZk/ogAoApzfQbCkAMkahRUVCkA1Z2JYAVOY1b8CqGW4GWjPQwVUZP2HBQgGQrAAIcgaMOtAhQVQgecgmYUSQAJIAAkgASSABJAAEkACSAAJ8IgByo0a4qNao+wfoFRFPFUt+QSoVxBfVeq+AOqIv+o+AEoVAQCVkneAKhKhqmeAMhKjsleAhiCAhleAmiCAmlcAJEoS4H8HMLLpaDSdLdwZ+3MNrgCrUUvpFLvejM4z+AJsRW3d3EtHlJpl8AU4ZnE/PmOHPWKYifb+YnAFuGFhP2CMD+jJV92gh0tyfcjurLkNvgD7NOh7Eh4X6dkJ/k4PSWps07M4vp42dK4AbAQOaficmeiUHg6o8fY0Ho9jt5HjCsBKgEbXkWF8i+9gbA759htyU6c33IYQgAS92KXhf1vzfWsfoTw1fk4bMREA5sDS8Am77NYzMSLkMkQAmFc0fAah5JPJl7Y+5TJEAVg6wsV3ZsLjBwwhAKtEBZQyDCNFJ0OSJUy4Db4A6zRokQKk2CAzojRCiTWr7DdcBl+ATavKLZQCyk5W/N1X5rrzY9o45/ssSDOCosHyR3O5X+z4+toydvDVtMF3HUCG81m3TYb61mlcEONy2ojxfRwX7Oi3dB345Hg+PyffF3+eNjgDoNSFFf2LtdC+mFT9S2Zk3AbnV7LYTjGZPImz4DhPjI3DK9vIzTI4v5Qe4TuxItM3bGMtM8vg/Vas56zok2WGVL2p84eMfwJoPvxindlNJJ46Z5d+NM+w1fQKkBf0Z0HeK0BHEEDHK0DrTEj+s5ZXgPZAF5BfH7S9AnS1kQCAkdb1vEfU00a8fwN9pPW8b1L1h9qA7zw4G2jDvo99wrGmaZ18k1P2Zr5D4o197ZSOhxpfDcc+94r7Pa75e33/u+XddotT9la7K/9hIQEkgASQABJAAkgACSABJMAjBgBvcABv8QBvcgFv8wFvdIJv9QJvdgNv94NveARv+YRveoVv+4VvfIZv/YZvfgdr//8D8blgj2yuUWUAAAAASUVORK5CYII=';


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'raw-css';
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

      $attributes['raw-css'] = $content;

      // --- --- --- --- ---

      $classes = [
        'page-editor_element_raw-css'
      ];

      // --- --- --- --- ---

      $styleElementHtml = "<style>{$content}</style>";


      //
      // Build edit mode HTML
      //
      if ( $add_wrapper ) {

        $html = "<div";
        $html .= self::build_html_element_line(
          $add_wrapper, $attributes, self::id(), $classes
        );
        $html .= ">";
        $html .=   "<div style='text-align: center'><img style='height: 60px' src='" . self::$icon . "'></div>";
        $html .= "</div>";
        $html .= $styleElementHtml;

        // Add wrapper
        $html = self::add_wrapper( $html );
      }


      //
      // Production mode HTML
      //
      else {
        $html = $styleElementHtml;
      }


      return $html;
    }


  }
}