<?php
/**
 * Template partial for a form input
 *
 * This file contains PHP, and HTML.
 *
 * @link        http://dotherightthing.co.nz
 * @since       0.1.0
 *
 * @package     Wpdtrt_Form
 * @subpackage  Wpdtrt_Form/views
 */

// note: other variables available from parent template (content-form.php).
$attr_autocomplete      = '';
$attr_checked           = '';
$attr_class             = '';
$attr_describedby       = '';
$attr_describedby_value = '';
$attr_id                = " id='{$field_id}'";
$attr_invalid           = '';
$attr_name              = " name='{$field_name}'";
$attr_pattern           = '';
$attr_required          = '';
$attr_size              = '';
$attr_type              = " type='{$type}'";
$attr_value             = '';

if ( isset( $autocomplete ) ) {
	$attr_autocomplete = " autocomplete='{$autocomplete}'";
}

if ( 'checkbox' === $type ) {
	$attr_checked = ' ' . checked( $value, 1 );
	$attr_value   = ' value="1"';
} elseif ( 'checkbox' !== $type ) { // TODO.
	$attr_checked = ' ' . checked( $value, 1 );
	$attr_value   = " value='{$value}'";
} elseif ( 'text' === $type ) {
	$attr_size = " size='{$size}'";
}

if ( isset( $required ) ) {
	// required attribute is added via JS to prevent HTML5 noscript validation
	// from intercepting styled PHP validation.
	$attr_required = " aria-required='true' data-required='true' data-describedby='{$field_id}-validation' data-msg-required='{$error}'";

	if ( '1' === $errors_inline ) {
		$attr_describedby_value .= " {$field_id}-validation";
	}
}

if ( null !== $notes ) {
	$attr_describedby_value .= " {$field_id}-notes";
}

if ( '' !== $attr_describedby_value ) {
	$attr_describedby_value = trim( $attr_describedby_value );
	$attr_describedby       = " aria-describedby='{$attr_describedby_value}'";
}

if ( ! isset( $sanitized_form_data[ $name ] ) || '' === $sanitized_form_data[ $name ] ) {
	if ( 'checkbox' !== $type ) {
		$attr_invalid = ' aria-invalid="true"';

		if ( '1' === $errors_inline ) {
			$attr_class = ' class="error"';
		}
	}
}

?>

<input<?php echo $attr_type . $attr_name . $attr_id . $attr_value . $attr_checked . $attr_size . $attr_pattern . $attr_required . $attr_invalid . $attr_describedby . $attr_autocomplete . $attr_class; ?>>
