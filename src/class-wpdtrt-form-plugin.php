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
		add_filter( 'query_vars', [ $this, 'helper_add_query_vars' ], 10, 1 );
		add_action( 'init', [ $this, 'helper_sendmail_proxy' ] );

		// add_action( 'init', [ $this, 'helper_akismet' ] );.
		// $this->helper_test_wp_mail( 'testmail' );.
	}

	/**
	 * Group: Getters and Setters
	 * _____________________________________
	 */

	/**
	 * Build the field ID
	 *
	 * @param string $form_id_raw The ID of the form.
	 * @param string $field_name The field name.
	 * @return string The field ID.
	 */
	public function get_field_id( string $form_id_raw, string $field_name ) : string {
		return "wpdtrt-form-{$form_id_raw}-{$field_name}";
	}

	/**
	 * Build the field name
	 *
	 * @param string $form_id_raw The ID of the form.
	 * @param string $field_name The field name.
	 * @return string The field name.
	 */
	public function get_field_name( string $form_id_raw, string $field_name ) : string {
		$form_id_raw = str_replace( '-', '_', $form_id_raw );
		$field_name  = str_replace( '-', '_', $field_name );

		return "wpdtrt_form_{$form_id_raw}_{$field_name}";
	}

	/**
	 * Extract the raw field name
	 *
	 * @param string $form_id_raw The ID of the form.
	 * @param string $field_name The field name.
	 * @return string The raw field name.
	 */
	public function get_field_name_raw( string $form_id_raw, string $field_name ) : string {
		$form_id_raw    = str_replace( '-', '_', $form_id_raw ) . '_';
		$field_name_raw = str_replace( 'wpdtrt_form_', '', $field_name );
		$field_name_raw = str_replace( $form_id_raw, '', $field_name_raw );

		return $field_name_raw;
	}

	/**
	 * Build the form ID
	 *
	 * @param string $form_id_raw The ID of the form.
	 * @return string The form id string.
	 */
	public function get_form_id( string $form_id_raw ) : string {
		return "wpdtrt-form-{$form_id_raw}";
	}

	/**
	 * Set the submit status
	 *
	 * @param string $status The submit status.
	 */
	public function set_submit_status( string $status ) {
		$this->submit_status = $status;
	}

	/**
	 * Get the submit status
	 *
	 * @param bool $debug - Debug mode.
	 * @return string The submit status
	 */
	public function get_submit_status( bool $debug = null ) : string {
		$the_submit_status = '';

		$submit_statuses = array(
			'0' => 'not submitted', // default.
			'1' => 'submitted, could not send', // 'unsent_message'.
			'2' => 'submitted, sent, redirected', // 'success_message'.
			'3' => 'noscript, submitted with errors', // 'error_message_single', 'error_message_plural'.
		);

		if ( isset( $this->submit_status ) ) {
			$the_submit_status = $this->submit_status;
		}

		if ( true === $debug ) {
			global $debug;

			foreach ( $submit_statuses as $key => $value ) {
				if ( intval( $the_submit_status ) === $key ) {
					$debug->log( "{$key}: {$value}" );
				}
			}
		}

		return $the_submit_status;
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
	 * Register a new query var for use with $_GET
	 *
	 * @param array $vars - Query vars.
	 * @return array $vars
	 */
	public function helper_add_query_vars( array $vars ) : array {
		$vars[] = 'wpdtrtformsent';
		return $vars;
	}

	/**
	 * Log errors when wp_mail fails
	 *
	 * @param object $wp_error The error object.
	 * @see https://core.trac.wordpress.org/ticket/46217#comment:4
	 */
	public function helper_wp_mail_failed( object $wp_error ) {
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
	 */
	public function helper_sanitize_form_data() {

		$sanitized_form_data = array();

		// this requires json_decode to use the optional second argument to return an associative array.
		$data = $this->get_plugin_data();

		$fields      = key_exists( 'fields', $data ) ? $data['fields'] : array();
		$form_id_raw = key_exists( 'form_id', $data ) ? $data['form_id'] : '';

		$field_name_submit = $this->get_field_name( $form_id_raw, 'submit' );

		// if the submit button is clicked, send the email.
		if ( isset( $_POST[ $field_name_submit ] ) ) {

			$wpdtrt_form_options = get_option( 'wpdtrt_form' );

			// sanitize form values
			// empty or unsanitary values are output as ''.
			foreach ( $fields as $field ) {

				// some fields like checkbox don't need sanitizing.
				if ( isset( $field['sanitizer'] ) ) {

					$sanitizer = $field['sanitizer'];

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
						$field_name = $this->get_field_name( $form_id_raw, $field['id'] );

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
	 * Proxy method to send arguments to helper_sendmail()
	 */
	public function helper_sendmail_proxy() {
		$this->helper_sendmail( 'contact-form', 'Contact', array() );
	}

	/**
	 * Send an email using $_POST data
	 *
	 * Uses the Post/Redirect/Get pattern.
	 *
	 * Without PRG:
	 * - POST request -> HTML response -> Refresh -> POST request -> HTML response
	 *
	 * With PRG:
	 * - POST request -> Redirect response -> GET request -> HTML response -> Refresh -> GET request -> HTML response
	 *
	 * @param string $form_id_raw The ID of the form.
	 * @param string $form_name The name of the form.
	 * @param string $errors_list Whether to output a list above the form when there are errors.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_mail/
	 * @see http://www.wordpresscheatsheets.com/how-to-send-html-emails-from-wordpress-using-wp_mail-function
	 * @see https://wpshout.com/preventing-form-resubmission-warnings-wordpress-postredirectget-pattern/
	 * @see https://developer.wordpress.org/reference/functions/wp_redirect/#comment-3973 - nocache_headers()
	 */
	public function helper_sendmail( $form_id_raw, $form_name, $errors_list ) {
		$this->get_api_data(); // load and store the external data (once).

		$data           = $this->get_plugin_data(); // retrieve the stored external data, this is an empty array if the request failed.
		$plugin_options = $this->get_plugin_options();

		$anchor_id = key_exists( 'anchor_id', $data ) ? $data['anchor_id'] : '';
		$fields    = key_exists( 'fields', $data ) ? $data['fields'] : array();
		$url       = key_exists( 'url', $data ) ? get_bloginfo( 'wpurl' ) . $data['url'] : get_bloginfo( 'wpurl' );

		$field_name_submit     = $this->get_field_name( $form_id_raw, 'submit' );
		$mail_role_field_names = array( 'submit' => $this->get_field_name( $form_id_raw, 'submit' ) );

		$blogname        = get_option( 'blogname' );
		$recipient_email = get_option( 'admin_email' );

		$mail_roles      = array( 'sender_name', 'sender_email', 'subject', 'body' );
		$required_fields = array();
		$sendmail        = true;
		$sentmail        = false;

		// if the submit button was clicked, send the email.
		if ( isset( $_POST[ $field_name_submit ] ) ) {
			$sanitized_form_data = $this->helper_sanitize_form_data();

			foreach ( $fields as $field ) {
				$field_name = $this->get_field_name( $form_id_raw, $field['id'] );

				foreach ( $mail_roles as $mail_role ) {
					if ( array_key_exists( 'mail_role', $field ) && ( $mail_role === $field['mail_role'] ) ) {
						$mail_role_field_names[ $mail_role ] = $field_name;
					}
				}

				if ( array_key_exists( 'required', $field ) && ( 'true' === $field['required'] ) ) {
					$required_fields[] = $field_name;

					if ( '' === $sanitized_form_data[ $field_name ] ) {
						$sendmail = false;
					}
				}
			}

			if ( $sendmail ) {
				$headers  = 'From: ' . $sanitized_form_data[ $mail_role_field_names['sender_name'] ] . ' <' . $sanitized_form_data[ $mail_role_field_names['sender_email'] ] . '>' . "\r\n";
				$message  = $sanitized_form_data[ $mail_role_field_names['body'] ] . "\r\n\r\n";
				$message .= '---' . "\r\n\r\n";
				$message .= "Sent from the {$blogname} {$form_name} form.";

				$sentmail = wp_mail(
					$recipient_email,
					$sanitized_form_data[ $mail_role_field_names['subject'] ],
					$message,
					$headers
				);

				if ( $sentmail ) {
					// prevent aggressive long term caching.
					nocache_headers();

					// this only works before html is output!
					$url = add_query_arg( 'wpdtrtformsent', '1', ( $url . '#' . $anchor_id ) );
					wp_safe_redirect( $url, 303 );
					exit();
				} else {
					$this->set_submit_status( '1' ); // ok, refresh resubmits.
				}
			} else {
				$this->set_submit_status( '3' ); // ok, refresh resubmits and revalidates.
			}
		} else {
			if ( array_key_exists( 'wpdtrtformsent', $_GET ) && '1' === $_GET['wpdtrtformsent'] ) {
				$this->set_submit_status( '2' ); // ok, refresh ok.
			} else {
				$this->set_submit_status( '0' ); // ok, refresh ok.
			}
		}
	}

	/**
	 * Test wp_mail
	 *
	 * @param string $urlparam URL parameter used to trigger test.
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

	/**
	 * Akismet
	 *
	 * @see https://stackoverflow.com/a/32836893
	 * @see https://solutionfactor.net/blog/2014/02/01/honeypot-technique-fast-easy-spam-prevention/
	 * @todo Akismet configuration not working, or doesn't work on local dev
	 */
	public function helper_akismet() {
		if ( function_exists( 'akismet_http_post' ) ) {
			global $akismet_api_host;
			global $akismet_api_port;
			global $debug;

			$data = $this->get_plugin_data();
			$test = true;

			// plugins/akismet/class.akismet-rest-api.php
			// /wp-admin/options-general.php?page=akismet-key-config
			// $akismet_api_key = get_option( 'wordpress_api_key' ); // ok
			// .
			$akismet_data = array(
				'comment_author'        => 'Jen',
				'comment_author_email'  => 'aduaros555@gmail.com',
				'comment_author_url'    => 'https://hpjk.dazafore.top/oheyueu-lqbips',
				'comment_content'       => 'Му husbаnd has got hіs power bаck!',
				'comment_type'          => 'contact-form',
				'blog'                  => ( true === $test ) ? 'http://dontbelievethehype.co.nz' : get_bloginfo( 'wpurl' ),
				'blog_charset'          => 'UTF-8',
				'blog_lang'             => ( true === $test ) ? 'en' : get_bloginfo( 'language' ), // ISO 639-1.
				'honeypot_field_name'   => 'wpdtrt_form_honey_pot',
				'hidden_honeypot_field' => 'Jen',
				'is_test'               => ( true === $test ) ? true : false,
				'permalink'             => ( true === $test ) ? 'http://dontbelievethehype.co.nz/contact/' : get_bloginfo( 'wpurl' ) . $data['url'],
				'referrer'              => ( true === $test ) ? '' : wp_get_referer(),
				'user_agent'            => ( true === $test ) ? 'dotbot' : $_SERVER['HTTP_USER_AGENT'], // phpcs:ignore
				'user_ip'               => ( true === $test ) ? '99.99.99.99' : $this->helper_get_user_ip(),
			);

			$query_string = http_build_query( $akismet_data );

			$response = akismet_http_post( $query_string, $akismet_api_host, '/1.1/comment-check', $akismet_api_port );

			$result = ( is_array( $response ) && isset( $response[1] ) ) ? $response[1] : 'false';

			$debug->log( $akismet_data );
			$debug->log( $response ); // [1] => false
		}
	}

	/**
	 * Get User IP
	 *
	 * @see https://dotlayer.com/how-to-get-users-ip-addresses-on-wordpress-and-display-it-using-shortcodes/
	 * @see https://www.wpbeginner.com/wp-tutorials/how-to-display-a-users-ip-address-in-wordpress/
	 * @see https://wordpress.stackexchange.com/questions/382558/wordpress-shortcode-using-wpb-get-ip
	 */
	public function helper_get_user_ip() {
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP']; // ip from shared internet.
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR']; // ip is passed from proxy.
		} else {
			$ip = $_SERVER['REMOTE_ADDR']; // phpcs:ignore
		}

		return apply_filters( 'wpb_get_ip', $ip );
	}
}
