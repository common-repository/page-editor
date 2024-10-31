<?php
/**
 * Class PageEditor_Post
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_Post' ) ) {
  class PageEditor_Post {


    /**
     * Get the current post.
     *
     * @return PageEditor_Post
     */
    public static function current_post() {
      global $post;
      return new self( $post );
    }


    // --- --- ---


    private $post;


    /**
     *
     */
    public function __construct( $post ) {
      $this->post = $post;
		}


    /**
     * Get the id of the post.
     *
     * @return string
     */
    public function id() {
      return $this->post->ID;
    }


    /**
     * @param array $query_arguments
     *
     * @return string
     */
    public function permalink( array $query_arguments = array() ) {
      /** @noinspection PhpUndefinedFunctionInspection */
      $url = get_permalink( $this->id() );

      foreach( $query_arguments as $query_id => $query_value ) {
        /** @noinspection PhpUndefinedFunctionInspection */
        $url = add_query_arg( array( $query_id => $query_value ), $url );
      }

      return $url;
    }


    /**
     * @param array $query_arguments
     *
     * @return string
     */
    public function edit_link( array $query_arguments = array() ) {
      /** @noinspection PhpUndefinedFunctionInspection */
      $url = get_edit_post_link( $this->id() );

      foreach( $query_arguments as $query_id => $query_value ) {
        /** @noinspection PhpUndefinedFunctionInspection */
        $url = add_query_arg( array( $query_id => $query_value ), $url );
      }

      return $url;
    }


	}
}