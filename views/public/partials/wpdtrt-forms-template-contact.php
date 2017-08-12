<?php
/**
 * Template partial for the contact form template
 *
 * This file contains PHP, and HTML.
 *
 * @link        http://dotherightthing.co.nz
 * @since       0.1.0
 *
 * @package     Wpdtrt_Forms
 * @subpackage  Wpdtrt_Forms/views
 */
?>

<?php
  // output widget customisations (not output with shortcode)
  echo $before_widget;
  echo $before_title . $title . $after_title;

  $wpdtrt_forms_options = get_option('wpdtrt_forms');

  // this requires json_decode to use the optional second argument
  // to return an associative array
  // @see wpdtrt_forms_get_data()
  $template_data = $wpdtrt_forms_options['wpdtrt_forms_data'];
  $template_fields = $template_fields = $template_data['template_fields'];
?>

<form action="<?php esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="post" class="wpdtrt-forms-template wpdtrt-forms-template-contact">
  <fieldset class="wpdtrt-forms-fieldset">
    <legend class="wpdtrt-forms-legend wpdtrt-forms-hidden"><?php echo $template_data['legend']; ?></legend>
    <ul class="wpdtrt-forms-fields">

      <?php foreach( $template_fields as $field ): ?>
        <?php

          // predeclare variables
          $id                   = null;
          $label                = null;
          $required             = null;
          $element              = null;
          $type                 = null;
          $html5_validation     = null;
          $size                 = null;
          $rows                 = null;
          $cols                 = null;
          $error                = null;

          // only overwrite predeclared variables
          extract ($field, EXTR_IF_EXISTS );

          $required             = isset( $required );
          $required_label_class = $required ? ' wpdtrt-forms-label_required' : '';
          $id                   = 'wpdtrt_forms_' . $id;
          $value                = ( isset( $_POST[$id] ) ? esc_attr( $_POST[$id] ) : '' );
        ?>

        <li class="wpdtrt-forms-field">

            <?php
              ob_start();

              switch( $element ) {

                case "input":

                  if ( $type === 'checkbox' ) {
                    require( WPDTRT_FORMS_PATH . 'views/public/partials/wpdtrt-forms-input.php' );
                    require( WPDTRT_FORMS_PATH . 'views/public/partials/wpdtrt-forms-label.php' );
                  }
                  else {
                    require( WPDTRT_FORMS_PATH . 'views/public/partials/wpdtrt-forms-label.php' );
                    require( WPDTRT_FORMS_PATH . 'views/public/partials/wpdtrt-forms-input.php' );
                  }

                break;

                case "textarea":

                  require( WPDTRT_FORMS_PATH . 'views/public/partials/wpdtrt-forms-label.php' );
                  require( WPDTRT_FORMS_PATH . 'views/public/partials/wpdtrt-forms-textarea.php' );

                break;
              }

              echo ob_get_clean();
          ?>
        </li>

      <?php endforeach; ?>

    </ul>

    <div>
      <input type="submit" name="wpdtrt_forms_submitted" class="wpdtrt-forms-submit" value="<?php echo $template_data['submit']; ?>">
    </div>

  </fieldset>
</form>

<?php
  // output widget customisations (not output with shortcode)
  echo $after_widget;
?>
