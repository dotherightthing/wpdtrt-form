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

$attr_checked           = '';
$attr_describedby       = '';
$attr_describedby_value = '';
$attr_id                = " id='{$id}'";
$attr_invalid           = '';
$attr_name              = " name='{$id}'";
$attr_pattern           = '';
$attr_required          = '';
$attr_size              = '';
$attr_type              = " type='{$type}'";
$attr_value             = '';

if ( 'checkbox' === $type ) {
	$attr_checked = ' ' . checked( $value, 1 );
	$attr_value   = ' value="1"';
} elseif ( 'checkbox' !== $type ) {
	$attr_checked = ' ' . checked( $value, 1 );
	$attr_value   = " value='{$value}'";
} elseif ( 'text' === $type ) {
	$attr_size = " size='{$size}'";
}

if ( isset( $html5_validation ) ) {
	$attr_pattern = " pattern='{$html5_validation}'";
}

if ( isset( $required ) ) {
	$attr_required = " aria-required='true' required='required' data-errors='{$id}-validation' data-msg-required='{$error}'";
}

if ( '' !== $notes ) {
	$attr_describedby_value = "{$id}-notes";
}

if ( ( '1' === $errors_inline ) && isset( $required ) ) {
	$attr_describedby_value .= " {$id}-error";
}

if ( '' !== $attr_describedby_value ) {
	$attr_describedby = " aria-describedby='{$attr_describedby_value}'";
}

if ( isset( $submitted_data[ $name ] ) ) {
	if ( ( 'checkbox' !== $type ) && ( '' === $submitted_data[ $name ] ) ) {
		$attr_invalid = ' aria-invalid="true"';
	}
}

?>

<input<?php echo $attr_type . $attr_name . $attr_id . $attr_value . $attr_checked . $attr_size . $attr_pattern . $attr_required . $attr_invalid . $attr_describedby; ?>>
