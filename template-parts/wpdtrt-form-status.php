<?php
/**
 * Template partial for a submit status message
 *
 * This file contains PHP, and HTML.
 *
 * @link        http://dotherightthing.co.nz
 * @since       0.1.0
 *
 * @package     Wpdtrt_Form
 * @subpackage  Wpdtrt_Form/views
 */

$errors_count       = 0;
$errors_list_items  = '';
$heading            = $data['heading'];
$heading_class_attr = '' !== $data['heading_class'] ? " class='{$data['heading_class']}'" : '';
$icon_class         = '2' === $submit_status ? 'email' : 'warning';
$legend             = $data['legend'];
$message            = '';
$show_errors_list   = $errors_list;
$template_fields    = $data['template_fields'];

if ( isset( $sanitized_form_data ) ) { // this line is redundant.
	foreach ( $sanitized_form_data as $key => $sanitized_value ) {
		if ( '' === $sanitized_value ) {
			++$errors_count;

			if ( $show_errors_list ) {
				/**
				 * Search the template_fields array for the id (field name) which matches the sanitized_form_data key (field name)
				 * array_map() creates a new array containing only the field ids, with the same order as the multidimensional array
				 * array_search() searches the new array for the value (id / field name) and returns the numeric key
				 * the numeric key can then be used to target the appropriate multidimensional child array
				 *
				 * @see https://stackoverflow.com/a/27387089/6850747
				 * @see http://php.net/manual/en/function.array-map.php
				 * @see http://php.net/manual/en/function.array-search.php
				 */
				$field_name_raw = $plugin->get_field_name_raw( $form_id_raw, $key );

				$index = array_search( $field_name_raw, array_map( function( $nested_array ) {
					return $nested_array['id'];
				}, $template_fields ), true );

				$field_id   = $plugin->get_field_id( $form_id_raw, $template_fields[ $index ]['id'] );
				$field_text = $template_fields[ $index ]['error'];

				$errors_list_items .= "<li><a href='#{$field_id}'>{$field_text}</a></li>";
			}
		}
	}
}

if ( '2' === $submit_status ) {
	$message = $data['success_message'];
} elseif ( '1' === $submit_status ) {
	$message = $data['unsent_message'];
} elseif ( ( '3' === $submit_status ) && $show_errors_list ) {
	if ( $errors_count > 1 ) {
		$message = $data['error_message_plural'];
		$message = str_replace( '#', $errors_count, $message );
	} else {
		$message = $data['error_message_single'];
	}
}

?>

<div class="wpdtrt-form__status">
	<h3<?php echo $heading_class_attr; ?>>
		<?php echo $heading; ?>
	</h3>
	<?php if ( '' !== $message ) { ?>
	<p>
		<span class="wpdtrt-form-icon-<?php echo $icon_class; ?>"></span>
		<?php echo $message; ?>
	</p>
	<?php } ?>
<?php
if ( ( '3' === $submit_status ) && $show_errors_list ) {
	// noscript error list.
	echo "<ol class='wpdtrt-form__errors-list'>{$errors_list_items}</ol>";
}
?>
</div>
