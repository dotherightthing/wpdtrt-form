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
 * @see https://codex.wordpress.org/Option_Reference
 * @see https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data
 * @see /wp-includes/formatting.php
 * @see https://developer.wordpress.org/reference/functions/sanitize_email/
 * @see https://developer.wordpress.org/reference/functions/sanitize_text_field/
 * @see https://developer.wordpress.org/reference/functions/sanitize_textarea_field/
 */

if ( !function_exists( 'wpdtrt_forms_sendmail' ) ) {

	function wpdtrt_forms_sendmail() {

		// if the submit button is clicked, send the email
		if ( isset( $_POST['wpdtrt_forms_submitted'] ) ) {

			// sanitize form values
			$name    		= sanitize_text_field( $_POST['wpdtrt_forms_name'] );
			$email   		= sanitize_email( $_POST['wpdtrt_forms_email'] );
			$subject 		= sanitize_text_field( $_POST['wpdtrt_forms_subject'] );
			$message 		= sanitize_textarea_field( $_POST['wpdtrt_forms_message'] ) . "\r\n\r\n";

			$blogname 		= get_option( 'blogname' );

			$message_source = '---' . "\r\n\r\n";
			$message_source = 'Sent from the "' . $blogname . '" Contact Form.' . "\r\n\r\n";

			$email_updates 	= '';

			if ( isset ( $_POST['wpdtrt_forms_email_updates'] ) ) {
				$email_updates .= 'I would like to receive email updates.';
			}

			// get the blog administrator's email address
			$to = get_option( 'admin_email' );

			$headers = "From: $name <$email>" . "\r\n";

			// If email has been processed for sending, display a success message
			if ( wp_mail( $to, $subject, ( $message . $email_updates . $message_source ), $headers ) ) {
				echo '<div class="wpdtrt-forms-message wpdtrt-forms-message_success">';
				echo '<p>Thank you for contacting me! If needed, you will hear back within 24 hours.</p>';
				echo '</div>';
			} else {
				echo '<div class="wpdtrt-forms-message wpdtrt-forms-message_error">';
				echo '<p>An unexpected error occurred, please try again.</p>';
				echo '</div>';
			}
		}
	}

}
