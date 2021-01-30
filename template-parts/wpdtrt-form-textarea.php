<?php
/**
 * Template partial for a form textarea
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
$attr_class             = '';
$attr_cols              = " cols='{$cols}'";
$attr_describedby       = '';
$attr_describedby_value = '';
$attr_id                = " id='{$field_id}'";
$attr_invalid           = '';
$attr_name              = " name='{$field_name}'";
$attr_rows              = " rows='{$rows}'";
$attr_required          = '';

if ( isset( $autocomplete ) ) {
	$attr_autocomplete = " autocomplete='{$autocomplete}'";
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
	$attr_invalid = ' aria-invalid="true"';

	if ( '1' === $errors_inline ) {
		$attr_class = ' class="error"';
	}
}

?>

<textarea<?php echo $attr_name . $attr_id . $attr_rows . $attr_cols . $attr_required . $attr_invalid . $attr_describedby . $attr_autocomplete . $attr_class; ?>><?php echo $value; ?></textarea>
