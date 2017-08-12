<?php
/**
 * Template partial for an inline form error
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

<?php if ( ( $sent === false ) && ( $errors_inline === 'true' ) ): ?>
<div id="<?php echo $id; ?>_error" class="wpdtrt-forms-error-inline">
	<p><?php echo $error; ?></p>
</div>
<?php endif; ?>