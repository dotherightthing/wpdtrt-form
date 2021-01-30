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

if ( ! isset( $sanitized_form_data[ $name ] ) || ( ( '' === $sanitized_form_data[ $name ] ) && ( '1' === $errors_inline ) ) ) {
	$required_label_class = $required_label_class . ' error';
}

?>

<label class="wpdtrt-form__label<?php echo $required_label_class; ?>" for="<?php echo $id; ?>">
<?php
echo $label;
if ( $required ) :
	?>
	<span class="wpdtrt-form__required"> (required)</span>
<?php endif; ?>
</label>
