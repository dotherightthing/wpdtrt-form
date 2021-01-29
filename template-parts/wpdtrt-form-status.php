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

$class   = ( $sentmail ? $data['success_class'] : $data['error_class'] );
$message = ( $sentmail ? $data['success_message'] : $data['error_message'] );
?>

<div class="wpdtrt-form__status wpdtrt-form__status-<?php echo $class; ?>">
<p><?php echo $message; ?></p>
<?php if ( 'true' === $errors_list ) : ?>
<ol class="wpdtrt-form__error-list">
	<?php foreach ( $submitted_data as $key => $sanitized_value ) : ?>
		<?php
		if ( '' === $sanitized_value ) :
			/**
			 * Search the template_fields array for the id (field name) which matches the submitted_data key (field name)
			 * array_map() creates a new array containing only the field ids, with the same order as the multidimensional array
			 * array_search() searches the new array for the value (id / field name) and returns the numeric key
			 * the numeric key can then be used to target the appropriate multidimensional child array
			 *
			 * @see https://stackoverflow.com/a/27387089/6850747
			 * @see http://php.net/manual/en/function.array-map.php
			 * @see http://php.net/manual/en/function.array-search.php
			 */
			$index = array_search( $key, array_map( function( $nested_array ) {
				return $nested_array['id'];
			}, $template_fields ), true );
			?>
	<li>
		<a href="#wpdtrt_form_<?php echo $template_fields[ $index ]['id']; ?>"><?php echo $template_fields[ $index ]['error']; ?></a>
	</li>
	<?php endif; ?>
	<?php endforeach; ?>
</ol>
<?php endif; ?>
</div>