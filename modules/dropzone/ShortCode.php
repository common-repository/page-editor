<?php
/**
 * Class PageEditor_Module_DropZone_ShortCode
 *
 * @author	support@page-editor.com
 * @license PageEditor 1.0.0 (Modified MIT)
 *          https://page-editor.com/licensing/page-editor-license-1-0-0
 */
if ( ! class_exists( 'PageEditor_Module_DropZone_ShortCode' ) ) {
  class PageEditor_Module_DropZone_ShortCode
    extends PageEditor_Model_ShortCode_BaseShortCode {


    //
    // Setting keys
    //
    private static $setting_key__text                 = 'text';
    private static $setting_key__accepted_file_types  = 'accepted-file-types';
    private static $setting_key__on_added             = 'on-added';
    private static $setting_key__on_queue_complete    = 'on-queue-complete';


    //
    // Default values
    //
    private static $default__text                     = 'Drop your files here';
    private static $default__accepted_file_types      = 'all';
    private static $default__on_added                 = '';
    private static $default__on_queue_complete        = '';


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * Get the shortcode id.
     *
     * @return string
     */
    static function id() {
      return 'dropzone';
    }


    /**
     * Get the default module attribute values.
     *
     * @return array
     */
    static function default_attribute_values() {
      return array(

        self::$setting_key__text                => self::$default__text,
        self::$setting_key__accepted_file_types => self::$default__accepted_file_types,
        self::$setting_key__on_added            => self::$default__on_added,
        self::$setting_key__on_queue_complete   => self::$default__on_queue_complete,

      );
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---
    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function text_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__text
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function accepted_file_types_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
				$attributes, self::$setting_key__accepted_file_types
			);
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function on_added_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__on_added
      );
    }


    /**
     * @param $attributes
     *
     * @return string|null
     */
    private static function on_queue_complete_from_attributes( $attributes ) {
      return self::read_attribute_as_string(
        $attributes, self::$setting_key__on_queue_complete
      );
    }


    // --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


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

      $text = self::text_from_attributes( $attributes );
      $accepted_file_types = self::accepted_file_types_from_attributes( $attributes );
      $on_added = self::on_added_from_attributes( $attributes );
      $on_queue_complete = self::on_queue_complete_from_attributes( $attributes );

      // --- --- --- ---

      //
      // Build Classes
      //
      $classes = array(
        'page-editor_element_dropzone',
      );

      // --- --- --- ---

      //
      // Build Html
      //
			$html = "<div";
			$html .= self::build_html_element_line(
        $add_wrapper, $attributes, self::id(), $classes
			);
			$html .= ">";

      if ( $add_wrapper ) {
        $html .= "<div class='form'>";
        $html .=   self::dropzone_inner_html( $text );
        $html .= "</div>";
      } else {
        $html .= "<form action='test.php' id='dropzone'>";
        $html .=   self::dropzone_inner_html( $text );
        $html .= "</form>";

        $html .= self::build_script(
          $accepted_file_types, $on_added, $on_queue_complete
        );
      }

      $html .= "</div>";

      // --- --- --- ---

      //
      // Add wrapper if in edit mode
      //
      if ( $add_wrapper ) {
        $html = self::add_wrapper( $html );
      }

      return $html;
    }


    /**
     * @param $text
     *
     * @return string
     */
    private static function dropzone_inner_html( $text ) {
      $html  = "<div class='dz-default dz-message'>";
      $html .=   "<div><i class='fa fa-download'></i></div>";
      $html .=   "<div class='text'>{$text}</div>";
      $html .=   "<div class='sub-text'>(Or click to browse)</div>";
      $html .= "</div>";
      return $html;
    }


    /**
     * @param $accepted_file_types
     * @param $on_added
     * @param $on_queue_complete
     *
     * @return string
     */
    private static function build_script(
      $accepted_file_types, $on_added, $on_queue_complete
    ) {

      $html = '';
      $html .= "<div>";
      $html .= "<script>";
      //$html .= "Dropzone.autoDiscover = false;";
      $html .= "$(function() {";

      // Now that the DOM is fully loaded, create the dropzone, and setup the
      // event listeners
      $html .= "var dropzone = new Dropzone('#dropzone', {";

      //addRemoveLinks: true,

      switch ( $accepted_file_types ) {

        // Images
        case 'images':
          $html .= "acceptedFiles: 'image/*',";
          break;

        // Audio
        case 'audio':
          $html .= "acceptedFiles: 'audio/*',";
          break;

        // Videos
        case 'videos':
          $html .= "acceptedFiles: 'video/*',";
          break;

        // All
        case 'all':
        default:
      }


      $html .= "parallelUploads: 1";

      //
      // What to do when an image is removed
      //
      //canceled: function(file) {
      //  cancelTableRow(file.tableRow);
      //}
      $html .= "})";


      //
      //
      // What to do when anything is dropped into the upload area
      //
      //
      //$html .= ".on('drop', function(e) {";
      //$html .=   "console.log(e.dataTransfer);";
      //    //var url = e.dataTransfer.getData("text");
      //    //if(validURL(url)) { optimiseUrl(url); }
      //$html .= "})";


      //
      // New file added (triggered each time for multiple)
      //
      $html .= ".on('complete', function(file) {" . base64_decode( $on_added ) . "})";


      //
      //
      // When a file upload has been completed
      //
      //
      //.on("complete", function( file ) {
      //  var xhr = file.xhr;
      //  if(xhr == null) { return; }
      //  var response = JSON.parse(xhr.response);

      //  showTableRowComplete(file.tableRow, response);
      //})


      //
      //
      // Upload progress update
      //
      //
      //.on("uploadprogress", function(file, progress, bytesSent) {
      //  setTableRowProgress(file.tableRow, progress);
      //})


      //
      //
      // Upload error
      //
      //
      //.on("error", function(file) {
      //  showTableRowAsError(file.tableRow);
      //})


      //
      //
      // Just prior to upload, attach additional data to be used
      //
      //
      //.on("sending", function(file, xhr, formData) {
      //  for (var k in file.additionalData){
      //    if (file.additionalData.hasOwnProperty(k)) {
      //      formData.append(k, file.additionalData[k]);
      //    }
      //  }
      //})


      //
      // What to do when the entire queue of files has been completed
      //
      $html .= ".on('queuecomplete', function() {" . base64_decode( $on_queue_complete ) . "})";


      $html .= "});";
      $html .= "</script>";
      $html .= "</div>";

      return $html;
    }


  }
}