<?php
/**
 * Template partial for a form textarea
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

<textarea
 name="<?php echo $id; ?>"
 id="<?php echo $id; ?>"
 rows="<?php echo $rows; ?>"
 cols="<?php echo $cols; ?>"
<?php if ( isset( $required ) ): ?> aria-required="true"<?php endif; ?>
<?php if ( isset( $submitted_data[$name] ) ): ?>
<?php if ( $submitted_data[$name] === '' ): ?> aria-invalid="true"<?php endif; ?>
<?php if ( ( $submitted_data[$name] === '' ) && ( $errors_inline === 'true' ) ): ?> aria-describedby="<?php echo $id; ?>_error"<?php endif; ?>
<?php endif; ?>
>
<?php echo $value; ?>
</textarea>