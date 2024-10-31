<?php
/**
 * Class PageEditor_WordPress
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_WordPress' ) ) {
  class PageEditor_WordPress {


    /**
     * Prepare the given text string. (Translates where translation available)
     *
     * @param $text
     *
     * @return string
     */
    public static function prepare_text( $text ) {
      /** @noinspection PhpUndefinedFunctionInspection */
      return __( $text );
    }


    /**
     * Hide the WordPress admin bar.
     */
    public static function hide_admin_bar() {
      /** @noinspection PhpUndefinedFunctionInspection */
      show_admin_bar( false );
    }


    /**
     * Get the title of the current admin page.
     *
     * @return string
     */
    public static function admin_page_title() {
      /** @noinspection PhpUndefinedFunctionInspection */
      return get_admin_page_title();
    }


    /**
     * Add "Edit with PageEditor" button where 'Pages' and 'Posts' are edited
     * with WordPress
     */
    public static function add_edit_button_to_pages_and_posts() {
      /** @noinspection PhpUndefinedFunctionInspection */
      add_action( 'edit_form_after_title', function() {
        global $post;

        if ( is_null( $post ) ) { return; }
        ?>

        <div style="margin-top: 15px">
          <a id="page-editor_launch-button" class="button button-primary button-large">
            <?php echo PageEditor_WordPress::prepare_text( 'Edit with PageEditor') ?>
          </a>
        </div>

      <?php
      } );
    }


    /**
     * Add a meta tag to the page head section.
     *
     * @param $tag_name
     * @param $tag_content
     */
    public static function add_meta_tag_to_head( $tag_name, $tag_content ) {
      /** @noinspection PhpUndefinedFunctionInspection */
      add_action( 'wp_head', function() use ( $tag_name, $tag_content ) {
        echo '<meta';
        echo ' name="' . $tag_name . '"';
        echo ' content="' . $tag_content . '"';
        echo '>' . "\n";
      }, 2 );
    }


    /**
     * @return boolean
     */
    public static function user_can_rich_edit() {
      return true;
      /** @noinspection PhpUndefinedFunctionInspection */
      //return user_can_richedit();
    }


    /**
     * Add "Edit with PageEditor" link to both the 'Posts' and 'Pages'
     * WordPress listing pages.
     */
    public static function add_edit_page_with_pageeditor_row_action() {

      $add_link_function = function( $actions, $post ) {
        $new_actions = array();

        foreach ( $actions as $action => $value ) {
          $new_actions[$action] = $value;

          // If current action is 'Quick Edit'...
          if ( 'inline hide-if-no-js' === $action ) {

            //
            // Create new 'Edit with PageEditor' button
            //
            $link_title = PageEditor_WordPress::prepare_text(
              'Edit with PageEditor'
            );

            /** @noinspection PhpUndefinedFunctionInspection */
            $link_url = add_query_arg(
              'page-editor-auto-open', 'true',
              get_edit_post_link( $post->ID, true )
            );

            $new_actions['page-editor_edit_link'] =
              "<a href='{$link_url}' title='{$link_title}'>{$link_title}</a>";
          }
        }

        return $new_actions;
      };

      // --- --- ---

      // Add edit link for WordPress pages
      /** @noinspection PhpUndefinedFunctionInspection */
      add_filter( 'page_row_actions', $add_link_function, 10, 2 );

      // Add edit link for WordPress posts
      /** @noinspection PhpUndefinedFunctionInspection */
      add_filter( 'post_row_actions', $add_link_function, 10, 2 );
    }


    /**
     * Add a link to the top admin bar.
     */
    public static function add_edit_with_pageeditor_link_to_admin_top_bar() {
      /** @noinspection PhpUndefinedFunctionInspection */
      add_action( 'admin_bar_menu', function( $wp_admin_bar ) {

        $current_page = PageEditor_Post::current_post();
        $url = $current_page->edit_link( array(
          'page-editor-auto-open' => 'true'
        ) );

        $text = PageEditor_WordPress::prepare_text( 'Edit with PageEditor' );
        $id   = 'page-editor';

        // ---

        // Build the link arguments
        $args = array(
          'id' => $id,
          'title' => $text,
          'href' => $url,
          'meta' => array(
            'class' => 'ab-item',
            'title' => $text
          )
        );

        /** @noinspection PhpUndefinedMethodInspection */
        $wp_admin_bar->add_node( $args );

      }, 999 );
    }


    /**
     *
     */
    public static function add_built_with_page_editor_footer_link() {
      /** @noinspection PhpUndefinedFunctionInspection */
      add_filter( 'the_content', function( $content ) {
        $html = "<div style='text-align:center; margin:10px; font-size:14px'>" .
          "Built with " .
          "<a target='_blank' href='https://page-editor.com'>PageEditor</a>" .
          "</div>";
        return $content . $html;
      }, 99999999 );
    }



    /**
     *
     *
     * @return bool
     */
    //private function current_user_can_edit_content() {
    //  return current_user_can( 'contributor' ) ||
    //  current_user_can( 'author' ) ||
    //  current_user_can( 'editor' ) ||
    //  current_user_can( 'administrator' );
    //}



  }
}