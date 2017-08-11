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

			// sanitize form values
			// unsanitary values are output as ''
			$name    		= sanitize_text_field( $_POST['wpdtrt_forms_name'] );
			$email   		= sanitize_email( $_POST['wpdtrt_forms_email'] );
			$subject 		= sanitize_text_field( $_POST['wpdtrt_forms_subject'] );
			$message 		= sanitize_textarea_field( $_POST['wpdtrt_forms_message'] );

			$blogname 		= get_option( 'blogname' );

			// get the blog administrator's email address
			$to = get_option( 'admin_email' );

			$headers = "From: $name <$email>" . "\r\n";

			if ( $message !== '' ) {

				$message .= "\r\n\r\n";

				if ( isset ( $_POST['wpdtrt_forms_email_updates'] ) ) {
					$message .= 'I would like to receive email updates.' . "\r\n\r\n";
				}

				$message .= '---' . "\r\n\r\n";
				$message .= 'Sent from the "' . $blogname . '" Contact Form.';
			}

			// If email has been processed for sending, display a success message
			if ( wp_mail( $to, $subject, $message, $headers ) ) {
				echo '<div class="wpdtrt-forms-message wpdtrt-forms-message_success">';
				echo '<p>Thank you for contacting me! If needed, you will hear back within 24 hours.</p>';
				echo '</div>';

				$sent = true;
			} else {
				echo '<div class="wpdtrt-forms-message wpdtrt-forms-message_error">';
				echo '<p>Please correct the following errors:</p>';
				echo '<ol>';

				if ( $name === '' ) {
					echo '<li><a href="#wpdtrt_forms_name">Please enter your name</a></li>';
				}

				if ( $email === '' ) {
					echo '<li><a href="#wpdtrt_forms_email">Please enter a valid email address</a></li>';
				}

				if ( $subject === '' ) {
					echo '<li><a href="#wpdtrt_forms_subject">Please enter a subject</a></li>';
				}

				if ( $message === '' ) {
					echo '<li><a href="#wpdtrt_forms_message">Please enter your message</a></li>';
				}

				echo '</ol>';
				echo '</div>';

				$sent = false;
			}

			return $sent;
		}
	}

}
