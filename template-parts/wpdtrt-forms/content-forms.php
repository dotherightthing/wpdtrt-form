<?php
/**
 * File: template-parts/wpdtrt-forms/content-forms.php
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
 * $wpdtrt_forms_options = get_option('wpdtrt_forms'); // option doesn't exist yet
 *
 * @todo test/update for multiple forms
 */
// $wpdtrt_forms_options['wpdtrt_forms_datatype'] = $template;
// $wpdtrt_forms_options['errors_list'] = $errors_list;
// $wpdtrt_forms_options['errors_inline'] = $errors_inline;
// update_option('wpdtrt_forms', $wpdtrt_forms_options);.
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
// @see wpdtrt_forms_get_data().
$render_form = false;

// get existing plugin data (not get_api_data).
$data = $plugin->get_plugin_data();

if ( key_exists( 'template_fields', $data ) ) {
	$template_fields = $data['template_fields'];
	$sent            = $plugin->helper_sendmail();

	if ( false === $sent ) {
		// get submission data.
		$submitted_data = $plugin->helper_sanitize_form_data();
	}

	// if the form hasn't been submitted yet
	// or if it was submitted but couldn't be sent due to errors.
	if ( ! isset( $_POST['wpdtrt_forms_submitted'] ) || ( false === $sent ) ) {
		$render_form = true;
	}
}

// WordPress widget options (not output with shortcode).
echo $before_widget;
echo $before_title . $title . $after_title;
if ( $render_form ) :
	?>

<div class="wpdtrt-forms">
	<form action="<?php esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post" class="wpdtrt-forms-template wpdtrt-forms-template-<?php echo $template; ?>">
		<fieldset class="wpdtrt-forms__fieldset">
			<legend class="wpdtrt-forms-legend wpdtrt-forms__hidden"><?php echo $data['legend']; ?></legend>
			<div class="wpdtrt-forms__fields">

				<?php
				foreach ( $template_fields as $field ) :

					// predeclare variables.
					$id               = null;
					$label            = null;
					$required         = null;
					$element          = null;
					$type             = null;
					$html5_validation = null;
					$size             = null;
					$rows             = null;
					$cols             = null;
					$error            = null;

					// only overwrite predeclared variables.
					extract( $field, EXTR_IF_EXISTS );

					$required             = isset( $required );
					$required_label_class = $required ? ' wpdtrt-forms__label--required' : '';
					$name                 = $id;
					$id                   = 'wpdtrt_forms_' . $id;
					$value                = ( isset( $_POST[ $id ] ) ? esc_attr( $_POST[ $id ] ) : '' );
					?>

				<div class="wpdtrt-forms__field">

					<?php
					ob_start();

					switch ( $element ) {
						case 'input':
							if ( 'checkbox' === $type ) {
								require WPDTRT_FORMS_PATH . 'template-parts/wpdtrt-forms-input.php';
								require WPDTRT_FORMS_PATH . 'template-parts/wpdtrt-forms-label.php';
							} else {
								require WPDTRT_FORMS_PATH . 'template-parts/wpdtrt-forms-label.php';
								require WPDTRT_FORMS_PATH . 'template-parts/wpdtrt-forms-input.php';
								require WPDTRT_FORMS_PATH . 'template-parts/wpdtrt-forms-error.php';
							}

							break;

						case 'textarea':
							require WPDTRT_FORMS_PATH . 'template-parts/wpdtrt-forms-label.php';
							require WPDTRT_FORMS_PATH . 'template-parts/wpdtrt-forms-textarea.php';
							require WPDTRT_FORMS_PATH . 'template-parts/wpdtrt-forms-error.php';

							break;
					}

					echo ob_get_clean();
					?>
				</div>

				<?php endforeach; ?>

			</div>

			<div>
				<input type="submit" name="wpdtrt_forms_submitted" class="wpdtrt-forms__submit" value="<?php echo $data['submit']; ?>">
			</div>
		</fieldset>
	</form>
</div>

	<?php
endif;

// output widget customisations (not output with shortcode).
echo $after_widget;
