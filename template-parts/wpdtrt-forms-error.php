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

global $wpdtrt_forms_plugin;
$submitted_data = $wpdtrt_forms_plugin->helper_sanitize_form_data();

if ( isset( $submitted_data[ $name ] ) ) :
	if ( ( '' === $submitted_data[ $name ] ) && ( '1' === $errors_inline ) ) : ?>
<span id="<?php echo $id; ?>-validation" class="validation">
	<strong><?php echo $error; ?></strong>
</span>
		<?php
	endif;
endif;
