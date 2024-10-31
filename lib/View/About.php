<?php
/**
 * Class PageEditor_View_About
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_View_About' ) ) {
  class PageEditor_View_About extends PageEditor_View_Template {


    public static function current_url() {
      return 'admin.php?page=pe-about';
    }


    /**
     *
     */
    public static function content() {
      self::welcome();
      self::whats_new();
    }


    /**
     * Generate a link to the PageEditor website with the given text.
     *
     * @param $text
     *
     * @return string
     */
    private static function link_to_page_editor_website( $text ) {
      return "<a target='_blank' href='https://page-editor.com'>{$text}</a>";
    }


    /**
     *
     */
    private static function welcome() {
    ?>
      <h2>Welcome</h2>

      <p>
        Welcome to the first release of
        <?php echo self::link_to_page_editor_website( 'PageEditor' ) ?>,
        version 1.0.0
      </p>

      <p>
        PageEditor is a free graphical, drag-and-drop, website content building
        plugin. Built with a modular structure, PageEditor is designed to be
        flexible, customisable and scalable as it is developed further in the
        future.
      </p>

      <p>
        It is our goal to produce an intuitive and powerful website content
        editor that will hopefully one day give thousands of people the tools
        they need to build complex and beautiful WordPress websites.
      </p>

      <p>
        Although we have made every effort to get PageEditor running as smoothly
        as possible - since this is the first release of our plugin, we are
        expecting inevitable teething issues.
      </p>

      <p>
        If you encounter issues with PageEditor, or have any other feedback or suggestions, contact us at:
        <a target="_blank" href="mailto:support@page-editor.com">support@page-editor.com</a>
      </p>

    <?php
    }


    /**
     *
     */
    private static function whats_new() {
    ?>
      <h2>What's new in 1.0.0?</h2>

      <p>
        Version 1.0.0 introduces the basic PageEditor framework.
      </p>

      <ul>
        <li>
          PageEditor can be launched from "Edit with PageEditor" button, which
          is available from the WordPress Page/Post edit page.
        </li>
        <li>
          Introduces a drag-and-drop environment for elements within the page
          area. New elements can be added to the page by either clicking the
          element icon, or by dragging the icon into the page.
        </li>
        <li>
          Elements can be modified from the properties displayed in the side bar
          by changing the displayed settings.
        </li>
        <li>
          Element settings are defined by the applicable module manifesto,
          which describes the available settings for an element instance and
          how the module should interface with PageEditor.
        </li>
        <li>
          Feedback and suggestions can be sent to PageEditor developers using
          the feedback modal - which is displayed by clicking the light-bulb
          icon at the bottom of the PageEditor side bar.
        </li>
      </ul>


      <h3>Changes to modules</h3>

      <p>
        Introduces <b>20</b> new modules.
      </p>

      <ul>
        <li>Introduce new module <b>row</b>, version 1.0.0</li>
        <li>Introduce new module <b>group</b>, version 1.0.0</li>
        <li>Introduce new module <b>text-block</b>, version 1.0.0</li>
        <li>Introduce new module <b>button</b>, version 1.0.0</li>
        <li>Introduce new module <b>empty-space</b>, version 1.0.0</li>
        <li>Introduce new module <b>google-map</b>, version 1.0.0</li>
        <li>Introduce new module <b>heading</b>, version 1.0.0</li>
        <li>Introduce new module <b>icon</b>, version 1.0.0</li>
        <li>Introduce new module <b>image</b>, version 1.0.0</li>
        <li>Introduce new module <b>image-carousel</b>, version 1.0.0</li>
        <li>Introduce new module <b>image-compare</b>, version 1.0.0</li>
        <li>Introduce new module <b>message-box</b>, version 1.0.0</li>
        <li>Introduce new module <b>panel</b>, version 1.0.0</li>
        <li>Introduce new module <b>progress-bar</b>, version 1.0.0</li>
        <li>Introduce new module <b>raw-css</b>, version 1.0.0</li>
        <li>Introduce new module <b>raw-html</b>, version 1.0.0</li>
        <li>Introduce new module <b>raw-js</b>, version 1.0.0</li>
        <li>Introduce new module <b>separator</b>, version 1.0.0</li>
        <li>Introduce new module <b>stage</b>, version 1.0.0</li>
        <li>Introduce new module <b>tabs</b>, version 1.0.0</li>
      </ul>


    <?php
    }


	}
}