<?php
/**
 * Generate a shortcode, to embed the widget inside a content area.
 *
 * This file contains PHP.
 *
 * @link        http://dotherightthing.co.nz
 * @link        https://generatewp.com/shortcodes/
 * @since       0.1.0
 *
 * @example     [wpdtrt_forms template="content"]
 * @example     do_shortcode( '[wpdtrt_forms template="content"]' );
 *
 * @package     Wpdtrt_Forms
 * @subpackage  Wpdtrt_Forms/app
 */

if ( !function_exists( 'wpdtrt_forms_shortcode' ) ) {

  /**
   * add_shortcode
   * @param       string $tag
   *    Shortcode tag to be searched in post content.
   * @param       callable $func
   *    Hook to run when shortcode is found.
   *
   * @since       0.1.0
   * @uses        ../../../../wp-includes/shortcodes.php
   * @see         https://codex.wordpress.org/Function_Reference/add_shortcode
   * @see         http://php.net/manual/en/function.ob-start.php
   * @see         http://php.net/manual/en/function.ob-get-clean.php
   */
  function wpdtrt_forms_shortcode( $atts, $content = null ) {

    // post object to get info about the post in which the shortcode appears
    global $post;

    // predeclare variables
    $before_widget = null;
    $before_title = null;
    $title = null;
    $after_title = null;
    $after_widget = null;
    $template = null;
    $shortcode = 'wpdtrt_forms';

    /**
     * Combine user attributes with known attributes and fill in defaults when needed.
     * @see https://developer.wordpress.org/reference/functions/shortcode_atts/
     */
    $atts = shortcode_atts(
      array(
        'template' => ''
      ),
      $atts,
      $shortcode
    );

    // only overwrite predeclared variables
    extract( $atts, EXTR_IF_EXISTS );

    $wpdtrt_forms_options = get_option('wpdtrt_forms');
    $wpdtrt_forms_data = $wpdtrt_forms_options['wpdtrt_forms_data'];

    /**
     * ob_start — Turn on output buffering
     * This stores the HTML template in the buffer
     * so that it can be output into the content
     * rather than at the top of the page.
     */
    ob_start();

    if ( $template === 'contact' ) {
      $sent = wpdtrt_forms_sendmail();

      if ( ! isset( $_POST['wpdtrt_forms_submitted'] ) || ( $sent === false ) ) {
        require(WPDTRT_FORMS_PATH . 'views/public/partials/wpdtrt-forms-template-contact.php');
      }
    }

    /**
     * ob_get_clean — Get current buffer contents and delete current output buffer
     */
    $content = ob_get_clean();

    return $content;
  }

  add_shortcode( 'wpdtrt_forms', 'wpdtrt_forms_shortcode' );

}

?>
