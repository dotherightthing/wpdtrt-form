<?php
/**
 * File: src/class-wpdtrt-form-plugin.php
 *
 * Plugin sub class.
 *
 * Since:
 *   0.9.1 - DTRT WordPress Plugin Boilerplate Generator
 */

/**
 * Class: WPDTRT_Form_Plugin
 *
 * Extends the base class to inherit boilerplate functionality, adds application-specific methods.
 *
 * Since:
 *   0.9.1 - DTRT WordPress Plugin Boilerplate Generator
 */
class WPDTRT_Form_Plugin extends DoTheRightThing\WPDTRT_Plugin_Boilerplate\r_1_7_15\Plugin {

	/**
	 * Constructor: __construct
	 *
	 * Supplement plugin initialisation.
	 *
	 * Parameters:
	 *   $options - Plugin options
	 *
	 * Since:
	 *   0.9.1 - DTRT WordPress Plugin Boilerplate Generator
	 */
	public function __construct( $options ) { // phpcs:ignore

		// edit here.
		parent::__construct( $options );
	}

	/**
	 * Group: WordPress Integration
	 * _____________________________________
	 */

	/**
	 * Function: wp_setup
	 *
	 * Supplement plugin's WordPress setup.
	 *
	 * Note:
	 * - Default priority is 10. A higher priority runs later.
	 *
	 * See:
	 * - <Action order: https://codex.wordpress.org/Plugin_API/Action_Reference>
	 *
	 * Since:
	 *   0.9.1 - DTRT WordPress Plugin Boilerplate Generator
	 */
	protected function wp_setup() { // phpcs:ignore

		parent::wp_setup();

		// About: add actions and filters here.
		add_filter( 'wpdtrt_form_set_api_endpoint', [ $this, 'filter_set_api_endpoint' ] );
		add_action( 'wp_mail_failed', [ $this, 'helper_wp_mail_failed' ], 10, 1 );

		$this->helper_test_wp_mail( 'testmail' );
	}

	/**
	 * Group: Getters and Setters
	 * _____________________________________
	 */

	/**
	 * Build the field ID
	 *
	 * @param {string} $form_id_raw The ID of the form.
	 * @param {string} $field_name The field name.
	 * @return {string} The field ID.
	 */
	public function get_field_id( $form_id_raw, $field_name ) {
		return "wpdtrt-form-{$form_id_raw}-{$field_name}";
	}

	/**
	 * Build the field name
	 *
	 * @param {string} $form_id_raw The ID of the form.
	 * @param {string} $field_name The field name.
	 * @return {string} The field name.
	 */
	public function get_field_name( $form_id_raw, $field_name ) {
		$form_id_raw = str_replace( '-', '_', $form_id_raw );
		$field_name  = str_replace( '-', '_', $field_name );

		return "wpdtrt_form_{$form_id_raw}_{$field_name}";
	}

	/**
	 * Extract the raw field name
	 *
	 * @param {string} $form_id_raw The ID of the form.
	 * @param {string} $field_name The field name.
	 * @return {string} The raw field name.
	 */
	public function get_field_name_raw( $form_id_raw, $field_name ) {
		$form_id_raw    = str_replace( '-', '_', $form_id_raw ) . '_';
		$field_name_raw = str_replace( 'wpdtrt_form_', '', $field_name );
		$field_name_raw = str_replace( $form_id_raw, '', $field_name_raw );

		return $field_name_raw;
	}

	/**
	 * Build the form ID
	 *
	 * @param {string} $form_id_raw The ID of the form.
	 * @return {string} The form id string.
	 */
	public function get_form_id( $form_id_raw ) {
		return "wpdtrt-form-{$form_id_raw}";
	}

	/**
	 * Group: Renderers
	 * _____________________________________
	 */

