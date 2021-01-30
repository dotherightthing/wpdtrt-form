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

$attr_autocomplete      = '';
$attr_class             = '';
$attr_cols              = " cols='{$cols}'";
$attr_describedby       = '';
$attr_describedby_value = '';
$attr_id                = " id='{$id}'";
$attr_invalid           = '';
$attr_name              = " name='{$id}'";
$attr_rows              = " rows='{$rows}'";
$attr_required          = '';

if ( isset( $autocomplete ) ) {
	$attr_autocomplete = " autocomplete='{$autocomplete}'";
}

if ( isset( $required ) ) {
	// required attribute is added via JS to prevent HTML5 noscript validation
	// from intercepting styled PHP validation.
	$attr_required = " aria-required='true' data-required='true' data-errors='{$id}-validation' data-msg-required='{$error}'";
}

if ( null !== $notes ) {
	$attr_describedby_value = "{$id}-notes";
}

if ( ( '1' === $errors_inline ) && isset( $required ) ) {
	$attr_describedby_value .= " {$id}-error";
}

if ( '' !== $attr_describedby_value ) {
	$attr_describedby_value = trim( $attr_describedby_value );
	$attr_describedby       = " aria-describedby='{$attr_describedby_value}'";
}

if ( isset( $sanitized_form_data[ $name ] ) ) {
	if ( '' === $sanitized_form_data[ $name ] ) {
		$attr_invalid = ' aria-invalid="true"';
	}
}

if ( isset( $sanitized_form_data[ $name ] ) && ( '' === $sanitized_form_data[ $name ] ) && ( '1' === $errors_inline ) ) {
	$attr_class = ' class="error"';
}

?>

<textarea<?php echo $attr_name . $attr_id . $attr_rows . $attr_cols . $attr_required . $attr_invalid . $attr_describedby . $attr_autocomplete . $attr_class; ?>><?php echo $value; ?></textarea>
