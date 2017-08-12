<?php
/**
 * Template partial for a form input
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

<input
 type="<?php echo $type; ?>"
 name="<?php echo $id; ?>"
 id="<?php echo $id; ?>"
<?php if ( $type === 'checkbox' ): ?> value="1" <?php checked( $value, 1 ); endif; ?>
<?php if ( $type !== 'checkbox' ): ?> value="<?php echo $value; ?>"<?php endif; ?>
<?php if ( $type === 'text' ): ?> size="<?php echo $size; ?>"<?php endif; ?>
<?php if ( isset( $html5_validation ) ): ?> pattern="<?php echo $html5_validation; ?>"<?php endif; ?>
<?php if ( isset( $required ) ): ?> aria-required="true"<?php endif; ?>
<?php if ( isset( $submitted_data[$name] ) ): ?>
<?php if ( ( $type !== 'checkbox' ) && ( $submitted_data[$name] === '' ) ): ?> aria-invalid="true"<?php endif; ?>
<?php if ( ( $type !== 'checkbox' ) && ( $submitted_data[$name] === '' ) && ( $errors_inline === 'true' ) ): ?> aria-describedby="<?php echo $id; ?>_error"<?php endif; ?>
<?php endif; ?>
/>