	/**
	 * Add project-specific frontend scripts
	 *
	 * Use this function to:
	 * - load scripts in addition to js/frontend-es5.js (via wp_enqueue_script)
	 * - add keys to <%= nameSafe %>_config (via wp_localize_script)
	 *
	 * Don't use function this to:
	 * - add ES6 scripts requiring transpiling (load them using frontend.txt instead)
	 *
	 * @see wpdtrt-plugin-boilerplate/src/Plugin.php
	 */
	public function render_js_frontend() {
		$attach_to_footer = true;

		wp_register_script( 'jquery_validate',
			$this->get_url() . 'node_modules/jquery-validation/dist/jquery.validate.js',
			array(
				// load these registered dependencies first.
				'jquery',
			),
			'1.16.0',
			$attach_to_footer
		);

		wp_enqueue_script( $this->get_prefix(),
			$this->get_url() . 'js/frontend-es5.js',
			array(
				// load these registered dependencies first.
				'jquery',
				'jquery_validate',
			),
			$this->get_version(),
			$attach_to_footer
		);

		// note: after wp_enqueue_script.
		wp_localize_script( $this->get_prefix(),
			$this->get_prefix() . '_config',
			array(
				// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php,
				// but we need to explicitly expose it to frontend pages.
				'ajaxurl' => admin_url( 'admin-ajax.php' ), // wpdtrt_foobar_config.ajaxurl.
				'options' => $this->get_options(), // wpdtrt_foobar_config.options.
			)
		);

		// If editing this function, remove this line to replace the parent function.
		// parent::render_js_frontend();.
	}

	/**
	 * Group: Filters
	 * _____________________________________
	 */

	/**
	 * Set the API endpoint
	 *  The filter is applied in wpplugin->get_api_data()
	 *
	 * @return      string $endpoint
	 *
	 * @since       1.3.4
	 *
	 * @example
	 *  add_filter( 'wpdtrt_form_set_api_endpoint', [$this, 'filter_set_api_endpoint'] );
	 */
	public function filter_set_api_endpoint() {
		$plugin_options = $this->get_plugin_options();
		$endpoint       = '';

		if ( key_exists( 'value', $plugin_options['template'] ) ) {
			$template = $plugin_options['template']['value'];
			$endpoint = ( WPDTRT_FORM_URL . 'data/form-' . $template . '.json' );
		}

		return $endpoint;
	}

	/**
	 * Group: Helpers
	 * _____________________________________
	 */

	/**
	 * Log errors when wp_mail fails
	 *
	 * @param {object} $wp_error The error object.
	 * @see https://core.trac.wordpress.org/ticket/46217#comment:4
	 */
	public function helper_wp_mail_failed( $wp_error ) {
		global $debug;
		$debug->log( $wp_error );
	}

	/**
	 * Sanitize form data
	 *  Validating: Ensure that submitted data matches your expectations
	 *  Santization: Clean user input to fit within an acceptable range
	 *  Escaping: Secure existing data prior to rendering it to the end user
	 *
	 * @return      Sanitized form data
	 *
	 * @see https://www.sitepoint.com/build-your-own-wordpress-contact-form-plugin-in-5-minutes/
	 * @see https://premium.wpmudev.org/blog/how-to-build-your-own-wordpress-contact-form-and-why/
	 * @see http://www.butlerblog.com/2012/09/23/testing-the-wp_mail-function/
	 * @see https://codeseekah.com/2012/02/27/getting-error-feedback-from-wp_mail/
	 * @see https://codex.wordpress.org/Option_Reference
	 * @see https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data
	 * @see /wp-includes/formatting.php
	 * @see https://developer.wordpress.org/reference/functions/sanitize_email/
	 * @see https://developer.wordpress.org/reference/functions/sanitize_text_field/
	 * @see https://developer.wordpress.org/reference/functions/sanitize_textarea_field/
	 * @see https://developer.wordpress.org/reference/functions/wp_mail/
	 * @todo Form seems to submit even if Subject field is empty
	 */
	public function helper_sanitize_form_data() {

		$sanitized_form_data = array();

		// this requires json_decode to use the optional second argument to return an associative array.
		$data                 = $this->get_plugin_data();
		$form_id_raw          = $data['form_id'];
		$field_name_submitted = $this->get_field_name( $form_id_raw, 'submitted' );
		$template_fields      = $data['template_fields'];

		// if the submit button is clicked, send the email.
		if ( isset( $_POST[ $field_name_submitted ] ) ) {

			$wpdtrt_form_options = get_option( 'wpdtrt_form' );

			// sanitize form values
			// empty or unsanitary values are output as ''.
			foreach ( $template_fields as $template_field ) {

				// some fields like checkbox don't need sanitizing.
				if ( isset( $template_field['sanitizer'] ) ) {

					$sanitizer = $template_field['sanitizer'];

					/**
					 * Verify that the contents of a variable can be called as a function
					 *
					 * @see http://php.net/is_callable
					 */
					if ( is_callable( $sanitizer ) ) {

						/**
						 * Call the callback given by the first parameter
						 *
						 * @see http://php.net/manual/en/function.call-user-func.php
						 */
						$field_name = $this->get_field_name( $form_id_raw, $template_field['id'] );

						if ( isset( $_POST[ $field_name ] ) ) {
							$sanitized_form_data[ $field_name ] = call_user_func( $sanitizer, $_POST[ $field_name ] );
						} else {
							$sanitized_form_data[ $field_name ] = '';
						}
					}
				}
			}
		}

		return $sanitized_form_data;
	}

