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
>
<?php echo $value; ?>
</textarea>
