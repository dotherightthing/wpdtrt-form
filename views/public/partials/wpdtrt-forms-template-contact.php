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

  // content data
  $legend = 'Contact';
  $submit = 'Submit';

  // structure
  $fields = array(
    array(
      "id" => "name",
      "label" => "Name",
      "required" => "true",
      "element" => "input",
      "type" => "text",
      "html5_validation" => "[a-zA-Z0-9 ]+",
      "size" => "40"
    ),
    array(
      "id" => "email",
      "label" => "Email",
      "required" => "true",
      "element" => "input",
      "type" => "text",
      "size" => "40"
    ),
    array(
      "id" => "email_updates",
      "label" => "Check here to receive email updates",
      "element" => "input",
      "type" => "checkbox"
    ),
    array(
      "id" => "subject",
      "label" => "Subject",
      "required" => "true",
      "element" => "input",
      "type" => "text",
      "html5_validation" => "[a-zA-Z ]+",
      "size" => "40"
    ),
    array(
      "id" => "message",
      "label" => "Message",
      "required" => "true",
      "element" => "textarea",
      "rows" => "6",
      "cols" => "35",
    )
  );

?>

<form action="<?php esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="post" class="wpdtrt-forms-template wpdtrt-forms-template-contact">
  <fieldset class="wpdtrt-forms-fieldset">
    <legend class="wpdtrt-forms-legend wpdtrt-forms-hidden"><?php echo $legend; ?></legend>
    <ul class="wpdtrt-forms-fields">

      <?php foreach( $fields as $field ): ?>
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

              $content = ob_get_clean();
              echo $content;
          ?>
        </li>

      <?php endforeach; ?>

    </ul>

    <div>
      <input type="submit" name="wpdtrt_forms_submitted" class="wpdtrt-forms-submit" value="<?php echo $submit; ?>">
    </div>

  </fieldset>
</form>

<?php
  // output widget customisations (not output with shortcode)
  echo $after_widget;
?>
