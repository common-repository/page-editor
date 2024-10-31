<?php
/**
 * Class PageEditor_View_TemplateViewProvider
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! interface_exists( 'PageEditor_View_TemplateViewProvider' ) ) {
  interface PageEditor_View_TemplateViewProvider {


    public static function current_url();


    public static function content();


  }
}