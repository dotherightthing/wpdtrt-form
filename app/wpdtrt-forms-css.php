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

if ( !function_exists( 'wpdtrt_forms_css_backend' ) ) {

  /**
   * Attach CSS for Settings > WPDTRT Forms
   *
   * @since       0.1.0
   */
  function wpdtrt_forms_css_backend() {

    wp_enqueue_style( 'wpdtrt_forms_css_backend',
      WPDTRT_FORMS_URL . 'views/admin/css/wpdtrt-forms.css',
      array(),
      WPDTRT_FORMS_VERSION
      //'all'
    );
  }

  add_action( 'admin_head', 'wpdtrt_forms_css_backend' );

}

if ( !function_exists( 'wpdtrt_forms_css_frontend' ) ) {

  /**
   * Attach CSS for front-end widgets and shortcodes
   *
   * @since       0.1.0
   */
  function wpdtrt_forms_css_frontend() {

    wp_enqueue_style( 'wpdtrt_forms_css_frontend',
      WPDTRT_FORMS_URL . 'views/public/css/wpdtrt-forms.css',
      array(),
      WPDTRT_FORMS_VERSION
      //'all'
    );

  }

  add_action( 'wp_enqueue_scripts', 'wpdtrt_forms_css_frontend' );

}

?>
