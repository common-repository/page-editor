<?php
/**
 * Class PageEditor_Model_ShortCode_BaseShortCode
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Model_ShortCode_BaseShortCode' ) ) {
  abstract class PageEditor_Model_ShortCode_BaseShortCode
    implements PageEditor_Model_ShortCode_ShortCodeProvider {

    const ELEMENT_CLASS   = 'page-editor_element';
    const CONTAINER_CLASS = 'page-editor_container';


    /**
     * Get the module shortcode signature.
     *
     * @return string
     */
    static function signature() {
      return 'pe_' . static::id();
    }


    /**
     * Is this module a container? Can it container other modules?
     *
     * @return boolean
     */
    static function is_container() {

      // By default, module is not a container since most modules are not.
      // This should be overridden where appropriate.
      return false;
    }


    /**
     * Register this module's shortcode.
     */
    static function register() {
      /** @noinspection PhpUndefinedFunctionInspection */
      add_shortcode(
        static::signature(), array( get_called_class(), 'handler' )
      );
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---



    /**
     * Handle this detected shortcode when the WordPress function 'do_shortcode'
     * is called.
     *
     * @param $attributes
     * @param $content
     *
     * @return string
     */
    static function handler( $attributes, $content ) {

      // Get the mode that the shortcode should be rendered in.
      $edit_mode = PageEditor_Model_ShortCode_Renderer::is_edit_mode();

      // Build the html for the shortcode in the given mode.
      return self::build_html_in_mode( $edit_mode, $attributes, $content );
    }


    /**
     * Build the shortcode attributes using the given attributes. This merges
     * the given attribute values with the module defined defaults and the
     * standard default attribute values.
     *
     * @param $attributes array
     *
     * @return array
     */
    static function build_shortcode_attributes( $attributes ) {

      $default_attributes = array_merge(
        static::default_attribute_values(),
        array(
          'margin-top'          => null,
          'margin-left'         => null,
          'margin-right'        => null,
          'margin-bottom'       => null,

          'border-top-width'    => null,
          'border-left-width'   => null,
          'border-right-width'  => null,
          'border-bottom-width' => null,

          'padding-top'         => null,
          'padding-left'        => null,
          'padding-right'       => null,
          'padding-bottom'      => null,

          'class'               => null,
          'id'                  => null,
        )
      );

      /** @noinspection PhpUndefinedFunctionInspection */
      return shortcode_atts(
        $default_attributes, $attributes, static::signature()
      );
    }


    /**
     * Build the HTML in either 'editor' or 'production' mode.
     *
     * @param $edit_mode    bool
     * @param $attributes   string[]
     * @param $content      string|null
     *
     * @return string
     */
    static function build_html_in_mode(
      $edit_mode, $attributes, $content
    ) {

      // Build the shortcode attributes with the default attribute values.
      $attributes = self::build_shortcode_attributes( $attributes );

      // Build the shortcode html.
      $html = static::build_html( $attributes, $edit_mode, $content );

      // TODO: Makes far more sense for this to go here.
      // TODO: However changes have to be made before this can be done.
      //if ( $edit_mode && $html != null ) {
      //  $html = PageEditor_Model_ShortCode_Util::addWrapper( $html );
      //}

      return $html;
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     *
     *
     * @param $edit_mode
     * @param $shortcode_attributes
     * @param $element_type
     * @param array $classes
     * @param array $styles
     *
     * @return string
     */
    static function build_html_element_line(
      $edit_mode, $shortcode_attributes, $element_type,
      array $classes = array(), array $styles = array()
    ) {

      $styles  = self::parse_styles( $shortcode_attributes, $styles );
      $classes = self::parse_classes( $shortcode_attributes, $classes );
      $id      = self::id_from_attributes( $shortcode_attributes );

      // --- --- --- --- ---

      //
      // Build Styles
      //
      $formatted_styles = [];
      foreach ( $styles as $style_key => $style_value ) {
        $formatted_styles[] = "$style_key:$style_value;";
      }

      // --- --- --- --- ---

      //
      // Build Html
      //
      $html = '';

      // Add styles
      if ( count( $formatted_styles ) > 0 ) {
        $html .= " style='" . implode( ' ', $formatted_styles ) . "'";
      }

      // Add classes
      if ( count( $classes ) > 0 ) {
        $html .= " class='" . implode( ' ', $classes ) . "'";
      }

      // Add id
      if ( $id != null && $id != '' ) {
        $html .= " id='$id'";
      }

      // --- --- ---

      //
      // If we're editing, add the PageEditor meta-data...
      //
      if ( $edit_mode ) {
        $html .= self::build_metadata_string(
          $element_type, $shortcode_attributes
        );
      }

      return $html;
    }


    /**
     * Add the PageEditor wrapper to the given HTML.
     *
     * @param $html
     *
     * @return string
     */
    static function add_wrapper( $html ) {
      return "<div class='page-editor_wrapper'>$html</div>";
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- READ DATA FROM SHORTCODE ATTRIBUTES --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Format the given value as a dimension.
     *
     * @param $value
     *
     * @return string
     */
    public static function format_dimension( $value ) {
      if ( is_numeric( $value ) ) {
        return "{$value}px";
      }
      return $value;
    }


    /**
     * Read an attribute as a string from the given attributes.
     *
     * @param $attributes
     * @param $key
     *
     * @return string
     */
    static function read_attribute_as_string( $attributes, $key ) {
      return PageEditor_Util::strip_all_tags( $attributes[$key] );
    }


    /**
     * Read an attribute as a boolean from the given attributes.
     *
     * @param $attributes
     * @param $key
     *
     * @return bool
     */
    static function read_attribute_as_boolean( $attributes, $key ) {
      $val = strtolower( PageEditor_Util::strip_all_tags( $attributes[$key] ) );
      return ( 'true' == $val || 'on' == $val || 'yes' == $val || 1 == $val );
    }


    /**
     * Read an attribute as an icon from the given attributes.
     *
     * @param $attributes
     * @param $key
     *
     * @return mixed[]
     */
    static function read_attribute_as_icon( $attributes, $key ) {
      $icon = PageEditor_Util::strip_all_tags( $attributes[$key] );
      return is_string( $icon ) ? json_decode( $icon ) : $icon;
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function id_from_attributes( $attributes ) {
      return self::read_attribute_as_string( $attributes, 'id' );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function class_from_attributes( $attributes ) {
      return self::read_attribute_as_string( $attributes, 'class' );
    }


    // --- --- --- --- --- ---


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function margin_top_from_attributes( $attributes ) {
      return self::read_attribute_as_string( $attributes, 'margin-top' );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function margin_right_from_attributes( $attributes ) {
      return self::read_attribute_as_string( $attributes, 'margin-right' );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function margin_bottom_from_attributes( $attributes ) {
      return self::read_attribute_as_string( $attributes, 'margin-bottom' );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function margin_left_from_attributes( $attributes ) {
      return self::read_attribute_as_string( $attributes, 'margin-left' );
    }


    // --- --- --- --- --- ---


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function border_top_width_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, 'border-top-width'
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function border_right_width_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, 'border-right-width'
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function border_bottom_width_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, 'border-bottom-width'
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function border_left_width_from_attributes( $attributes ) {
      return self::read_attribute_as_string( $attributes, 'border-left-width' );
    }


    // --- --- --- --- --- ---


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function padding_top_from_attributes( $attributes ) {
      return self::read_attribute_as_string( $attributes, 'padding-top' );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function padding_right_from_attributes( $attributes ) {
      return self::read_attribute_as_string( $attributes, 'padding-right' );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function padding_bottom_from_attributes( $attributes ) {
      return self::read_attribute_as_string( $attributes, 'padding-bottom' );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    static function padding_left_from_attributes( $attributes ) {
      return self::read_attribute_as_string( $attributes, 'padding-left' );
    }



    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- BUILD ELEMENT METADATA  --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     *
     *
     * @param $element_type
     * @param $shortcode_attributes
     *
     * @return string
     */
    private static function build_metadata_string(
      $element_type, $shortcode_attributes
    ) {
      $html = '';

      // Element type
      $html .= " data-page-editor-element-type='$element_type'";

      // Settings meta-data
      $html .= ' ';
      $html .= self::build_settings_metadata_string( $shortcode_attributes );

      // Events meta-data
      $html .= ' ';
      $html .= self::build_events_metadata_string( $shortcode_attributes );

      // Styles meta-data
      $html .= ' ';
      $html .= self::build_styles_metadata_string( $shortcode_attributes );

      return $html;
    }


    // --- --- --- --- --- ---


    /**
     * Build the settings meta-data string.
     *
     * @param $shortcode_attributes
     *
     * @return string
     */
    static function build_settings_metadata_string(
      $shortcode_attributes
    ) {
      // Build the settings meta-data
      $settings_metadata = self::build_settings_metadata(
        $shortcode_attributes
      );

      // Encode the metadata as a string
      $json_string = base64_encode( json_encode( $settings_metadata ) );

      // Return meta-data string with tag
      return "data-page-editor-settings='$json_string'";
    }


    /**
     * Build the setting meta data.
     *
     * @param $shortcode_attributes
     *
     * @return array
     */
    private static function build_settings_metadata( $shortcode_attributes ) {

      $filtered_shortcode_attributes = array();

      $style_keys = [
        'margin-top', 'margin-left', 'margin-right', 'margin-bottom',
        'border-top-width', 'border-left-width', 'border-right-width',
        'border-bottom-width',
        'padding-top', 'padding-left', 'padding-right', 'padding-bottom',
      ];

      $shortscode_attribute_keys = array_keys( $shortcode_attributes );
      foreach ( $shortscode_attribute_keys as $key ) {

        $is_style_key = array_key_exists( $key, $style_keys );
        $is_event_key = substr( $key, 0, 2 ) == 'on-';

        if ( ! $is_style_key && ! $is_event_key ) {
          $filtered_shortcode_attributes[$key] = $shortcode_attributes[$key];
        }

      }

      return $filtered_shortcode_attributes;
    }


    // --- --- --- --- --- ---


    /**
     * @param $short_code_attributes
     *
     * @return string
     */
    private static function build_events_metadata_string(
      $short_code_attributes
    ) {
      $settings_meta_data = self::build_events_metadata(
        $short_code_attributes
      );
      $json_string = base64_encode( json_encode( $settings_meta_data ) );
      return "data-page-editor-events='$json_string'";
    }


    /**
     * @param $shortcode_attributes
     *
     * @return array
     */
    private static function build_events_metadata( $shortcode_attributes ) {

      $filtered_shortcode_attributes = array();

      $shortscode_attribute_keys = array_keys( $shortcode_attributes );
      foreach ( $shortscode_attribute_keys as $key ) {

        // Any attribute beginning with 'on-' is an event
        $is_event_key = substr( $key, 0, 3 ) == 'on-';

        // If we're dealing with an event...
        if ( $is_event_key ) {
          $filtered_shortcode_attributes[$key] = base64_decode(
            $shortcode_attributes[$key]
          );
        }
      }

      return $filtered_shortcode_attributes;
    }


    // --- --- --- --- --- ---


    /**
     * Build the element styles meta-data string.
     *
     * @param $short_code_attributes
     *
     * @return string
     */
    private static function build_styles_metadata_string(
      $short_code_attributes
    ) {
      $styles_meta_data = self::build_styles_metadata( $short_code_attributes );
      $json_string = json_encode( $styles_meta_data );
      return "data-page-editor-styles='$json_string'";
    }


    /**
     * Build the element styles meta-data.
     *
     * @param $shortcode_attributes
     *
     * @return array
     */
    private static function build_styles_metadata( $shortcode_attributes ) {

      $style_metadata = array();

      // Margin
      $margin = self::build_margin_styles_metadata( $shortcode_attributes );
      if ( count( $margin ) > 0 ) { $style_metadata['margin'] = $margin; }

      // Border
      $border = self::build_border_styles_metadata( $shortcode_attributes );
      if ( count( $border ) > 0 ) { $style_metadata['border'] = $border; }

      // Padding
      $padding = self::build_padding_styles_metadata( $shortcode_attributes );
      if ( count( $padding ) > 0 ) { $style_metadata['padding'] = $padding; }

      return $style_metadata;
    }


    /**
     * Build the element margin styles meta-data.
     *
     * @param $shortcode_attributes
     *
     * @return array
     */
    private static function build_margin_styles_metadata(
      $shortcode_attributes
    ) {
      $margin = array();

      $margin_top = self::margin_top_from_attributes(
        $shortcode_attributes
      );
      $margin_left = self::margin_left_from_attributes(
        $shortcode_attributes
      );
      $margin_right = self::margin_right_from_attributes(
        $shortcode_attributes
      );
      $margin_bottom = self::margin_bottom_from_attributes(
        $shortcode_attributes
      );

      // ---

      if ( $margin_top != null ) { $margin['top'] = $margin_top; }
      if ( $margin_left != null ) { $margin['left'] = $margin_left; }
      if ( $margin_right != null ) { $margin['right'] = $margin_right; }
      if ( $margin_bottom != null ) { $margin['bottom'] = $margin_bottom; }

      return $margin;
    }


    /**
     * Build the element border styles meta-data.
     *
     * @param $shortcode_attributes
     *
     * @return array
     */
    private static function build_border_styles_metadata(
      $shortcode_attributes
    ) {
      $border = array();

      $border_top_width = self::border_top_width_from_attributes(
        $shortcode_attributes
      );
      $border_left_width = self::border_left_width_from_attributes(
        $shortcode_attributes
      );
      $border_right_width = self::border_right_width_from_attributes(
        $shortcode_attributes
      );
      $border_bottom_width = self::border_bottom_width_from_attributes(
        $shortcode_attributes
      );

      // ---

      if ( $border_top_width != null ) {
        $border['top'] = $border_top_width;
      }
      if ( $border_left_width != null ) {
        $border['left'] = $border_left_width;
      }
      if ( $border_right_width != null ) {
        $border['right'] = $border_right_width;
      }
      if ( $border_bottom_width != null ) {
        $border['bottom'] = $border_bottom_width;
      }

      return $border;
    }


    /**
     * Build the element padding styles meta-data.
     *
     * @param $shortcode_attributes
     *
     * @return array
     */
    private static function build_padding_styles_metadata(
      $shortcode_attributes
    ) {
      $padding = array();

      $padding_top = self::padding_top_from_attributes(
        $shortcode_attributes
      );
      $padding_left = self::padding_left_from_attributes(
        $shortcode_attributes
      );
      $padding_right = self::padding_right_from_attributes(
        $shortcode_attributes
     );
      $padding_bottom = self::padding_bottom_from_attributes(
        $shortcode_attributes
      );

      // ---

      if ( $padding_top != null ) { $padding['top'] = $padding_top; }
      if ( $padding_left != null ) { $padding['left'] = $padding_left; }
      if ( $padding_right != null ) { $padding['right'] = $padding_right; }
      if ( $padding_bottom != null ) { $padding['bottom'] = $padding_bottom; }

      return $padding;
    }



    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- PARSE VALUES FROM SHORTCODE ATTRIBUTES  --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Parse the element classes from the given shortcode attributes.
     *
     * @param $shortcode_attributes
     * @param array $classes
     *
     * @return array
     */
    private static function parse_classes(
      $shortcode_attributes, array $classes = array()
    ) {

      // All PageEditor elements have the class 'page-editor_element'
      $classes[] = 'page-editor_element';

      // Read the 'class' attribute and add it if a value is specified
      $class = self::class_from_attributes( $shortcode_attributes );
      if ( $class != null ) { $classes[] = $class; }

      return $classes;
    }


    /**
     * Parse the element styles from the given shortcode attributes
     *
     * @param $shortcode_attributes string[]
     * @param $styles string[]
     *
     * @return array
     */
    private static function parse_styles(
      $shortcode_attributes, array $styles = array()
    ) {

      $styles = self::parse_margin_styles( $shortcode_attributes, $styles );
      $styles = self::parse_border_styles( $shortcode_attributes, $styles );
      $styles = self::parse_padding_styles( $shortcode_attributes, $styles );

      return $styles;
    }



    /**
     * Parse the element margin styles from the given shortcode attributes
     *
     * @param $shortcode_attributes string[]
     * @param $styles string[]
     *
     * @return array
     */
    private static function parse_margin_styles(
      $shortcode_attributes, array $styles = array()
    ) {

      // Read margin values from attributes
      $margin_top = self::margin_top_from_attributes(
        $shortcode_attributes
      );
      $margin_left = self::margin_left_from_attributes(
        $shortcode_attributes
      );
      $margin_right = self::margin_right_from_attributes(
        $shortcode_attributes
      );
      $margin_bottom = self::margin_bottom_from_attributes(
        $shortcode_attributes
      );

      // ---

      // Build margin styles
      if ( $margin_top !== null && $margin_top !== '' ) {
        $styles['margin-top'] = self::format_dimension( $margin_top );
      }
      if ( $margin_left !== null && $margin_left !== '' ) {
        $styles['margin-left'] = self::format_dimension( $margin_left );
      }
      if ( $margin_right !== null && $margin_right !== '' ) {
        $styles['margin-right'] = self::format_dimension( $margin_right );
      }
      if ( $margin_bottom !== null && $margin_bottom !== '' ) {
        $styles['margin-bottom'] = self::format_dimension( $margin_bottom );
      }

      return $styles;
    }


    /**
     * Parse the element border styles from the given shortcode attributes
     *
     * @param $shortcode_attributes string[]
     * @param $styles string[]
     *
     * @return array
     */
    private static function parse_border_styles(
      $shortcode_attributes, array $styles = array()
    ) {

      // Read border width values from attributes
      $border_top_width = self::border_top_width_from_attributes(
        $shortcode_attributes
      );
      $border_left_width = self::border_left_width_from_attributes(
        $shortcode_attributes
      );
      $border_right_width = self::border_right_width_from_attributes(
        $shortcode_attributes
      );
      $border_bottom_width = self::border_bottom_width_from_attributes(
        $shortcode_attributes
      );

      // ---

      // Build border styles
      if ( $border_top_width != null ) {
        $styles['border-top-width'] = self::format_dimension(
          $border_top_width
        );
      }
      if ( $border_left_width != null ) {
        $styles['border-left-width'] = self::format_dimension(
          $border_left_width
        );
      }
      if ( $border_right_width != null ) {
        $styles['border-right-width'] = self::format_dimension(
          $border_right_width
        );
      }
      if ( $border_bottom_width != null ) {
        $styles['border-bottom-width'] = self::format_dimension(
          $border_bottom_width
        );
      }

      return $styles;
    }


    /**
     * Parse the element padding styles from the given shortcode attributes
     *
     * @param $shortcode_attributes string[]
     * @param $styles string[]
     *
     * @return array
     */
    private static function parse_padding_styles(
      $shortcode_attributes, array $styles = array()
    ) {

      // Read padding values from attributes
      $padding_top = self::padding_top_from_attributes(
        $shortcode_attributes
      );
      $padding_left = self::padding_left_from_attributes(
        $shortcode_attributes
      );
      $padding_right = self::padding_right_from_attributes(
        $shortcode_attributes
      );
      $padding_bottom = self::padding_bottom_from_attributes(
        $shortcode_attributes
      );

      // ---

      // Build padding styles
      if ( $padding_top != null ) {
        $styles['padding-top'] = self::format_dimension( $padding_top );
      }
      if ( $padding_left != null ) {
        $styles['padding-left'] = self::format_dimension( $padding_left );
      }
      if ( $padding_right != null ) {
        $styles['padding-right'] = self::format_dimension( $padding_right );
      }
      if ( $padding_bottom != null ) {
        $styles['padding-bottom'] = self::format_dimension( $padding_bottom );
      }

      return $styles;
    }


  }
}