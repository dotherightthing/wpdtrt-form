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

$attr_cols        = " cols='{$cols}'";
$attr_describedby = '';
$attr_id          = " id='{$id}'";
$attr_invalid     = '';
$attr_name        = " name='{$id}'";
$attr_rows        = " rows='{$rows}'";
$attr_required    = '';

if ( isset( $required ) ) {
	$attr_required = " aria-required='true' required='required' data-errors='{$id}-validation' data-msg-required='{$error}' aria-describedby='{$id}-error'";
}

if ( isset( $submitted_data[ $name ] ) ) {
	if ( '' === $submitted_data[ $name ] ) {
		$attr_invalid = ' aria-invalid="true"';
	}
}

?>

<textarea<?php echo $attr_name . $attr_id . $attr_rows . $attr_cols . $attr_required . $attr_invalid . $attr_describedby; ?>><?php echo $value; ?></textarea>
