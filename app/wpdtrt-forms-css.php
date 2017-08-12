<?php
/**
 * CSS imports
 *
 * This file contains PHP.
 *
 * @link        http://dotherightthing.co.nz
 * @since       0.1.0
 *
 * @package     Wpdtrt_Forms
 * @subpackage  Wpdtrt_Forms/app
 */

if ( !function_exists( 'wpdtrt_forms_css_frontend' ) ) {

  /**
   * Attach CSS for front-end widgets and shortcodes
   *
   * @since       0.1.0
   */
  function wpdtrt_forms_css_frontend() {

    wp_enqueue_style( 'wpdtrt_forms_css_frontend',
      WPDTRT_FORMS_URL . 'css/wpdtrt-forms.css',
      array(),
      WPDTRT_FORMS_VERSION
      //'all'
    );

  }

  add_action( 'wp_enqueue_scripts', 'wpdtrt_forms_css_frontend' );

}

?>
