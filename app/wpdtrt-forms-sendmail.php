<?php
/**
 * Send the form contents to an email address
 *
 * This file contains PHP.
 *
 * Validating: Ensure that submitted data matches your expectations
 * Santization: Clean user input to fit within an acceptable range
 * Escaping: Secure existing data prior to rendering it to the end user
 *
 * @link        http://dotherightthing.co.nz
 * @link        https://generatewp.com/shortcodes/
 * @since       0.1.0
 *
 * @package     Wpdtrt_Forms
 * @subpackage  Wpdtrt_Forms/app
 *
 * @see https://www.sitepoint.com/build-your-own-wordpress-contact-form-plugin-in-5-minutes/
 * @see https://premium.wpmudev.org/blog/how-to-build-your-own-wordpress-contact-form-and-why/
 * @see http://www.butlerblog.com/2012/09/23/testing-the-wp_mail-function/
 * @see https://codeseekah.com/2012/02/27/getting-error-feedback-from-wp_mail/
 *
 * @see https://codex.wordpress.org/Option_Reference
 * @see https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data
 * @see /wp-includes/formatting.php
 * @see https://developer.wordpress.org/reference/functions/sanitize_email/
 * @see https://developer.wordpress.org/reference/functions/sanitize_text_field/
 * @see https://developer.wordpress.org/reference/functions/sanitize_textarea_field/
 * @see https://developer.wordpress.org/reference/functions/wp_mail/
 * @todo Form seems to submit even if Subject field is empty
 */

if ( !function_exists( 'wpdtrt_forms_sendmail' ) ) {

	function wpdtrt_forms_sendmail() {

		// if the submit button is clicked, send the email
		if ( isset( $_POST['wpdtrt_forms_submitted'] ) ) {

			$wpdtrt_forms_options = get_option('wpdtrt_forms');

			// this requires json_decode to use the optional second argument
			// to return an associative array
			// @see wpdtrt_forms_get_data()
			$template_data = $wpdtrt_forms_options['wpdtrt_forms_data'];
			$template_fields = $template_data['template_fields'];

			// sanitize form values
			// empty or unsanitary values are output as ''
			foreach( $template_fields as $template_field ) {

				// some fields like checkbox don't need sanitizing
				if ( isset( $template_field['sanitizer'] ) ) {

					$sanitizer = $template_field['sanitizer'];

					/**
					 * Verify that the contents of a variable can be called as a function
					 * @see http://php.net/is_callable
					 */
					if ( is_callable( $sanitizer ) ) {

						/**
						 * Call the callback given by the first parameter
						 * @see http://php.net/manual/en/function.call-user-func.php
						 */
						$submitted_data[ $template_field['id'] ] = call_user_func( $sanitizer, $_POST[ 'wpdtrt_forms_' . $template_field['id'] ] );
					}

				}
			}

			$blogname = get_option( 'blogname' );

			// get the blog administrator's email address
			$to = get_option( 'admin_email' );

			$headers = "From: " . $submitted_data['name'] . "<" . $submitted_data['email'] . ">" . "\r\n";

			if ( $submitted_data['message'] !== '' ) {

				$message = "\r\n\r\n";

				if ( isset ( $_POST['wpdtrt_forms_email_updates'] ) ) {
					$message .= 'I would like to receive email updates.' . "\r\n\r\n";
				}

				$message .= '---' . "\r\n\r\n";
				$message .= 'Sent from the "' . $blogname . '" Contact Form.';
			}
			else {
				$message = '';
			}

			$sentmail = wp_mail( $to, $submitted_data['subject'], $message, $headers );

			$errors_list = $wpdtrt_forms_options['errors_list'];
		    require( WPDTRT_FORMS_PATH . 'template-parts/wpdtrt-forms-status.php' );

			return $sentmail;
		}
	}

}
