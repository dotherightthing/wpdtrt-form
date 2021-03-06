<?php
/**
 * Template partial for a form label
 *
 * This file contains PHP, and HTML.
 *
 * @link        http://dotherightthing.co.nz
 * @since       0.1.0
 *
 * @package     Wpdtrt_Form
 * @subpackage  Wpdtrt_Form/views
 */

if ( $errors_inline ) {
	if ( isset( $sanitized_form_data ) && array_key_exists( $field_name, $sanitized_form_data ) && '' === $sanitized_form_data[ $field_name ] ) {
		$required_label_class = $required_label_class . ' error';
	}
}

?>

<label class="wpdtrt-form__label<?php echo $required_label_class; ?>" for="<?php echo $field_id; ?>">
<?php
echo $label;
if ( $required ) :
	?>
	<span class="wpdtrt-form__required"> (required)</span>
<?php endif; ?>
</label>