	/**
	 * Send an email using $_POST data
	 *
	 * @param {string} $form_id_raw The ID of the form.
	 * @param {string} $form_name The name of the form.
	 * @param {string} $errors_list Whether to output a list above the form when there are errors.
	 * @return $sentmail Whether the email contents were sent successfully.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_mail/
	 * @see http://www.wordpresscheatsheets.com/how-to-send-html-emails-from-wordpress-using-wp_mail-function
	 * @todo Use template loader
	 */
	public function helper_sendmail( $form_id_raw, $form_name, $errors_list ) {

		// TODO add a key-value pair to track which of these a field represents.
		$errors_list        = $errors_list;
		$field_name_name    = $this->get_field_name( $form_id_raw, 'name' );
		$field_name_email   = $this->get_field_name( $form_id_raw, 'email' );
		$field_name_message = $this->get_field_name( $form_id_raw, 'message' );
		$field_name_subject = $this->get_field_name( $form_id_raw, 'subject' );
		$field_name_submit  = $this->get_field_name( $form_id_raw, 'submitted' );
		$sendmail           = true;
		$sentmail           = false;
		$submitted          = false;

		global $debug;

		// if the submit button is clicked, send the email.
		if ( isset( $_POST[ $field_name_submit ] ) ) {
			$sanitized_form_data = $this->helper_sanitize_form_data();
			$submitted           = true;

			// TODO create an array from fields that are actually required.
			$required_fields = array(
				$field_name_name,
				$field_name_email,
				$field_name_message,
				$field_name_subject,
			);

			foreach ( $required_fields as $field_name ) {
				if ( '' === $sanitized_form_data[ $field_name ] ) {
					$sendmail = false;
				}
			}

			if ( $sendmail ) {
				$blogname = get_option( 'blogname' );
				$to       = get_option( 'admin_email' ); // blog administrator's email address.
				$headers  = 'From: ' . $sanitized_form_data[ $field_name_name ] . '<' . $sanitized_form_data[ $field_name_email ] . '>' . "\r\n";

				$message  = $sanitized_form_data[ $field_name_message ] . "\r\n\r\n";
				$message .= '---' . "\r\n\r\n";
				$message .= "Sent from the {$blogname} {$form_name} form.";

				$sentmail = wp_mail( $to, $sanitized_form_data[ $field_name_subject ], $message, $headers );
			}
		}

		$data           = $this->get_plugin_data();
		$plugin_options = $this->get_plugin_options();

		require WPDTRT_FORM_PATH . 'template-parts/wpdtrt-form-status.php';

		return $sentmail;
	}

	/**
	 * Test wp_mail
	 *
	 * @param {string} $urlparam URL parameter used to trigger test.
	 * @see https://core.trac.wordpress.org/ticket/46217#comment:4
	 */
	public function helper_test_wp_mail( $urlparam ) {
		if ( array_key_exists( $urlparam, $_GET ) ) {
			if ( '1' === $_GET[ $urlparam ] ) {
				$from      = get_option( 'admin_email' );
				$recipient = get_option( 'admin_email' );
				$subject   = 'PHP Mail Test script';
				$body      = 'This is a test to check the PHP Mail functionality';
				$headers   = 'From: ' . $from . "\r\n";
				$mail      = wp_mail( $recipient, $subject, $body, $headers );
				if ( $mail ) {
					wp_die( 'Mail sent' );
				} else {
					wp_die( 'Mail not sent' );
				}
			}
		}
	}
}
