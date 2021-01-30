<?php
/**
 * File: template-parts/wpdtrt-form/content-forms.php
 *
 * Template to display plugin output in shortcodes and widgets.
 *
 * Since:
 *   0.9.1 - DTRT WordPress Plugin Boilerplate Generator
 */

// Predeclare variables
//
// Internal WordPress arguments available to widgets
// This allows us to use the same template for shortcodes and front-end widgets.
$before_widget = null; // register_sidebar.
$before_title  = null; // register_sidebar.
$title         = null;
$after_title   = null; // register_sidebar.
$after_widget  = null; // register_sidebar.

// shortcode options.
$template      = null;
$errors_list   = null;
$errors_inline = null;

// access to plugin.
$plugin = null;

// Options: display $args + widget $instance settings + access to plugin.
$options = get_query_var( 'options', array() );

/**
 * Store the shortcode options in the options table
 *
 * $wpdtrt_form_options = get_option('wpdtrt_form'); // option doesn't exist yet
 *
 * @todo test/update for multiple forms
 */
// $wpdtrt_form_options['wpdtrt_form_datatype'] = $template;
// $wpdtrt_form_options['errors_list'] = $errors_list;
// $wpdtrt_form_options['errors_inline'] = $errors_inline;
// update_option('wpdtrt_form', $wpdtrt_form_options);.
//
// store the template data in the options table.
// $plugin->refresh_api_data();.
//
// Overwrite variables from array values
// https://gist.github.com/dotherightthing/a1bde197a6ff5a9fddb886b0eb17ac79.
extract( $options, EXTR_IF_EXISTS );

// load the data.
$plugin->get_api_data();
// $foo = $plugin->get_api_data_bar();
//
// this requires json_decode to use the optional second argument
// to return an associative array
// @see wpdtrt_form_get_data().
$render_form = false;

// get existing plugin data (not get_api_data).
$data = $plugin->get_plugin_data();

if ( key_exists( 'template_fields', $data ) ) {
	$form_id         = $data['form_id'];
	$form_name       = $data['form_name'];
	$template_fields = $data['template_fields'];

	// send form submission to email and output wpdtrt-form-status.php.
	$sent = $plugin->helper_sendmail( $form_id, $form_name, $errors_list );

	$current_url = $_SERVER['REQUEST_URI'];

	if ( false === $sent ) {
		// get submission data.
		$submitted_data = $plugin->helper_sanitize_form_data();
	}

	// if the form hasn't been submitted yet
	// or if it was submitted but couldn't be sent due to errors.
	if ( ! isset( $_POST[ 'wpdtrt-' . $form_id . '-submitted' ] ) || ( false === $sent ) ) {
		$render_form = true;
	}
}

// WordPress widget options (not output with shortcode).
echo $before_widget;
echo $before_title . $title . $after_title;
if ( $render_form ) :
	?>

<div class="wpdtrt-form" id="wpdtrt-<?php echo $form_id; ?>-<?php echo $template; ?>">
	<form action="<?php echo $current_url; ?>" method="post" class="wpdtrt-form-template wpdtrt-form-template-<?php echo $template; ?>">
		<fieldset class="wpdtrt-form__fieldset">
			<legend class="wpdtrt-form__legend">
				<?php echo $data['legend']; ?>
			</legend>
			<p class="wpdtrt-form__notes">
				<?php
				foreach ( $template_fields as $template_field ) {
					if ( array_key_exists( 'notes', $template_field ) ) {
						$id   = $template_field['id'];
						$text = $template_field['notes'];

						echo "<span id='wpdtrt-{$form_id}-{$id}-notes'>{$text}</span>";
					}
				}
				?>
				<span class="wpdtrt-form__label--required">
					Required fields are marked as <span class="wpdtrt-form__required"> (required)</span>
				</span>
			</p>
			<?php
			foreach ( $template_fields as $field ) :

				// predeclare variables.
				$autocomplete     = null;
				$cols             = null;
				$element          = null;
				$error            = null;
				$html5_validation = null;
				$id               = null;
				$label            = null;
				$notes            = null;
				$required         = null;
				$rows             = null;
				$size             = null;
				$type             = null;

				// only overwrite predeclared variables.
				extract( $field, EXTR_IF_EXISTS );

				$id                   = "wpdtrt-{$form_id}-{$id}";
				$name                 = $id;
				$required             = isset( $required );
				$required_label_class = $required ? ' wpdtrt-form__label--required' : '';
				$value                = ( isset( $_POST[ $id ] ) ? esc_attr( $_POST[ $id ] ) : '' );
				?>

			<div class="wpdtrt-form__item">

				<?php
				ob_start();

				switch ( $element ) {
					case 'input':
						if ( 'checkbox' === $type ) {
							require WPDTRT_FORM_PATH . 'template-parts/wpdtrt-form-input.php';
							require WPDTRT_FORM_PATH . 'template-parts/wpdtrt-form-label.php';
						} else {
							require WPDTRT_FORM_PATH . 'template-parts/wpdtrt-form-label.php';
							require WPDTRT_FORM_PATH . 'template-parts/wpdtrt-form-input.php';
							require WPDTRT_FORM_PATH . 'template-parts/wpdtrt-form-error.php';
						}

						break;

					case 'textarea':
						require WPDTRT_FORM_PATH . 'template-parts/wpdtrt-form-label.php';
						require WPDTRT_FORM_PATH . 'template-parts/wpdtrt-form-textarea.php';
						require WPDTRT_FORM_PATH . 'template-parts/wpdtrt-form-error.php';

						break;
				}

				echo ob_get_clean();
				?>
			</div>

			<?php endforeach; ?>

			<div class="wpdtrt-form__submit-wrapper">
				<input type="submit" name="wpdtrt-<?php echo $form_id; ?>-submitted" id="wpdtrt-<?php echo $form_id; ?>-submitted" class="wpdtrt-form__submit" value="<?php echo $data['submit']; ?>">
			</div>
		</fieldset>
	</form>
</div>

	<?php
endif;

// output widget customisations (not output with shortcode).
echo $after_widget;
